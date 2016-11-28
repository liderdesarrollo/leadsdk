<?php
    
    /*
    $challenge = $_REQUEST["hub_challenge"];
    $verify_token = $_REQUEST["hub_verify_token"];
    
    if($verify_token == "abc123"){
        echo $challenge;
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    error_log(print_r($input, true));*/
    
    // Bootup the Composer autoloader
    include '/app/vendor/autoload.php';  
    session_start();
    use Mautic\Auth\ApiAuth;
    use Mautic\MauticApi;
    $challenge = isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : '';
    $verify_token = isset($_REQUEST['hub_verify_token']) ? $_REQUEST['hub_verify_token'] : ''; 
    if ($verify_token === 'abc123') {
      echo $challenge;
    }
    //$string = '{"entry":[{"changes":[{"field":"leadgen","value":{"ad_id":0,"form_id":624049654589,"leadgen_id":6276465415920,"created_time":1476740844,"page_id":561823650667842,"adgroup_id":0}}],"id":"561823650667842","time":1476740844}],"object":"page"}	';
    //$data = json_decode($string, true);
    $data = json_decode(file_get_contents("php://input"),true);
    $gen_id = $data['entry'][0]['changes'][0]['value']['leadgen_id'];
    $form_id = $data['entry'][0]['changes'][0]['value']['form_id'];
    
    $ch = curl_init();
    $url = "https://graph.facebook.com/v2.8/".$gen_id;
    $url_query = "access_token=EAAJJal9jlqQBANVaO3ct4QFIfoQBsq4yKUT7TLw4on4WJZCKhgQS6zoGJlEyrByv4QYBh3JLHKwk2pHCOoiAT2uz1UpMmOBRSn17R5EVbIVFGBYV8lof8FD8yh5a9K9eCBzWVnqV13l7JIkZBGNZCvqavSE8QcZD"; // you have to subscribe to the page that has the form to generate an Access Token
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
    if($form_id == "198579217265271"){ // Black friday final
        
        $lead_email = $data['field_data'][1][values][0];
        $lead_first = $data['field_data'][2][values][0];
        $lead_last = $data['field_data'][2][values][0];
        $phone = $data['field_data'][3][values][0];;
        
        $facebook = "https://www.facebook.com/felicident";
            
    }else if($form_id == "1701486986833396"){ // Descuentos Black friday
        
        $lead_email = $data['field_data'][0][values][0];
        $lead_first = $data['field_data'][1][values][0];
        $phone = $data['field_data'][2][values][0];
        
        $facebook = "https://www.facebook.com/felicident";
                    
    }else if($form_id == "208573666260152"){ //Black Friday
        
        $lead_email = $data['field_data'][1][values][0];
        $lead_first = $data['field_data'][2][values][0];
        $phone = $data['field_data'][4][values][0];
        
        $facebook = "https://www.facebook.com/felicident";
        
    }else if($form_id == "1709171312744798"){ // Agendar Valoracion con detalle
                
        $lead_email = $data['field_data'][0][values][0];
        $lead_first = $data['field_data'][1][values][0];
        $phone = $data['field_data'][2][values][0];
        
        $facebook = "https://www.facebook.com/felicident";
        
    }else if($form_id == "1143944375720504"){ // Agendar Valoracion
                
        $lead_email = $data['field_data'][0][values][0];
        $lead_first = $data['field_data'][1][values][0];
        $phone = $data['field_data'][2][values][0];
        
        $facebook = "https://www.facebook.com/felicident";        
    }
    
    if(1==1){
        $publicKey = ''; 
        $secretKey = ''; 
        $callback  = ''; 
        // ApiAuth::initiate will accept an array of OAuth settings
        $settings = array(
            'baseUrl'          => 'http://98.142.105.122/~inboundfeliciden',       // Base URL of the Mautic instance
            'version'          => 'OAuth2', // Version of the OAuth can be OAuth2 or OAuth1a. OAuth2 is the default value.
            'clientKey'        => '1_1qkt36ktsr8k4wskocss0c4gcsco00o000kso48w8so4kkok4s',       // Client/Consumer key from Mautic
            'clientSecret'     => '2telqvs0fmw48k00g4oww88cwgs0s0kws8kck4g0wk8cc044s0',       // Client/Consumer secret key from Mautic
            'callback'         => 'https://sheltered-wave-31226.herokuapp.com/webhook.php'        // Redirect URI/Callback URI for this script
        );
        
        // If you already have the access token, et al, pass them in as well to prevent the need for reauthorization
        $settings['accessToken']        = "NTdlMDhmZTZjNmQxMzdjMzUwNTk3ZmY4NzY3YTE1NWJkZmRlNWMxMTA0MjA2YTVlMTE4ZTk4M2YwNjk1YzhhNA";
        //$settings['accessTokenSecret']  = ""; //for OAuth1.0a
        $settings['accessTokenExpires'] = 1540349518; //UNIX timestamp
        $settings['refreshToken']       = "git ";
        
        // Initiate the auth object
        $apiAuth = new ApiAuth();
        $auth = $apiAuth->newAuth($settings);
        // Initiate process for obtaining an access token; this will redirect the user to the $authorizationUrl and/or
        // set the access_tokens when the user is redirected back after granting authorization
        // If the access token is expired, and a refresh token is set above, then a new access token will be requested
        $auth->enableDebugMode();
        try {
            if ($auth->validateAccessToken()) {
                // Obtain the access token returned; call accessTokenUpdated() to catch if the token was updated via a
                // refresh token
                // $accessTokenData will have the following keys:
                // For OAuth1.0a: access_token, access_token_secret, expires
                // For OAuth2: access_token, expires, token_type, refresh_token
                
                if ($auth->accessTokenUpdated()) {
                    $accessTokenData = $auth->getAccessTokenData();
                    var_dump($accessTokenData);
                    //store access token data in the settings above
                }
            }else{
                
                echo 'not valid access token';
            }
        } catch (Exception $e) {
            // Do Error handling
        }
        // Create an api context by passing in the desired context (Contacts, Forms, Pages, etc), the $auth object from above
        // and the base URL to the Mautic server (i.e. http://my-mautic-server.com/api/)
        $api = new MauticApi();
        $contactApi = $api->newApi('contacts', $auth, $settings['baseUrl']);
        //Create a new Contact
        $fields =array(); 
        $fields['firstname'] = $lead_first;
        $fields['lastname'] = $lead_last;
        $fields['email'] = $lead_email;
        $fields['phone'] = $phone;
        $fields['facebook'] = $facebook;
        $fields['position'] = "coconut"; // i used this to automaticlly subscribe lead to a list
        // Set the IP address the contact originated from if it is different than that of the server making the request
        //$data['ipAddress'] = $ipAddress;
        // Create the contact 
        /*ob_start();
            $fields = $contactApi->getFieldList();
            var_dump($fields);
        $b = ob_get_clean();
        error_log($b);*/
        
        $contact = $contactApi->create($fields);
        
        ob_start();
        if (isset($contact['error'])) {
            echo $contact['error']['code'] . ": " . $result['error']['message'];
        } else {
            // do whatever with the info
            echo "Contact created!";
        }
        $b = ob_get_clean();
        error_log($b);
    }


