<?php

namespace App\Http\Controllers;

use App\ShopOption;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use JavaScript;
class ContactController extends Controller
{
    public function index()
    {
        $contact_mail = ShopOption::where('meta_key', 'paypal_email')->first()['meta_value'];

        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        return view('contacts.index', compact('contact_mail'));
    }
    public function store(Request $request)
    {
        $this->setMail('beats@transactionmusic.com', 'ci?,Ur)RX!$?', 'gator4240.hostgator.com', 465, 'ssl');

        try {
            Mail::send('mail', [ 'name' => $request->name, 'text_message' => $request->message, 'email' => $request->email ], function ($message)
            {
                if(env('APP_ENV') == 'local')
                {
                    $message->to('dusan@librafire.com')->subject('Contact us');
                } else {
                    $message->to(ShopOption::where('meta_key', 'paypal_email')->first()['meta_value'])->subject('Contact us');
                }
            });

        } catch (Exception $e) {
            return redirect('/contact')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('/contact')->with('data', [ 'message'  => 'Successfully sent message', 'type' => 'success']);
    }
//    public function dedicated_mobile()
//    {
//        return view('contacts.dedicatedMobileApp');
//    }
}
