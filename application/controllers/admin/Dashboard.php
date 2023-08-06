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

        $tanggal  = date('Y-m-d');

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

        $data['rekap'] = $this->db->query("SELECT
            a.nama,
            b.nama AS nm_tingkat,
            c.total_siswa,
            case when d.total_isi is null then 0 else d.total_isi end as total_isi
        FROM
            ref_kelas a
            LEFT JOIN ref_tingkat b ON b.id = a.id_kelas
            LEFT JOIN ( SELECT id_kelas, count( 1 ) AS total_siswa FROM data_user WHERE deleted IS NULL AND id_otoritas = 3 GROUP BY id_kelas ) c ON c.id_kelas = a.id 
            left join (select id_kelas, id_tingkat, count(DISTINCT id_user) as total_isi from jawab_instrumen where tanggal='$tanggal' group by id_kelas, id_tingkat ) d on d.id_kelas=a.id and d.id_tingkat=b.id
        ORDER BY
            a.id
        ")->result();

        $this->templates->load($data);
    }

    public function session()
    {
        session();
    }
}

/* End of file Dashboard.php */
