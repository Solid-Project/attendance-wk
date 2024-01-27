<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

class Absensi extends RestController {
	function __construct()
    {
        parent::__construct();
        $this->load->model('M_absensi');
        $this->load->model('M_siswa');
    }

	public function index_get()
    {
        try {
            
                $this->response( [
                    'status'    => true,
                    'result'    => [],
                    'total'     => 0,
                    'message'   => 'ON GOING...'
                ], 200 );
        } catch (Exception $th) {
            $this->response( [
                    'status'    => true,
                    'result'    => [],
                    'total'     => 0,
                    'message'   => $th->getMessage()
                ], 200 );
        }
    }

	public function index_post()
    {
        try{
            date_default_timezone_set('asia/jakarta');
            $data = $this->post();

            if (count($data) > 0){
                $getSiswa = $this->M_siswa->select('', ['token' => $data['token']]);
                if ($getSiswa->num_rows() == 0)
                    throw new Exception("Data siswa tidak ditemukan", 1);

                else{
                    $getSiswa = $getSiswa->row();
                    $cekData = $this->M_absensi->select('', ['id_siswa' => $getSiswa->id, 'date(tanggal)' => date('Y-m-d')]);
                    $i = 0;
                    if ($cekData->num_rows() == 0){
                            $insertData = array(
                                'id_siswa'      => @$getSiswa->id,
                                'tanggal'   => date('Y-m-d H:i:s'),
                            );

                        $saving = $this->M_absensi->save($insertData);

                        if ($saving){
                            $this->response( [
                                'status'        => true,
                                'Total'         => $i,
                                'message'       => 'Absensi berhasil.'
                            ], 200 );
                        }else{
                            $this->response( [
                                'status'        => false,
                                'ModulID'       => null,
                                'message'       => 'Simpan data gagal.'
                            ], 200 );
                        }
                    }else{
                        throw new Exception("Data sudah terdaftar", 1);

                    }
                }
            }else{
                $this->response( [
                    'status' => false,
                    'message' => 'Form harus diisi.'
                ], 200 );
            }
        }catch (Exception $th){
            $this->response( [
                    'status'    => true,
                    'result'    => [],
                    'total'     => 0,
                    'message'   => $th->getMessage()
                ], 200 );
        }
		
    }

}