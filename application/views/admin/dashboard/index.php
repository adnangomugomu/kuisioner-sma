<style>
    .avatar-title {
        background-color: #2143eb !important;
    }
</style>

<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex justify-content-start" style="align-items: center;">
                        <i class="mdi mdi-account-circle text-primary h1 mr-2"></i>
                        <h5><?= $this->nama ?></h5>
                    </div>

                    <div>
                        <small class="mb-1"><?= $row->nama_prov ?>, <?= $row->nama_kab ?></small>
                        <p class="text-muted mb-0">email : <?= $row->email ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div>
                <div class="row">
                    <div class="col-lg-9 col-sm-8">
                        <div class="p-4">
                            <h5 class="text-primary">Selamat Datang !</h5>
                            <p class="mb-1"><?= data_sistem('nama') ?></p>

                            <div class="text-muted mb-2">
                                <?= data_sistem('deskripsi') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4 align-self-center">
                        <div>
                            <img src="<?= base_url('assets/skote/dist/') ?>assets/images/crypto/features-img/img-1.png" alt="image" class="img-fluid d-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h4 class="text-center">Rekap Pengisian Hari Ini <?= tgl_indo(date('Y-m-d')) ?></h4>

        <div class="row">
            <?php foreach ($rekap as $i => $dt) : ?>
                <div class="col-md-3 my-1">
                    <div class="card mini-stats-wid bg2">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-primary mb-1">Kelas <?= $dt->nm_tingkat ?>-<?= $dt->nama ?> <span class="badge badge-dark"><i class="fa fa-users mr-1"></i> <?= $dt->total_siswa ?></span></p>
                                    <h6 class="mb-0 text-danger">0% (0 dari <?= $dt->total_siswa ?>)</h6>
                                </div>

                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                        <i class="bx bx-copy-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>