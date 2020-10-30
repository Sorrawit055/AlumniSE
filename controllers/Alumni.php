<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alumni extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Alumni_model');
	}
	public function index()
	{
		$this->load->view('index');
	}
	public function login()
	{
		$this->load->view('login');
	}
	public function find()
	{
		$result['user'] = $this->Alumni_model->showAlumni();
		$this->load->view('find', $result);
	}

	public function information()
	{
		$result['user'] = $this->Alumni_model->showDataAlumni();
		$this->load->view('listinfo', $result);
	}

	public function profile()
	{
		$result['user'] = $this->Alumni_model->showDataAlumni();
		$this->load->view('profile', $result);
	}

	public function search()
	{
		$data = $this->input->post('searchalumni');
		$result['user'] = $this->Alumni_model->SearchUsers($data);
		$this->load->view('search', $result);
	}
	public function reg(){
		$this->load->view('register');
	}
		public function registeruser()
		{
			$config['upload_path'] = './public/upload/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 2000;
			$config['max_width'] = 1500;
			$config['max_height'] = 1500;
	
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('fileupload')) {
			} else {
				$data1 = $this->upload->data();
				$filename = $data1['file_name'];
				$data1 = array(
					's_fname' => $this->input->post("s_fname"),
					's_lname' => $this->input->post("s_lname"),
					's_title' => $this->input->post("s_title"),
					's_gender' => $this->input->post("s_gender"),
					's_phone' => $this->input->post("s_phone"),
					's_nickname' => $this->input->post("s_nickname"),
					's_facebook' => $this->input->post("s_facebook"),
					's_email' => $this->input->post("s_email"),
					's_password' => $this->input->post("s_password"),
					's_repassword' => $this->input->post("s_repassword"),
					's_bday' => $this->input->post("s_bday"),
					'address1' => $this->input->post("address1"),
					'address2' => $this->input->post("address2"),
					'address3' => $this->input->post("address3"),
					'address4' => $this->input->post("address4"),
					'address5' => $this->input->post("address5"),
					's_generation' => $this->input->post("s_generation"),
					's_address' => $this->input->post("s_address"),
					's_position' => $this->input->post("s_position"),
					's_year' => $this->input->post("s_year"),
					's_class' => $this->input->post("s_class"),
					'fileupload' => $filename
				);
				if ($data1) {
					$this->Alumni_model->insert($data1);
					redirect('alumni/login', 'refresh');
				} else {
					echo '<script> alert("เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง !!") </script>';
				}
			}
		}
		public function formlogin()
	{
		$s_email = $this->input->post('s_email');
		$s_password = ($this->input->post('s_password'));
		$this->db->select('*');
		$this->db->from('register');
		$this->db->where(array('s_email' => $s_email, 's_password' => $s_password));
		$query = $this->db->get();

		$user = $query->row();

		if ($user->s_email) {
			$this->session->set_flashdata("เข้าสู่ระบบสำเร็จ");
			$_SESSION['s_id'] = $user->s_id;
			$_SESSION['s_password'] = $user->s_password;
			redirect("alumni/index", "refresh");
		} else {
			$this->session->set_flashdata("error");
			redirect("alumni/login", "refresh");
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('alumni/login', 'refresh');
	}
	public function Update()
	{
		$data1 = array(
			's_fname' => $this->input->post("s_fname"),
			's_lname' => $this->input->post("s_lname"),
			's_title' => $this->input->post("s_title"),
			's_gender' => $this->input->post("s_gender"),
			's_phone' => $this->input->post("s_phone"),
			's_nickname' => $this->input->post("s_nickname"),
			's_facebook' => $this->input->post("s_facebook"),
			's_bday' => $this->input->post("s_bday"),
			'address1' => $this->input->post("address1"),
			'address2' => $this->input->post("address2"),
			'address3' => $this->input->post("address3"),
			'address4' => $this->input->post("address4"),
			'address5' => $this->input->post("address5"),
			's_generation' => $this->input->post("s_generation"),
			's_address' => $this->input->post("s_address"),
			's_position' => $this->input->post("s_position"),
			's_year' => $this->input->post("s_year"),
			's_class' => $this->input->post("s_class")

		);
		$this->Alumni_model->edit($data1);
		if ($_FILES['fileupload']['name'] != "") {
			$config['upload_path'] = './public/upload/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 2000;
			$config['max_width'] = 1500;
			$config['max_height'] = 1500;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('fileupload')) {

				$data2 = $this->upload->data();
				$filename = $data2['file_name'];

				$data2 = array(
					'fileupload' => $filename
				);

				$this->Alumni_model->editimg($data2);

				if ($data4) {
					redirect('alumni/find', 'refresh');
				} else {
					echo '<script> alert("อัพเดตไม่ได้ โปรดลองอีกครั้ง") </script>';
					redirect('alumni/profile', 'refresh');
				}
			}
		} else {
			redirect('alumni/find', 'refresh');
		}
	}
}
