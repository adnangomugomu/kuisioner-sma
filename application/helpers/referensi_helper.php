<?php

function total_informasi()
{
    $ci = &get_instance();
    $data = $ci->db->query("SELECT * from informasi where deleted is null order by id desc")->result();
    return $data;
}


function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

function insert_visitor()
{
    $CI = &get_instance();
    $CI->load->helper('cookie');

    $my_cookie = get_cookie('devices_id');
    if (empty($my_cookie)) {
        $my_cookie = generateRandomString(15) . time();

        set_cookie([
            'name'   => 'devices_id',
            'value'  => $my_cookie,
            'expire' => '31536000',
            'secure' => TRUE
        ]);
    }

    $ip = getUserIP();
    $cek_ada = $CI->db->get_where('visitor', [
        'waktu' => date('Y-m-d'),
        'devices' => $my_cookie,
    ])->row();

    if (empty($cek_ada)) {
        $CI->db->insert('visitor', [
            'waktu' => date('Y-m-d'),
            'ip' => $ip,
            'devices' => $my_cookie,
            'created' => date('Y-m-d H:i:s'),
        ]);
    }
}