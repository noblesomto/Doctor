<?php
defined('BASEPATH') OR exit("Access Denied");//remove this line if not using with CodeIgniter


class Pay extends CI_Controller{
    public function __construct(){
        parent::__construct();
       
		 $this->load->model('Page_Model');
		$this->load->helper('url');
		$this->load->library('cart');
		$this->load->helper('url_helper');
		$this->load->helper('form');
        $this->load->library('form_validation');
       
		$this->load->helper('text');
		$this->load->library('session');
		$this->load->database();
        $this->load->library('paystack', [
            'secret_key'=>'sk_live_16a9e5fed484e7fe28b2c448430365ab7d495a73', 
            'public_key'=>'pk_live_f81cddf4119ef18f22c8eaca048da2e3d7d06159']);
    }
    
  
    /**
     * Initialise a transaction by getting only the authorised URL returned
     */
    public function getAuthURL(){
		
		
		
		
		$data['title'] = 'Make Payment';
		
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
       
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->database();
       
		

		$this->form_validation->set_rules('name','Name', 'required');
        $this->form_validation->set_rules('phone','Phone', 'trim|required');
        $this->form_validation->set_rules('email','Email', 'trim|required');
        $this->form_validation->set_rules('location','Location', 'required');
        

		
		
			
        if($this->form_validation->run() == false){
            		$this->load->view('templates/header', $data);
					$this->load->view('templates/nav');
                    $this->load->view('billing');
                    $this->load->view('templates/footer');
            
        }else{
		
	
       
        
                
 
//get customer email
$email = $this->input->post('email'); 
$amount = $this->input->post('location'); 
$name = $this->input->post('name');
$phone = $this->input->post('phone');



$length = 10;

$order_id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);


			$this->Page_Model->payment($name,$phone,$email,$order_id);
					
					 
                 
              

$amount2 = $amount * 100;
 
			
            //init($ref, $amount_in_kobo, $email, $metadata_arr=[], $callback_url="", $return_obj=false)
        $url = $this->paystack->init($order_id, $amount2, $email, base_url('pay/callback'), FALSE);
        
        //$url ? header("Location: {$url}") : "";
        $url ? redirect($url) : "";   
            
        
}
		
    }
    
    
   
    public function verify($ref){
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
       
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Page_Model');
		$this->load->library('email');
		
        //verifyTransaction($ref) will return an array of verification details or FALSE on failure
        $ver_info = $this->paystack->verifyTransaction($ref);
        
        //do something if verification is successful e.g. save authorisation code
        if($ver_info && ($ver_info->status = TRUE) && ($ver_info->data->status == "success")){
            $auth_code = $ver_info->data->authorization->authorization_code;
            
            //do something with $auth_code. $auth_code can be used to charge the customer next time
         
			 
			
			
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Your Payment was successful</div><br>');
			
		$data['title']='Payment Successful';
		
		$this->cart->destroy();
        $this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		
		$this->load->view('payment-success', $data);
		
		$this->load->view('templates/footer');
				
        }
        
        else{
            //do something else
			
		$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Your Payment was not successful. Please Try again later</div>');
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		
		$this->load->view('payment-success', $data);
		
		$this->load->view('templates/footer');
        }
    }
    
   
    
    public function callback(){
        $trxref = $this->input->get('trxref', TRUE);
        $ref = $this->input->get('reference', TRUE);

        
        //do something e.g. verify the transaction
        if($trxref === $ref){
            $this->verify($trxref);
        }
    }
    
  
    
  
}