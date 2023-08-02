<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
            </div>

            <div class="card-body">
                <table class="mt-3 table table-striped" id="table_data">
                    <thead>
                        <tr>
                            <th class="fw-600">NO</th>
                            <th class="fw-600">JUDUL</th>
                            <th class="fw-600">TANGGAL</th>
                            <th class="fw-600">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_data as $index => $dt) : ?>
                            <tr>
                                <td><?= ($index + 1) ?></td>
                                <td><?= $dt->judul ?></td>
                                <td><?= tgl_indo($dt->tanggal) ?></td>
                                <td><?= nl2br($dt->keterangan) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>