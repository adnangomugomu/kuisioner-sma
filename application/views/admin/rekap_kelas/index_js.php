<script>
    $(document).ready(function() {
        load_table();
    });

    function load_table() {
        $('#table_data').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            ajax: {
                url: '<?= base_url($this->type . '/rekap_kelas/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tanggal: $('#select_tanggal').val(),
                    kelas: $('#select_kelas').val(),
                },
            },
            order: [],
            columnDefs: [{
                targets: [0],
                className: 'text-center',
                orderable: false,
            }],
        })
    }
</script>