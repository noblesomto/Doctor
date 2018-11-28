<?php
class Doctor extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                 $this->load->model('Doctor_model');
				$this->load->model('Account_Model');
                $this->load->helper('url_helper');
				$this->load->library('cart');
				$this->load->library('user_agent');
				$this->load->library('session');
				$this->load->helper('form');
				$this->load->helper('text');
        		$this->load->library('form_validation');
				$this->load->helper('string');
				$this->load->library('pagination');
				$sess_id = $this->session->userdata('user_id');
		

   if(empty($sess_id))
   {

    redirect(base_url().'account/login');
}
        }


public function index()
        {
		
		$data['title'] = 'News Feed - Friendly Doctor';
        $this->load->view('templates/header', $data);
       	$this->load->view('templates/nav2');
		$this->load->view('doctor/side1', $data);
		$this->load->view('doctor/index', $data);
		$this->load->view('doctor/side2', $data);
        $this->load->view('templates/footer');
       
       }


public function post()
        {
		
		$data['title'] = 'Post Article - Friendly Doctor';

		$this->form_validation->set_rules('title', 'Title', 'required');
    	$this->form_validation->set_rules('body', 'Article Content', 'required');

    	if ($this->form_validation->run() === FALSE)
    {

        $this->load->view('templates/header', $data);
       	$this->load->view('templates/nav2');
		$this->load->view('doctor/side1', $data);
		$this->load->view('doctor/post', $data);
		$this->load->view('doctor/side2', $data);
        $this->load->view('templates/footer');

         }else
    {
	
    $post_id= rand(000000,999999);
	$slug = url_title($this->input->post('title'), 'dash', TRUE);
	$date = date("Y-m-d H:i:s");
	$user_id = $this->session->userdata('user_id'); 
 
    $data = array(
        'title' => $this->input->post('title'),
        'slug' => $slug,
		
		'body' => $this->input->post('body'),
		
		'user_id' => $user_id,
		'post_date' => $date,
		
		'post_id'=>$post_id,
		
		
		
    );

    $this->Doctor_model->post_article($data);
		
    
 $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Article successfully Published</div>'); 
		
		
        redirect(base_url("doctor/post"));
            
                


	}
       
       }



public function profile()
{
		$data['title'] = 'My Profile - Typist.ng';
		$user_id = $this->uri->segment(3);
		$data['user']=$this->Account_Model->get_user();
        $this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/profile', $data);
		
		$this->load->view('typist/templates/footer');	
	
	
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
         $data['title'] = 'My Profile';     
      		 $config['upload_path']          = './pix/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['overwrite'] = false;
			$config['max_size']             = 800;
			
			$config['file_name'] = $_FILES["picture"]['name'];

			$this->load->library('upload', $config);
			
				
							
			if (! $this->upload->do_upload('picture')){
				 $data['title'] = 'My Profile - Typist.ng'; 
				$error = array('error' => $this->upload->display_errors());
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/profile', $error);
		
		$this->load->view('typist/templates/footer');
			}else{
				
	$image=$this->upload->data();	
	
	 $data = array(
       
		'pix' => $image['file_name'],
		
		
		
		
    );


		$this->Account_Model->update_profile($user_id,$data);
		
		
		 $this->session->set_flashdata('pix-msg', '<div class="alert alert-success">You have Updated Your profile picture </div>');
		 
		$user_id = $this->uri->segment(3); 
        
     redirect( base_url() . 'typist/profile');  
 
		
			}
		
    }	 	   
	  
public function edit_profile()
    {
		
       
        
        $data['title'] = 'Edit Profile - Typist.ng.';
		
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
         $this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/profile', $data);
		
		$this->load->view('typist/templates/footer');	
 
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
				'acc_name' => $this->input->post('acc_name'),
				'bank_name' => $this->input->post('bank_name'),
				'acc_num' => $this->input->post('acc_num'),
				
				
            );
			 
		

		$this->Account_Model->update_profile($user_id,$data);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have Updated Your profile </div>');
		 
		 
        
     redirect( base_url() . 'typist/profile/'.$user_id);   
 
		
			
		
        }
    
	}
	   
   

public function orders()

{
		$data['title'] = 'New Orders - Typist.ng';
		
		$data['order']=$this->Typist_model->get_new_orders();
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/orders', $data);
		
		$this->load->view('typist/templates/footer');
}

public function pickup_action()

{
		$data['title'] = 'Order Details - Typist.ng';
		$ref =$this->input->post('ref');
		$data = array(
		'pickup_action' =>$this->input->post('pickup'),
		'pickup_date' => date("Y-m-d H:i:s"),
		);
	
		
		
		$this->Typist_model->pickup_action($data,$ref);
		
		$user_id = $this->input->post('user');
		$data['user'] = $this->Typist_model->get_user($user_id);
		$user_email= $data['user']['email'];
		$this->Typist_model->email_user_pickup($user_email);
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have modified this Order  </div>');
        
     redirect( base_url() . 'typist/orders');   
		
}


public function order_action()

{
		$data['title'] = 'Order Details - Typist.ng';
		$ref =$this->input->post('ref');
		$data = array(
		'typist_action' =>$this->input->post('action'),
		'action_date' => date("Y-m-d H:i:s"),
		);
	
		$action = $this->input->post('action');
		
		$this->Typist_model->order_action($data,$ref);
		
		$user_id = $this->input->post('user');
		$data['user'] = $this->Typist_model->get_user($user_id);
		$user_email= $data['user']['email'];
		if($action=='Accepted'){
		$this->Typist_model->email_user_accept($user_email);
		}else{
		$this->Typist_model->email_user_decline($user_email);	
		}
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have '.$action.' this Order  </div>');
        
     redirect( base_url() . 'typist/orders');   
		
}

public function search_typist($offset=0)
        {
			
	$data['title'] = 'Find Typist';
		$search = $this->input->post('typist');
			
	
	$config['total_rows'] = $this->User_model->totaltypist($search);
  
  $config['base_url'] = base_url()."account/search_typist/";
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
   

  $query = $this->User_model->get_typist($search,20,$this->uri->segment(3));
  
  $data['user'] = null;
  
  if($query){
   $data['user'] =  $query;
  }
  
  		
		
	
        
        $this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/search-typist', $data);
		
		$this->load->view('typist/templates/footer');
		 
		
        }
		
public function view_typist()

{
		$data['title'] = 'Typist Profile - Typist.ng';
		$user_id = $this->uri->segment(3);
		 $data['user']=$this->User_model->get_user_by_id($user_id);
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/typist-profile', $data);
		
		$this->load->view('typist/templates/footer');
}

public function order_search()

{
		$data['title'] = 'Update Order - typist.ng';
		
		 
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/get-order', $data);
		
		$this->load->view('typist/templates/footer');
}


public function update_order()

{
		$data['title'] = 'Update Order - Typist.ng';
		
		$search = $this->input->post('search');
		
		 		
		$this->form_validation->set_rules('progress','Work Progress', 'required');
		$this->form_validation->set_rules('comment','Progress Comment', 'required');
      
	
        if ($this->form_validation->run() === FALSE)
        {
			
		
		$data['ref']=$this->Typist_model->get_order($search);
			
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/update-order', $data);
		
		$this->load->view('typist/templates/footer');
		}
		 else
		
        {
			
			 $config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'doc|pdf|docx';
			$config['overwrite'] = false;
			$config['max_size']             = 1500;
			$config['remove_spaces'] = FALSE;
			
			$config['file_name'] = $_FILES["job_upload"]['name'];

			$this->load->library('upload', $config);
			$this->upload->do_upload('job_upload');
			$image=$this->upload->data();
			
			
			$ref =$this->input->post('ref');
			 
            $data = array(
				
               
				'progress' => $this->input->post('progress'),
				
				'comment' => $this->input->post('comment'),
				'job_status' => $this->input->post('status'),
				'words' => $this->input->post('words'),
				'job_upload' => $image['file_name'],
				'update_date' => date("Y-m-d H:i:s"),
				
				
            );
			 
		

		$this->Typist_model->update_job($ref,$data);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have updated the Job Order </div>');
		 
		 
        
     redirect( base_url() . 'typist/order_search');   
 
		
			
		
        }
}

public function booking()

{
		$data['title'] = 'Booking Details - Typist.ng';
		$ref = $this->uri->segment(3);
		 $data['ref']=$this->User_model->get_booking($ref);
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/booking', $data);
		
		$this->load->view('typist/templates/footer');
}

public function track_jobs()

{
		$data['title'] = 'Track Jobs - Typist.ng';
		
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/track-jobs', $data);
		
		$this->load->view('typist/templates/footer');
}

public function job_details()

{
		$data['title'] = 'Track Jobs';
		$ref = $this->input->post('ref');
		$data['ref']=$this->User_model->get_booking($ref);
		
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/job-details', $data);
		
		$this->load->view('typist/templates/footer');
}

public function completed_jobs()

{
		$data['title'] = 'Completed Jobs - Typist.ng';
		
		$data['job']=$this->Typist_model->completed_jobs();
		
		
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/completed-jobs', $data);
		
		$this->load->view('typist/templates/footer');
}


public function withdrawal()

{
		$data['title'] = 'Request Withdrawal - Typist.ng';
		
		
		
		$this->form_validation->set_rules('amount','Amount', 'required'); 		
		$this->form_validation->set_rules('bname','Bank Name', 'required');
		$this->form_validation->set_rules('accname','Account Name', 'required');
		$this->form_validation->set_rules('accnum','Account Number', 'required');
      
	
        if ($this->form_validation->run() === FALSE)
        {
			
		
		
			
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/withdrawal', $data);
		
		$this->load->view('typist/templates/footer');
		}
		 else
		
        {
			
			
			 
            $data = array(
				
               
				'amount' => $this->input->post('amount'),
				'bname' => $this->input->post('bname'),
				'accname' => $this->input->post('accname'),
				'accnum' => $this->input->post('accnum'),
				'account' => $this->input->post('account'),
				'user_id' => $this->session->userdata('user_id'),
				'status' => "pending",
				'date' => date("Y-m-d H:i:s"),
				
				
            );
			 
		

		$this->Typist_model->request_withdrawal($data);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have requested for Withdrawal </div>');
		 
		 
        
     redirect( base_url() . 'typist/withdrawal');   
 
		
			
		
        }
}

public function transactions()

{
		$data['title'] = 'My Transactions - Typist.ng';
		
		$data['trans']=$this->Typist_model->get_transactions();
		
		
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/transactions', $data);
		
		$this->load->view('typist/templates/footer');
}


public function corrections()

{
		$data['title'] = 'Request Correction - Typist.ng';
		
		$data['job']=$this->Typist_model->get_corrections();
		
		
		$this->load->view('typist/templates/header', $data);
		$this->load->view('typist/templates/nav');
		
		$this->load->view('typist/corrections', $data);
		
		$this->load->view('typist/templates/footer');
}


public function download($ref){
        if(!empty($ref)){
            //load download helper
            $this->load->helper('download');
            
            //get file info from database
            $data['filename'] = $this->Typist_model->get_download($ref);
			$fileInfo=$data['filename']['job'];
           
            //file path
            $file = './corrections/'.$fileInfo;
            
            //download file from directory
            force_download($file, NULL);
        }
    }

 public function download_job($ref){
        if(!empty($ref)){
            //load download helper
            $this->load->helper('download');
            
            //get file info from database
            $data['filename'] = $this->Typist_model->get_download_format($ref);
			$fileInfo=$data['filename']['job_format'];
           
            //file path
            $file = './uploads/'.$fileInfo;
            
            //download file from directory
            force_download($file, NULL);
        }
    }

}