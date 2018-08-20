<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    public $table = "notifications";
    protected $primaryKey = "notification_id";

    protected $fillable = ['title', 'message', 'status'];

    public static function commonNotification($title, $message, $fcm_id, $count)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
            
        $fields = '{
            "to": "'.$fcm_id.'",
            "data": {
                "body":"'.$message.'",
                "title":"'.$title.'",
                "badge":"'.$count.'",
                 "notiType":"0"
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
            "priority" : "high",
            "data": {
                "body":"User looking for hotel",
                "user_id":"'.$collect['user_id'].'",
                "user_name":"'.$collect['name'].'",
                "user_email":"'.$collect['email'].'",
                "user_number":"'.$collect['number'].'",
                "user_building":"'.$collect['building'].'",
                "user_street":"'.$collect['street'].'",
                "user_landmark":"'.$collect['landmark'].'",
                "user_city":"'.$collect['city'].'",
                "user_state":"'.$collect['state'].'",
                "reference_id":"'.$collect['reference_id'].'",
                "roomtype":"'.$collect['roomtype'].'",
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

    public static function hotelacceptNotification($fcm_id, $collect)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
            
        $fields = '{
            "to": "'.$fcm_id.'",
            "data": {
                "body":"'.$collect['hotel_name'].' accepted your booking",
                "hotel_id":"'.$collect['hotel_data_id'].'",
                "roomtype":"'.$collect['roomtype'].'",
                 "notiType":"2"
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

    public static function otherhotelacceptNotification($fcm_id)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
            
        $fields = '{
            "to": "'.$fcm_id.'",
            "data": {
                "body":"Some other hotel accepted this users request",
                 "notiType":"3"
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

    public static function hotelnoresponseNotification($fcm_id)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
            
        $fields = '{
            "to": "'.$fcm_id.'",
            "data": {
                "body":"Sorry! No response, please try after sometime",
                 "notiType":"4"
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
