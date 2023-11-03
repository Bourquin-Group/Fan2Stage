<?php

function send_notification_FCM($FcmToken,$title, $body, $event_id, $status, $type){
 
    $url = 'https://fcm.googleapis.com/fcm/send';

    // $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        
    $serverKey = env('FCM_KEY'); // ADD SERVER KEY HERE PROVIDED BY FCM
    // $serverKey = 'AAAAQpJl2UQ:APA91bEhJEHUHEpD6WeZk1cb94A3wNSgP-zjDHQS_DeF7mvLns1zGb8VFJHPIllvHr3EvzN0lCE941ju4XjtWXZL25rci0IQuikXa28DocrgKPqPARE9GdgL-NIUMBOQ2tmhUbwSStvf'; // ADD SERVER KEY HERE PROVIDED BY FCM

    $data = [
        "registration_ids" => $FcmToken,
        "notification" => [
            "title" => $title,
            "body" => $body,  
        ],
     "data" => [
            "event_id" => $event_id,
            "isLiveEvent" => $status,
            "event_states" => $type, 
        ]
    ];
    $encodedData = json_encode($data);

    $headers = [
        'Authorization:key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
    // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    // Close connection
    curl_close($ch);
    // return $result_noti;
     
  
 }