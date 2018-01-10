<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DateTimeZone;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use File;
use DB;
use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;
use RecursiveIteratorIterator;
use FilesystemIterator;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function setMail($username, $pw, $smtp = 'smtp.gmail.com', $port = 587, $encryption = 'tls')
    {
        $transport = SmtpTransport::newInstance($smtp, $port, $encryption);
        $transport->setEncryption($encryption);
        $transport->setUsername(''.$username.'');
        $transport->setPassword(''.$pw.'');
        $swift = new \Swift_Mailer($transport);
        Mail::setSwiftMailer($swift);
    }

    protected function uploadPhoto($name, $path, $height = null, $width = null )
    {
        $new_path = '';
        $tz = new DateTimeZone('Europe/Belgrade');
        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
        $d->setTimezone($tz);
        $picname = $d->format("Y-m-d-H-i-u") . '.' . $name->getClientOriginalExtension();
        $year = date("Y");
        $month = date("m");

        //check if year folder exists and make folder with name of current year if not exist
        if(!file_exists($path.'/'.$year)){
            File::makeDirectory($path.'/'.$year, 0775);
        }

        //check if month folder exists and make folder with name of current month if not exist
        if(!file_exists($path.'/'.$year.'/'.$month)) {
            File::makeDirectory($path.'/'.$year.'/'.$month, 0775);
        }
        $new_path = $path .'/'. $year .'/'.$month;
//        $new_path = ;
        //image resize
        if($height != null && is_int($height) && $width != null && is_int($width) ){
            $file = Image::make($name)->resize($width, $height);
            $file->save($new_path.'/'.$picname);
        } else {
            $file = $name;
            $file->move($new_path, $picname);
        }

        $new_path = url($new_path) .'/'. $picname;

        return $new_path;
    }

    protected function average($beat_id)
    {
        $avg = DB::select(DB::raw("SELECT AVG(amount) as avg FROM rates WHERE beat_id = '$beat_id';"));

        return (float)($avg[0]->avg);
    }

    protected function human_time($time)
    {
        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }


    }

    protected function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }

    protected function get_key_twodim_array($array, $field, $value)
    {
        foreach($array as $key => $product)
        {
            if ( $product[$field] === $value )
                return $key;
        }
        return false;
    }

    protected function get_directory_size($path)
    {
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }

        return number_format((float)$bytestotal / 1048576, 2, '.', '');
    }

    protected function delete_beat_file($beat_file_path)
    {
        $beat_path = explode( '/', substr_replace( $beat_file_path, '', 0, strpos( $beat_file_path, 'beats' ) ) );
        $beat_path = implode('/', $beat_path);
        $beat_fixed_path = public_path($beat_path);
        try{
            File::delete($beat_fixed_path);
        } catch(Exception $ex){
            $ex->getMessage();
        }
    }

    protected function delete_beat_dirs($beat_file_paths)
    {
        foreach ($beat_file_paths as $file_path) {

            $beat_path = explode( '/', substr_replace( $file_path, '', 0, strpos( $file_path, 'beats' ) ) );
            unset( $beat_path[count($beat_path) - 1], $beat_path[count($beat_path) - 1] );
            $beat_path = public_path( implode('/', $beat_path) );
            if(File::exists($beat_path)){
                try{
                    File::deleteDirectory($beat_path);
                } catch(Exception $ex){
                    $ex->getMessage();
                }
            }
        }
    }
}
