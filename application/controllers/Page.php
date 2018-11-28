<?php
class Page extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
               
                $this->load->helper('url_helper');
				$this->load->helper('text');
				$this->load->helper('url');
				$this->load->library('javascript');
				$this->load->library('session');
 				$this->load->library('pagination');
 				$this->load->library('session');
				$this->load->helper('form');
				$this->load->helper('text');
        		$this->load->library('form_validation');
				

        }


	public function index()
        {
		
        $data['title'] = 'Friendly Doctor';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('index', $data);
       
       }


    


        public function newsfeed()
        {
			
			
		
        $data['title'] = 'About Us | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav2');
		
		$this->load->view('newsfeed', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function services()
        {
			
        $data['title'] = 'Our Services | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('services', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function ecommerce()
        {
			
        $data['title'] = 'Ecommerce | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('ecommerce', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function sms_marketing()
        {
			
        $data['title'] = 'SMS Marketing | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('sms_marketing', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function email_marketing()
        {
			
        $data['title'] = 'Email Marketing | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('email_marketing', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function digital_marketing()
        {
			
        $data['title'] = 'Digital Marketing | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('digital_marketing', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function mobile_apps()
        {
			
        $data['title'] = 'Mobile Apps | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('mobile_apps', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function web_development()
        {
			
        $data['title'] = 'Web Development | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('web_development', $data);
        $this->load->view('templates/footer');
        }
		
		
		
		public function social_media()
        {
			
        $data['title'] = 'Social Media Marketing | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('social_media', $data);
        $this->load->view('templates/footer');
        }
		
		
		public function seo()
        {
			
        $data['title'] = 'Search Engine Optimization | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('seo', $data);
        $this->load->view('templates/footer');
        }


        public function trainings()
        {
			
        $data['title'] = 'Trainings | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('data', $data);
        $this->load->view('templates/footer');
        }


        public function course()
        {
			
        $data['title'] = 'Training Course | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('course', $data);
        $this->load->view('templates/footer');
        }



        public function form()
        {
			
        $data['title'] = 'Training Course | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('form', $data);
        $this->load->view('templates/footer');
        }
		
		
		
		public function contact(){
		
		 $data['title'] = 'Contact Us | Noble Contracts - Web Design  | e-Commerce Development | Digital Marketing';
		
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
       
        $this->load->library('email');
        $this->load->helper('url');
       
        $this->load->model('Page_Model');
		$this->load->library('email');
		
		 $this->form_validation->set_rules('name','Name', 'required');
       	 $this->form_validation->set_rules('phone','Phone', 'trim|required');
        $this->form_validation->set_rules('email','Email', 'trim|required');
        $this->form_validation->set_rules('subject','Subject', 'trim|required');
        $this->form_validation->set_rules('message','Message', 'required');
		
		
			
        if($this->form_validation->run() == false){
            		$this->load->view('templates/header', $data);
					$this->load->view('templates/nav');
                    $this->load->view('contact');
                    $this->load->view('templates/footer');
            
        }else{
		
      
                $name = $this->input->post('name');
				$phone = $this->input->post('phone');
                $subject = $this->input->post('subject');
              
				$email = $this->input->post('email');
				$comment = $this->input->post('message');
				
            
            
           
           $this->Page_Model->contact_admin($name,$phone,$email,$subject,$comment);
                
               
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Successfully Sent Your Message, We would get back to you immediately</div>');
					 redirect(base_url().'page/contact');
               
                
            
        
		}
    }
		
		
		public function career()
        {
			
        $data['title'] = 'Career | Crystalinks Investment and Services';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('careers', $data);
        $this->load->view('templates/footer');
        }
		
		public function travel()
        {
			
        $data['title'] = 'Travel and Tours | Crystalinks Investment and Services';
		$this->load->view('templates/header', $data);
       	$this->load->view('templates/nav');
		
		$this->load->view('travel-and-tours', $data);
        $this->load->view('templates/footer');
        }


      
}