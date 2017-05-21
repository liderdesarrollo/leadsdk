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
    
    $id_form = $data["id"];
    
    if($form_id == "1876724585924467"){
        
        $escoge_el_programa_de_tu_interes = $data['field_data'][0]["values"][0];
        $full_name = $data['field_data'][1]["values"][0];
        $phone_number = $data['field_data'][2]["values"][0];
        $email = $data['field_data'][3]["values"][0];
        $city = $data['field_data'][4]["values"][0];
        
        
        $ch = curl_init();
        $url = "http://98.142.105.122/~inbowundca2olica/external/index.php";
        $url_query = "escoge_el_programa_de_tu_interes=" . $escoge_el_programa_de_tu_interes . "&full_name=" . $full_name . "&phone_number=" . $phone_number . "&email=" . $email . "&city=" . $city;
        $url_final = urlencode($url.'?'.$url_query);
        curl_setopt($ch, CURLOPT_URL,$url_final);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close ($ch);
        //$data = json_decode($response, true);
        
        error_log($url_final);
        error_log($response);    
        
        /*error_log($escoge_el_programa_de_tu_interes);
        error_log($full_name);
        error_log($phone_number);
        error_log($email);
        error_log($city);*/
        
        /*$lead_first = $data['field_data'][2][values][0];
        $lead_last = $data['field_data'][2][values][0];
        $phone = $data['field_data'][3][values][0];;
        
        $facebook = "https://www.facebook.com/felicident";
          */  
    }


