<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_kelas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_rekap_kelas', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/rekap_kelas/index',
            'index_js' => 'admin/rekap_kelas/index_js',
            'title' => 'Rekap Kelas',
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

        $data['ref_jenis'] = $this->db->query("SELECT * from ref_jenis where deleted is null order by id asc")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data = [];
        $html = $this->load->view('admin/rekap_kelas/form', $data, true);

        json([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from informasi where id='$id' and deleted is null ")->row();
        $html = $this->load->view('admin/rekap_kelas/form', $data, true);

        json([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_submit()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $hapus = $this->input->post('hapus');

        $judul = $this->input->post('judul');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $keterangan = $this->input->post('keterangan');

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('informasi', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('informasi', [
                    'judul' => $judul,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('informasi', [
                    'judul' => $judul,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        json([
            'status' => 'success'
        ]);
    }
}
