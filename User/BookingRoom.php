<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BookingRoom extends CI_Controller
{

	public function index()
	{
		$this->session->set_userdata('usercurrentmenu', 'BookingRoom');
		$this->load->model('User/BookingRoomModel');
		$result = $this->BookingRoomModel->GetAll($this->session->userdata('StaffLoggedIn')->UID);
		$data['ShowMsg'] = false;
		$data['Isvalid'] = true;
		$data['msg'] = '';
		$data['dataList'] = $result;
		$this->load->view('User/BookingRoom', $data);
	}
	public function deleteRoomBooking()
	{
		$rbid = $this->input->post('RBID');
		$this->load->model('User/BookingRoomModel');
		$result1 = $this->BookingRoomModel->Cancelled($rbid);
		$result = $this->BookingRoomModel->GetAll($this->session->userdata('StaffLoggedIn')->UID);
		$data['ShowMsg'] = false;
		$data['Isvalid'] = true;
		$data['msg'] = '';
		$data['dataList'] = $result;
		$this->load->view('User/BookingRoom', $data);
	}
	public function addBookingRoom()
	{
		$this->load->model('User/BookingRoomModel');
		$result = $this->BookingRoomModel->GetAll($this->session->userdata('StaffLoggedIn')->UID);
		$data['dataList'] = $result;
		$this->form_validation->set_rules('RoomNumber', 'Room Number', 'trim|required');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('StartTime', 'Start Time', 'trim|required');
		$this->form_validation->set_rules('EndTime', 'End Time', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		if ($this->form_validation->run() == false) {
			$data['ShowMsg'] = false;
			$data['Isvalid'] = true;
			$data['msg'] = '';
			$this->load->view('User/BookingRoom', $data);
		} else {
			$data['ShowMsg'] = true;
			$adddata = array(
				'RoomNumber' => $this->input->post('RoomNumber'),
				'BookingDate' => $this->input->post('date'),
				'BookedStartTime' => $this->input->post('StartTime'),
				'BookedEndTime' => $this->input->post('EndTime'),
				'BookingStatus' => 'Waiting',
				'UID' => $this->session->userdata('StaffLoggedIn')->UID
			);
			$addresult = $this->BookingRoomModel->Add($adddata);
			if ($addresult) {
				$result = $this->BookingRoomModel->GetAll($this->session->userdata('StaffLoggedIn')->UID);
				$data['dataList'] = $result;
				$data['Isvalid'] = true;
				$data['msg'] = 'Room booking request sent successfully!';
				$this->load->view('User/BookingRoom', $data);
			} else {
				$data['Isvalid'] = false;
				$data['msg'] = 'Error:Room booking request not send.';
				$this->load->view('User/BookingRoom', $data);
			}
		}
	}
}