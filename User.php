<?php

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('register');
    }
    
      //common curl API call
    private function common_curl_call($url, $param, $header, $method) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//here we have to give our url
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if ($param != "") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);//checking parameters empty or not empty
        }
        if ($method == "post") {
            curl_setopt($ch, CURLOPT_POST, true);//if method is post
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//here setting header
        $resultcurl = curl_exec($ch);//from API call , result is getting and storing in this variable
      //  print_r($resultcurl);
        curl_close($ch);//closing curl
        return $resultcurl;//returning the data
    }
    
  
    
   
    public function userRegistration(){
        $data = array("uname"=>$this->input->post('uname'),
            "upassword"=>md5($this->input->post('upassword')),
            "uemail"=>$this->input->post('uemail'),
            "umobile"=>$this->input->post('umobile'));
        
       
        $reqparmt = json_encode($data);//converting data to json format and passing as parameter to API curl call
       
       //change path according to your localhost
       $url = serverhostpath.'dboperations_sql/api/operation.php/v1/userRegistration';//creating URL for API call(open this path)
       $header = array('Content-Type: application/json');//this is necessary to passs
       $method = "post";//method type
       $response = $this->common_curl_call($url,$reqparmt,$header,$method);//calling curl function by passing all required parameters
      //$response = json_decode($response);//after getting data from curl call we have to convert json to php array
       print_r($response);exit;
        
        
    }
    
    public function login_page(){
         $this->load->view('login');
    }
    
    public function userLogin(){
        $where = array( "uemail"=>$this->input->post('uemail'),
            "upassword"=>md5($this->input->post('upassword')));
        // print_r($data);exit;
        
       $reqparmt = json_encode($where);
       $url = serverhostpath.'dboperations_sql/api/operation.php/v1/userLogin';
       $header = array('Content-Type: application/json');
       $response = $this->common_curl_call($url,$reqparmt,$header,"post");
       $response = json_decode($response);
      // print_r($response);exit;
       
       $res['userdetails'] = $response;
       $this->load->view('update',$res);
       // echo $res;
    }
    
    public function userUpdateDetails(){
        $data = array( "uid"=>$this->input->post('user_id'),
        "uname"=>$this->input->post('uname'),
            "upassword"=>$this->input->post('upassword'),
            "uemail"=>$this->input->post('uemail'),
            "umobile"=>$this->input->post('umobile'));
       // print_r($data);exit;
       $reqparmt = json_encode($data);
       $url = serverhostpath.'dboperations_sql/api/operation.php/v1/userUpdate';
       $header = array('Content-Type: application/json');
       $response = $this->common_curl_call($url,$reqparmt,$header,"post");
       print_r($response);exit;
    }
    
    public function userDelete(){
        $where = array("uid"=>$this->input->post('user_id'));
        $reqparmt = json_encode($where);
        $url = serverhostpath.'dboperations_sql/api/operation.php/v1/userDelete';
        $header = array('Content-Type: application/json');
        $response = $this->common_curl_call($url,$reqparmt,$header,"post");
        print_r($response);exit;
    }
}
