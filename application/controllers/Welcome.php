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

	public function register()
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name','trim|required');
			$this->form_validation->set_rules('email', 'Email','trim|required');
			$this->form_validation->set_rules('password', 'Password','trim|required');

			if ($this->form_validation->run() == 'TRUE')
     		{
				$user_fname = $this->input->post('first_name');
				$user_lname = $this->input->post('last_name');
				$user_email = $this->input->post('email');
				$user_password = $this->input->post('password');

				$emailData = $this->CM->getRowData('tb_users',array('user_email'=>$user_email));
				if($emailData)
				{
					$this->session->set_flashdata('error_msg', 'Email already exist');
					redirect('register');
				}
				else
				{
					$user_id = uniqid();
					$inserArray = array(
					 	'user_uid'=> $user_id,
					 	'user_fname'=>$user_fname,
					 	'user_lname'=>$user_lname,
					 	'user_email'=>$user_email,
					 	'user_password'=>$user_password,
					 	'user_encrypted'=>md5($user_password)
				 	);
					
	 
					$message ='<!DOCTYPE html>
						<html lang="en">
						<body>
						  <main>
						    <div class="container">
						      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
						        <div class="container">
						          <div class="row justify-content-center">
						            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
						              <div class="card mb-3">
						                <div class="card-body">
						                  <div class="pt-4 pb-2">
						                    <h5 class="card-title text-center pb-0 fs-4" style="padding: 20px 0 15px 0; font-size: 18px; font-weight: 500; color: #008080; font-family: "Poppins", sans-serif;">Welcome To PUMA Database</h5>
						                    <p class="text-center small">Thanks for signingup! We just need to verify your account. Please click the link below to verify your account <br></p>
						                    <p><a href="'.base_url().'user/verify/'.$user_id.'">Verify My Account</a></p>
						                    <p>For any technical issue, please reach out - neelam.rathore@crystallise.com</p>
						                    <br>
						                    <br><br><br>
						                    <p>Thank You</p>
						                    <p>PUMA Team</p>
						                  </div>
						                </div>
						              </div>
						              </div>
						            </div>
						          </div>
						        </div>
						      </section>
						    </div>
						  </main>
						</body>
						</html>';
					$config = array(
                        
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => TRUE
                    );

        			$this->load->view('emailTemplate');
         			$this->load->library('email',$config);
		 			$this->email->from('webmaster@crystallise.com');
					$this->email->to($user_email);
					$this->email->subject('PUMA Databse Email Verification');
					$this->email->message($message);
				    
				    if($this->email->send()){
				    	echo 'email sent';
				    }
				    else{
				    	print_r($this->email->print_debugger());
		 			}
		 
		            $insertId = $this->CM->insertData('tb_users',$inserArray);
		            $this->session->set_flashdata('success_msg', 'Signup Successfully, please verify your email.');
		            redirect('login');
		        }
	        } 
		}
		else
		{
			$this->load->view('register');
		}	
	}

    public function testEmail()
    {
        $user_id ="1";
        $user_email = "neelam.rathore@crystallise.com";
        $message ='<!DOCTYPE html>
						<html lang="en">
						<body>
						  <main>
						    <div class="container">
						      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
						        <div class="container">
						          <div class="row justify-content-center">
						            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
						              <div class="card mb-3">
						                <div class="card-body">
						                  <div class="pt-4 pb-2">
						                    <h5 class="card-title text-center pb-0 fs-4" style="padding: 20px 0 15px 0; font-size: 18px; font-weight: 500; color: #008080; font-family: "Poppins", sans-serif;">Welcome To PUMA Database</h5>
						                    <p class="text-center small">Thanks for signingup! We just need to verify your account. Please click the link below to verify your account <br></p>
						                    <p><a href="'.base_url().'user/verify/'.$user_id.'">Verify My Account</a></p>
						                    <p>For any technical issue, please reach out - neelam.rathore@crystallise.com</p>
						                    <br>
						                    <br><br><br>
						                    <p>Thank You</p>
						                    <p>PUMA Team</p>
						                  </div>
						                </div>
						              </div>
						              </div>
						            </div>
						          </div>
						        </div>
						      </section>
						    </div>
						  </main>
						</body>
						</html>';
					$config = array(
                        
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => TRUE
                    );

        			$this->load->view('emailTemplate');
         			$this->load->library('email',$config);
		 			$this->email->from('webmaster@crystallise.com');
					$this->email->to($user_email);
					$this->email->subject('PUMA Databse Email Verification');
					$this->email->message($message);
				    
				    if($this->email->send()){
				    	echo 'email sent';
				    }
				    else{
				    	print_r($this->email->print_debugger());
		 			}
		 
    }
	public function verifyAccount($user_id)
	{
		if($this->input->post('resend_verify'))
		{
			echo 'test';
			$emailData =  $this->db->get_where("tb_users",array('user_uid'=>$user_id))->row();#
			$user_email = $emailData->user_email;
			
			$message ='<!DOCTYPE html>
						<html lang="en">
						<body>
						  <main>
						    <div class="container">
						      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
						        <div class="container">
						          <div class="row justify-content-center">
						            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
						              <div class="card mb-3">
						                <div class="card-body">
						                  <div class="pt-4 pb-2">
						                    <h5 class="card-title text-center pb-0 fs-4" style="padding: 20px 0 15px 0; font-size: 18px; font-weight: 500; color: #008080; font-family: "Poppins", sans-serif;">Welcome To PUMA Database</h5>
						                    <p class="text-center small">Thanks for signingup! We just need to verify your account. Please click the link below to verify your account <br></p>
						                    <p><a href="'.base_url().'user/verify/'.$user_id.'">Verify My Account</a></p>
						                    <p>For any technical issue, please reach out - neelam.rathore@crystallise.com</p>
						                    <br>
						                    <br><br><br>
						                    <p>Thank You</p>
						                    <p>PUMA Team</p>
						                  </div>
						                </div>
						              </div>
						              </div>
						            </div>
						          </div>
						        </div>
						      </section>
						    </div>
						  </main>
						</body>
						</html>';
						$config = array(
                        
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => TRUE
                    );

			$this->load->view('emailTemplate');
 			$this->load->library('email',$config);
 			$this->email->from('webmaster@crystallise.com');
			$this->email->to($user_email);
			$this->email->subject('PUMA Databse Email Verification');
			$this->email->message($message);
		    
		    if($this->email->send()){
		    	echo 'email sent';
		    }
		    else{
		    	print_r($this->email->print_debugger());
 			}
 			$this->session->set_flashdata('success_msg', 'Email sent!Please verify your email.');
			$data['user_id'] = $user_id;
			$this->load->view('verify',$data);
		}
		else
		{	
			$emailData =  $this->db->get_where("tb_users",array('user_uid'=>$user_id))->row();
			if($emailData)
			{
				date_default_timezone_set("Europe/London");
				$datetime_curr = date('Y-m-d h:i:s');
				$datetime_created = $emailData->created_datetime;
				$seconds = strtotime($datetime_curr) - strtotime($datetime_created);
				$days    = floor($seconds / 86400); 
				$hours   = floor(($seconds - ($days * 86400)) / 3600);
				// echo $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);echo '<br>';
				// echo $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));echo '<br>';
				if($hours<=24)
				{
					$update_data = array('email_authentication'=>'true');
					$where = array('user_uid'=>$user_id);
					$this->session->set_flashdata('success_msg', 'Your account verified!');
					$this->CM->updateData('tb_users',$update_data,$where);
					redirect('login');
				}
				else
				{
				    $this->session->set_flashdata('error_msg', 'Your session expired!');
					$data['user_id'] = $user_id;
					$this->load->view('verify',$data);
				}
			}
		}
	}

	public function emailTemplate()
	{
		$this->load->view('emailTemplate');
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
     			
				if($login_result && ($login_result->email_authentication == 'false'))
				{
					$this->session->set_flashdata('error_msg', 'Please verify your email');
					redirect('login');
				}
				else
				{
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
						$this->session->set_flashdata('error_msg', 'Please check your Email/Password');
						redirect('login');
					}
				}	
			}
		}
		$this->load->view('login');
	}

	public function logout()
    {
    	$this->session->set_userdata('login_data','');
    	redirect(site_url());
    }
}
