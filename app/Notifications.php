<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    public $table = "notifications";
    protected $primaryKey = "notification_id";

    protected $fillable = ['title', 'message'];

    public static function commonNotification($title, $message, $fcm_id, $count)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
            
        $fields = '{
            "to": "'.$fcm_id.'",
            "data": {
                "body":"New Notification",
                "title":"'.$title.'",
                "message": "'.$message.'",
                "badge":"'.$count.'",
                 "notiType":"0"
               },
            "notification": {
                "body":"New Notification",
                "title":"'.$title.'",
                "message": "'.$message.'",
                "badge":"'.$count.'",
                "notiType":"1"
            }
        }';
        
        $headers = [
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        //print_r(json_encode($fields)); exit;
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        
        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return $result; 
    }

    public static function nearbyhotelNotification($fcm_id, $collect)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
            
        $fields = '{
            "to": "'.$fcm_id.'",
            "data": {
                "body":"User looking for hotel",
                "user_name":"'.$collect['name'].'",
                "user_email":"'.$collect['email'].'",
                "user_number":"'.$collect['number'].'",
                "user_building":"'.$collect['building'].'",
                "user_street":"'.$collect['street'].'",
                "user_landmark":"'.$collect['landmark'].'",
                "user_city":"'.$collect['city'].'",
                "user_state":"'.$collect['state'].'",
                 "notiType":"0"
               },
            "notification": {
                "body":"User looking for hotel",
                "user_name":"'.$collect['name'].'",
                "user_email":"'.$collect['email'].'",
                "user_number":"'.$collect['number'].'",
                "user_building":"'.$collect['building'].'",
                "user_street":"'.$collect['street'].'",
                "user_landmark":"'.$collect['landmark'].'",
                "user_city":"'.$collect['city'].'",
                "user_state":"'.$collect['state'].'",
                "notiType":"1"
            }
        }';
        
        $headers = [
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        //print_r(json_encode($fields)); exit;
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        
        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return $result; 
    }
}
