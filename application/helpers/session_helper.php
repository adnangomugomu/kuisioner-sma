<?php

function data_sistem($get = 'nama')
{
    $data = [
        'nama' => 'KURIKULUM ADAB',
        'deskripsi' => 'SMA ISLAM AL AZHAR 7 SUKOHARJO',
        'pemilik' => 'SMAI AL AZHAR 7',
        'logo' => base_url('uploads/img/logo.png'),
        'nickname' => 'AL AZHAR 7',
    ];

    return $data[$get];
}

function my_csrf($target = '')
{
    $CI = &get_instance();
    $data['name'] = $CI->security->get_csrf_token_name();
    $data['hash'] = $CI->security->get_csrf_hash();

    if (empty($target)) {
        return $data;
    } else {
        return $data[$target];
    }
}
