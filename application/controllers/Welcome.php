<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	

	function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		// $this->load->library('encrypt');
		$this->load->model('Common_model','CM');
    }

	

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function login()
	{
		if($this->input->post()){
			$email = $this->input->post('email');
			// $password = $this->input->post('password');
			$password = md5($this->input->post('password'));		
			
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('email', 'Email','trim|required');
			
			if ($this->form_validation->run() == 'TRUE')
     		{
     			$login_result = $this->db->get_where("tb_users",array('user_email'=>$email))->row();
     			
				if($login_result && md5($login_result->user_password) == $password)
				{
					$user_email = $login_result->user_email;
					$user_uid = $login_result->user_uid;					
					$email = $login_result->user_email;						
					$user_id = $login_result->user_id;
					$sess_data = array(
						'user_email'=>$user_email,						
						'user_uid'=>$user_uid,						
						'user_id' => $user_id,
						'user_fname'=> $login_result->user_fname,
						'user_lname'=> $login_result->user_lname						
						);
					
					$_SESSION['email'] = $user_email;
					$this->session->set_userdata('login_data',$sess_data);
					$this->session->set_flashdata('success','Login Successfuly.');
					redirect('dashboard');
				}
				else
				{
					$this->session->set_flashdata('error','Please check Email or Password.');
					redirect('login');
				}
			}
			// echo 'fail';
			// die;
		}
		$this->load->view('login');
	}

	public function logout()
    {
    	$this->session->set_userdata('login_data','');
    	redirect(site_url());
    }
}
