<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Instrumen extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'siswa/instrumen/index',
            'index_js' => 'siswa/instrumen/index_js',
            'title' => 'Form - ' . tgl_indo(date('Y-m-d')),
        ];

        $tanggal = date('Y-m-d');

        $data['cek'] = $this->db->query("SELECT * from jawab_instrumen where 
            id_user='$this->id_akun' and id_tingkat='$this->id_tingkat' 
            and id_kelas='$this->id_kelas' and tanggal='$tanggal' 
        ")->row();

        if (empty($data['cek'])) {
            $data['instrumen'] = $this->db->query("SELECT * from instrumen where id_tingkat='$this->id_tingkat' and deleted is null order by id_jenis asc")->result();
        } else {
            $data['instrumen'] = $this->db->query("SELECT
                a.*, case when nilai='1' then 'YA' when nilai='2' then 'TIDAK' end as nilai
            FROM
                instrumen a
                left join (select * from jawab_instrumen where id_user='$this->id_akun' and id_tingkat='$this->id_tingkat' and id_kelas='$this->id_kelas' and tanggal='$tanggal' and deleted is null) b on b.id_instrumen=a.id
            WHERE
                a.id_tingkat = '$this->id_tingkat' 
                AND a.deleted IS NULL 
            ORDER BY
                a.id_jenis ASC
            ")->result();
        }

        $this->templates->load($data);
    }

    public function do_submit()
    {
        $tanggal = date('Y-m-d');
        $jawaban = $this->input->post('jawaban');

        $arr = [];
        foreach ($jawaban as $dt) {
            $arr[] = [
                'nilai' => $dt['nilai'],
                'id_instrumen' => decode_id($dt['id_instrumen']),
                'id_user' => $this->id_akun,
                'id_tingkat' => $this->id_tingkat,
                'id_kelas' => $this->id_kelas,
                'tanggal' => $tanggal,
                'created' => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($arr)) $this->db->insert_batch('jawab_instrumen', $arr);

        json([
            'status' => 'success',
            'msg' => 'data berhasil disimpan',
        ]);
    }
}

/* End of file Dashboard.php */
