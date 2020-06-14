<?php 
 namespace App\Http\Controllers\Admin;
class AdminCustomersPush {
 
    public function send($title='', $message='',$registration_ids='',$type='',$status='', $checkUser='') {
        if($checkUser == ''){
            // $data=array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000));
    
            if($type==''){
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'sound'=>'default'),
                    'data' => array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000)),
                    'registration_ids' => $registration_ids,
                    //'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }/*else{
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'status' => $status,'sound' => 'default', 'server_time'=>round(microtime(true) * 1000), 'badge' => '1'),
                    'data' => $data,
                    //'registration_ids' => $registration_ids,
                    'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }*/
            return $this->sendPushNotification($fields);
        } else {
            // $data=array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000), 'api_action' => 'forceLogout');
    
            if($type==''){
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'sound'=>'default'),
                    'data' => array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000), 'api_action' => 'forceLogout'),
                    'registration_ids' => $registration_ids,
                    //'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }/*else{
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'status' => $status,'sound' => 'default', 'server_time'=>round(microtime(true) * 1000), 'badge' => '1', 'api_action' => 'forceLogout'),
                    'data' => $data,
                    //'registration_ids' => $registration_ids,
                    'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }*/
            return $this->sendPushNotification($fields);
        }
            
    }
    
    /*
    * This function will make the actuall curl request to firebase server
    * and then the message is sent 
    */
    private function sendPushNotification($fields) {
        
        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        //building headers for the request
        $headers = array(
            'Authorization: key=AAAA15mA2AI:APA91bGPH7XfeMXuFtLkg-tlvOD0LhECxYWtOmfEM5URcr1cFN4BQtMwo2X84DH7WXiFKZbA8nVPlq5RQ4Dn0ZevqApSaku8sWi6vuPs8MWWdCyuT9koZ3jS6upAa0LLrjRQIEdC0GzT',
            'Content-Type: application/json'
        );
 
        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
 
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);
 
        //and return the result 
        return $result;
    }
}