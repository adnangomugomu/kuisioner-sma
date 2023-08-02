<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'siswa/dashboard/index',
            'index_js' => 'siswa/dashboard/index_js',
            'title' => 'Dashboard',
        ];

        $data['row'] = $this->db->query("SELECT 
            a.*, 
            b.nama as nama_prov, c.nama as nama_kab, d.nama as nama_kec, e.nama as nama_kel,
            f.nama as nm_tingkat, g.nama as nm_kelas
            from data_user a 
            left join ref_provinsi b on b.kode_wilayah=a.kode_prov
            left join ref_kabupaten c on c.kode_wilayah=a.kode_kab
            left join ref_kecamatan d on d.kode_wilayah=a.kode_kec
            left join ref_kelurahan e on e.kode_wilayah=a.kode_kel
            left join ref_tingkat f on f.id=a.id_tingkat
            left join ref_kelas g on g.id=a.id_kelas
            where a.id='$this->id_akun'
        ")->row();

        $this->templates->load($data);
    }

    public function session()
    {
        session();
    }
}

/* End of file Dashboard.php */
