<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $url = $this->uri->segment(1);
        if (!session('is_login')) {
            redirect('login/logout');
        } elseif (session('type') != $url && $url != 'global') {
            if (!session('is_super')) {
                redirect('login/logout');
            }else{
                if ($url != 'super_admin') {
                    redirect('login/logout');
                }
            }
        }

        $this->id_akun = session('id_akun');
        $this->id_otoritas = session('id_otoritas');
        $this->nama = session('nama');
        $this->nm_email = session('email');
        $this->no_hp = session('no_hp');
        $this->username = session('username');
        $this->foto = session('foto');
        $this->id_tingkat = session('id_tingkat');
        $this->id_kelas = session('id_kelas');
    }
}

/* End of file MY_Controller.php */
