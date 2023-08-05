<style>
    .avatar-title {
        background-color: #2143eb !important;
    }

    @media screen and (max-width: 450px) {
        .page-content {
            padding: 80px 0px !important;
        }

        .gambar_icon {
            display: none;
        }
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
                        <span class="mb-1">Kelas <?= $row->nm_kelas ?>-<?= $row->nm_tingkat ?></span>
                        <p class="text-muted mb-0">NUM <?= $row->num ?></p>
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
                        <div class="text-center">
                            <img src="<?= base_url('assets/skote/dist/') ?>assets/images/crypto/features-img/img-1.png" alt="image" class="img-fluid gambar_icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card" style="background-color: #05c46b !important;">
            <div class="card-body">
                <div class="text-center text-white fw-600">Ayo Isi Formulir Hari ini</div>
                <div class="text-center mt-2">
                    <a class="btn btn-primary fw-600" href="<?= base_url('siswa/instrumen') ?>"><i class="fa fa-edit mr-1"></i> KLIK DISINI</a>
                </div>
            </div>
        </div>
    </div>
</div>