<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

defined('BASEPATH') or exit('No direct script access allowed');

class Export extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function periode()
    {

        $kelas = decode_id($this->input->get('kelas'));
        $tahun = decode_id($this->input->get('tahun'));
        $periode = decode_id($this->input->get('periode'));

        $ref_jenis = $this->db->query("SELECT * from ref_jenis where deleted is null ")->result();
        $ref_kelas = $this->db->query("SELECT
                a.id, a.nama, b.nama AS nm_tingkat
            FROM
                ref_kelas a
                LEFT JOIN ref_tingkat b ON b.id = a.id_kelas
            where a.id='$kelas'
        ")->row();

        $ref_periode = $this->db->query("SELECT * from ref_periode where id='$periode' ")->row();
        $tgl_start = $tahun . '-' . $ref_periode->awal;
        $tgl_finish = $tahun . '-' . $ref_periode->akhir;

        $data = $this->db->query("SELECT a.nama, a.num, concat(c.nama,'-',b.nama) as nm_kelas, 
            d.id_jenis, d.nilai, d.tanggal
            from data_user a 
            left join ref_kelas b on b.id=a.id_kelas
            left join ref_tingkat c on c.id=a.id_tingkat

            left join (select a.id_user, a.id_kelas, b.id_jenis, a.nilai, a.tanggal
                from jawab_instrumen a 
                left join instrumen b on b.id=a.id_instrumen
            ) d on d.id_user=a.id and d.id_kelas=a.id_kelas and d.tanggal>='$tgl_start' and d.tanggal<='$tgl_finish'

            where a.id_otoritas=3 and a.deleted is null AND a.id_kelas='$kelas'
            order by a.nama asc
        ")->result();

        $list = [];
        foreach ($data as $dt) {
            $list[$dt->num][$dt->tanggal][$dt->id_jenis] = $dt;
            $list[$dt->num]['nama'] = $dt->nama;
        }

        $spreadsheet = new Spreadsheet();

        foreach ($ref_jenis as $i => $dt) {
            $sheet = $spreadsheet->createSheet($i);
            $sheet->getColumnDimension('A')->setWidth(4);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->setTitle($dt->nama);
            $sheet->setCellValue('A1', 'DATA PELAKSANAAN ADAB KEPADA ' . $dt->nama . ' KELAS ' . $ref_kelas->nm_tingkat . '-' . $ref_kelas->nama);
            $sheet->setCellValue('A2', 'SMA ISLAM AL AZHAR 7 SUKOHARJO');

            $sheet->getStyle('A1:A2')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
            ]);

            $warna = ['ffbf00', 'b7dee8', 'ebf1de'];
            $warna_semu = ['ffda8f', 'b7dee8', 'ebf1de'];
            $judul = ['NO', 'NUM', 'NAMA'];
            $alphabet = generateAlphabetArray($judul);
            foreach ($alphabet as $key => $value) $sheet->setCellValue($value . '4', $judul[$key]);

            $no_kolom = 3;
            $arr_bulan = explode(',', $ref_periode->bulan);
            foreach (explode(',', $ref_periode->nilai) as $idx => $periode) {
                $max_hari = date('t', strtotime($tahun . '-' . $periode . '-01'));
                for ($inc = 1; $inc <= $max_hari; $inc++) {
                    if ($inc == 1) {
                        $sheet->setCellValue(numberToLetter($no_kolom) . '3', 'TANGGAL PELAKSANAAN ADAB KEPADA ' . strtoupper($dt->nama) . ' BULAN ' . strtoupper($arr_bulan[$idx]) . ' ' . $tahun);
                        $awal_merge = $no_kolom;
                    }
                    $sheet->setCellValue(numberToLetter($no_kolom) . '4', $inc);
                    $sheet->getColumnDimension(numberToLetter($no_kolom))->setWidth(3);
                    $no_kolom++;
                    if ($inc == $max_hari) {
                        $sheet->setCellValue(numberToLetter($no_kolom) . '4', 'JML');
                        $sheet->getColumnDimension(numberToLetter($no_kolom))->setWidth(4);
                        $akhir_merge = $no_kolom;
                        $no_kolom++;
                    }
                }
                $sheet->mergeCells(numberToLetter($awal_merge) . '3:' . numberToLetter($akhir_merge) . '3');
                $sheet->getStyle(numberToLetter($awal_merge) . '3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle(numberToLetter($awal_merge) . '3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => $warna[$idx],
                        ],
                    ],
                ]);
                $sheet->getStyle(numberToLetter($awal_merge) . '4:' . numberToLetter($akhir_merge) . '4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => $warna_semu[$idx],
                        ],
                    ],
                ]);
            }

            $awal = 5;
            $no = 1;

            foreach ($list as $key => $val) {
                $sheet
                    ->setCellValue('A' . $awal, $no++)
                    ->setCellValue('B' . $awal, $key)
                    ->setCellValue('C' . $awal, $val['nama']);

                $no_kolom = 3;
                $arr_bulan = explode(',', $ref_periode->bulan);
                foreach (explode(',', $ref_periode->nilai) as $idx => $periode) {
                    $total_jawab = 0;
                    $max_hari = date('t', strtotime($tahun . '-' . $periode . '-01'));
                    for ($inc = 1; $inc <= $max_hari; $inc++) {
                        $tanggal = $tahun . '-' . $periode . '-' . zerofill($inc, 2);
                        if (!empty($val[$tanggal][$dt->id]->nilai)) {
                            if ($val[$tanggal][$dt->id]->nilai == 1) {
                                $jawab = 1;
                                $total_jawab += 1;
                            } else $jawab = 0;
                        } else {
                            $jawab = 0;
                        }

                        $sheet->setCellValue(numberToLetter($no_kolom) . $awal, $jawab);
                        $sheet->getColumnDimension(numberToLetter($no_kolom))->setWidth(3);
                        $no_kolom++;
                        if ($inc == $max_hari) {
                            $sheet->setCellValue(numberToLetter($no_kolom) . $awal, $total_jawab);
                            $sheet->getColumnDimension(numberToLetter($no_kolom))->setWidth(4);
                            $akhir_merge = $no_kolom;
                            $no_kolom++;
                        }
                    }
                }
                $awal++;
            }
            $awal--;
        }

        $spreadsheet->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Kelas ' . $ref_kelas->nm_tingkat . '-' . $ref_kelas->nama . ' ' . $ref_periode->nama . '_' . date('d-m-Y H:i') . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
