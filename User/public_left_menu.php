<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PublicLeftMenu extends CI_Controller
{

	public function index()
	{
		$this->load->view('User/Dashboard');
	}
}