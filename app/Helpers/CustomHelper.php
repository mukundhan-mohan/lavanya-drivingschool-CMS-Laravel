<?php

namespace App\Helpers;

use App\Models\Role;
use App\Models\Country;
use App\Models\Tag;
use App\Models\TagMapping;
use DB;
use Carbon\Carbon;

class CustomHelper
{
    /**
     * Save the uploaded image.
     *
     * @param UploadedFile $file     Uploaded file.
     * @param int          $maxWidth
     * @param string       $path
     * @param Closure      $callback Custom file naming method.
     *
     * @return string File name.
     */
    public static function convertDate($date)
    {
        return date("m-d-Y", strtotime($date));
    }

    public static function monthfirst($date){
		$date = Carbon::parse($date)->format('M d, Y');
		return $date;
	}

  public static function sixDigitCode() {
		return mt_rand(10000, 99999);
	}

    public function getSerialNumber(): string
{
   $lastUsedSerialNumber = licence_entries::query()->orderByDesc('serial_number')->first();
   // explode by - so you have your tho sequences of the number
   $parts = explode('-', $lastUsedSerialNumber);
   // if second part is 999, increment first part, from AAB to AAC, and set 
   // second sequence to 000;
   if ((int) $parts[1] === 999) {
     $parts[0] = $parts[0]++;
     $parts[1] = 000;
   }
   // increment second sequence if lower than 999
   if ((int) $parts[1] < 999) {
      $parts[1] = str_pad(++$parts[1], 3, '0', STR_PAD_LEFT);
   }
   return $parts[0] . '-' . $parts[1];

}

public static function whatsappSms($msg,$phone_number)
    {
        
        $username="mukundhan";

        $password="!Mukundhan1";

        $message= $msg;

        $mobile_number= $phone_number;

        $url ="https://login.bulksmsgateway.in/textmobilesmsapi.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&type=".urlencode('3');

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_scraped_page = curl_exec($ch);

        curl_close($ch);
    }
   
}
