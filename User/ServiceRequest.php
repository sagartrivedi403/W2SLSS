<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ServiceRequest extends CI_Controller
{

    public function index()
    {
        $this->session->set_userdata('usercurrentmenu', 'ServiceRequest');
        $this->load->view('User/ServiceRequest');
    }
    public function addServiceRequest()
    {

        $this->form_validation->set_rules('WhitireiaID', 'WhitireiaID', 'trim|required');
        $this->form_validation->set_rules('contectpore', 'Contact Phone No. or Email', 'trim|required');
        $this->form_validation->set_rules('firstname', 'First name', 'trim|required');
        $this->form_validation->set_rules('Surname', 'Surname', 'trim|required');
        $this->form_validation->set_rules('ProgrammeName', 'Programme Name', 'trim|required');
        $this->form_validation->set_rules('CourseName', 'Course Name', 'trim|required');
        $this->form_validation->set_rules('Date', 'Date', 'trim|required');
        $this->form_validation->set_rules('Time', 'Time', 'trim|required');
        $this->form_validation->set_rules('StaffName', 'Staff Name', 'trim|required');
        $this->form_validation->set_rules('Dateinf', 'Date', 'trim|required');
        $this->form_validation->set_rules('Timeinf', 'Time', 'trim|required');
        $this->form_validation->set_rules('Assignmentdetails', 'Assignment details', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run() == false) {
            $this->load->view('User/ServiceRequest');
        } else {

            $Enquiry_type = $this->input->post('etInPerson');
            $Distance_Learner_Tutor = $this->input->post('dltYes');
            $Used_sources = $this->input->post('usLibraryWebsite');
            $Time_taken = $this->input->post('tt10min');


            $data = array(
                'WID' => $this->input->post('WhitireiaID'),
                'Phone' => $this->input->post('contectpore'),
                'Fname' => $this->input->post('firstname'),
                'Sname' => $this->input->post('Surname'),
                'Prgname' => $this->input->post('ProgrammeName'),
                'Crsname' => $this->input->post('CourseName'),
                'Date' => $this->input->post('Date'),
                'Time' => $this->input->post('Time'),
                'Staff_name' => $this->input->post('StaffName'),
                'Date_NeededBy' => $this->input->post('Dateinf'),
                'Time_NeededBy' => $this->input->post('Timeinf'),
                'Assignment_details' => $this->input->post('Assignmentdetails'),
                'Enquiry_type' => $Enquiry_type,
                'Distance_Learner_Tutor' => $Distance_Learner_Tutor,
                'Used_sources' => $Used_sources,
                'Time_taken' => $Time_taken
            );

            $this->load->model('ServiveRequestModel');
            $result = $this->ServiveRequestModel->Add($data);
            if ($result) {
                $this->load->view('User/ServiceRequest');
                echo "<script>alert('Service Request sent successfully!');</script>";
            } else {
                $this->load->view('User/ServiceRequest');
                echo "<script>alert('Error:Service Request not send.');</script>";
            }
        }
    }
}