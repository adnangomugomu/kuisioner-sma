<?php

class Table_rekap_kelas extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('nama', 'num'); //field yang diizin untuk pencarian
    var $order = array('nama' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $tanggal = $this->input->get('tanggal');
        $kelas = $this->input->get('kelas');

        $where = '';
        if ($kelas != 'all') $where .= "AND a.id_kelas='$kelas' ";

        $query = "SELECT a.nama, a.num, concat(c.nama,'-',b.nama) as nm_kelas, d.all_jenis, d.all_jawab
            from data_user a 
            left join ref_kelas b on b.id=a.id_kelas
            left join ref_tingkat c on c.id=a.id_tingkat

            left join (select a.id_user, a.id_kelas, group_concat(b.id_jenis) as all_jenis, group_concat(case when a.nilai='1' then 'YA' when a.nilai='2' then 'TIDAK' end) as all_jawab
                from jawab_instrumen a 
                left join instrumen b on b.id=a.id_instrumen
                where a.tanggal='$tanggal' 
                group by a.id_user, a.id_kelas
                order by b.id_jenis asc
            ) d on d.id_user=a.id and d.id_kelas=a.id_kelas

            where a.id_otoritas=3 and a.deleted is null $where
            order by a.nama asc
        ";

        $this->db->select('*');
        $this->db->from("($query) as tabel");

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

        $ref_jenis = $this->db->query("SELECT * from ref_jenis where deleted is null order by id asc")->result();

        foreach ($list as $field) {
            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $field->nama
                . '<br><small class="text-primary fw-600">NUM :' . $field->num . '</small>'
                . ' | <small class="text-danger fw-600">KELAS :' . $field->nm_kelas . '</small>';

            $arr_jenis = explode(',', $field->all_jenis);
            $arr_jawab = explode(',', $field->all_jawab);

            $arr_fix = [];
            foreach ($arr_jenis as $index => $dt) $arr_fix[$dt] = $arr_jawab[$index];

            foreach ($ref_jenis as $dt) {
                if (!empty($arr_fix[$dt->id])) $jawab = $arr_fix[$dt->id];
                else $jawab = '-';
                $row[] = $jawab;
            }

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
