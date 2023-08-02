<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data_user extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_user', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/data_user/index',
            'index_js' => 'admin/data_user/index_js',
            'title' => 'Data User',
        ];

        $data['ref_role'] = $this->db->query("SELECT * from dev_otoritas where id != 1")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $otoritas = decode_id($this->input->post('otoritas'));
        $data['otoritas'] = $otoritas;

        $data['ref_tingkat'] = $this->db->query("SELECT * from ref_tingkat")->result();
        $data['ref_kelas'] = [];

        $data['ref_prov'] = $this->db->query("SELECT * from ref_provinsi")->result();
        $data['ref_kel'] = [];

        $html = $this->load->view('admin/data_user/form', $data, true);

        json([
            'status' => 'success',
            'html' => $html,
            'type' => $otoritas == 3 ? 'Operator' : 'Admin',
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $otoritas = decode_id($this->input->post('otoritas'));

        $data['otoritas'] = $otoritas;

        $row = $this->db->query("SELECT
            a.*, b.otoritas as nama_otoritas from data_user a 
            left join dev_otoritas b on b.id=a.id_otoritas
            where a.id='$id' and a.deleted is null 
        ")->row();

        $data['data'] = $row;

        $data['ref_tingkat'] = $this->db->query("SELECT * from ref_tingkat")->result();
        $data['ref_kelas'] = $this->db->query("SELECT * from ref_kelas where id_kelas='$row->id_tingkat' ")->result();

        $data['ref_prov'] = $this->db->query("SELECT 
            * from ref_provinsi
        ")->result();

        $data['ref_kab'] = $this->db->query("SELECT 
            * from ref_kabupaten where kode_prop='$row->kode_prov'
        ")->result();

        $data['ref_kec'] = $this->db->query("SELECT 
            * from ref_kecamatan where kode_kab='$row->kode_kab'
        ")->result();

        $data['ref_kel'] = $this->db->query("SELECT 
            * from ref_kelurahan where kode_kec='$row->kode_kec'
        ")->result();

        $html = $this->load->view('admin/data_user/form', $data, true);

        json([
            'status' => 'success',
            'html' => $html,
            'type' => $data['data']->nama_otoritas,
            'data' => $data,
        ]);
    }

    public function do_submit()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $otoritas = decode_id($this->input->post('otoritas'));
        $hapus = $this->input->post('hapus');

        $nama = $this->input->post('nama');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $re_password = $this->input->post('re_password');
        $no_hp = $this->input->post('no_hp');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $provinsi = $this->input->post('provinsi');
        $kabupaten = $this->input->post('kabupaten');
        $kecamatan = $this->input->post('kecamatan');
        $kelurahan = $this->input->post('kelurahan');

        $num = $this->input->post('num');
        $jk = $this->input->post('jk');
        $id_tingkat = $this->input->post('id_tingkat');
        $id_kelas = $this->input->post('id_kelas');

        if (!empty($id)) {
            $cek_username = $this->db->query("SELECT * from data_user where deleted is null and username='$username' and id !='$id' ")->row();
            $cek_email = $this->db->query("SELECT * from data_user where deleted is null and email='$email' and id !='$id' ")->row();
            $cek_no_hp = $this->db->query("SELECT * from data_user where deleted is null and no_hp='$no_hp' and id !='$id' ")->row();
            $cek_num = $this->db->query("SELECT * from data_user where deleted is null and num='$num' and id !='$id' ")->row();
        } else {
            $cek_username = $this->db->query("SELECT * from data_user where deleted is null and username='$username' ")->row();
            $cek_email = $this->db->query("SELECT * from data_user where deleted is null and email='$email' ")->row();
            $cek_no_hp = $this->db->query("SELECT * from data_user where deleted is null and no_hp='$no_hp' ")->row();
            $cek_num = $this->db->query("SELECT * from data_user where deleted is null and num='$num' ")->row();
        }

        if (!empty($cek_username)) {
            json([
                'status' => 'failed',
                'msg' => 'username sudah digunakan',
            ]);
            die;
        }

        if (!empty($cek_num)) {
            json([
                'status' => 'failed',
                'msg' => 'NUM sudah digunakan',
            ]);
            die;
        }

        if (!empty($cek_email)) {
            json([
                'status' => 'failed',
                'msg' => 'email sudah digunakan',
            ]);
            die;
        }

        if (!empty($cek_no_hp)) {
            json([
                'status' => 'failed',
                'msg' => 'nomer hp sudah digunakan',
            ]);
            die;
        }

        if ($hapus) {
            $this->db->where('id', $id);
            $this->db->update('data_user', [
                'deleted' => date('Y-m-d H:i:s')
            ]);
        } else {
            if (empty($id)) {
                if ($password != $re_password) {
                    json([
                        'status' => 'failed',
                        'msg' => 'password tidak sama',
                    ]);
                    die;
                }

                $this->db->insert('data_user', [
                    'id_otoritas' => $otoritas,
                    'nama' => $nama,
                    'username' => $username,
                    'password' => sha1($password),
                    'email' => $email,
                    'kode_prov' => $provinsi,
                    'kode_kab' => $kabupaten,
                    'kode_kec' => $kecamatan,
                    'kode_kel' => $kelurahan,
                    'alamat' => $alamat,
                    'no_hp' => $no_hp,

                    'num' => $num,
                    'jk' => $jk,
                    'id_tingkat' => $id_tingkat,
                    'id_kelas' => $id_kelas,

                    'foto' => 'uploads/users/default.png',
                    'created' => date('Y-m-d H:i:s')
                ]);
            } else {
                if (!empty($password)) $this->db->set('password', sha1($password));

                $this->db->where('id', $id);
                $this->db->update('data_user', [
                    'id_otoritas' => $otoritas,
                    'nama' => $nama,
                    'username' => $username,
                    'email' => $email,
                    'kode_prov' => $provinsi,
                    'kode_kab' => $kabupaten,
                    'kode_kec' => $kecamatan,
                    'kode_kel' => $kelurahan,
                    'alamat' => $alamat,
                    'no_hp' => $no_hp,

                    'num' => $num,
                    'jk' => $jk,
                    'id_tingkat' => $id_tingkat,
                    'id_kelas' => $id_kelas,
                    
                    'updated' => date('Y-m-d H:i:s')
                ]);
            }
        }

        json([
            'status' => 'success',
            'msg' => 'berhasil menyimpan data',
        ]);
    }
}
