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
$ch = curl_init();
$url = "https://graph.facebook.com/v2.8/".$gen_id;
$url_query = "access_token=EAAJJal9jlqQBAI7Dsd2gD57NHqecHqx72fJbwgQktUzOYHtxGVfpqPVBoftjaQXGckVVrI1gDkujKV0YV83GfEx5FAWbtlIjgSNXSUaWfykZCqtHz41vzewwlk7XoM5ph4LZCIfNzd34HdEH8enSsRERQDt4F6qSYZCZAmAtTAZDZD"; // you have to subscribe to the page that has the form to generate an Access Token
$url_final = $url.'?'.$url_query;
curl_setopt($ch, CURLOPT_URL, $url_final);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close ($ch);
$data = json_decode($response, true);
//$lead_email = $data['field_data'][0][values][0];
//$lead_first = $data['field_data'][1][values][0];
//$lead_last = $data['field_data'][2][values][0];
var_dump($data);
