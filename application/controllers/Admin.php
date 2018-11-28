<?php
class Admin extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                
                $this->load->helper('url_helper');
				$this->load->helper('text');
				$this->load->library('javascript');
				$this->load->library('cart');
				$this->load->library('session');
 				$this->load->library('pagination');
				 $this->load->library('form_validation');
				 $this->load->model('Admin_model'); 
				 
    

        }

        public function admin(){
	
	 $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Admin_model'); 
		 $this->load->helper('url_helper');
		
		
        $data['title'] = 'Admin Login';
        $this->form_validation->set_rules('username','Username', 'trim|required');
        $this->form_validation->set_rules('password','Password', 'trim|required');
        
        if($this->form_validation->run() == false){
                   
                    $this->load->view('templates/header', $data);
					$this->load->view('templates/nav');
                    $this->load->view('admin');
                    $this->load->view('templates/footer');
                  
        }else{
            
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            
            if($this->Admin_model->loginAdmin($username, $password)){
                
                $userInfo = $this->Admin_model->loginAdmin($username, $password);
            
                
                    
                
                
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Successfully logged in</div>');
                //$this->load->view('header');
                //$this->load->view('tasks_view');
                //$this->load->view('footer');
				if( $this->session->userdata('redirect_back') ) {
    $redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
    $this->session->unset_userdata('redirect_back');
    redirect( $redirect_url );
}
				else{
                redirect(base_url().'admin/index');
				}
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Login Failed!! Please try again.</div>');
                    $this->load->view('templates/header', $data);
					$this->load->view('templates/nav');
                    $this->load->view('admin');
                    $this->load->view('templates/footer');
                
            }
        }
    }
    

 public function admin_logout(){
		
		
        $this->load->library('session');
         
        
        if($this->session->has_userdata('admin_id')){
            //$this->session->unset_userdata('user_data');
            $this->session->sess_destroy();
            //unset($_SESSION['user_data']);
             
            redirect(base_url().'admin/admin');
        }
        
        
    }

 
 public function index()
        {
		 $sess_id = $this->session->userdata('admin_id');
		

   if(empty($sess_id))
   {

    redirect(base_url().'admin/admin');
}            
        $data['title'] = 'Admin Dashboard'; 
		
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/nav');
		
        $this->load->view('admin/index', $data);
		
        $this->load->view('admin/templates/footer');
        }

 
    


public function unpaid()
        {
		             
       
		
		$data['title'] = 'Unconfirmed Payments';
		
	
		$data['unpaid']=$this->Admin_model->get_unpaid();
		
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/nav');
		
        $this->load->view('admin/unpaid', $data);
		
        $this->load->view('admin/templates/footer');
        }

 public function confirm_payment()
        {
		             
       $ref = $this->uri->segment(3);
		date_default_timezone_set('Africa/Lagos');
			$pay_date = date("Y-m-d H:i:s");
			
			$data = array(
                
				'status'=>"paid",
				
				'pay_date'=>$pay_date,
            );
			$this->Admin_model->confirm_pay($ref,$data);
			
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">You have confrimed the payment</div>');			
		
		redirect(base_url().'admin/unpaid');
		
        }
		
		
    
public function jobs($offset=0)
        {
			
	$data['title'] = 'All Jobs';
		
	
	$config['total_rows'] = $this->Admin_model->totaljobs();
  
  $config['base_url'] = base_url()."admin/jobs/";
  $config['per_page'] = 20;
  $config['uri_segment'] = '3';
 $config['use_page_numbers'] = TRUE;
 $config['full_tag_open'] = '<ul class="pagination">';
 $config['full_tag_close'] = '</ul>';
 $config['prev_link'] = '&laquo;';
 $config['prev_tag_open'] = '<li>';
 $config['prev_tag_close'] = '</li>';
 $config['next_tag_open'] = '<li>';
 $config['next_tag_close'] = '</li>';
 $config['cur_tag_open'] = '<li class="active"><a href="#">';
 $config['cur_tag_close'] = '</a></li>';
 $config['num_tag_open'] = '<li>';
 $config['num_tag_close'] = '</li>';
 $config['next_link'] = '&raquo;';


  $this->pagination->initialize($config);
   

  $query = $this->Admin_model->list_jobs(20,$this->uri->segment(3));
  
  $data['job'] = null;
  
  if($query){
   $data['job'] =  $query;
  }

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/nav');
		
        $this->load->view('admin/jobs', $data);
		
        $this->load->view('admin/templates/footer');
		}
		
		
public function users($offset=0)
        {
			
	$data['title'] = 'Users';
		
	
	$config['total_rows'] = $this->Admin_model->totalusers();
  
  $config['base_url'] = base_url()."admin/users/";
  $config['per_page'] = 20;
  $config['uri_segment'] = '3';
 $config['use_page_numbers'] = TRUE;
 $config['full_tag_open'] = '<ul class="pagination">';
 $config['full_tag_close'] = '</ul>';
 $config['prev_link'] = '&laquo;';
 $config['prev_tag_open'] = '<li>';
 $config['prev_tag_close'] = '</li>';
 $config['next_tag_open'] = '<li>';
 $config['next_tag_close'] = '</li>';
 $config['cur_tag_open'] = '<li class="active"><a href="#">';
 $config['cur_tag_close'] = '</a></li>';
 $config['num_tag_open'] = '<li>';
 $config['num_tag_close'] = '</li>';
 $config['next_link'] = '&raquo;';


  $this->pagination->initialize($config);
   

  $query = $this->Admin_model->list_users(20,$this->uri->segment(3));
  
  $data['user'] = null;
  
  if($query){
   $data['user'] =  $query;
  }

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/nav');
		
        $this->load->view('admin/users', $data);
		
        $this->load->view('admin/templates/footer');
		}


    public function cba($offset=0)
        {
      
  $data['title'] = 'Campus Brand Ambassador';
    
  
  $config['total_rows'] = $this->Admin_model->totalcba();
  
  $config['base_url'] = base_url()."admin/cba/";
  $config['per_page'] = 20;
  $config['uri_segment'] = '3';
 $config['use_page_numbers'] = TRUE;
 $config['full_tag_open'] = '<ul class="pagination">';
 $config['full_tag_close'] = '</ul>';
 $config['prev_link'] = '&laquo;';
 $config['prev_tag_open'] = '<li>';
 $config['prev_tag_close'] = '</li>';
 $config['next_tag_open'] = '<li>';
 $config['next_tag_close'] = '</li>';
 $config['cur_tag_open'] = '<li class="active"><a href="#">';
 $config['cur_tag_close'] = '</a></li>';
 $config['num_tag_open'] = '<li>';
 $config['num_tag_close'] = '</li>';
 $config['next_link'] = '&raquo;';


  $this->pagination->initialize($config);
   

  $query = $this->Admin_model->list_cba(20,$this->uri->segment(3));
  
  $data['user'] = null;
  
  if($query){
   $data['user'] =  $query;
  }

    $this->load->view('admin/templates/header', $data);
    $this->load->view('admin/templates/nav');
    
        $this->load->view('admin/cba', $data);
    
        $this->load->view('admin/templates/footer');
    }


public function typist($offset=0)
        {
			
	$data['title'] = 'All Typists';
		
	
	$config['total_rows'] = $this->Admin_model->totaltypist();
  
  $config['base_url'] = base_url()."admin/typist/";
  $config['per_page'] = 20;
  $config['uri_segment'] = '3';
 $config['use_page_numbers'] = TRUE;
 $config['full_tag_open'] = '<ul class="pagination">';
 $config['full_tag_close'] = '</ul>';
 $config['prev_link'] = '&laquo;';
 $config['prev_tag_open'] = '<li>';
 $config['prev_tag_close'] = '</li>';
 $config['next_tag_open'] = '<li>';
 $config['next_tag_close'] = '</li>';
 $config['cur_tag_open'] = '<li class="active"><a href="#">';
 $config['cur_tag_close'] = '</a></li>';
 $config['num_tag_open'] = '<li>';
 $config['num_tag_close'] = '</li>';
 $config['next_link'] = '&raquo;';


  $this->pagination->initialize($config);
   

  $query = $this->Admin_model->list_typist(20,$this->uri->segment(3));
  
  $data['user'] = null;
  
  if($query){
   $data['user'] =  $query;
  }

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/nav');
		
        $this->load->view('admin/typist', $data);
		
        $this->load->view('admin/templates/footer');
		}
		
		
		
		
public function user_details()
        {
		             
    $user_id = $this->uri->segment(3);   
		
		$data['title'] = 'User Profile';
		
	
		$data['user']=$this->Admin_model->get_user($user_id);
		
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/nav');
		
        $this->load->view('admin/user-details', $data);
		
        $this->load->view('admin/templates/footer');
        }		


public function delete_job()
    {
      $job_id = $this->uri->segment(3);
        
        if (empty($job_id))
        {
            show_404();
        }
                
      
        
        $this->Admin_model->delete_job($job_id);  
	$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">You have deleted a job</div>');      
        redirect( base_url() . 'admin/jobs');        
    }


public function delete_user()
    {
      $user_id = $this->uri->segment(3);
        
        if (empty($user_id))
        {
            show_404();
        }
                 
        
        $this->Admin_model->delete_user($user_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">You have deleted a user</div>');        
        redirect( base_url() . 'admin/users');        
    }


public function delete_typist()
    {
      $user_id = $this->uri->segment(3);
        
        if (empty($user_id))
        {
            show_404();
        }
                 
        
        $this->Admin_model->delete_user($user_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">You have deleted a Typist</div>');        
        redirect( base_url() . 'admin/typist');        
    }


public function suspend_typist()

{
		
		$user_id =$this->input->post('user_id');
		$data = array(
		'user_status' =>$this->input->post('user_status'),
		
		);
	
		
		
		$this->Admin_model->suspend_typist($data,$user_id);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have changed a Typist Status </div>');
        
    redirect( base_url() . 'admin/typist');       
		
}











		
}