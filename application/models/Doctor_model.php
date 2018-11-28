<?php

class Doctor_model extends CI_Model{

    function __construct(){
        
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
		$this->load->helper('string');
		$this->load->library('email');
	
    }


     public function post_article($data){
        
        return $this->db->insert('article',$data);
      
    }



	
public function total_amount()
    {
$user_id = $this->session->userdata('user_id');  		
 $array = array('booking.typist_id' => $user_id, 'booking.job_status' => 'completed', 'order.status' => 'paid');     
 
		 $this->db->select_sum('amount', 'Amount');
		 $this->db->from('order');
		 $this->db->join('booking', 'order.ref_id = booking.ref','left');
		 $this->db->where($array);
		return $this->db->get()->row()->Amount;
		
       
    }
	
public function total_word()
    {
	$user_id = $this->session->userdata('user_id');
	
	
   $query = $this->db->select_sum('words', 'Word');
	$query = $this->db->where('typist_id',$user_id);
	$query = $this->db->get('booking');
	$result = $query->result();
	return $result[0]->Word;
	
    }

public function total_order()
{
	$user_id = $this->session->userdata('user_id');
    return $this->db
        ->where('typist_id', $user_id)
		->where('job_status', 'pending')
        ->count_all_results('booking');
}
	
	
 public function get_new_orders()
    {
$user_id = $this->session->userdata('user_id');  
  $array = array('job_status' => 'pending', 'typist_id' => $user_id);      	
			$this->db->where($array);
            $query = $this->db->get('booking');
            return $query->result_array();
		
       
    }   

 public function order_action($data,$ref)  
    {		
          $this->db->where('ref', $ref);
          return $this->db->update('booking', $data);
        
    }

public function pickup_action($data,$ref)  
    {		
          $this->db->where('ref', $ref);
          return $this->db->update('booking', $data);
        
    }  
	

public function get_order($search)
    {
     	
			$this->db->where('ref', $search);
            $query = $this->db->get('booking');
            return $query->result_array();
		
       
    }  

public function get_user($user_id)
    {
     		$this->db->where('user_id', $user_id);
            $query = $this->db->get('user_table');
            return $query->row_array();
       
    }	




	function get_typist($search, $limit=null,$offset=NULL){
	
 $array = array('user_type' => 'typist', 'institution' => $search);    
	
			$this->db->limit($limit, $offset);
			$this->db->order_by('id','DESC');
			$this->db->where($array);
		  $query = $this->db->get('user_table');
           return $query->result_array();
 }

 function totaltypist($search){
 
$array = array('user_type' => 'typist', 'institution' => $search);    	
    return $this->db
        ->where($array)
        ->count_all_results('user_table');
 } 
 
 
public function get_user_by_id($user_id)
    {
		
		
			$this->db->where('user_id', $user_id);
            $query = $this->db->get('user_table');
            return $query->result_array();
		
       
    }

  public function book_typist($data){
        
        return $this->db->insert('booking',$data);
      
    }


public function send_typist_email($typist_email){
        
        
        
        
       $mail_message='Dear User,'. "\r\n";
        
        $mail_message.='<br>This is to notify you that someone just booked you for typist job';
		$mail_message.='<br>Please Login in and view the job';
        $mail_message.='<br><br>Thanks & Regards';
        $mail_message.='<br>Typist';        
        date_default_timezone_set('Africa/Lagos');
		
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
        $mail = new PHPMailer;
        $mail->isSMTP();
		$mail->SMTPSecure = "true"; 
        $mail->Debugoutput = 'html';
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;   
        $mail->Username = "nobleprojects001@gmail.com";    
        $mail->Password = "Nobleprojects001";
        $mail->setFrom('office@typist.ng', 'Typist');
        $mail->addReplyTo("no-reply@typist.ng", "");
        $mail->IsHTML(true);
        $mail->addAddress($typist_email);
        $mail->Subject = 'Typist Booking Notification';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
        
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }

public function get_booking($ref)
    {
		
		
			$this->db->where('ref', $ref);
            $query = $this->db->get('booking');
            return $query->result_array();
		
       
    }
	
 public function update_job($ref,$data)  
    {		
          $this->db->where('ref', $ref);
          return $this->db->update('booking', $data);
        
    } 
		
 
 
 public function completed_jobs()
    {
$user_id = $this->session->userdata('user_id');  		
 $array = array('booking.typist_id' => $user_id, 'booking.job_status' => 'completed', 'order.status' => 'paid');     
 
		$this->db->select('*');
		$this->db->from('order');
		$this->db->join('booking', 'order.ref_id = booking.ref','left');
		$this->db->where($array);
		$result = $this->db->get()->result_array();
		 return $result;
		
       
    }

 public function request_withdrawal($data){
        
        return $this->db->insert('withdraw',$data);
      
    }	


public function get_transactions()
    {
	$user_id = $this->session->userdata('user_id');  	
		
			$this->db->where('user_id', $user_id);
            $query = $this->db->get('withdraw');
            return $query->result_array();
		
       
    }

public function get_corrections()
    {
	$user_id = $this->session->userdata('user_id');  
		
		$this->db->select('*');
		$this->db->from('corrections');
		$this->db->join('booking', 'corrections.ref = booking.ref','left');
	$this->db->where('booking.typist_id', $user_id);
		$result = $this->db->get()->result_array();
		 return $result;
		
       
    }	
public function get_download($ref)
    {		
          $query = $this->db->get_where('corrections', array('ref' => $ref));
        return $query->row_array();
        
    } 
	
    public function get_download_format($ref)
    {       
          $query = $this->db->get_where('booking', array('ref' => $ref));
        return $query->row_array();
        
    } 
	
			
 public function update_price($code,$data)  
    {		
          $this->db->where('code', $code);
          return $this->db->update('basket', $data);
        
    } 
	
	
	

public function get_order_details($order_id)
    {
		
		$this->db->select('*');
		$this->db->from('order');
		$this->db->join('order_details', 'order_details.order_id = order.order_id','left');
	$this->db->where('order.order_id', $order_id);
		$result = $this->db->get()->result_array();
		 return $result;
		
       
    }

public function cancel_order($order_id)  
    {		
          $this->db->where('order_id', $order_id);
          return $this->db->delete('order');
        
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
	
	
	
public function email_user_accept($user_email){
        
	
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
       $mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->Host = "localhost"; // sets the SMTP server
		$mail->Port = 25; // set the SMTP port for the GMAIL server
		$mail->Username = "office@typist.ng"; // SMTP account username
		$mail->Password = "+zyXb?Vp0tbJ"; // SMTP account password
		$mail->SetFrom('office@typist.ng', 'Typist');
		$mail->AddReplyTo("office@typist.ng","Typist");
		$mail->Subject = "Typing Order Accepted ";
        $message = $this->load->view('accept-email', $mail, true);
		$mail->MsgHTML($message);
		$mail->AddAddress($user_email);
        
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }
	

public function email_user_decline($user_email){
        
	
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
       $mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->Host = "localhost"; // sets the SMTP server
		$mail->Port = 25; // set the SMTP port for the GMAIL server
		$mail->Username = "office@typist.ng"; // SMTP account username
		$mail->Password = "+zyXb?Vp0tbJ"; // SMTP account password
		$mail->SetFrom('office@typist.ng', 'Typist');
		$mail->AddReplyTo("office@typist.ng","Typist");
		$mail->Subject = "Typing Order Declined ";
		$message = $this->load->view('decline-email', $mail, true);
        $mail->MsgHTML($message);
		$mail->AddAddress($user_email);
        
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }
	
	

public function email_user_pickup($user_email){

		
		require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');
		
		
		
       $mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->Host = "localhost"; // sets the SMTP server
		$mail->Port = 25; // set the SMTP port for the GMAIL server
		$mail->Username = "office@typist.ng"; // SMTP account username
		$mail->Password = "+zyXb?Vp0tbJ"; // SMTP account password
		$mail->SetFrom('office@typist.ng', 'Typist');
		$mail->AddReplyTo("office@typist.ng","Typist");
		$mail->Subject = "Typing Order Picked ";
		$mail->MsgHTML("<html><body><p>Dear User, </p>
<p><br>The typist has picked your job from the drop zone.</p>

<p><br> Please track the job progress from  your dashboard </p>
	

<p><br>Contact us on 08035504753 for more enquiries.</p>
<p><br>Thanks &amp; Regards.</p>
<p>Typist.ng</p>
		
		</body></html>");
		$mail->AddAddress($user_email);
        
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }	

}

?>