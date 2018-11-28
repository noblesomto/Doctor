<?php

class Page_Model extends CI_Model{

    function __construct(){
        
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
		$this->load->helper('string');
		$this->load->library('email');
	}
    
	 

		
  //send confirm mail
    public function contact_admin($name,$phone,$email,$subject,$comment){
        
        
        
        
       $mail_message='Dear Admin,'. "\r\n";
        $mail_message.='A user with the following details contacted you'."\r\n";
        $mail_message.=' Name'.$name."\r\n";
		$mail_message.=' Phone'.$phone."\r\n";
		$mail_message.=' Email'.$email."\r\n";
		$mail_message.=' Phone'.$subject."\r\n";
		$mail_message.=' Name'.$comment."\r\n";
        $mail_message.='<br>Thanks & Regards';
        $mail_message.='<br>Savers';        
        date_default_timezone_set('Africa/Lagos');
		
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
        $mail = new PHPMailer;
        $mail->isSMTP();
		$mail->Timeout = 120;
        $mail->SMTPSecure = "ssl"; 
        $mail->Debugoutput = 'html';
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;   
        $mail->Username = "nobleprojects001@gmail.com";    
        $mail->Password = "Nobleprojects001";
        $mail->setFrom('no-reply@noblecontrtacts.com', 'Noble Contracts');
        $mail->IsHTML(true);
        $mail->addAddress('contact@noblecontracts.com');
        $mail->Subject = 'Customer Contact ';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
        
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }




    public function payment($name,$phone,$email,$order_id){
        
        
        
        
       $mail_message='Dear Admin,'. "\r\n";
        $mail_message.='A user with the following details made an Order'."\r\n";
        $mail_message.='<br> Name :  '.$name."\r\n";
        $mail_message.='<br> Phone : '.$phone."\r\n";
        $mail_message.='<br> Email : '.$email."\r\n";
        $mail_message.='<br> Order ID : '.$order_id."\r\n";
       

        $mail_message.='<br>Thanks & Regards';
        $mail_message.='<br>Noble Contracts';        
        date_default_timezone_set('Africa/Lagos');
        
        require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
        
        
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Timeout = 120;
        $mail->SMTPSecure = "ssl"; 
        $mail->Debugoutput = 'html';
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;   
        $mail->Username = "nobleprojects001@gmail.com";    
        $mail->Password = "Nobleprojects001";
        $mail->setFrom('no-reply@noblecontrtacts.com', 'Noble Contracts');
        $mail->IsHTML(true);
        $mail->addAddress('info@noblecontracts.com');
        $mail->Subject = 'Customer Order ';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
        
        if($mail->send()){
            //for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }
    
    
}

?>