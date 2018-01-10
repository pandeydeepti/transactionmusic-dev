<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\UserInterface;
use App\ShopOption;
use Artisan;
use Hash;
use App\User;

class AjaxController extends Controller
{
    public function sendmail(Request $request)
    {
        Mail::send('mail', ['name' => $request->input('name'), 'email' => $request->input('email')], function ($message)
        {
//            $message->to('duka@outlook.com');
        });

        return response('Successful', 200)->header('Content-Type', 'text/plain');
    }

    public function migrate_app(Request $request)
    {

        $POST_DATA = $request->all();

        $shopoptions_data = [];

        $shopoptions_data[] = [
            'meta_key' => 'admin_firstname',
            'meta_value' => $POST_DATA['order_firstname']
        ];
        $shopoptions_data[] = [
            'meta_key' => 'admin_lastname',
            'meta_value' => $POST_DATA['order_lastname']
        ];

        $shopoptions_data[] = [
            'meta_key' => 'paypal_email',
            'meta_value' => $POST_DATA['order_paypal_email']
        ];

        $name = $POST_DATA['order_instance_username'];
        $password = $POST_DATA['order_instance_password'];
        $email = $POST_DATA['order_instance_email'];

        try{
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ["--force"=> true ]);
            Artisan::call('key:generate');

            $user = new User;

            if($name != null AND $email != null AND $password != null){
                if(User::where('email', '=', $email)->exists()){
                    return response()->json(['status' => 'error', 'message' => "A user with this email already exists"]);
                }else{
                    $user->name = $name;
                    $user->email = $email;
                    $user->password = Hash::make($password);
                    $user->api_token = str_random(60);
                    $user->save();
                }
            }else{
                return response()->json(['status' => 'error', 'message' => "All fields are required"]);

            }

            try{
                foreach ($shopoptions_data as $item) {
                    ShopOption::updateOrCreate(
                        ['meta_key'         => $item['meta_key']],
                        ['meta_value'       => $item['meta_value']]
                    )
                    ;
                }
            } catch( Exception $ex ){
                return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
            }

        } catch(Exception $ex){
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
        }

        return response()->json(['status' => 'success', 'message' => 'Successfully migrated application']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
