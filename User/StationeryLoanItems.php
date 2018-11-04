<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StationeryLoanitems extends CI_Controller
{

	public function index()
	{
		$this->session->set_userdata('usercurrentmenu', 'StationeryLoanitems');
		$this->load->model('User/StationeryLoanitemsModel');
		$result = $this->StationeryLoanitemsModel->GetAll($this->session->userdata('StaffLoggedIn')->UID);
		$data['ShowMsg'] = false;
		$data['Isvalid'] = true;
		$data['msg'] = '';
		$data['dataList'] = $result;
		$this->load->view('User/StationeryLoanitems', $data);
	}
	public function addStationeryLoanItems()
	{

		$this->load->model('User/StationeryLoanitemsModel');
		$result = $this->StationeryLoanitemsModel->GetAll($this->session->userdata('StaffLoggedIn')->UID);
		$data['dataList'] = $result;

		$this->form_validation->set_rules('Staff_Name', 'Staff Name', 'trim|required');
		$this->form_validation->set_rules('Position', 'Position', 'trim|required');
		$this->form_validation->set_rules('Date', 'Date', 'trim|required');
		$this->form_validation->set_rules('Item', 'Item', 'trim|required');
		$this->form_validation->set_rules('Quantity', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('Purpose', 'Purpose', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if ($this->form_validation->run() == false) {
			$data['ShowMsg'] = false;
			$data['Isvalid'] = true;
			$data['msg'] = '';
			$this->load->view('User/StationeryLoanitems', $data);
		} else {
			$data['ShowMsg'] = true;
			$add_data = array(
				'UserName' => $this->input->post('Staff_Name'),
				'Position' => $this->input->post('Position'),
				'Date' => $this->input->post('Date'),
				'ItemName' => $this->input->post('Item'),
				'ItemQuantity' => $this->input->post('Quantity'),
				'Purpose' => $this->input->post('Purpose'),
				'UID' => $this->session->userdata('StaffLoggedIn')->UID
			);
			$result1 = $this->StationeryLoanitemsModel->Add($add_data);
			if ($result1) {
				$result2 = $this->StationeryLoanitemsModel->GetAll($this->session->userdata('StaffLoggedIn')->UID);
				$data['dataList'] = $result2;
				$data['Isvalid'] = true;
				$data['msg'] = 'Stationery Loan Items request sent successfully!';
				$this->load->view('User/StationeryLoanitems', $data);
			} else {
				$data['Isvalid'] = false;
				$data['msg'] = 'Error:Stationery Loan Items request not send.';
				$this->load->view('User/StationeryLoanitems', $data);
			}
		}
	}
}