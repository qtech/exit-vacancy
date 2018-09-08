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
               },
            "notification": {
                "body":"'.$message.'",
                "title":"'.$title.'",
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

    public static function nearbyhotelNotification($fcm_id, $device, $collect)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        if($device != NULL)
        {
            if($device == 'android')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "priority" : "high",
                    "data": {
                        "body":"User looking for hotel",
                        "user_id":"'.$collect['user_id'].'",
                        "user_name":"'.$collect['name'].'",
                        "user_email":"'.$collect['email'].'",
                        "user_number":"'.$collect['number'].'",
                        "reference_id":"'.$collect['reference_id'].'",
                        "roomtype":"'.$collect['roomtype'].'",
                        "amount":"'.$collect['amount'].'",
                         "notiType":"1"
                       }
                }';
            }

            if($device == 'ios')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "priority" : "high",
                    "data": {
                        "body":"User looking for hotel",
                        "user_id":"'.$collect['user_id'].'",
                        "user_name":"'.$collect['name'].'",
                        "user_email":"'.$collect['email'].'",
                        "user_number":"'.$collect['number'].'",
                        "reference_id":"'.$collect['reference_id'].'",
                        "roomtype":"'.$collect['roomtype'].'",
                        "amount":"'.$collect['amount'].'",
                         "notiType":"1"
                       },
                    "notification": {
                        "body":"User looking for hotel",
                        "user_id":"'.$collect['user_id'].'",
                        "user_name":"'.$collect['name'].'",
                        "user_email":"'.$collect['email'].'",
                        "user_number":"'.$collect['number'].'",
                        "reference_id":"'.$collect['reference_id'].'",
                        "roomtype":"'.$collect['roomtype'].'",
                        "amount":"'.$collect['amount'].'",
                         "notiType":"0"
                       }
                }';
            }
        }
        else
        {
            $error = "Oops! Something went wrong"; 
            return $error;
        }
        
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

    public static function hotelacceptNotification($fcm_id, $device, $collect)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        if($device != NULL)
        {
            if($device == 'android')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"'.$collect['hotel_name'].' accepted your booking. You have successfully payed $'.$collect['price'].' for this booking.",
                        "hotel_id":"'.$collect['hotel_data_id'].'",
                        "hotel_owner_id":"'.$collect['hotel_owner_id'].'",
                        "roomtype":"'.$collect['roomtype'].'",
                        "ref_id":"'.$collect['ref_id'].'",
                         "notiType":"2"
                       }
                }';
            }

            if($device == 'ios')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"'.$collect['hotel_name'].' accepted your booking. You have successfully payed $'.$collect['price'].' for this booking.",
                        "hotel_id":"'.$collect['hotel_data_id'].'",
                        "hotel_owner_id":"'.$collect['hotel_owner_id'].'",
                        "roomtype":"'.$collect['roomtype'].'",
                        "ref_id":"'.$collect['ref_id'].'",
                         "notiType":"2"
                       },
                    "notification": {
                        "body":"'.$collect['hotel_name'].' accepted your booking. You have successfully payed $'.$collect['price'].' for this booking.",
                        "hotel_id":"'.$collect['hotel_data_id'].'",
                        "hotel_owner_id":"'.$collect['hotel_owner_id'].'",
                        "roomtype":"'.$collect['roomtype'].'",
                        "ref_id":"'.$collect['ref_id'].'",
                         "notiType":"2"
                       }
                }';       
            }
        }
        else
        {
            $error = "Oops! Something went wrong"; 
            return $error;
        }

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

    public static function otherhotelacceptNotification($fcm_id, $device)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        if($device != NULL)
        {
            if($device == 'android')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"Some other hotel accepted this users request",
                         "notiType":"3"
                       }
                }';
            }

            if($device == 'ios')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"Some other hotel accepted this users request",
                         "notiType":"3"
                       },
                    "notification": {
                        "body":"Some other hotel accepted this users request",
                         "notiType":"3"
                       }
                }';
            }
        }
        else
        {
            $error = "Oops! Something went wrong"; 
            return $error;
        }
        
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

    public static function hotelnoresponseNotification($fcm_id, $device)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        if($device != NULL)
        {
            if($device == 'android')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"Sorry! No response, please try after sometime",
                         "notiType":"4"
                    }
                }';
            }

            if($device == 'ios')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"Sorry! No response, please try after sometime",
                         "notiType":"4"
                    },
                    "notification": {
                        "body":"Sorry! No response, please try after sometime",
                         "notiType":"4"
                    }
                }';
            }
        }
        else
        {
            $error = "Oops! Something went wrong"; 
            return $error;
        }
        
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

    public static function accountstatusNotification($fcm_id, $device, $msg)
    {
        //define('GOOGLE_API_KEY','AIzaSyAkWTvVkFdHXGPfNjsTxFTTxN13gSr0efQ');
        $key = 'AIzaSyA0JKIDq5Jj8ia_bHE66vlVXRIZv_Rgdi0';
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        if($device != NULL)
        {
            if($device == 'android')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"'.$msg.'",
                         "notiType":"3"
                       }
                }';
            }

            if($device == 'ios')
            {
                $fields = '{
                    "to": "'.$fcm_id.'",
                    "data": {
                        "body":"'.$msg.'",
                         "notiType":"3"
                       },
                    "notification": {
                        "body":"'.$msg.'",
                         "notiType":"3"
                       }
                }';
            }
        }
        else
        {
            $error = "Oops! Something went wrong"; 
            return $error;
        }
        
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
