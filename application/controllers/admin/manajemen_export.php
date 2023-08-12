<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_export extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'admin/manajemen_export/index',
            'index_js' => 'admin/manajemen_export/index_js',
            'title' => 'Manajemen Export',
        ];

        $where = '';
        if ($this->type == 'walkas') $where .= "AND a.id='$this->id_kelas'";

        $data['list_kelas'] = $this->db->query("SELECT
            a.id, a.nama, b.nama AS nm_tingkat
        FROM
            ref_kelas a
            LEFT JOIN ref_tingkat b ON b.id = a.id_kelas
        WHERE 1=1 $where
        ORDER BY
            a.id
        ")->result();

        $data['list_periode'] = $this->db->query("SELECT * from ref_periode")->result();
        $data['ref_tahun'] = $this->db->query("SELECT * from ref_tahun order by tahun asc")->result();

        $this->templates->load($data);
    }

}

/* End of file Dashboard.php */
