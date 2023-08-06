<div class="alert alert-primary">
    <span class="text-underline fw-600">CATATAN</span>
    <ul>
        <li>Pilih kelas terlebih dahulu</li>
        <li>Pilih tahun</li>
        <li>Kemudian tentukan periode waktu yang ingin export</li>
        <li>Klik tombol export</li>
    </ul>
</div>

<div class="card bg2">
    <div class="card-body">

        <h3 class="text-center text-underline">Export Data</h3>
        <form onsubmit="event.preventDefault();do_submit(this);">

            <div class="form-group">
                <label>Pilih Kelas</label>
                <select required class="form-control js_select2" id="select_kelas">
                    <option selected value="">pilih kelas</option>
                    <?php foreach ($list_kelas as $dt) : ?>
                        <option value="<?= encode_id($dt->id) ?>"><?= $dt->nm_tingkat . '-' . $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Pilih Tahun</label>
                <select required class="form-control js_select2" id="select_tahun">
                    <option selected value="">pilih tahun</option>
                    <?php foreach ($ref_tahun as $dt) : ?>
                        <option value="<?= encode_id($dt->tahun) ?>"><?= $dt->tahun ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Periode Waktu</label>
                <?php foreach ($list_periode as $dt) : ?>
                    <div class="custom-control custom-radio custom-radio custom-radio-primary mb-1" id="select_periode">
                        <input required value="<?= encode_id($dt->id) ?>" type="radio" id="pilih_<?= $dt->id ?>" name="pilih" class="custom-control-input">
                        <label class="custom-control-label fw-600" for="pilih_<?= $dt->id ?>"><?= $dt->nama ?> - ( <span class="text-primary"><?= $dt->bulan ?></span> )</label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="btn btn-primary fw-600"><i class="fa fa-print mr-1"></i> Export</button>

        </form>
    </div>
</div>