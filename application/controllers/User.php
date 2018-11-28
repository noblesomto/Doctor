<?php
class User extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                 $this->load->model('User_model');
				
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

    redirect(base_url().'page/index');
}
        }

public function index()
        {

		$data['title'] = 'News Feed - Friendly Doctor';
		
        $this->load->view('templates/header', $data);
       	$this->load->view('templates/nav2');
		
		$this->load->view('user/index', $data);
        $this->load->view('templates/footer');
       
       }


   

public function find_typist()

{
		$data['title'] = 'Find Typist - Typist.ng';
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/find-typist', $data);
		
		$this->load->view('dashboard/templates/footer');
}


public function search_typist($offset=0)
        {
			
	$data['title'] = 'Find Typist - Typist.ng';
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
  
  		
		
	
        
        $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/search-typist', $data);
		
		$this->load->view('dashboard/templates/footer');
		 
		
        }
		
public function view_typist()

{
		$data['title'] = 'Typist Profile - Typist.ng';
		$user_id = $this->uri->segment(3);
		 $data['user']=$this->User_model->get_user_by_id($user_id);
		 $data['rating']=$this->User_model->get_rating_total($user_id);
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/typist-profile', $data);
		
		$this->load->view('dashboard/templates/footer');
}

public function book_typist()

{
		$data['title'] = 'Book Typist - Typist.ng';
		$user_id = $this->uri->segment(3);
		 $data['user']=$this->User_model->get_user_by_id($user_id);
		 
		
		$this->form_validation->set_rules('title','Title The Job', 'required');
		$this->form_validation->set_rules('about','About The Work', 'required');
      
	
        if ($this->form_validation->run() === FALSE)
        {
			
			
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/book-typist', $data);
		
		$this->load->view('dashboard/templates/footer');
		}
		 else{


		 	 $config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'doc|pdf|docx';
			$config['overwrite'] = false;
			$config['max_size']             = 1500;
			$config['remove_spaces'] = FALSE;
			
			$config['file_name'] = $_FILES["job_format"]['name'];

			$this->load->library('upload', $config);
			$this->upload->do_upload('job_format');
			$image=$this->upload->data();



			
			$length = 8;

$ref = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

			$user_id = $this->session->userdata('user_id');       
       		 $typist_email = $this->input->post('typist_email');
			 
            $data = array(
				
                'typist_name' => $this->input->post('typist'),
				'typist_id' => $this->input->post('typist_id'),
				'title' => $this->input->post('title'),
				'about' => $this->input->post('about'),
				'user_id' => $user_id,
				'ref' => $ref,
				'job_status' => "pending",
				'job_format' => $image['file_name'],
				'date' => date("Y-m-d H:i:s"),
				
				
            );
			 
		

		$this->User_model->book_typist($data);
		
		$this->User_model->send_typist_email($typist_email);
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have Booked this typist, you can track your job with '.$ref.' </div>');
		 
		 
        
     redirect( base_url() . 'user/booking/'.$ref);   
 
		
			
		
        }
}

public function booking()

{
		$data['title'] = 'Booking Details - Typist.ng';
		$ref = $this->uri->segment(3);
		 $data['ref']=$this->User_model->get_booking($ref);
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/booking', $data);
		
		$this->load->view('dashboard/templates/footer');
}

public function track_jobs()

{
		$data['title'] = 'Track Jobs - Typist.ng';
		$data['job']=$this->User_model->pending_jobs();
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/track-jobs', $data);
		
		$this->load->view('dashboard/templates/footer');
}

public function job_details()

{
		$data['title'] = 'Track Jobs - Typist.ng';
		$ref = $this->input->post('ref');
		$data['ref']=$this->User_model->get_booking($ref);
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/job-details', $data);
		
		$this->load->view('dashboard/templates/footer');
}

public function job_pay()

{
		$data['title'] = 'Make Payment - Typist.ng';
		$ref = $this->uri->segment(3);
		$data['ref']=$this->User_model->get_booking($ref);
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/payment', $data);
		
		$this->load->view('dashboard/templates/footer');
}


public function payment()

{
		$data['title'] = 'Typist Profile - Typist.ng';
		$ref = $this->uri->segment(3);
		
		$data['ref']=$this->User_model->get_booking($ref);
		 
		
		$this->form_validation->set_rules('depositor','Depositor Name', 'required');
		$this->form_validation->set_rules('amount','Amount Deposited', 'required');
		$this->form_validation->set_rules('method','Method of Payment', 'required');
      
	
        if ($this->form_validation->run() === FALSE)
        {
			
		$ref = $this->input->post('ref');
		
		$data['ref']=$this->User_model->get_booking($ref);
			
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/payment');
		
		$this->load->view('dashboard/templates/footer');
		}
		 else
		
        {
			
			$length = 10;

$order_id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

			
			 
            $order = array(
			'user_id'=>$this->session->userdata('user_id'),
			'order_id'=>$order_id,
			'ref_id'=>$this->input->post('ref'),
			'depositor'=>$this->input->post('depositor'),
			'status'=>"pending",
			'method'=>$this->input->post('method'),
			'amount' =>$this->input->post('amount'),
			'date' => date("Y-m-d H:i:s"),
			);
			 
		

		$this->User_model->insert_order($order);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Thank you for using our service. After your payment has been verified, you will be notified via email or SMS to download your completed job from the Completed Job tab. </div>');
		 
		 
    $data['title']='Payment Successful - Typist.ng';
		
		
        $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/payment-success', $data);
		
		$this->load->view('dashboard/templates/footer');
			
		
        }
}


public function completed_jobs()

{
		$data['title'] = 'Completed Jobs - Typist.ng';
		
		$data['job']=$this->User_model->completed_jobs();
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/completed-jobs', $data);
		
		$this->load->view('dashboard/templates/footer');
}

public function download_job()

{
		$data['title'] = 'Download Job - Typist.ng';
		$this->form_validation->set_rules('review','Review', 'required');
		
		if ($this->form_validation->run() === FALSE)
        {
			
		$user_id = $this->uri->segment(3);
		$data['user']=$this->User_model->get_user_by_id($user_id);
		$job_id = $this->uri->segment(4);
		$data['job']=$this->User_model->jobs_by_id($job_id);
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/download-job', $data);
		
		$this->load->view('dashboard/templates/footer');
		}else{
			
		$prop= $this->input->post('proposal_id');
		
			$data = array(
       
	    'user_id'=>$this->session->userdata('user_id'),
		'username'=>$this->session->userdata('username'),
		'rate' => $this->input->post('star'),
		'review' => $this->input->post('review'),
		'typist_id' =>$typist= $this->input->post('typist'),
		'date' => date("Y-m-d H:i:s"),
		
		
		
    );


		$this->User_model->add_rating($data);
		$data['rating'] = $this->User_model->get_rating_number($typist);
		
		
		$rate = array(
        'rating' => $data['rating'],
	
    );
	
		$this->User_model->update_rating($typist,$rate);
		
		
		  $this->session->set_flashdata('review', '<div class="alert alert-success text-center">Thank You!. You have Successfully added your review</div>');
		  $user_id = $this->uri->segment(3);
		  $job_id = $this->uri->segment(4);
		redirect(base_url("user/download_job/".$user_id.'/'.$job_id));
	
		
		
			
			}
		
		
}

public function download($ref){
        if(!empty($ref)){
            //load download helper
            $this->load->helper('download');
            
            //get file info from database
            $data['filename'] = $this->User_model->get_download($ref);
			$fileInfo=$data['filename']['job_upload'];
           
            //file path
            $file = './uploads/'.$fileInfo;
            
            //download file from directory
            force_download($file, NULL);
        }
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
			
		
		
			
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/withdrawal', $data);
		
		$this->load->view('dashboard/templates/footer');
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
			 
		

		$this->User_model->request_withdrawal($data);
		
		
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">You have requested for Withdrawal </div>');
		 
		 
        
     redirect( base_url() . 'user/withdrawal');   
 
		
			
		
        }
}


public function transactions()

{
		$data['title'] = 'My Transactions - Typist.ng';
		
		$data['trans']=$this->User_model->transactions();
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/transactions', $data);
		
		$this->load->view('dashboard/templates/footer');
}



public function history()

{
		$data['title'] = 'My Transactions - Typist.ng';
		
		$data['trans']=$this->User_model->get_transactions();
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/history', $data);
		
		$this->load->view('dashboard/templates/footer');
}


public function corrections(){
	
	 
		
        $data['title'] = 'Request Correction - Typist.ng';
		 $this->form_validation->set_rules('title','Title', 'trim|required');
        $this->form_validation->set_rules('ref','Reference ID', 'trim|required');
		$this->form_validation->set_rules('action','Select Correction/Re-type', 'trim|required');
		$this->form_validation->set_rules('comment','Details Of the Correction', 'trim|required');
        
        
        if($this->form_validation->run() == false){
                   
    	 $this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		$this->load->view('dashboard/request-correction', $data);
		$this->load->view('dashboard/templates/footer');
                  
        }else{
            
            $config['upload_path']          = './corrections/';
			$config['allowed_types']        = 'pdf|doc|docx';
			$config['overwrite'] = false;
			$config['max_size']             = 1500;
			$config['file_name'] = $_FILES["job"]['name'];

			$this->load->library('upload', $config);
			
				
							
			if ( ! $this->upload->do_upload('job')){
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('dashboard/templates/header', $data);
				$this->load->view('dashboard/templates/nav');
				$this->load->view('dashboard/request-correction', $data);
				$this->load->view('dashboard/templates/footer');
			}else{
								
					$image=$this->upload->data();
					
				
	
	

	
   
	$date = date("Y-m-d H:i:s");

 
    $data = array(
        'title' => $this->input->post('title'),
		'ref' => $this->input->post('ref'),
		'action' => $this->input->post('action'),
		'details' => $this->input->post('comment'),
       
		'date' => $date,
	
		'job' => $image['file_name'],
		
		
		
    );


		$this->User_model->upload_correction($data);
    
 $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">You Have requested for correction</div>'); 
		
		
        redirect(base_url("user/corrections"));
            
                

			}
		}
 }

public function review($offset=0)

{
		$data['title'] = 'Typist Review - Typist.ng';
		
		$user_id = $this->uri->segment(3);
		$data['user']=$this->User_model->get_user_by_id($user_id);
		$data['rating']=$this->User_model->get_rating_total($user_id);
		 
		 
		$config['total_rows'] = $this->User_model->totalreview($user_id);
  
  $config['base_url'] = base_url()."user/review/".$user_id.'/';
  $config['per_page'] = 5;
  $config['uri_segment'] = '4';
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
   

  $query = $this->User_model->get_review($user_id,5,$this->uri->segment(4));
  
  $data['rate'] = null;
  
  if($query){
   $data['rate'] =  $query;
  }
		
		
		$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/review', $data);
		
		$this->load->view('dashboard/templates/footer');
}


public function add_rating()
    {
		
     $this->form_validation->set_rules('review','Enter Review', 'required');
      
	
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('dashboard/templates/header', $data);
		$this->load->view('dashboard/templates/nav');
		
		$this->load->view('dashboard/review', $data);
		
		$this->load->view('dashboard/templates/footer');
		
		}else{
		
		$data = array(
        'typist_id' => $typist_id = $this->input->post('typist_id'),
		'username' => $this->session->userdata('username'),
		'user_id' => $this->session->userdata('user_id'),
        'rate'=> $this->input->post('star'),
		'review'=>$this->input->post('review'),
		'date'=>date("Y-m-d H:i:s"),
    );
		
		 $this->User_model->add_rating($data);
		$data['rating'] = $this->User_model->get_rating_number($typist_id);
		
		
		$rate = array(
        'rating' => $data['rating'],
	
    );
	
		$this->User_model->update_rating($typist_id,$rate);
		
	
		 
     $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">You Have added your Review</div>'); 
		
		
        redirect(base_url("user/review/".$typist_id));
            
	  
	}

		}
		



}