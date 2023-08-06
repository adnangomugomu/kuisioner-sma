<?php
function encode_id($id_ = null)
{
    if ($id_ == null) {
        return '';
    } else {
        return substr(md5($id_), 0, 20) . $id_ . substr(md5($id_), 20, 12);
    }
}

function decode_id($id_ = null)
{
    if ($id_ == null) {
        return '';
    } else {
        return substr($id_, 20, strlen($id_) - 32);
    }
}

function dd($arr)
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($arr);
    die;
}

function json($arr)
{
    header('Content-Type: application/json; charset=utf-8');
    $arr['csrf'] = my_csrf();
    echo json_encode($arr);
    die;
}

function generateRandomString($length = 5)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function rupiah($data, $is_koma = false)
{
    if ($data == null) {
        return '';
    } else {
        if ($is_koma == true) {
            return number_format($data, 2, ',', '.');
        } else {
            return number_format($data, 0, ',', '.');
        }
    }
}

function session($name = null)
{

    $CI = &get_instance();
    if (!$name) {
        json($_SESSION);
        die;
    } else {
        return $CI->session->userdata($name);
    }
}

function cek_post()
{
    if (!$_POST) {
        echo 'not allowed';
        die;
    }
}

function tgl_indo($tgl = null, $jam = false)
{
    if ($tgl != null) {
        if ($jam) {
            $date = strtotime($tgl);
            $tanggal = strftime('%d %B %Y %H:%M', $date);
            return $tanggal;
        } else {
            $date = strtotime($tgl);
            $tanggal = strftime('%d %B %Y', $date);
            return $tanggal;
        }
    } else {
        return '';
    }
}

function clear_koma($dt)
{
    $data = str_replace('.', '', $dt);
    $data = str_replace(',', '.', $data);
    return $data;
}

function generateAlphabetArray($arr)
{
    $alphabet = [];
    for ($i = 0; $i < count($arr); $i++) {
        $letter = chr(ord('A') + $i);  // Mengonversi kode ASCII ke huruf
        array_push($alphabet, $letter);
    }
    return $alphabet;
}

function numberToLetter($number)
{
    if ($number < 0) throw new InvalidArgumentException("Number must be non-negative.");

    $letters = "";
    while ($number >= 0) {
        $remainder = $number % 26;
        $letters = chr(65 + $remainder) . $letters;
        $number = intdiv($number, 26) - 1;
    }

    return $letters;
}

function zerofill($number, $length)
{
    return str_pad($number, $length, '0', STR_PAD_LEFT);
}