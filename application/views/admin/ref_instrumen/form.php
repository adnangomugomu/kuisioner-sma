<form onsubmit="event.preventDefault();do_submit(this);">

    <div class="form-group">
        <label>Tingkat</label>
        <select required name="id_tingkat" class="form-control js_select2" data-placeholder="pilih tingkat">
            <option value=""></option>
            <?php foreach ($ref_tingkat as $dt) : ?>
                <option <?= $dt->id == @$data->id_tingkat ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Jenis Instrumen</label>
        <select required name="id_jenis" class="form-control js_select2" data-placeholder="pilih jenis instrumen">
            <option value=""></option>
            <?php foreach ($ref_jenis as $dt) : ?>
                <option <?= $dt->id == @$data->id_jenis ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Instrumen</label>
        <input type="text" required name="nama" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->nama ?>">
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
    $(document).ready(function() {
        $('.js_select2').select2({
            width: '100%'
        });
    });

    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Instrumen ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var form = new FormData(dt);
                form.append(CSRF.name, CSRF.hash);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/ref_instrumen/do_submit') ?>",
                    data: form,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
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
                            $('#modal_custom').modal('hide');
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    $('#table_data').DataTable().ajax.reload();
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