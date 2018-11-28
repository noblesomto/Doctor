<?php
class Admin_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
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

public function get_unpaid()    {
	 $array = array('method !=' => 'online', 'status' => 'pending'); 
	 		
			$this->db->where($array);
			
            $query = $this->db->get('order');
            return $query->result_array();
       
    }
public function confirm_pay($ref,$data)  
    {		
          $this->db->where('order_id', $ref);
          return $this->db->update('order', $data);
        
    } 
	
	
	
function list_jobs($limit=null,$offset=NULL){
	
	
	
			$this->db->limit($limit, $offset);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('booking');
            return $query->result_array();
 }

 function totaljobs(){
  return $this->db->count_all_results('booking');
 }
 
 
function list_users($limit=null,$offset=NULL){
	
	
	
			$this->db->limit($limit, $offset);
			$this->db->order_by('id', 'DESC');
			$this->db->where('user_type', 'user');
			$query = $this->db->get('user_table');
            return $query->result_array();
 }

 function totalusers(){
  return $this->db
        ->where('user_type','user')
        ->count_all_results('user_table');
 }


 function list_cba($limit=null,$offset=NULL){
    
    
    
            $this->db->limit($limit, $offset);
            $this->db->order_by('id', 'DESC');
            $this->db->where('user_type', 'brand');
            $query = $this->db->get('user_table');
            return $query->result_array();
 }

 function totalcba(){
  return $this->db
        ->where('user_type','brand')
        ->count_all_results('user_table');
 }


 

function list_typist($limit=null,$offset=NULL){
	
	
	
			$this->db->limit($limit, $offset);
			$this->db->order_by('id', 'DESC');
			$this->db->where('user_type', 'typist');
			$query = $this->db->get('user_table');
            return $query->result_array();
 }

 function totaltypist(){
  return $this->db
        ->where('user_type','typist')
        ->count_all_results('user_table');
 }
 
public function suspend_typist($data,$user_id)  
    {		
          $this->db->where('user_id', $user_id);
          return $this->db->update('user_table', $data);
        
    } 

public function get_user($user_id)    {
	 		
			$this->db->where('user_id',$user_id);
			
            $query = $this->db->get('user_table');
            return $query->result_array();
       
    } 

public function delete_job($job_id)
    {
        $this->db->where('id', $job_id);
        return $this->db->delete('booking');
    }
	
public function delete_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('user_table');
    }
	
	
 
function get_approved_projects($limit=null,$offset=NULL){
	
	
	
			$this->db->limit($limit, $offset);
			$this->db->select('*');
			$this->db->from('projects');
			$this->db->join('proposal', 'proposal.project_id = projects.project_id','left');
			
			$result = $this->db->get()->result_array();
			 return $result;
 }

public function get_emails()    {
		
		$this->db->select('email');
		$this->db->from('user_table');
		$result = $this->db->get()->result_array();
		 return $result;
       
    }
	
public function new_message($data)
{
   
    return $this->db->insert('message', $data);
	
	
	
}


public function send_email($title,$message,$date,$email2){
        
        
        
        
       $mail_message='Dear User,'. "\r\n";
        $mail_message='<br><br> You have a new message fro Axiatag'. "\r\n";
        $mail_message.='<br><h3>'. $title.'</h3>';
        $mail_message.='<br><br>'.$message;
		$mail_message.='<br><h5>'. $date.'</h5>';
        $mail_message.='<br><br>Axiatag';        
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
        $mail->setFrom('admin@axiatag.com', 'Axiatag');
        $mail->addReplyTo("no-reply@axiatag.com", "");
        $mail->IsHTML(true);
        $mail->addAddress($email2);
        $mail->Subject = 'New Message';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
        
        if($mail->send()){
			//for testing
            
            return true;
        }else{
           
            return false;
        }
        
       
    }

function get_all_message($limit=null,$offset=NULL){
	
	
	
			$this->db->limit($limit, $offset);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('message');
            return $query->result_array();
 }

 function totalmessage(){
  return $this->db->count_all_results('message');
 }

public function delete_message($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('message');
    }


}