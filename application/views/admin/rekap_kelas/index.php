<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <div style="width: 250px;" class="d-flex mr-2">
                    <input onchange="load_table();" value="<?= date('Y-m-d') ?>" type="date" style="width: 140px;" class="form-control mr-2" placeholder="Semua tanggal" id="select_tanggal">
                    <select onchange="load_table();" class="form-control js_select2" data-placeholder="Pilih Kelas" id="select_kelas">
                        <option value="all" selected>Semua Kelas</option>
                        <?php foreach ($list_kelas as $dt) : ?>
                            <option value="<?= $dt->id ?>"><?= $dt->nm_tingkat . '-' . $dt->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_data" style="width: 100%;">
                        <thead class="bg1">
                            <tr>
                                <th rowspan="2" class="fw-600 text1">NO</th>
                                <th rowspan="2" class="fw-600 text1">NAMA</th>
                                <th colspan="<?= count($ref_jenis) ?>" class="fw-600 text-center text1">JENIS PERTANYAAN</th>
                            </tr>
                            <tr>
                                <?php foreach ($ref_jenis as $dt) : ?>
                                    <th class="fw-600 text1"><?= $dt->nama ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>