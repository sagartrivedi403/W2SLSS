<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function index()
	{
		$data['IsValid'] = true;
		$data['msg'] = '';
		$this->load->view('Admin/login', $data);
	}

	public function adminLogin()
	{
		$this->form_validation->set_rules('Username', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');


		if ($this->form_validation->run() == false) {
			$this->load->view('Admin/login');
		} else {
			$username = $this->input->post('Username');
			$password = $this->input->post('password');
			$this->load->model('Authentication');
			$login_data = $this->Authentication->AdminLogin($username, $password);
			if ($login_data) {
				if ($login_data->IsActive == 1) {
					$remember = $this->input->post('remember-me');
					if ($remember == '1') {
						$sess_data = array(
							'IsRemember' => '1',
							'Username' => $username,
							'Password' => $password
						);
						$this->session->set_userdata('AdminRememberMe', $sess_data);
					} else {
						$sess_data = array(
							'IsRemember' => '0',
							'Username' => '',
							'Password' => ''
						);
						$this->session->set_userdata('AdminRememberMe', $sess_data);
					}
					$this->session->set_userdata('AdminLoggedIn', $login_data);
					return redirect('Admin/Dashboard');
				} else {
					$data['IsValid'] = false;
					$data['msg'] = 'Your Account is Locked!, Please contact Admin.';
					$this->load->view('Admin/login', $data);
				}
			} else {
				$data['IsValid'] = false;
				$data['msg'] = 'Invalid Username or Password. Enter a valid Username and Password.';
				$this->load->view('Admin/login');
			}
		}

	}
}