<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ref_instrumen extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_ref_instrumen', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/ref_instrumen/index',
            'index_js' => 'admin/ref_instrumen/index_js',
            'title' => 'Daftar Instrumen',
        ];

        $data['ref_tingkat'] = $this->db->query("SELECT * from ref_tingkat where deleted is null")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_tingkat'] = $this->db->query("SELECT * from ref_tingkat where deleted is null")->result();
        $data['ref_jenis'] = $this->db->query("SELECT * from ref_jenis where deleted is null")->result();

        $html = $this->load->view('admin/ref_instrumen/form', $data, true);

        json([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from instrumen where id='$id' and deleted is null ")->row();

        $data['ref_tingkat'] = $this->db->query("SELECT * from ref_tingkat where deleted is null")->result();
        $data['ref_jenis'] = $this->db->query("SELECT * from ref_jenis where deleted is null")->result();

        $html = $this->load->view('admin/ref_instrumen/form', $data, true);

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

        $id_tingkat = $this->input->post('id_tingkat');
        $id_jenis = $this->input->post('id_jenis');
        $nama = $this->input->post('nama');

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('instrumen', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('instrumen', [
                    'id_tingkat' => $id_tingkat,
                    'id_jenis' => $id_jenis,
                    'nama' => $nama,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('instrumen', [
                    'id_tingkat' => $id_tingkat,
                    'id_jenis' => $id_jenis,
                    'nama' => $nama,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        json([
            'status' => 'success'
        ]);
    }
}
