<style>
    @media screen and (max-width: 450px) {
        .page-content {
            padding: 80px 0px !important;
        }
    }
</style>

<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
            </div>

            <?php if (empty($cek)) : ?>

                <div class="card-body" style="background-color: #EDEAFF;">
                    <h3 class="text-center text-primary fw-600 text-underline">SILAHKAN DIJAWAB DENGAN JUJUR</h3>
                    <?php foreach ($instrumen as $i => $dt) : ?>
                        <div class="card" style="border-left: 5px solid #2143eb !important;">
                            <div class="card-body">
                                <div style="font-size: 15px;"><?= $i + 1 ?>. <?= $dt->nama ?> <small class="text-danger fw-600">*</small></div>
                                <div class="pl-4 mt-2">
                                    <div class="custom-control custom-radio custom-radio custom-radio-primary mb-1">
                                        <input data-id_instrumen="<?= encode_id($dt->id) ?>" value="1" type="radio" id="pilih_ya_<?= $i ?>" name="pilih_<?= $i ?>" class="custom-control-input">
                                        <label class="custom-control-label fw-600" for="pilih_ya_<?= $i ?>"><i class="fa fa-check text-success ml-1"></i> YA</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-radio custom-radio-primary">
                                        <input data-id_instrumen="<?= encode_id($dt->id) ?>" value="2" type="radio" id="pilih_tidak_<?= $i ?>" name="pilih_<?= $i ?>" class="custom-control-input">
                                        <label class="custom-control-label fw-600" for="pilih_tidak_<?= $i ?>"><i class="fa fa-times text-danger ml-1"></i> TIDAK</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="d-flex justify-content-end">
                        <div>
                            <button onclick="do_submit();" class="btn btn-primary fw-600"><i class="fa fa-check mr-1"></i> Klik disini untuk simpan</button>
                            <br>
                            <small class="text-danger fw-600">* tidak dapat diedit kembali</small>
                        </div>
                    </div>
                </div>

            <?php else : ?>
                <div class="card-body" style="background-color: #EDEAFF;">
                    <h3 class="text-center text-primary fw-600 text-underline"><i class="fa fa-check mr-1"></i> ANDA SUDAH SUBMIT JAWABAN</h3>
                    <p class="text-center"><i class="fa fa-clock mr-1"></i> <?= tgl_indo($cek->created, true) ?></p>

                    <?php foreach ($instrumen as $i => $dt) : ?>
                        <div class="card" style="border-left: 5px solid #2143eb !important;">
                            <div class="card-body">
                                <div style="font-size: 15px;"><?= $i + 1 ?>. <?= $dt->nama ?> <small class="text-danger fw-600">*</small></div>
                                <p class="text-primary">Jawab : <?= $dt->nilai ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>