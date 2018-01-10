<?php

namespace App\Http\Controllers;

use App\Customer;
use App\LfTransaction;
use App\ShopOption;
use App\TransactionDetail;
use Carbon\Carbon;

use DB;
use App\Beat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use League\Flysystem\Exception;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use ZipArchive;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;
use Log;
use App\Http\Controllers\Admin\BeatController;
class TransactionController extends BeatController
{
    private $_api_context;

    public function __construct()
    {
        // setup PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function humanTiming ($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            3600 => 'hour',
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return intval($numberOfUnits);
        }

    }

    public function tm_transaction(Request $request)
    {
        $transaction = LfTransaction::where('location', $request->transaction['location'])->first();

        if(!$transaction)
        {
            $transaction = new LfTransaction($request->transaction);
        }

        try{
            $transaction->save();
        } catch(Exception $ex){
            $ex->getMessage();
        }

        try{
            DB::table('beat_lf_transaction')->insert(
                [
                    'lf_transaction_id' => $transaction->id,
                    'beat_id' => $request->beat_lf_transaction['beat_id'],
                    'buyed_types' => $request->beat_lf_transaction['buyed_types']
                ]
            );
        } catch(Exception $ex){
            return $ex->getMessage();
        }

        return response(200);
    }

    public function tm_transaction_state(Request $request)
    {
        $transaction = LfTransaction::where('location', $request->location)->with('beats')->first();

        $transaction->pay_id = $request->pay_id;
        $transaction->total_money = $request->total_money;
        $transaction->payment_state = $request->payment_state;
        $inactive_beats = [];

        foreach ($transaction->beats as $beat) {

            if(!$beat->active)
            {
                $transaction->payment_state = 'error';
                $paths = explode(', ', $beat->pivot->buyed_types);

                foreach ($paths as &$path) {
                    $path = strtolower( str_replace( ' ', '_', $path ) );
                    $path = urldecode(realpath(substr($beat->{$path}, strpos($beat->{$path}, 'beats'))));
                }

                array_push($inactive_beats,
                    [
                        'beat_title'  => $beat->title,
                        'beat_types' => $beat->pivot->buyed_types,
                        'beat_type_paths' => $paths
                    ]);

            } else if(str_contains($beat->pivot->buyed_types, "EXCLUSIVE" )) {

                $beat->active = 0;
                $beat->save();
            }

        }

        $this->generate_beat_JSON();

        try{
            $transaction->save();
        } catch(Exception $ex){
            $ex->getMessage();
        }

        if( empty($inactive_beats ))
        {
            return response()->json(['status' => $transaction->payment_state == 'error' ? 'error' : 'success', 'message' => 'success']);
        } else {
            return response()->json(['status' => 'error' , 'message' => 'beat already bought', 'inactive_beats' => $inactive_beats]);
        }
    }
    /* creates a compressed zip file */
    public function create_zip($files = array(), $destination = '', $overwrite = false) {
        //if the zip file already exists and overwrite is false, return false
        if(file_exists($destination) && !$overwrite) { return false; }
        //vars
        $valid_files = array();
        //if files were passed in...
        if(is_array($files)) {

            //cycle through each file
            foreach($files as $file) {
                //make sure the file exists
                if(file_exists($file)) {
                    $valid_files[] = $file;
                }

            }
        }
        //if we have good files...
        if(count($valid_files) > 0) {
            //create the archive
            $zip = new ZipArchive();
            $created_zip = $zip->open($destination, ZIPARCHIVE::CREATE);
            if( $created_zip !== true) {
                return false;
            }
            //add the files
            foreach($valid_files as $file) {
                //get filename from realpath and urldecode
                $file_name = urldecode( explode('/', $file)[count(explode('/', $file)) - 1] );
                $zip->addFile($file, $file_name);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        }
        else
        {
            return false;
        }
    }

    public function cron_delete_zip()
    {
        $now = Carbon::now();
        $now = $now->toDateTimeString();

        $date = new DateTime;
        $date->modify('-24 hours');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $files = LFTransaction::where('created_at', '<=', $formatted_date)->get();

        $i = 0;
        if($files->count() > 0) {

            foreach ($files as $file) {
                    $file->payment_state = 'Expired';
                    $delete_path = array_slice(explode('/', $file->zip_path), -2);
                    $delete_path = public_path() . '/' . implode('/', $delete_path);
                    $file->zip_path = null;

                    if (File::exists($delete_path)) {
                        File::delete($delete_path);
                        $i++;
                    }

                    if (!File::exists($delete_path)) {
                        $file->save();
                        $file->delete();
                        Log::info('Deleted transaction with id:'.$file->id . ' reason: transaction expired, transaction created:'. $file->created_at. ' now:'.$now);
                    }
                }

        } else {
            return response(400);
        }

        if($i > 0 )
            return response(200)->setContent('Deleted ' . $i . ' zips');
        else
            return response(400);
    }

    public function download($zip_name)
    {
        $download_link_created = LfTransaction::where('zip_path', 'LIKE', '%'.$zip_name.'%')->first();

        $time = $this->humanTiming(strtotime($download_link_created['created_at']));

        if(($time <= 24 || $time == null) && $download_link_created)
        {
            $real_path = public_path(). '/zips/'. $zip_name;
            $headers = array(
                'Content-Type: application/zip'
            );
            $download_link_created->zip_path = 'downloaded';
            $download_link_created->save();

            return response()->download($real_path, $zip_name.'.zip', $headers)->deleteFileAfterSend(true);
        } else{
            return redirect('/');
        }

    }

    public function thanks()
    {
        $inactive = Session::get('beats_inactive');
        $paykey = Session::get('paypal_payment_id');
        $contact_mail = Session::get('contact_email');
        Session::forget('paypal_payment_id');
        Session::forget('contact_email');
        Session::forget('beats_inactive');

        $transaction = LfTransaction::where('pay_id', $paykey)->with('customers')->first();
        $thank_you_content = ShopOption::where('meta_key', 'thank_you_page')->first()['meta_value'];

        return view('beats.buyed-beats',
            [
                'shop' => $thank_you_content,
                'customer_mail' => $transaction->customers->first()->email,
                'state' => $transaction->payment_state,
                'inactive_beats' => $inactive,
                'contact_mail' => $contact_mail

            ]
        );
    }

    public function postPayment(Request $request)
    {

//      EXAMPLE START
        $mail_temp = [];
//      EXAMPLE END
        $prices = [];
        $all_items = [];
        $db_items = [];

        $transaction = new LfTransaction([
            'pay_id' => 'some_id',
            'location' => 'local',
            'total_money' => 0.00,
            'payment_state' => 'initialize'
        ]);

        try{
            $transaction->save();
        } catch(Exception $ex){
            $ex->getMessage();
        }
        $tr_id = $transaction->id;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        for ($i = 0; $i < count($request->beat_id); $i++) {
            $types = explode(',', $request->file_type[$i]);

            array_walk($types, function (&$value, $key) {
                $value = trim($value);
                $value = strtolower(str_replace(" ", "_", $value )) . '_price';
            });
            array_push($types, 'title');

            if(in_array( 'exclusive_price', $types ))
            {
                $beat = DB::table('beats')->select('title', 'exclusive_price')->where('id', $request->beat_id[$i])->first();
                $title = $beat->title;
                unset($beat->title);

                $price = $beat->exclusive_price;

                $item = new Item();
                $item->setName($title)// item name
                    ->setCurrency('USD')
                    ->setSku($request->beat_id[$i])
                    ->setDescription('EXCLUSIVE')
                    ->setQuantity(1)
                    ->setPrice($price);// unit price

                $db_items [] = ['beat_id'=> $request->beat_id[$i], 'lf_transaction_id' => $tr_id, 'buyed_types' => 'EXCLUSIVE'];
                array_push($all_items, $item);
                array_push($prices, $price);

            } else {

                $beat = Beat::select($types)->find((int)$request->beat_id[$i]);
                $beat = $beat->toArray();

                $beat = array_reverse( $beat );
                $title = array_shift( $beat );

                $price = array_sum($beat);

                $item = new Item();
                $item->setName($title)// item name
                          ->setCurrency('USD')
                          ->setSku($request->beat_id[$i])
                          ->setDescription($request->file_type[$i])
                          ->setQuantity(1)
                          ->setPrice($price);// unit price

                $db_items [] = ['beat_id'=> $request->beat_id[$i], 'lf_transaction_id' => $tr_id, 'buyed_types' => $request->file_type[$i]];
                array_push($all_items, $item);
                array_push($prices, $price);

            }

        }

        try{
            DB::table('beat_lf_transaction')->insert($db_items);
        } catch(Exception $ex){
            $ex->getMessage();
        }

        // add all_items to list
        $item_list = new ItemList();
        $item_list->setItems($all_items);

//       $beatzip = $this->create_zip($beat_files, $zip_destionation);
//        dd($beat_files);
        $amount = new Amount();
        $amount->setCurrency('USD')->setTotal(array_sum($prices));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($tr_id);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('payment/status'))// Specify return URL
                        ->setCancelUrl(url('/'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        if(isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }

        return Redirect::route('original.route')
            ->with('error', 'Unknown error occurred');
    }


    public function getPaymentStatus()
    {
        // Get the payment ID from $_GET
        $payment_id = $_GET['paymentId'];
        // add payment ID to session
        Session::put('paypal_payment_id', $payment_id);
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return Redirect::route('original.route')
                ->with('error', 'Payment failed');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
//        dd( $payment->getTransactions()[0]->getItemList()->getItems() );
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $tr_id = $payment->getTransactions()[0]->description;

        $mail_temp = DB::table('beat_lf_transaction')->select('beat_id', 'buyed_types as beat_types')->where('lf_transaction_id', $tr_id)->get()->toArray();
        //convert table results to array
        $mail_temp =json_decode(json_encode($mail_temp), true);

        $customer_email = $payment->getPayer()->getPayerInfo()->email;
        $customer = Customer::where('email', $customer_email)->first();

        if( !$customer )
        {
            $customer = new Customer();
            $customer->payer_id = $payment->getPayer()->getPayerInfo()->payer_id;
            $customer->first_name = $payment->getPayer()->getPayerInfo()->first_name;
            $customer->last_name = $payment->getPayer()->getPayerInfo()->last_name;
            $customer->email = $customer_email;
            $customer->country_code = $payment->getPayer()->getPayerInfo()->country_code;
            $customer->shiping_recipient_name = $payment->getPayer()->getPayerInfo()->shipping_address->recipient_name;
            $customer->shiping_line1 = $payment->getPayer()->getPayerInfo()->shipping_address->line1;
            $customer->shiping_city = $payment->getPayer()->getPayerInfo()->shipping_address->city;
            $customer->shiping_state = $payment->getPayer()->getPayerInfo()->shipping_address->state;
            $customer->shiping_postal_code = $payment->getPayer()->getPayerInfo()->shipping_address->postal_code;
            $customer->shiping_country_code = $payment->getPayer()->getPayerInfo()->shipping_address->country_code;

            try {
                $customer->save();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        $transaction = LfTransaction::find($tr_id);
        $transaction->pay_id = $payment->id;
        $transaction->total_money = (float)$payment->getTransactions()[0]->getAmount()->getTotal();
        $transaction->payment_state = 'in_progress';

        try {
            $transaction->save();
            $customer->transactions()->attach($tr_id);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') { // payment made
//        if (true) { // payment made (testing purpose)

            $beat_files = [];
            $beats_inactive = [];
            $website_logo = ShopOption::where('meta_key', 'logo_path')->first()['meta_value'];
            $email_content = ShopOption::where('meta_key', 'email_content')->first()['meta_value'];


            for ($i = 0; $i < count($mail_temp); $i++) {
                $mail_temp[$i]['beat_types'] = explode(', ', $mail_temp[$i]['beat_types']);

                $beat = Beat::find($mail_temp[$i]['beat_id']);
                if( $beat['active'] )
                {

                    if ($mail_temp[$i]['beat_types'][0] == 'EXCLUSIVE') {

                        $beat->active = 0;
                        $beat->save();

                        $beat = [
                            'mp3' => $beat->mp3,
                            'wav' => $beat->wav,
                            'tracked_out' => $beat->tracked_out,
                        ];

                    } else {

                        if (in_array('TRACKED OUT', $mail_temp[$i]['beat_types'])) {
                            $nedle = array_search('TRACKED OUT', $mail_temp[$i]['beat_types']);
                            $mail_temp[$i]['beat_types'][$nedle] = 'tracked_out';
                        }

                        $beat = Beat::where('id',
                            $mail_temp[$i]['beat_id'])->first($mail_temp[$i]['beat_types'])->toArray();
                    }


                    if ($beat != null) {
                        foreach ($beat as $beat_single_path) {
                            $beat_single_path = public_path(str_replace(url('/') . '/', '', $beat_single_path));
                            array_push($beat_files, $beat_single_path);
                        }
                    }
                } else {

                    array_push($beats_inactive,
                        [
                            'beat_title'  => $beat->title,
                            'beat_types' => implode(', ', $mail_temp[$i]['beat_types'])
                        ]
                );

                    $transaction->payment_state = 'error';
                }
            }

            Session::put('beats_inactive', $beats_inactive);
            $zip_destionation = public_path() . '/zips/' . md5((string)mt_rand()) . '.zip';


            if( !File::exists(public_path('/zips') ) )
                File::makeDirectory(public_path('/zips'), 0775, true, true) ;

            try {
                $this->create_zip($beat_files, $zip_destionation);
                $this->generate_beat_JSON();
            } catch (Exception $e) {
                return $e->getMessage();
            }

            $transaction->zip_path = $zip_destionation;

            $this->setMail('beats@transactionmusic.com', 'ci?,Ur)RX!$?', 'gator4240.hostgator.com', 465, 'ssl');

            $mail_sending_status = Mail::send('email.beats-email', [
                'email_content' => $email_content,
                'beat_route' => explode('/',   $transaction->zip_path)[count(explode('/',   $transaction->zip_path)) - 1],
                'website_logo' => $website_logo
            ], function ($message) use ($customer_email) {
                if (App::environment('local')) {
                    $message->to('dusan@librafire.com');
                } else {
                    $message->to($customer_email);
                }
            });

            $pay_mail = ShopOption::where('meta_key', 'paypal_email')->first()['meta_value'];
            Session::put('contact_email', $pay_mail);

            Log::info('beat_route' . explode('/',   $transaction->zip_path)[count(explode('/',   $transaction->zip_path)) - 1]);
            Log::info('Sending status' . $mail_sending_status .'state');
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
                'USER' => 'duka_api1.duka.com',
                'PWD' => 'FGDDRYEQZTNHRZMQ',
                'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AOgJHGa8xOuKy0jdj.f5O-OBdSvI',
                'METHOD' => 'MassPay',
                'VERSION' => '99',
                'CURRENCYCODE' => 'USD',
                'RECEIVERTYPE' => '',
                'EMAILSUBJECT' => 'Assunt',
                'L_EMAIL0' => $pay_mail,
                'L_AMT0' =>  (string)round(($transaction->total_money * 0.85), 2)
            )));

            curl_exec($curl);
            curl_close($curl);
            $transaction->payment_state == 'error' ? '' : $transaction->payment_state = 'success';
            try {
                $transaction->save();
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return redirect('/thanks');
        } else {
            $transaction->payment_state = $result->getState();
            try {
                $transaction->save();
            } catch (Exception $e) {
                return $e->getMessage();
            }
            return redirect('/');
        }
    }

    function utf8_encode_deep(&$input) {
        if (is_string($input)) {
            $input = utf8_encode($input);
        } else if (is_array($input)) {
            foreach ($input as &$value) {
                self::utf8_encode_deep($value);
            }

            unset($value);
        } else if (is_object($input)) {
            $vars = array_keys(get_object_vars($input));

            foreach ($vars as $var) {
                self::utf8_encode_deep($input->$var);
            }
        }
    }



    public function get_beat()
    {

        $file = 'http://subinstance.dev/api/beat-info/14';
        $get_file = file_get_contents($file);
//        $get_file = json_decode($get_file);
//
        file_put_contents(public_path('/beats/') . 'djura2.mp3', $get_file['file']);
    }


}
