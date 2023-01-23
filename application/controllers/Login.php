<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
public function __construct()
{
	parent::__construct();
	$this->load->model('Common_model', 'CM', TRUE);
	$sess = $this->session->userdata('admin_type');
	// if ($sess == 'master')
	// 	{
	// 	redirect('dashboard');
	// 	}
}
public function index()
{
	echo 'test';
	$data['title'] = 'home';
	$this->load->view('forms-layouts',$data);
}
public function adminAuth()
{
	//echo $this->encryption->encrypt('1234');

	if ($this->input->post())
		{
		$this->form_validation->set_rules('admin_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('admin_password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE)
			{
				
			$post = $this->input->post();
			$clean = $this->security->xss_clean($post);
			$check = $this->CM->userAuthentication($clean);
			if ($check != 'success')
				{
				$this->session->set_flashdata('msg', array(
					'message' => "$check",
					'class' => 'alert alert-warning'
				));
				redirect('signIn');
				}
			  else
			  	{
			  		
				
					if ($this->session->userdata('admin_type') == 'master')
					{
						redirect('dashboard');
					}
					elseif ($this->session->userdata('admin_type') == 'admin')
					{
						redirect('admin/dashboard');
					}
					elseif ($this->session->userdata('admin_type') == 'sales_person')
					{
						redirect('sales/dashboard');
					}
				}
			}
		  else
			{
			$this->load->view('sign-in');
			}
		}
	  else
		{
		$this->load->view('sign-in');
		}				
	}	
}