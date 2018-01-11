<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ShopOption;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use JavaScript;
use App\User;
use Auth;
use Session;
USE DB;
class ShopOptionController extends Controller
{
    private $defaults = [
        'main_color' => '#1f373d',
        'secondary_color' => '#162831',
        'third_color' => '#19cefb',
        'fourth_color' => '#ffffff',
        'text_color' => '#b4b8b9',
        'paypal_email' => '',
        'logo_path' => '',
        'beat_thumbnail_path' => '',
        'thank_you_page' => '<p><strong><span style="font-size: 24pt; color: #19cefb;">THANK YOU FOR USING TRANSACTION MUSIC</span></strong></p>
                    <p><span style="font-size: 24pt; color: #19cefb;">&nbsp;</span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum &nbsp;dolor sit amet, consectetur adipisicing elit. Architecto distinctio esse fuga optioratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta vitae voluptate.<br /></span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta<br />vitae voluptate.</span><br /><br /><br /> <span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam </span> <span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">Download link of your beats are sent on <span class="custom-mail-text" style="color: #20cffb;">%s</span> and will be available in next 24 hours</span></p>',
        'email_content' => '<p><strong><span style="font-size: 24pt; color: #19cefb;">THANK YOU FOR USING TRANSACTION MUSIC</span></strong></p>
                    <p><span style="font-size: 24pt; color: #19cefb;">&nbsp;</span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum &nbsp;dolor sit amet, consectetur adipisicing elit. Architecto distinctio esse fuga optioratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta vitae voluptate.<br /></span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta<br />vitae voluptate.</span><br /><br /><br /> <span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam </span> <span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
                    <p><span style="color: #1f373d; font-size: 18pt;">Download link of your beats are sent on <span class="custom-mail-text" style="color: #20cffb;">%s</span> and will be available in next 24 hours</span></p>',
    ];


    public function reset_fields( Request $request )
    {
        $response = [];

        foreach ($request->all() as $item) {
            $single_item =  ShopOption::where('meta_key', $item)->first();
            $single_item->meta_value = $this->defaults[$item];
            $single_item->save();
            $response[$item] = $single_item->meta_value;
        }

        return response()->json($response);
    }
    public function index($paypal = null)
    {
        $acc_info = User::select('email', 'password')->where('id', Auth::user()->id)->first();
        $shop_options = ShopOption::all();
        $paypal_email = '';
        $countries = [
                [ 'id'=> 'AF',  'text' => 'Afghanistan'],
                [ 'id'=> 'AX',  'text' => 'Aland Islands'],
                [ 'id'=> 'AL',  'text' => 'Albania'],
                [ 'id'=> 'DZ',  'text' => 'Algeria'],
                [ 'id'=> 'AS',  'text' => 'American Samoa'],
                [ 'id'=> 'AD',  'text' => 'Andorra'],
                [ 'id'=> 'AO',  'text' => 'Angola'],
                [ 'id'=> 'AI',  'text' => 'Anguilla'],
                [ 'id'=> 'AQ',  'text' => 'Antarctica'],
                [ 'id'=> 'AG',  'text' => 'Antigua And Barbuda'],
                [ 'id'=> 'AR',  'text' => 'Argentina'],
                [ 'id'=> 'AM',  'text' => 'Armenia'],
                [ 'id'=> 'AW',  'text' => 'Aruba'],
                [ 'id'=> 'AU',  'text' => 'Australia'],
                [ 'id'=> 'AT',  'text' => 'Austria'],
                [ 'id'=> 'AZ',  'text' => 'Azerbaijan'],
                [ 'id'=> 'BS',  'text' => 'Bahamas'],
                [ 'id'=> 'BH',  'text' => 'Bahrain'],
                [ 'id'=> 'BD',  'text' => 'Bangladesh'],
                [ 'id'=> 'BB',  'text' => 'Barbados'],
                [ 'id'=> 'BY',  'text' => 'Belarus'],
                [ 'id'=> 'BE',  'text' => 'Belgium'],
                [ 'id'=> 'BZ',  'text' => 'Belize'],
                [ 'id'=> 'BJ',  'text' => 'Benin'],
                [ 'id'=> 'BM',  'text' => 'Bermuda'],
                [ 'id'=> 'BT',  'text' => 'Bhutan'],
                [ 'id'=> 'BO',  'text' => 'Bolivia'],
                [ 'id'=> 'BA',  'text' => 'Bosnia And Herzegovina'],
                [ 'id'=> 'BW',  'text' => 'Botswana'],
                [ 'id'=> 'BV',  'text' => 'Bouvet Island'],
                [ 'id'=> 'BR',  'text' => 'Brazil'],
                [ 'id'=> 'IO',  'text' => 'British Indian Ocean Territory'],
                [ 'id'=> 'BN',  'text' => 'Brunei Darussalam'],
                [ 'id'=> 'BG',  'text' => 'Bulgaria'],
                [ 'id'=> 'BF',  'text' => 'Burkina Faso'],
                [ 'id'=> 'BI',  'text' => 'Burundi'],
                [ 'id'=> 'KH',  'text' => 'Cambodia'],
                [ 'id'=> 'CM',  'text' => 'Cameroon'],
                [ 'id'=> 'CA',  'text' => 'Canada'],
                [ 'id'=> 'CV',  'text' => 'Cape Verde'],
                [ 'id'=> 'KY',  'text' => 'Cayman Islands'],
                [ 'id'=> 'CF',  'text' => 'Central African Republic'],
                [ 'id'=> 'TD',  'text' => 'Chad'],
                [ 'id'=> 'CL',  'text' => 'Chile'],
                [ 'id'=> 'CN',  'text' => 'China'],
                [ 'id'=> 'CX',  'text' => 'Christmas Island'],
                [ 'id'=> 'CC',  'text' => 'Cocos (Keeling) Islands'],
                [ 'id'=> 'CO',  'text' => 'Colombia'],
                [ 'id'=> 'KM',  'text' => 'Comoros'],
                [ 'id'=> 'CG',  'text' => 'Congo'],
                [ 'id'=> 'CD',  'text' => 'Congo}, Democratic Republic'],
                [ 'id'=> 'CK',  'text' => 'Cook Islands'],
                [ 'id'=> 'CR',  'text' => 'Costa Rica'],
                [ 'id'=> 'CI',  'text' => 'Cote D\'Ivoire'],
                [ 'id'=> 'HR',  'text' => 'Croatia'],
                [ 'id'=> 'CU',  'text' => 'Cuba'],
                [ 'id'=> 'CY',  'text' => 'Cyprus'],
                [ 'id'=> 'CZ',  'text' => 'Czech Republic'],
                [ 'id'=> 'DK',  'text' => 'Denmark'],
                [ 'id'=> 'DJ',  'text' => 'Djibouti'],
                [ 'id'=> 'DM',  'text' => 'Dominica'],
                [ 'id'=> 'DO',  'text' => 'Dominican Republic'],
                [ 'id'=> 'EC',  'text' => 'Ecuador'],
                [ 'id'=> 'EG',  'text' => 'Egypt'],
                [ 'id'=> 'SV',  'text' => 'El Salvador'],
                [ 'id'=> 'GQ',  'text' => 'Equatorial Guinea'],
                [ 'id'=> 'ER',  'text' => 'Eritrea'],
                [ 'id'=> 'EE',  'text' => 'Estonia'],
                [ 'id'=> 'ET',  'text' => 'Ethiopia'],
                [ 'id'=> 'FK',  'text' => 'Falkland Islands (Malvinas)'],
                [ 'id'=> 'FO',  'text' => 'Faroe Islands'],
                [ 'id'=> 'FJ',  'text' => 'Fiji'],
                [ 'id'=> 'FI',  'text' => 'Finland'],
                [ 'id'=> 'FR',  'text' => 'France'],
                [ 'id'=> 'GF',  'text' => 'French Guiana'],
                [ 'id'=> 'PF',  'text' => 'French Polynesia'],
                [ 'id'=> 'TF',  'text' => 'French Southern Territories'],
                [ 'id'=> 'GA',  'text' => 'Gabon'],
                [ 'id'=> 'GM',  'text' => 'Gambia'],
                [ 'id'=> 'GE',  'text' => 'Georgia'],
                [ 'id'=> 'DE',  'text' => 'Germany'],
                [ 'id'=> 'GH',  'text' => 'Ghana'],
                [ 'id'=> 'GI',  'text' => 'Gibraltar'],
                [ 'id'=> 'GR',  'text' => 'Greece'],
                [ 'id'=> 'GL',  'text' => 'Greenland'],
                [ 'id'=> 'GD',  'text' => 'Grenada'],
                [ 'id'=> 'GP',  'text' => 'Guadeloupe'],
                [ 'id'=> 'GU',  'text' => 'Guam'],
                [ 'id'=> 'GT',  'text' => 'Guatemala'],
                [ 'id'=> 'GG',  'text' => 'Guernsey'],
                [ 'id'=> 'GN',  'text' => 'Guinea'],
                [ 'id'=> 'GW',  'text' => 'Guinea-Bissau'],
                [ 'id'=> 'GY',  'text' => 'Guyana'],
                [ 'id'=> 'HT',  'text' => 'Haiti'],
                [ 'id'=> 'HM',  'text' => 'Heard Island & Mcdonald Islands'],
                [ 'id'=> 'VA',  'text' => 'Holy See (Vatican City State)'],
                [ 'id'=> 'HN',  'text' => 'Honduras'],
                [ 'id'=> 'HK',  'text' => 'Hong Kong'],
                [ 'id'=> 'HU',  'text' => 'Hungary'],
                [ 'id'=> 'IS',  'text' => 'Iceland'],
                [ 'id'=> 'IN',  'text' => 'India'],
                [ 'id'=> 'ID',  'text' => 'Indonesia'],
                [ 'id'=> 'IR',  'text' => 'Iran}, Islamic Republic Of'],
                [ 'id'=> 'IQ',  'text' => 'Iraq'],
                [ 'id'=> 'IE',  'text' => 'Ireland'],
                [ 'id'=> 'IM',  'text' => 'Isle Of Man'],
                [ 'id'=> 'IL',  'text' => 'Israel'],
                [ 'id'=> 'IT',  'text' => 'Italy'],
                [ 'id'=> 'JM',  'text' => 'Jamaica'],
                [ 'id'=> 'JP',  'text' => 'Japan'],
                [ 'id'=> 'JE',  'text' => 'Jersey'],
                [ 'id'=> 'JO',  'text' => 'Jordan'],
                [ 'id'=> 'KZ',  'text' => 'Kazakhstan'],
                [ 'id'=> 'KE',  'text' => 'Kenya'],
                [ 'id'=> 'KI',  'text' => 'Kiribati'],
                [ 'id'=> 'KR',  'text' => 'Korea'],
                [ 'id'=> 'KW',  'text' => 'Kuwait'],
                [ 'id'=> 'KG',  'text' => 'Kyrgyzstan'],
                [ 'id'=> 'LA',  'text' => 'Lao People\'s Democratic Republic'],
                [ 'id'=> 'LV',  'text' => 'Latvia'],
                [ 'id'=> 'LB',  'text' => 'Lebanon'],
                [ 'id'=> 'LS',  'text' => 'Lesotho'],
                [ 'id'=> 'LR',  'text' => 'Liberia'],
                [ 'id'=> 'LY',  'text' => 'Libyan Arab Jamahiriya'],
                [ 'id'=> 'LI',  'text' => 'Liechtenstein'],
                [ 'id'=> 'LT',  'text' => 'Lithuania'],
                [ 'id'=> 'LU',  'text' => 'Luxembourg'],
                [ 'id'=> 'MO',  'text' => 'Macao'],
                [ 'id'=> 'MK',  'text' => 'Macedonia'],
                [ 'id'=> 'MG',  'text' => 'Madagascar'],
                [ 'id'=> 'MW',  'text' => 'Malawi'],
                [ 'id'=> 'MY',  'text' => 'Malaysia'],
                [ 'id'=> 'MV',  'text' => 'Maldives'],
                [ 'id'=> 'ML',  'text' => 'Mali'],
                [ 'id'=> 'MT',  'text' => 'Malta'],
                [ 'id'=> 'MH',  'text' => 'Marshall Islands'],
                [ 'id'=> 'MQ',  'text' => 'Martinique'],
                [ 'id'=> 'MR',  'text' => 'Mauritania'],
                [ 'id'=> 'MU',  'text' => 'Mauritius'],
                [ 'id'=> 'YT',  'text' => 'Mayotte'],
                [ 'id'=> 'MX',  'text' => 'Mexico'],
                [ 'id'=> 'FM',  'text' => 'Micronesia}, Federated States Of'],
                [ 'id'=> 'MD',  'text' => 'Moldova'],
                [ 'id'=> 'MC',  'text' => 'Monaco'],
                [ 'id'=> 'MN',  'text' => 'Mongolia'],
                [ 'id'=> 'ME',  'text' => 'Montenegro'],
                [ 'id'=> 'MS',  'text' => 'Montserrat'],
                [ 'id'=> 'MA',  'text' => 'Morocco'],
                [ 'id'=> 'MZ',  'text' => 'Mozambique'],
                [ 'id'=> 'MM',  'text' => 'Myanmar'],
                [ 'id'=> 'NA',  'text' => 'Namibia'],
                [ 'id'=> 'NR',  'text' => 'Nauru'],
                [ 'id'=> 'NP',  'text' => 'Nepal'],
                [ 'id'=> 'NL',  'text' => 'Netherlands'],
                [ 'id'=> 'AN',  'text' => 'Netherlands Antilles'],
                [ 'id'=> 'NC',  'text' => 'New Caledonia'],
                [ 'id'=> 'NZ',  'text' => 'New Zealand'],
                [ 'id'=> 'NI',  'text' => 'Nicaragua'],
                [ 'id'=> 'NE',  'text' => 'Niger'],
                [ 'id'=> 'NG',  'text' => 'Nigeria'],
                [ 'id'=> 'NU',  'text' => 'Niue'],
                [ 'id'=> 'NF',  'text' => 'Norfolk Island'],
                [ 'id'=> 'MP',  'text' => 'Northern Mariana Islands'],
                [ 'id'=> 'NO',  'text' => 'Norway'],
                [ 'id'=> 'OM',  'text' => 'Oman'],
                [ 'id'=> 'PK',  'text' => 'Pakistan'],
                [ 'id'=> 'PW',  'text' => 'Palau'],
                [ 'id'=> 'PS',  'text' => 'Palestinian Territory}, Occupied'],
                [ 'id'=> 'PA',  'text' => 'Panama'],
                [ 'id'=> 'PG',  'text' => 'Papua New Guinea'],
                [ 'id'=> 'PY',  'text' => 'Paraguay'],
                [ 'id'=> 'PE',  'text' => 'Peru'],
                [ 'id'=> 'PH',  'text' => 'Philippines'],
                [ 'id'=> 'PN',  'text' => 'Pitcairn'],
                [ 'id'=> 'PL',  'text' => 'Poland'],
                [ 'id'=> 'PT',  'text' => 'Portugal'],
                [ 'id'=> 'PR',  'text' => 'Puerto Rico'],
                [ 'id'=> 'QA',  'text' => 'Qatar'],
                [ 'id'=> 'RE',  'text' => 'Reunion'],
                [ 'id'=> 'RO',  'text' => 'Romania'],
                [ 'id'=> 'RU',  'text' => 'Russian Federation'],
                [ 'id'=> 'RW',  'text' => 'Rwanda'],
                [ 'id'=> 'BL',  'text' => 'Saint Barthelemy'],
                [ 'id'=> 'SH',  'text' => 'Saint Helena'],
                [ 'id'=> 'KN',  'text' => 'Saint Kitts And Nevis'],
                [ 'id'=> 'LC',  'text' => 'Saint Lucia'],
                [ 'id'=> 'MF',  'text' => 'Saint Martin'],
                [ 'id'=> 'PM',  'text' => 'Saint Pierre And Miquelon'],
                [ 'id'=> 'VC',  'text' => 'Saint Vincent And Grenadines'],
                [ 'id'=> 'WS',  'text' => 'Samoa'],
                [ 'id'=> 'SM',  'text' => 'San Marino'],
                [ 'id'=> 'ST',  'text' => 'Sao Tome And Principe'],
                [ 'id'=> 'SA',  'text' => 'Saudi Arabia'],
                [ 'id'=> 'SN',  'text' => 'Senegal'],
                [ 'id'=> 'RS',  'text' => 'Serbia'],
                [ 'id'=> 'SC',  'text' => 'Seychelles'],
                [ 'id'=> 'SL',  'text' => 'Sierra Leone'],
                [ 'id'=> 'SG',  'text' => 'Singapore'],
                [ 'id'=> 'SK',  'text' => 'Slovakia'],
                [ 'id'=> 'SI',  'text' => 'Slovenia'],
                [ 'id'=> 'SB',  'text' => 'Solomon Islands'],
                [ 'id'=> 'SO',  'text' => 'Somalia'],
                [ 'id'=> 'ZA',  'text' => 'South Africa'],
                [ 'id'=> 'GS',  'text' => 'South Georgia And Sandwich Isl.'],
                [ 'id'=> 'ES',  'text' => 'Spain'],
                [ 'id'=> 'LK',  'text' => 'Sri Lanka'],
                [ 'id'=> 'SD',  'text' => 'Sudan'],
                [ 'id'=> 'SR',  'text' => 'Suriname'],
                [ 'id'=> 'SJ',  'text' => 'Svalbard And Jan Mayen'],
                [ 'id'=> 'SZ',  'text' => 'Swaziland'],
                [ 'id'=> 'SE',  'text' => 'Sweden'],
                [ 'id'=> 'CH',  'text' => 'Switzerland'],
                [ 'id'=> 'SY',  'text' => 'Syrian Arab Republic'],
                [ 'id'=> 'TW',  'text' => 'Taiwan'],
                [ 'id'=> 'TJ',  'text' => 'Tajikistan'],
                [ 'id'=> 'TZ',  'text' => 'Tanzania'],
                [ 'id'=> 'TH',  'text' => 'Thailand'],
                [ 'id'=> 'TL',  'text' => 'Timor-Leste'],
                [ 'id'=> 'TG',  'text' => 'Togo'],
                [ 'id'=> 'TK',  'text' => 'Tokelau'],
                [ 'id'=> 'TO',  'text' => 'Tonga'],
                [ 'id'=> 'TT',  'text' => 'Trinidan And Tobago'],
                [ 'id'=> 'TN',  'text' => 'Tunisia'],
                [ 'id'=> 'TR',  'text' => 'Turkey'],
                [ 'id'=> 'TM',  'text' => 'Turkmenistan'],
                [ 'id'=> 'TC',  'text' => 'Turks And Caicos Islands'],
                [ 'id'=> 'TV',  'text' => 'Tuvalu'],
                [ 'id'=> 'UG',  'text' => 'Uganda'],
                [ 'id'=> 'UA',  'text' => 'Ukraine'],
                [ 'id'=> 'AE',  'text' => 'United Arab Emirates'],
                [ 'id'=> 'GB',  'text' => 'United Kingdom'],
                [ 'id'=> 'US',  'text' => 'United States'],
                [ 'id'=> 'UM',  'text' => 'United States Outlying Islands'],
                [ 'id'=> 'UY',  'text' => 'Uruguay'],
                [ 'id'=> 'UZ',  'text' => 'Uzbekistan'],
                [ 'id'=> 'VU',  'text' => 'Vanuatu'],
                [ 'id'=> 'VE',  'text' => 'Venezuela'],
                [ 'id'=> 'VN',  'text' => 'Viet Nam'],
                [ 'id'=> 'VG',  'text' => 'Virgin Islands}, British'],
                [ 'id'=> 'VI',  'text' => 'Virgin Islands}, U.S.'],
                [ 'id'=> 'WF',  'text' => 'Wallis And Futuna'],
                [ 'id'=> 'EH',  'text' => 'Western Sahara'],
                [ 'id'=> 'YE',  'text' => 'Yemen'],
                [ 'id'=> 'ZM',  'text' => 'Zambia'],
                [ 'id'=> 'ZW',  'text' => 'Zimbabwe'],
        ];
        $shop = new ShopOption();

        foreach ($shop_options as $key => $shop_option) {
            $shop->{$shop_option->meta_key} = $shop_option->meta_value;
            if( $shop_option->meta_key == 'order_paypal_email' || $shop_option->meta_key == 'paypal_email' ){
                $paypal_email = $shop_option->meta_value;
            }
        }
        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        (  $paypal_email == "" ) ? JavaScript::put(['message' => 'You must first enter paypal email, beat default thumbnail and category thumbnail' ,'type' => 'error']) : '';

        return view('admin.shopOptions.index', compact('shop', 'acc_info', 'countries') );
    }

    public function store(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->email = $request->master_email;
        $request->master_password === $user->password ? '' : $user->password = Hash::make($request->master_password);

        $env = file_get_contents(base_path('.env'));
        $env = str_replace(env('APP_NAME'), $request->sub_name, $env);

        try{
           $user->save();
           file_put_contents(base_path('.env'), $env);
        } catch(Exception $ex){
            $ex->getMessage();
        }

        $update_array = $request->all();
        unset($update_array['_token']);
        unset($update_array['master_email']);
        unset($update_array['master_password']);
        unset($update_array['sub_name']);
        $data = [];

        foreach ($update_array as $key => $single_request) {
            $shop = ShopOption::where('meta_key', $key)->first();

            if ( $shop == null ) {
                if( $request->hasFile($key) ){
                    $data[] = [ 'meta_key' => $key, 'meta_value' => $this->uploadPhoto($request->files->all()[$key], 'images/shop_options', 200, 200)];
                } else {
                    $data[] = [ 'meta_key' => $key, 'meta_value' => $single_request ];
                }

            } else {
                if( $request->hasFile($key) ){
                    $shop->meta_value =  $this->uploadPhoto($request->files->all()[$key], 'images/shop_options', 200, 200);
                } else {
                    $shop->meta_value = $single_request;
                }
                try{
                    $shop->save();
                } catch(Exception $ex){
                    $ex->getMessage();
                }
            }
        }

        if( !empty($data) ){
            try {
                ShopOption::insert($data);
            } catch (Exception $e) {
                return redirect('/admin/shop_options')->with('data', [ 'message'  => $e->getMessage(), 'type' => 'error']);
            }
        }

        $this->color_css();

        return redirect('/admin/shop_options')->with('data', [ 'message'  => 'Successfully updated shop options', 'type' => 'success']);
    }
    public function embed()
    {
        $embed_width = ShopOption::where('meta_key', 'embed_width')->first()['meta_value'];
        $embed_height = ShopOption::where('meta_key', 'embed_height')->first()['meta_value'];

        JavaScript::put(['getSiteUrl' => url('embed/player')]);

        return view('admin.embed.index', ['embed_width' => (int)$embed_width ,'embed_height' => (int)$embed_height, ]);
    }
    public function store_embed(Request $request)
    {
        $embeds = ShopOption::where('meta_key', 'LIKE', 'embed%')->get();

        if( $embeds->isEmpty())
        {
            ShopOption::insert([['meta_key' => 'embed_width', 'meta_value' => $request->width],
                ['meta_key' => 'embed_height', 'meta_value' => $request->height]]);

        } else {
            foreach ($embeds as $embed) {
                if($embed->meta_key == 'embed_height'){
                    $embed->meta_value = $request->height;
                } else {
                    $embed->meta_value = $request->width;
                }

                try{
                    $embed->save();
                } catch(Exception $ex){
                    $ex->getMessage();
                }
            }
            return redirect('/admin/embed');
        }
        return redirect('/admin/embed');
    }
    public function embed_code()
    {
        $newest_beats = DB::select(DB::raw('
            SELECT
            beats.title as beat_title,
            (

                            SELECT beats.bpm

                         ) AS bpm,

            (

            SELECT GROUP_CONCAT(categories.title) FROM `beat_categories`
                            INNER JOIN categories on categories.id = beat_categories.category_id
                            INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
                            INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
                            WHERE taxonomies.id = 3 AND beat_categories.beat_id = beats.id

            ) AS producer,

            (
            SELECT GROUP_CONCAT(categories.title) FROM `beat_categories`
                            INNER JOIN categories on categories.id = beat_categories.category_id
                            INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
                            INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
                            WHERE taxonomies.id = 1 AND beat_categories.beat_id = beats.id
            ) AS genre,

            beats.id as beat_id,
            beats.bpm as beat_bpm,
            beats.created_at as beat_created_at

             FROM `beats`

            INNER JOIN beat_categories ON  beat_categories.beat_id = beats.id
            INNER JOIN categories ON  beat_categories.category_id = categories.id
            INNER JOIN category_taxonomies ON  category_taxonomies.category_id = categories.id
            INNER JOIN taxonomies ON  category_taxonomies.taxonomy_id = taxonomies .id

            ORDER BY beats.created_at, \'desc\' LIMIT 6;

        '));

        foreach ($newest_beats as $newest_beat) {
            $newest_beat->beat_created_at = $this->human_time(strtotime($newest_beat->beat_created_at));
        }

        $paypal_mail = ShopOption::where('meta_key', 'paypal_email')->first()->meta_value;

        JavaScript::put([ 'data' =>  json_decode( file_get_contents(public_path() . '/json_resources/data.json') ) ]);

        return view('admin.embed.code', ['newest_beats' => $newest_beats, 'paypal_mail' => $paypal_mail]);
    }
    private function color_css()
    {
        $colors = ShopOption::where('meta_key', 'LIKE', '%color%')->get()->toArray();
        foreach ($colors as $color) {
            ${$color['meta_key']} = $color['meta_value'];
        }
        ob_start();
        include('css/dynamic_admin-css.php');

        $admin_content = ob_get_contents();
        file_put_contents('css/dynamic_admin.css', $admin_content);
        ob_end_clean();
        ob_start();
        include('css/dynamic_front-css.php');

        $front_content = ob_get_contents();
        file_put_contents('css/dynamic_front.css', $front_content);
        ob_end_clean();
    }

    public function instance_state($state)
    {
        $instance_state = ShopOption::where('meta_key', 'instance_active')->first();
        $instance_state->meta_value = $state;

        try{
            $instance_state->save();
        } catch(Exception $ex){
            return response()->json( [ 'error' => $ex->getMessage() ] );
        }

        return response(200);
    }
}
