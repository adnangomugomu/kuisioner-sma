<form onsubmit="event.preventDefault();do_submit(this);">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" required name="nama" autocomplete="off" placeholder="Tulis nama lengkap" class="form-control" value="<?= @$data->nama ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Username</label>
                <input type="text" required autocomplete="new-password" name="username" autocomplete="off" placeholder="Tulis username" class="form-control" value="<?= @$data->username ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Password</label>
                <input type="password" autocomplete="new-password" <?= empty($data->id) ? 'required' : '' ?> name="password" autocomplete="off" placeholder="Tulis password" class="form-control" value="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Ulangi Password</label>
                <input type="password" autocomplete="new-password" <?= empty($data->id) ? 'required' : '' ?> name="re_password" autocomplete="off" placeholder="Tulis ulangi password" class="form-control" value="">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>NUM (Nomer Unik Murid)</label>
                <input type="number" <?= @$otoritas == '3' ? 'required' : '' ?> name="num" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->num ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jk" class="form-control js_select2" <?= @$otoritas == '3' ? 'required' : '' ?> data-placeholder="pilih jenis kelamin">
                    <option value=""></option>
                    <option <?= 'L' == @$data->jk ? 'selected' : '' ?> value="L">Laki - Laki</option>
                    <option <?= 'P' == @$data->jk ? 'selected' : '' ?> value="P">perempuan</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tingkat</label>
                <select name="id_tingkat" <?= @$otoritas == '3' ? 'required' : '' ?> onchange="pilih_tingkat(this);" class="form-control js_select2" data-placeholder="pilih tingkat">
                    <option value=""></option>
                    <?php foreach ($ref_tingkat as $dt) : ?>
                        <option <?= $dt->id == @$data->id_tingkat ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Kelas</label>
                <select name="id_kelas" <?= @$otoritas == '3' ? 'required' : '' ?> id="select_kelas" class="form-control js_select2" data-placeholder="pilih kelas">
                    <option value=""></option>
                    <?php foreach ($ref_kelas as $dt) : ?>
                        <option <?= $dt->id == @$data->id_kelas ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" autocomplete="off" placeholder="Tulis email aktif" class="form-control" value="<?= @$data->email ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nomer HP</label>
                <input type="number" name="no_hp" autocomplete="off" placeholder="Tulis nomer hp yang aktif" class="form-control" value="<?= @$data->no_hp ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Provinsi</label>
                <select name="provinsi" onchange="pilih_provinsi(this);" class="form-control js_select2" data-placeholder="pilih provinsi">
                    <option value=""></option>
                    <?php foreach ($ref_prov as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_prov ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kabupaten</label>
                <select name="kabupaten" onchange="pilih_kabupaten(this);" id="select_kabupaten" class="form-control js_select2" data-placeholder="pilih kabupaten">
                    <option value=""></option>
                    <?php foreach ($ref_kab as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_kab ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Kecamatan</label>
                <select name="kecamatan" onchange="pilih_kecamatan(this);" id="select_kecamatan" class="form-control js_select2" data-placeholder="pilih kecamatan">
                    <option value=""></option>
                    <?php foreach ($ref_kec as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_kec ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kelurahan</label>
                <select name="kelurahan" id="select_kelurahan" class="form-control js_select2" data-placeholder="pilih kelurahan">
                    <option value=""></option>
                    <?php foreach ($ref_kel as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_kel ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="5" class="form-control" placeholder="tulis alamat yang sesuai"><?= @$data->alamat ?></textarea>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <input type="hidden" name="otoritas" value="<?= encode_id($otoritas) ?>">
    <button type="submit" class="btn btn-block btn-primary">SIMPAN</button>
</form>

<script>
    $(document).ready(function() {
        $('.js_select2').select2({
            width: '100%'
        });
    });

    function do_submit(dt) {
        Swal.fire({
            title: 'Simpan data ?',
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
                    url: "<?= base_url('admin/data_user/do_submit') ?>",
                    data: form,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    error: function(res) {
                        toastr.error('gagal');
                    },
                    success: function(res) {
                        generate_csrf(res);
                        if (res.status == 'success') {
                            $('#modal_custom').modal('hide');
                            $('#table_data').DataTable().ajax.reload();
                            toastr.success('data berhasil disimpan');
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: res.msg,
                                showConfirmButton: true,
                            })
                        }
                    }
                });
            }
        })
    }

    function pilih_provinsi(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_kabupaten') ?>",
            data: {
                id_prov: $(dt).val(),
                [CSRF.name]: CSRF.hash,
            },
            async: false,
            dataType: "JSON",
            success: function(res) {
                generate_csrf(res);
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.kode_wilayah}">${e.nama}</option>
                       `;
                    });
                    $('#select_kabupaten').html(html);
                    $('#select_kecamatan').html('<option value=""></option>');
                    $('#select_kelurahan').html('<option value=""></option>');
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }

    function pilih_kabupaten(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_kecamatan') ?>",
            data: {
                id_kab: $(dt).val(),
                [CSRF.name]: CSRF.hash,
            },
            async: false,
            dataType: "JSON",
            success: function(res) {
                generate_csrf(res);
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.kode_wilayah}">${e.nama}</option>
                       `;
                    });
                    $('#select_kecamatan').html(html);
                    $('#select_kelurahan').html('<option value=""></option>');
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }

    function pilih_kecamatan(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_kelurahan') ?>",
            data: {
                id_kec: $(dt).val(),
                [CSRF.name]: CSRF.hash,
            },
            async: false,
            dataType: "JSON",
            success: function(res) {
                generate_csrf(res);
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.kode_wilayah}">${e.nama}</option>
                       `;
                    });
                    $('#select_kelurahan').html(html);
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }

    function pilih_tingkat(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_kelas') ?>",
            data: {
                id_tingkat: $(dt).val(),
                [CSRF.name]: CSRF.hash,
            },
            dataType: "JSON",
            async: false,
            success: function(res) {
                generate_csrf(res);
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.id}">${e.nama}</option>
                       `;
                    });
                    $('#select_kelas').html(html);
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }
</script>