<?php

class Account_Model extends CI_Model{

    function __construct(){
        
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
		$this->load->helper('string');
		$this->load->library('email');
		date_default_timezone_set('Africa/Lagos');
	
    }
    
	 public function get_message($slug = FALSE)
    {
		
        if ($slug === FALSE)
        {
			$this->db->limit(5);
			$this->db->order_by('id', 'DESC');
			$this->db->where('slug', $slug);
            $query = $this->db->get('message');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('message', array('slug' => $slug));
        return $query->row_array();
    }

function get_all_messages($limit=null,$offset=NULL){
	
	
	
			$this->db->limit($limit, $offset);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('message');
            return $query->result_array();
 }

 function totalmessage(){
  return $this->db->count_all_results('message');
 }
 
	
	 public function get_users($slug = FALSE)
    {
		$user_id = $this->session->userdata('user_id');
        if ($slug === FALSE)
        {
			$this->db->where('user_id', $user_id);
            $query = $this->db->get('user_table');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('user_table', array('user_id' => $slug));
        return $query->row_array();
    }
    
	
	
    //insert user details to user table
    public function insertUser($data){
        
        return $this->db->insert('user_table',$data);
      
    }
    
    public function loginUser($email, $password){
        //$this->db->where(array('username' = >$username, 'password' => $password));
        $query = $this->db->get_where('user_table', array('email' => $email, 'password' => $password,'status'=> 1));   //status sholud be 1
        
        if($query->num_rows() == 1){
            
            $userArr = array();
            foreach($query->result() as $row){
                $userArr[0] = $row->user_id;
                $userArr[1] = $row->email;
				$userArr[2] = $row->username;
                $userArr[3] = $row->user_type;
				
                
            }
            $userdata = array(
                'user_id' => $userArr[0],
                'email' => $userArr[1],
				'username' => $userArr[2],
                'user_type' => $userArr[3],
				
                'logged_in'=> TRUE
            );
            $this->session->set_userdata($userdata);
            
            return $query->result();
        }else{
            return false;
        }
    }
    
    
    //send confirm mail
    public function sendEmail($receiver){
        
        
        
        
       $mail_message='Dear User,'. "\r\n";
        $mail_message.='Please click on the below activation link to verify your email address<br><br>
        <a href=\'http://axiatag.com/account/confirmEmail/'.md5($receiver).'\'>http://axiatag.com/account/confirmEmail/'. md5($receiver).'</a>' ."\r\n";
        $mail_message.='<br>Please contact the admin if your account could not be verifed';
        $mail_message.='<br><br>Thanks & Regards';
        $mail_message.='<br>Axiatag';        
        date_default_timezone_set('Africa/Lagos');
		
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
         $mail = new PHPMailer;
       	//$mail->isSMTP();
        $mail->SMTPSecure = "true"; 
        $mail->Debugoutput = 'html';
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;   
        $mail->Username = "nobleprojects001@gmail.com";    
        $mail->Password = "Nobleprojects001";
        $mail->setFrom('noreply@axiatag.com', 'Axiatag');
        $mail->addReplyTo("noreply@axiatag.com", "");
        $mail->IsHTML(true);
        $mail->addAddress($receiver);
        $mail->Subject = 'Verify Email';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
        
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }
    
    //activate account
    function verifyEmail($key){
        $data = array('status' => 1);
        $this->db->where('md5(email)',$key);
        return $this->db->update('user_table', $data);    //update status as 1 to make active user
    }
	

public function loginAdmin($username, $password){
        //$this->db->where(array('username' = >$username, 'password' => $password));
        $query = $this->db->get_where('admin_table', array('username' => $username, 'password' => $password));   //status sholud be 1
        
        if($query->num_rows() == 1){
            
            $userArr = array();
            foreach($query->result() as $row){
                $userArr[0] = $row->admin_id;
                $userArr[1] = $row->username;
				
                
            }
            $userdata = array(
                'admin_id' => $userArr[0],
                'username' => $userArr[1],
				
                'logged_in'=> TRUE
            );
            $this->session->set_userdata($userdata);
            
            return $query->result();
        }else{
            return false;
        }
    }
    
	
	public function count_orders()
{
	$user_id = $this->session->userdata('user_id');
    return $this->db
        ->where('poster_id', $user_id)
        ->count_all_results('booking');
}


public function count_new_orders()
{
	$user_id = $this->session->userdata('user_id');
    return $this->db
        ->where('poster_id', $user_id)
		->where('status', 'pending')
        ->count_all_results('booking');
}


public function booking_request()
{
	$user_id = $this->session->userdata('user_id');
    return $this->db
        ->where('user_id', $user_id)
		->count_all_results('booking');
}


public function canceled_booking()
{
	$user_id = $this->session->userdata('user_id');
    return $this->db
        ->where('user_id', $user_id)
		->where('status', 'canceled')
		->count_all_results('booking');
}


	
	public function ForgotPassword($email)
 {
        $this->db->select('email');
        $this->db->from('user_table'); 
        $this->db->where('email', $email); 
        $query=$this->db->get();
        return $query->row_array();
 }
 public function sendpassword($data)
{
		
        $email = $data['email'];
        $query1=$this->db->query("SELECT *  from user_table where email = '".$email."' ");
        $row=$query1->result_array();
        if ($query1->num_rows()>0)
      
{
        $passwordplain = "";
        $passwordplain  = rand(999999999,9999999999);
        $newpass['password'] = md5($passwordplain);
        $this->db->where('email', $email);
        $this->db->update('user_table', $newpass); 
        $mail_message='Dear '.$row[0]['fullname'].','. "\r\n";
        $mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
        $mail_message.='<br>Please Update your password.';
        $mail_message.='<br>Thanks & Regards';
        $mail_message.='<br>Your company name';        
        date_default_timezone_set('Africa/Lagos');
		
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPSecure = "ssl"; 
        $mail->Debugoutput = 'html';
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;   
        $mail->Username = "nobleprojects001@gmail.com";    
        $mail->Password = "Nobleprojects001";
        $mail->setFrom('nobleprojects001@gmail.com', 'Host Places');
        $mail->IsHTML(true);
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
		
		
		
	
     
if (!$mail->send()) {
     $this->session->set_flashdata('login_msg','Failed to send password, please try again!');
} else {
   $this->session->set_flashdata('login_msg','Password sent to your email!');
}
  redirect(base_url().'account/login','refresh');        
}
else
{  
 $this->session->set_flashdata('login_msg','Email not found try again!');
 redirect(base_url().'account/login','refresh');
}
}
	
	
	
	 public function upload_proof($data)  
    {
        $user_id = $this->session->userdata('user_id');
 		$proof= $data['proof'];
		$status= "pending";
         $data = array(
        
		'verify_upload' => $proof,
		'verify_status'=>$status,
		
        );
       
            $this->db->where('user_id', $user_id);
            return $this->db->update('user_table', $data);
			
			$mail_message='Dear Admin,'. "\r\n";
        $mail_message.='A user just uploaded a proof of identity for you to confirm<br><br>';
        $mail_message.='<br>Please login into the admin dashboard to confirm.';
        $mail_message.='<br>Thanks & Regards';
        $mail_message.='<br>Host Places';        
        date_default_timezone_set('Africa/Lagos');
		
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPSecure = "ssl"; 
        $mail->Debugoutput = 'html';
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;   
        $mail->Username = "nobleprojects001@gmail.com";    
        $mail->Password = "Nobleprojects001";
        $mail->setFrom('nobleprojects001@gmail.com', 'Host Places');
        $mail->IsHTML(true);
        $mail->addAddress('contact@noblecontracts.com');
        $mail->Subject = 'Verify Proof of Identity';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
    }
	
	
	
	public function check_status($user_id)
    {
		$this->db->select('verify_status');
    	$this->db->from('user_table');
    	$this->db->where('user_id',$user_id);
		return $this->db->get()->row()->verify_status;
        
    }
	
public function total_projects($user_id)
	{
	
	$array = array('user_id' => $user_id);
	
    return $this->db
        ->where($array)
        ->count_all_results('projects');
}	


public function total_proposal($user_id)
	{
	
	$array = array('user_id' => $user_id);
	
    return $this->db
        ->where($array)
        ->count_all_results('proposal');
}	

public function ongoing_projects($user_id)
	{
	
	$array = array('user_id' => $user_id, 'project_status' => 'pending');
	
    return $this->db
        ->where($array)
        ->count_all_results('order');
}	


public function com_projects($user_id)
	{
	
	$array = array('user_id' => $user_id, 'project_status' => 'completed');
	
    return $this->db
        ->where($array)
        ->count_all_results('order');
}	

public function get_payment()
    {
		$user_id = $this->session->userdata('user_id');
       
			$this->db->where('user_id', $user_id);
            $query = $this->db->get('order');
            return $query->result_array();
       
    }


}

?>