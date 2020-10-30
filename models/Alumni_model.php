<?php defined('BASEPATH') or exit('No direct script access allowed');
class Alumni_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Alumni_model');
	}
	function showAlumni()
	{
		$result = $this->db->get('register');
		return $result;
	}
	function showDataAlumni()
	{
		$id = $_GET['id'];
		$this->db->select('*');
		$this->db->from('register');
		$this->db->where(array('s_id' => $id));

		$result = $this->db->get();
		return $result;
	}
	function Alumniw($data){
		$this->db->insert('register',$data);
	}
	function SearchUsers($data)
	{
		$this->db->select('*');
		$this->db->from('register');
		$this->db->like('s_id', $data, 'both');
		$this->db->or_like('s_fname', $data, 'both');
		$this->db->or_like('s_lname', $data, 'both');
		$this->db->or_like('s_email', $data, 'both');
		$this->db->or_like('address4', $data, 'both');
		$this->db->or_like('s_year', $data, 'both');
		$this->db->or_like('s_class', $data, 'both');
		$this->db->or_like('s_phone', $data, 'both');

		$result = $this->db->get();
		return $result;
	}
	function Login()
	{
		$this->db->select('s_email, s_password');
		$result = $this->db->get('register');
		return $result;
	}

	// เพิ่มศิษเก่าเข้า database
	function insert($data1)
	{
		$this->db->insert('register', $data1);
	}

	function edit($data1)
	{
		$id = $_SESSION['s_id'];
		$this->db->where('s_id', $id);
		$this->db->update('register', $data1);
	}
	function editimg($data2)
	{
		$id = $_SESSION['s_id'];
		$this->db->where('s_id', $id);
		$this->db->update('register', $data4);
	}



}
