<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_siswa extends CI_Model {

	public function select($select = '', $where = '', $searchLike = '', $limit = '', $offset = ''){
		if ($select != ''){
			$this->db->select($select);
		}
		if ($where != ''){
			$this->db->where($where);
		}
		if ($searchLike != ''){
			$this->db->like('PhoneNumber', $searchLike);
			$this->db->or_like('Merchant', $searchLike);
			$this->db->or_like('RefID', $searchLike);
		}
		if ($limit != '' && $offset != ''){
			$this->db->limit($limit, $offset);
		}


					$this->db->from('siswa');
		$response = $this->db->get();
		return $response;
	}

	public function save($data){
		$response = $this->db->insert('siswa', $data);
		return $response;
	}

	public function update($data, $where){
		$response = $this->db->update('siswa', $data, $where);
		return $response;
	}

	public function delete($arr){
		return $this->db->delete('siswa', $arr);
	}
}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */