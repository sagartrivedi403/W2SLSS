<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function index()
	{
		$this->session->set_userdata('admincurrentmenu', 'Dashboard');
		$this->load->model('ServiveRequestModel');
		$data['GetAll'] = $this->ServiveRequestModel->GetAll();
		$this->load->view('Admin/Dashboard', $data);
	}
}