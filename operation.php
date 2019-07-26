<?php
//for better understanding please go through slim framework tutorial
/*
1.Install Slimframework on xampp (https://www.wdb24.com/how-to-install-slim-framework-3-in-windows-using-xampp/)
2.Install php_mongodb.dll on xampp(https://learnedia.com/install-mongodb-configure-php-xampp-windows/)
Note:Use php 5.6 version,in your xampp php version is higher than 5.6 uninstall it and intall php version with 5.6 
*/

require 'vendor/autoload.php';//mandatory file this is come from slimapp

require 'apihandler.php';
require 'action/action.php';
ini_set('memory_limit', '-1');
date_default_timezone_set("Asia/Calcutta");

//slim framework for displaying errors
$app = new Slim\App(
    [
    'settings' =>
            [
        'displayErrorDetails' => true,
        'debug'               => true,
        'whoops.editor'       => 'sublime',
            ]

    ]
 );

//$app = new Slim\App();//for not displaying errors

$app->post('/v1/userRegistration','userRegistration');
$app->post('/v1/userLogin','userLogin');
$app->post('/v1/userUpdate','userUpdate');
$app->post('/v1/userGetDetails','userGetDetails');
$app->post('/v1/userDelete','userDelete');

$app->run();//for running methods

function userRegistration($request,$response){
    $apiobj=new Apihandler;//creating object for Apihandler class
    $payload = $apiobj->apirequest($request);//calling apirequest method
    //print_r($payload);exit;
    $obj = new Action;//creatiing object for Action class
    $apiresponse = $obj->userRegistration($payload);//calling user registration method
   // print_r($apiresponse);exit;
    $response = $apiobj->apiresponse($response,$apiresponse);//calling apiresponse method
    return $response;//returning response to common_curl_call function in Home conrtoller
}

function userLogin($request,$response){
    $apiobj=new Apihandler;
    $payload = $apiobj->apirequest($request);
    //print_r($payload);exit;
    $obj = new Action;
    $apiresponse = $obj->userLogin($payload);
   // print_r($apiresponse);exit;
    $response = $apiobj->apiresponse($response,$apiresponse);
    return $response;
}

function userUpdate($request,$response){
    $apiobj=new Apihandler;
    $payload = $apiobj->apirequest($request);
    //print_r($payload);exit;
    $obj = new Action;
    $apiresponse = $obj->userUpdate($payload);
   // print_r($apiresponse);exit;
    $response = $apiobj->apiresponse($response,$apiresponse);
    return $response;
}

function userGetDetails($request,$response){
    $apiobj=new Apihandler;
    $payload = $apiobj->apirequest($request);
    //print_r($payload);exit;
    $obj = new Action;
    $apiresponse = $obj->userGetDetails($payload);
   // print_r($apiresponse);exit;
    $response = $apiobj->apiresponse($response,$apiresponse);
    return $response;
}

function userDelete($request,$response){
    $apiobj=new Apihandler;
    $payload = $apiobj->apirequest($request);
    //print_r($payload);exit;
    $obj = new Action;
    $apiresponse = $obj->userDelete($payload);
   // print_r($apiresponse);exit;
    $response = $apiobj->apiresponse($response,$apiresponse);
    return $response;
}

?>
