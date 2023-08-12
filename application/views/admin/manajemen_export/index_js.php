<script>
    function do_submit(dt) {

        Swal.fire({
            title: 'Cetak Data ?',
            text: 'membutuhkan beberapa waktu untuk diproses oleh sistem',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var select_kelas = $('#select_kelas').val();
                var select_tahun = $('#select_tahun').val();
                var select_periode = $('input[name=pilih]:checked').val();

                window.open(`<?= base_url($this->type . '/export/periode?') ?>kelas=${select_kelas}&periode=${select_periode}&tahun=${select_tahun}`);

            } else {
                return false;
            }
        })
    }
</script>