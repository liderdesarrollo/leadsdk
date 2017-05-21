<?php
    
    /*
        App Id : 830126147162941
        App Secret : 48e2ab802436fe7b967913a7018490bf
        Short Live Access Token : EAALyZCs4e0z0BAGDfV6tpZCDKHWSXQGgKyNlLaxCJqCJ6gZCrEJWJ0Tij4ZBjudMGRVTJSbeAf9ZBXCzVJSrSq8Bg19JP93XgxYs0GgQ48nIJdCWeFH65d2P9Ay1dQoZASvfNVWwJnMgAgDw41FI7xQ5iey9mSBt4ICTaZAgs3qa3GUB8NccujtKgqQeY83BREZD
    
        {
          "access_token": "EAALyZCs4e0z0BAJq1Y8ZCq46SiT1DfeppMHfyF9cVjzZCske3p9vzcUmG3VW4TYfIGZBkI6ZCdSlgndZBSG3dTWapIzsxl93k4bescIlAk6c0J8ZBzjbaH8pcqe3qfu99RwZB5ZBrf8EcYrOeeoCEiycjZCwDB5FWL6IYZD",
          "token_type": "bearer",
          "expires_in": 5183999
        }
    */
    
    $challenge = $_REQUEST["hub_challenge"];
    $verify_token = $_REQUEST["hub_verify_token"];
    
    if($verify_token == "abc123"){
        echo $challenge;
    }
    
    $data = json_decode(file_get_contents("php://input"),true);
    error_log(json_encode($data));
    $gen_id = $data['entry'][0]['changes'][0]['value']['leadgen_id'];
    $form_id = $data['entry'][0]['changes'][0]['value']['form_id'];
    
    $ch = curl_init();
    $url = "https://graph.facebook.com/v2.9/".$gen_id;
    $url_query = "access_token=EAALyZCs4e0z0BAJq1Y8ZCq46SiT1DfeppMHfyF9cVjzZCske3p9vzcUmG3VW4TYfIGZBkI6ZCdSlgndZBSG3dTWapIzsxl93k4bescIlAk6c0J8ZBzjbaH8pcqe3qfu99RwZB5ZBrf8EcYrOeeoCEiycjZCwDB5FWL6IYZD"; // you have to subscribe to the page that has the form to generate an Access Token
    $url_final = $url.'?'.$url_query;
    curl_setopt($ch, CURLOPT_URL, $url_final);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close ($ch);
    $data = json_decode($response, true);
    
    $lead_first = "Anonimo";
    $lead_last = "";
    $lead_email = "sincorreo@gmail.com";
    $phone = "1234";
    $facebook = "http://facebook.com";
    
    $id_form = $data["id"];
    
    ob_start();
        var_dump($form_id);
        var_dump($data);
    error_log(ob_get_clean());
    
    if($form_id == "198579217265271"){
        
        $lead_email = $data['field_data'][1][values][0];
        $lead_first = $data['field_data'][2][values][0];
        $lead_last = $data['field_data'][2][values][0];
        $phone = $data['field_data'][3][values][0];;
        
        $facebook = "https://www.facebook.com/felicident";
            
    }


