<div class="row mb-2">
    <div class="col-md-12">
        <button  onclick="tambah();" type="button" class="btn btn-primary waves-effect btn-label waves-light float-right"><i class="fa fa-plus label-icon"></i> Tambah Data</button>
        <div style="clear: both;"></div>
    </div>
</div>
<div class="card">
    <div class="card-body bg2 border1 rounded">
        <h3 class="text-center fw-600 mb-4">AKSES YANG TERSEDIA</h3>
        <div style="display: flex;flex-direction: row;justify-content: center;">
            <?php foreach ($ref_role as $i => $dt) : ?>
                <div class="ml-2 mr-2">
                    <button onclick="load_table('<?= encode_id($dt->id) ?>');set_radio(this,'select_type');" class="btn select_type p-2 <?= $i == 0 ? 'active' : '' ?> btn-outline-light glow2 fw-600 btn-block">
                        <i class="fa fa-users"></i> <?= $dt->keterangan ?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card-body">

        <table class="mt-3 table table-striped" id="table_data">
            <thead class="bg1 text-white">
                <tr>
                    <th class="fw-600">NO</th>
                    <th class="fw-600">NAMA</th>
                    <th class="fw-600">KONTAK</th>
                    <th class="fw-600">ALAMAT</th>
                    <th class="fw-600">NUM</th>
                    <th class="fw-600">INFORMASI</th>
                    <th class="fw-600" style="width:200px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>