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
            'index' => 'admin/dashboard/index',
            'index_js' => 'admin/dashboard/index_js',
            'title' => 'Dashboard',
        ];

        $data['row'] = $this->db->query("SELECT 
            a.*, 
            b.nama as nama_prov, c.nama as nama_kab, d.nama as nama_kec, e.nama as nama_kel
            from data_user a 
            left join ref_provinsi b on b.kode_wilayah=a.kode_prov
            left join ref_kabupaten c on c.kode_wilayah=a.kode_kab
            left join ref_kecamatan d on d.kode_wilayah=a.kode_kec
            left join ref_kelurahan e on e.kode_wilayah=a.kode_kel
            where a.id='$this->id_akun'
        ")->row();

        $data['rekap'] = $this->db->query("SELECT a.nama, b.nama as nm_tingkat,
            c.total_siswa
            from ref_kelas a 
            left join ref_tingkat b on b.id=a.id_kelas
            left join (select id_kelas, count(1) as total_siswa from data_user where deleted is null and id_otoritas=3 group by id_kelas) c on c.id_kelas=a.id
            order by a.id
        ")->result();

        $this->templates->load($data);
    }

    public function session()
    {
        session();
    }
}

/* End of file Dashboard.php */
