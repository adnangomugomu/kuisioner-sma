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
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_data" style="width: 100%;">
                        <thead class="bg1">
                            <tr>
                                <th class="fw-600 text1">NO</th>
                                <th class="fw-600 text1">JENIS</th>
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