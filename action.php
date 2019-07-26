<?php
ini_set('memory_limit', '-1');
require 'dbo.php';

class Action {

   public function userRegistration($payload){
      // print_r($payload);exit;
       $dboobj = new Dbo;//creating object for db operations file
       $apidata['uname'] = $payload->uname;
       $apidata['uemail'] = $payload->uemail;
       $apidata['upassword'] = $payload->upassword;
       $apidata['umobile'] = $payload->umobile;
       $res = $dboobj->insert("user_details", $apidata);
       if($res == "inserted"){
           $response['status'] = 1;
           $response['message'] = "Data inserted successfully";
       }
       return $response;
   }
   
   public function userLogin($payload){
      // print_r($payload);exit;
       $select = "*";
       $dboobj = new Dbo;
        $response = array();
       $where = array();
       $sort_columun = "created_on";
    
      if(empty($payload)){
         // $select = "uname,uemail";
            $res = $dboobj->get("user_details", $select, $where,"result",$sort_columun,"DESC",9999);
       }else{
           $where['uemail'] = $payload->uemail;
           $where['upassword'] = $payload->upassword;     
           $res = $dboobj->get("user_details", $select, $where,"row",$sort_columun,"DESC",9999);
       }    
       
      // print_r($res);exit;
       if(count($res)>0){
           $response['status'] = 1;
           $response['message'] = "User Logged In Successfully";
           $response['data'] = $res;
       }else{
           $response['status'] = 0;
           $response['message'] = "User Login Failed";
           $response['data'] = $res;
       }
       return $response;
   }
   
   public function userUpdate($payload){
      // print_r($payload);exit;
       $dboobj = new Dbo;
       $where['uid'] = (int)$payload->uid;
       $setdata['uname'] = $payload->uname;
       $setdata['uemail'] = $payload->uemail;
       $setdata['upassword'] = $payload->upassword;
       $setdata['umobile'] = $payload->umobile;
    
       $res = $dboobj->update("user_details", $where,$setdata);  
       //print_r($res);exit;
       if($res == 1){
           $response['status'] = 1;
           $response['message'] = "Data updated successfully";
       }
       return $response;
   }
   
   public function userGetDetails($payload){
      // print_r($payload);exit;
       $response = array();
       $where = array();
       $select = "*";
       $dboobj = new Dbo;
       $sort_columun = "created_on";
       if(empty($payload)){
         // $select = "uname,uemail";
             $res = $dboobj->get("user_details", $select, $where,"result",$sort_columun,"DESC",9999);
       }else{
           $where['uid'] = (int)$payload->uid;
           
           $res = $dboobj->get("user_details", $select, $where,"row",$sort_columun,"DESC",9999);
       }    
       
       //print_r($res);exit;
       if(count($res)>0){
           $response['status'] = 1;
           $response['message'] = "Data get successfully";
           $response['countn'] = count($res);
           $response['data'] = $res;
       }else{
           $response['status'] = 0;
           $response['message'] = "Data not found";
           $response['countn'] = count($res);
           $response['data'] = $res;
       }
       return $response;
   }
   
    public function userDelete($payload){
      // print_r($payload);exit;
       $dboobj = new Dbo;
       $where['uid'] = (int)$payload->uid;
       $res = $dboobj->delete("user_details", $where);
       if($res == "deleted"){
           $response['status'] = 1;
           $response['message'] = "Data deleted successfully";
       }
       return $response;
   }
}

?>
