<script>
    function do_submit() {
        var arr = [];
        var obj = {};
        $("input[type='radio']").each(function() {
            var nama = $(this).attr("name");
            obj[nama] = 1;
        });

        $.map(obj, function(e, i) {
            var nilai = $("input[name='" + i + "']:checked").val();
            var id_instrumen = $("input[name='" + i + "']:checked").data('id_instrumen');

            if (nilai !== undefined) {
                arr.push({
                    nilai: nilai,
                    id_instrumen: id_instrumen,
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Wajib diisi semua',
                    showConfirmButton: true,
                })
                throw false;
            }
        });

        Swal.fire({
            title: 'Simpan Formulir ?',
            text: 'tanggal <?= tgl_indo(date('Y-m-d')) ?>, tidak dapat dibatalkan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('siswa/instrumen/do_submit') ?>",
                    data: {
                        [CSRF.name]: CSRF.hash,
                        jawaban: arr,
                    },
                    dataType: "JSON",
                    beforeSend: function(res) {
                        Swal.fire({
                            title: 'Loading ...',
                            html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                    },
                    error: function(res) {
                        Swal.close();
                    },
                    success: function(res) {
                        generate_csrf(res);
                        if (res.status == 'success') {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    location.reload();
                                })
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: res.msg,
                                showConfirmButton: true,
                            })
                        }
                    }
                });

            } else {
                return false;
            }
        })
    }
</script>