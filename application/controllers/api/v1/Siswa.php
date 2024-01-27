<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Siswa extends RestController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_siswa');
		$this->load->helper('string');
	}

	public function index_get()
	{
		try {
			$getAllSiswa = $this->M_siswa->select();

			$this->response([
				'status'    => true,
				'result'    => $getAllSiswa->result(),
				'total'     => $getAllSiswa->num_rows(),
				'message'   => 'ON GOING...'
			], 200);
		} catch (Exception $th) {
			$this->response([
				'status'    => true,
				'result'    => [],
				'total'     => 0,
				'message'   => $th->getMessage()
			], 200);
		}
	}

	public function index_post()
	{
		try {
			date_default_timezone_set('asia/jakarta');
			$data = $this->post();

			if (count($data) > 1) {
				$token = sha1(base64_encode($data['nama']));

				$newStudent = array(
					'nama' => $data['nama'],
					'kelas' => $data['kelas'],
					'token' => $token
				);

				$saving = $this->M_siswa->save($newStudent);

				if ($saving) {
					return $this->response([
						'status'        => true,
						'message'       => 'Tambah siswa berhasil..'
					]);
				}

				return $this->response([
					'status' => false,
					'ModulID'       => null,
					'message'       => 'Tambah siswa gagal.'
				]);
			}
		} catch (Exception $th) {
			return $this->response([
				'status'    => true,
				'result'    => [],
				'total'     => 0,
				'message'   => $th->getMessage()
			], 200);
		}
	}

	public function index_put()
	{
		try {
			$data = $this->put();

			if (count($data) > 1) {
				$updateStudent = $this->M_siswa->update($data, ['id' => $data['id']]);

				if (!$updateStudent) {
					return $this->response([
						'status' => false,
						'message' => 'Gagal merubah data siswa'
					]);
				}

				return $this->response([
					'status' => true,
					'message' => 'Berhasil merubah data siswa'
				]);
			}
		} catch (Exception $th) {
			return $this->response([
				'status'    => true,
				'result'    => [],
				'total'     => 0,
				'message'   => $th->getMessage()
			], 200);
		}
	}
}
