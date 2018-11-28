<?php
class Account extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                 $this->load->model('Account_Model');
                 $this->load->model('User_model');
				$this->load->model('Typist_model');
                $this->load->helper('url_helper');
				$this->load->library('cart');
				$this->load->library('user_agent');
				$this->load->library('session');
				$this->load->helper('form');
				$this->load->helper('text');
        		$this->load->library('form_validation');
				$this->load->helper('string');
				$this->load->library('pagination');
        }

   
    public function register(){
		
		$data['title'] = 'User Registeration - Friendly Doctor';
		
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
       
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Account_Model');
		$this->load->library('email');
		
		
        $this->form_validation->set_rules('fname','First name', 'required');
        $this->form_validation->set_rules('lname','Last name', 'required');
		$this->form_validation->set_rules('email','Email', 'trim|required|valid_email|is_unique[user_table.email]');
        $this->form_validation->set_message('is_unique', 'The %s already exist');
        $this->form_validation->set_rules('password','Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('username','Username', 'trim|required|is_unique[user_table.username]');
		$this->form_validation->set_rules('phone','Phone Number', 'trim|required|is_unique[user_table.phone]');
		$this->form_validation->set_rules('sex','Sex', 'trim|required');
		
        
        if($this->form_validation->run() == false){
            		
        $this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('index', $data);
                   
            
        }else{
            //call db
			$date = date("Y-m-d H:i:s");
			$user_id=rand(00000,99999); 
            $data = array(
                'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				
				'user_id' => $user_id,
                'email' => $this->input->post('email'),
               'phone' => $this->input->post('phone'),
                'password' => md5($this->input->post('password')),
				'username' => $this->input->post('username'),
				'sex' => $this->input->post('sex'),
				'user_type' => "user",
				'status' => "0",
				
				'reg_date'=>$date,
            );
            
            $receiver =$this->input->post('email');
            
                 $this->Account_Model->insertUser($data);
                //send confirm mail
				
                if($this->Account_Model->sendEmail($receiver)){
                    $this->Account_Model->insertUser($data);
                    //redirect('Login_Controller/index');
                    //$msg = "Successfully registered with the sysytem.Conformation link has been sent to: ".$this->input->post('txt_email');
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Successfully registered. Please confirm your Email. </div>');
					 redirect(base_url().'account/login');
                }else{
                    
                    //$error = "Error, Cannot insert new user details!";
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Failed!! Please try again or Contact office@typist.ng</div>');
					 redirect(base_url().'account/register');
                
                
                
            }
        }
        
    }


    public function doctor_register(){
		
		$data['title'] = 'Doctor Registeration - Friendly Doctor';
		
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
       
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Account_Model');
		$this->load->library('email');
		
		
        $this->form_validation->set_rules('fname','First name', 'required');
        $this->form_validation->set_rules('lname','Last name', 'required');
		$this->form_validation->set_rules('email','Email', 'trim|required|valid_email|is_unique[user_table.email]');
        $this->form_validation->set_message('is_unique', 'The %s already exist');
        $this->form_validation->set_rules('password','Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('username','Username', 'trim|required|is_unique[user_table.username]');
		$this->form_validation->set_rules('phone','Phone Number', 'trim|required|is_unique[user_table.phone]');
		$this->form_validation->set_rules('specialization','Specialization', 'required');
		$this->form_validation->set_rules('sex','Sex', 'required');
		
		
        
        if($this->form_validation->run() == false){
            		
        $this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('doctor-register', $data);
                   
            
        }else{
            //call db
			$date = date("Y-m-d H:i:s");
			$user_id=rand(00000,99999); 
            $data = array(
                'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				
				'user_id' => $user_id,
                'email' => $this->input->post('email'),
               'phone' => $this->input->post('phone'),
                'password' => md5($this->input->post('password')),
				'username' => $this->input->post('username'),
				'specialization' => $this->input->post('specialization'),
				'sex' => $this->input->post('sex'),
				'user_type' => "doctor",
				'status' => "0",
				'reg_date'=>$date,
            );
            
            $receiver =$this->input->post('email');
            
                 $this->Account_Model->insertUser($data);
                //send confirm mail
				
                if($this->Account_Model->sendEmail($receiver)){
                    $this->Account_Model->insertUser($data);
                    //redirect('Login_Controller/index');
                    //$msg = "Successfully registered with the sysytem.Conformation link has been sent to: ".$this->input->post('txt_email');
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Successfully registered. Please confirm your Email. </div>');
					 redirect(base_url().'page/index');
                }else{
                    
                    //$error = "Error, Cannot insert new user details!";
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Failed!! Please try again or Contact office@typist.ng</div>');
					 redirect(base_url().'account/doctor_register');
                
                
                
            }
        }
        
    }

    
    function confirmEmail($hashcode){
        if($this->Account_Model->verifyEmail($hashcode)){
            $this->session->set_flashdata('verify', '<div class="alert alert-success text-center">Email address is confirmed. Please login to the system</div>');
           redirect(base_url().'account/login');
        }else{
            $this->session->set_flashdata('verify', '<div class="alert alert-danger text-center">Email address is not confirmed. Please try to re-register.</div>');
           redirect(base_url().'account/register');
        }
    }




public function login(){
	
	 $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Account_Model'); 
		 $this->load->helper('url_helper');
		
		
        $data['title'] = 'Login - Typist.ng';
        $this->form_validation->set_rules('email','Email', 'trim|required');
        $this->form_validation->set_rules('password','Password', 'trim|required');
        
        if($this->form_validation->run() == false){
                    
        $this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('login', $data);
		 $this->load->view('templates/footer');
                  
        }else{
            
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));
            
            if($this->Account_Model->loginUser($email, $password)){
                
                $userInfo = $this->Account_Model->loginUser($email, $password);
            
                
                    
                
                
$this->session->set_flashdata('login_msg', '<div class="alert alert-success text-center">Successfully logged in</div>');
                //$this->load->view('header');
                //$this->load->view('tasks_view');
                //$this->load->view('footer');
				if( $this->session->userdata('redirect_back') ) {
    $redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
    $this->session->unset_userdata('redirect_back');
    redirect( $redirect_url );
}
				else{
					if($this->session->userdata('user_type')=='user'){
                redirect(base_url().'user/index');
					
					}else{
				redirect(base_url().'doctor/index');		
					}
				}
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Login Failed!! Please try again. make sure you verifed your account throught the email sent to you</div>');
                   
                    redirect(base_url().'page/index');
                   
                
            }
        }
    }
    
   

public function index(){
	
	
         $data['title'] = 'User - Dashboard.';
		;
      
        if(isset($_SESSION['user_id'])){
		if($this->session->userdata('user_type')=='typist'){
		
		redirect(base_url().'account/login');	
		}elseif($this->session->userdata('user_type')=='brand'){
				redirect(base_url().'account/brand');
		}else{
		
			$this->load->helper('url');
			$user_id = $this->session->userdata('user_id');
       $data['user']=$this->Account_Model->get_user();
       $data['job']=$this->User_model->pending_jobs();
        $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/index', $data);
		
		$this->load->view('dashboard/templates/footer');
		}
        }else{
            redirect(base_url().'account/login');
        }
        
    }


public function brand(){
	
	
         $data['title'] = 'Brand Ambassador - Dashboard.';
		;
      
        if(isset($_SESSION['user_id'])){
		if($this->session->userdata('user_type')=='typist'){
		
		redirect(base_url().'account/login');	
		}elseif($this->session->userdata('user_type')=='user'){
		redirect(base_url().'account/login');
		}else{	
		
			$this->load->helper('url');
			$user_id = $this->session->userdata('user_id');
       $data['user']=$this->Account_Model->get_user();
       $data['word']=$this->Account_Model->count_words();
       $data['job']=$this->Account_Model->count_jobs();
        $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/brand', $data);
		
		$this->load->view('dashboard/templates/footer');
		}
        }else{
            redirect(base_url().'account/login');
        }
        
    }
    
	
public function typist(){
	
	
         $data['title'] = 'Typist - Dashboard.';
		;
      
        if(isset($_SESSION['user_id'])){
			
			if($this->session->userdata('user_type')=='user'){
		
		redirect(base_url().'account/login');	
		}else{
			
			$this->load->helper('url');
			$user_id = $this->session->userdata('user_id');
       $data['user']=$this->Account_Model->get_user();
	   $data['amount']=$this->Typist_model->total_amount();
	    $data['word']=$this->Typist_model->total_word();
		 $data['order']=$this->Typist_model->total_order();
	   
        $this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/index', $data);
		
		$this->load->view('typist/templates/footer');
		}
        }else{
            redirect(base_url().'account/login');
        }
        
    }
    
	
    public function logout(){
		
		
        $this->load->library('session');
         
        
        if($this->session->has_userdata('user_id')){
            //$this->session->unset_userdata('user_data');
            $this->session->sess_destroy();
            //unset($_SESSION['user_data']);
             
            redirect(base_url().'home/index');
        }
        
        
    }


		

public function recoverpassword()
{
		 $data['title'] = 'Forgot Passowrd';
 		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('account/forgotpassword');
        $this->load->view('templates/footer');
}

public function doforget()
{		$data['title'] = 'Forgot Passowrd';
		$this->load->helper('url');
		$email= $this->input->post('email');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','email','required|trim');
	
	if ($this->form_validation->run() == FALSE)
{
		
 		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('account/forgotpassword');
        $this->load->view('templates/footer');
}
	else
{
		$data['title'] = 'Passowrd Sent';
		$this-> Account_Model->reset_password($email);	
		$this->session->set_flashdata('message','Password has been reset and has been sent to email');
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('account/forgotpassword');
        $this->load->view('templates/footer');
}
}



  public function ForgotPassword1()
   {
         $email = $this->input->post('email');      
         $findemail = $this->Account_Model->ForgotPassword($email);  
         if($findemail){
          $this->Account_Model->sendpassword($findemail);        
           }else{
          $this->session->set_flashdata('login_msg',' Email not found!');
          redirect(base_url().'account/login','refresh');
      }
   }


public function forgotpassword()
{		$data['title'] = 'Forgot Passowrd';
		$this->load->helper('url');
		$email= $this->input->post('email');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','email','required|trim');
	
	if ($this->form_validation->run() == FALSE)
{
		
 		
        $this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('forgotpassword', $data);
		 $this->load->view('templates/footer');
       
}
	else
{
		$email= $this->input->post('email');
		if($user = $this->Account_Model->get_user_by_email($email)){
			
			foreach($user as $users) { 
			$slug = md5($users->user_id);
			$user_id=$users->user_id;
		
			
			if($this->Account_Model->send_email($email,$slug,$user_id)){
			
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">An email has been sent to you</div>');
           redirect(base_url().'account/forgotpassword');
        }else{
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Email could not be sent, please try again.</div>');
           redirect(base_url().'account/forgotpassword');
        }}
		}else{
			
		$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Email address is not found. Please try to re-register.</div>');
           redirect(base_url().'account/register');	
			
		}

}
}


public function reset_password()
{		$data['title'] = 'Change Passowrd';
		
		$this->load->helper('url');

		$data['user_id'] = $this->uri->segment(4);
		$data['hash'] = $this->uri->segment(3);
	
		
		$user_id= $this->input->post('user_id');
		$hash= $this->input->post('hash');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('password','Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
	
	if ($this->form_validation->run() == FALSE)
{
		
 		
        $this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('reset_password', $data);
		 $this->load->view('templates/footer');
       
}
	else
	
{	
	
	$user = $this->Account_Model->get_slug($user_id);
			
			foreach($user as $users) { 
			$slug = md5($users->user_id);
			
		
			
			if($hash != $slug){
			
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">The Code from the email does not match</div>');
          $this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('reset_password', $data);
		 $this->load->view('templates/footer');
        }else{
			
			
			$data = array(
        		
                'password' => md5($this->input->post('password')),
				
		
		
		
    );

	
		if($this->Account_Model->update_password($user_id,$data)){
			
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Your Password has been updated. please Login</div>');
           redirect(base_url().'account/login');
        
		}else{
			
		$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">An Error occoured Please try again later</div>');
           redirect(base_url().'account/reset_password');	
			
		}	
	
		}}
}
}
   
   public function success()
   {
	   $data['title'] = 'Verify Your Email';
	   $this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('account/success');
        $this->load->view('templates/footer');
	   
	   
	   
	   }
	   
public function verify_success()
   {
	   $data['title'] = 'Verify Your Email';
	   $this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('account/verify_success');
        $this->load->view('templates/footer');
	   
	   
	   
	   }
	   
public function profile ()
{
		$data['title'] = 'My Profile - Typist.ng';
		$user_id = $this->uri->segment(3);
		$data['user']=$this->Account_Model->get_user();
        $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/profile', $data);
		
		$this->load->view('dashboard/templates/footer');	
	
	
}

public function upload()
    {
		$user_id = $this->uri->segment(3);
        
        if (empty($user_id))
        {
            show_404();
        }
		
		
		$data['user']=$this->Account_Model->get_user();
		
        $user_id = $this->uri->segment(3);
         $data['title'] = 'My Profile - Typist.ng';     
      		 $config['upload_path']          = './pix/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['overwrite'] = false;
			$config['max_size']             = 800;
			
			$config['file_name'] = $_FILES["picture"]['name'];

			$this->load->library('upload', $config);
			
				
							
			if (! $this->upload->do_upload('picture')){
				 $data['title'] = 'My Profile'; 
				$error = array('error' => $this->upload->display_errors());
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/profile', $error);
		
		$this->load->view('dashboard/templates/footer');
			}else{
				
	$image=$this->upload->data();	
	
	 $data = array(
       
		'pix' => $image['file_name'],
		
		
		
		
    );


		$this->Account_Model->update_profile($user_id,$data);
		
		
		 $this->session->set_flashdata('pix-msg', '<div class="alert alert-success">You have Updated Your profile picture </div>');
		 
		$user_id = $this->uri->segment(3); 
        
     redirect( base_url() . 'account/profile');  
 
		
			}
		
    }	   
	  
public function edit_profile()
    {
		
       
        
        $data['title'] = 'Edit Profile - Dashboard.';
		
			$user_id = $this->session->userdata('user_id');
       $data['user']=$this->Account_Model->get_user();
        
  		$this->form_validation->set_rules('fname','First Name', 'required');
		$this->form_validation->set_rules('lname','Last Name', 'required');
		$this->form_validation->set_rules('phone','Phone', 'required');
		$this->form_validation->set_rules('school','Institution', 'required');
		$this->form_validation->set_rules('campus','Campus', 'required');
		$this->form_validation->set_rules('address','Address', 'required');
		$this->form_validation->set_rules('about','About Me', 'required');
      
	
        if ($this->form_validation->run() === FALSE)
        {
         $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/profile', $data);
		
		$this->load->view('dashboard/templates/footer');	
 
        }
        else
		
        {
			$user_id = $this->session->userdata('user_id');       
       		 
            $data = array(
				
                'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'phone' => $this->input->post('phone'),
				'institution' => $this->input->post('school'),
				'campus' => $this->input->post('campus'),
				'address' => $this->input->post('address'),
				'about' => $this->input->post('about'),
				'about' => $this->input->post('about'),
				'city' => $this->input->post('city'),
				'zip' => $this->input->post('zip'),
				
				
            );
			 
		

		$this->Account_Model->update_profile($user_id,$data);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have Updated Your profile </div>');
		 
		 
        
     redirect( base_url() . 'account/profile/'.$user_id);   
 
		
			
		
        }
    
	}
	
public function order()
        {
		$data['title'] = 'Oder Details';
		 $code = $this->uri->segment(3);	
		 $data['user']=$this->Account_Model->get_user();
		 $data['order'] = $this->Basket_model->get_order($code);
		 
		 $this->form_validation->set_rules('ownprice','Your Price', 'required');
      
	
        if ($this->form_validation->run() === FALSE)
        {
         $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
        $this->load->view('dashboard/order-details', $data);
		 $this->load->view('dashboard/templates/footer');
		 
		}else{
			 
		    $code = $this->uri->segment(3);	
       		 
            $data = array(
				
                'ownprice' => $this->input->post('ownprice'),
				
				
            );
			 
		

		$this->Account_Model->update_price($code,$data);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have Updated your order Price </div>');
		 
		 
        
     redirect( base_url() . 'account/order/'.$code);   	 
			 
		 }
        }
		


public function celebrant_orders()
        {
		$data['title'] = 'Oder Details';
		 $data['user']=$this->Account_Model->get_user();
		 $data['order'] = $this->Account_Model->get_order();
         $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
        $this->load->view('dashboard/celebrant-order');
		 $this->load->view('dashboard/templates/footer');
        }

public function order_history()
        {
		$data['title'] = 'Oder History | Tradpeek Plus';
		 $data['user']=$this->Account_Model->get_user();
		 $data['order'] = $this->Account_Model->get_order_history();
         $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
        $this->load->view('dashboard/order-history');
		 $this->load->view('dashboard/templates/footer');
        }

public function order_details()
        {
			$order_id = $this->uri->segment(3);
		$data['title'] = 'Order History | Tradpeek Plus';
		 $data['user']=$this->Account_Model->get_user();
		 $data['order'] = $this->Account_Model->get_order_details($order_id);
         $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
        $this->load->view('dashboard/order-history-details');
		 $this->load->view('dashboard/templates/footer');
        }


public function cancel_order()
        {
		
		 $order_id = $this->uri->segment(3);
		
           
		

		$this->Account_Model->cancel_order($order_id);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have deleted an Order</div>');
		 
		 
        
     redirect( base_url() . 'account/order_history');   	 
			 
		 
        }
	


}