<?php

class Table_user extends CI_Model
{
    var $column_order = array(null, 'a.nama', null, 'alamat', null); //field yang ada di table user
    var $column_search = array('a.nama', 'alamat',); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $jenis = decode_id($this->input->get('jenis'));

        $query = "SELECT
            a.*,
            b.nama AS kecamatan, c.nama AS kelurahan,
            d.nama as nm_tingkat, e.nama as nm_kelas
        FROM
            data_user a
            LEFT JOIN ref_kecamatan b ON b.kode_wilayah = a.kode_kec
            LEFT JOIN ref_kelurahan c ON c.kode_wilayah = a.kode_kel 
            left join ref_tingkat d on d.id=a.id_tingkat
            left join ref_kelas e on e.id=a.id_kelas
        WHERE
            a.deleted IS NULL 
            AND a.id_otoritas = '$jenis' ";
        $this->db->from("($query) as a");

        $i = 0;

        foreach ($this->column_search as $item) { // looping awal
            if ($_GET['search']['value']) { // jika datatable mengirimkan pencarian dengan metode POST

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like('LOWER(' . $item . ')', strtolower($_GET['search']['value']));
                } else {
                    $this->db->or_like('LOWER(' . $item . ')', strtolower($_GET['search']['value']));
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_GET['order'])) {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

    function generate_table()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = $_GET['start'];

        foreach ($list as $field) {
            $no++;
            $row = [];

            $informasi = 'Kelas :' . $field->nm_tingkat . '-' . $field->nm_kelas;

            $row[] = $no;
            $row[] = $field->nama;
            $row[] = $field->no_hp . '
                <span class="d-block fw-600 text-primary">' . $field->email . '</span>
            ';
            $row[] = 'Kec. ' . $field->kecamatan
                . '<div>Kel. ' . $field->kelurahan . '</div>';
            $row[] = $field->num;
            $row[] = $informasi;
            $row[] = '
                <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit"></i> Ubah</button>
                <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger fw-600"><i class="fas fa-trash-alt"></i> Hapus</button>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        return json_encode($output);
    }
}
