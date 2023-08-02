<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <button onclick="tambah();" class="btn btn-light fw-600 btn-sm">
                    <i class="fa fa-plus mr-1"></i> Tambah Data
                </button>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <ul class="nav nav-pills nav-justified rounded border border-secondary" style="background-color: #fff;">
                            <?php foreach ($ref_tingkat as $i => $dt) : ?>
                                <li class="nav-item">
                                    <a href="#" data-toggle="tab" onclick="load_table();" aria-expanded="true" data-value="<?= encode_id($dt->id) ?>" class="nav-link btn_tingkat <?= $i == 0 ? 'active' : '' ?>">
                                        <span class="d-none d-sm-block">Tingkat <?= $dt->nama ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-4"></div>
                </div>

                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_data" style="width: 100%;">
                        <thead class="bg1">
                            <tr>
                                <th class="fw-600 text1">NO</th>
                                <th class="fw-600 text1">TINGKAT</th>
                                <th class="fw-600 text1">JENIS</th>
                                <th class="fw-600 text1">INSTRUMEN</th>
                                <th class="fw-600 text1" style="width: 150px;">AKSI</th>
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