<div class="table-responsive">
    <table class="table table-bordered table-hover" id="tabel_show_data" style="width: 100%;">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Informasi</th>
                <th style="width: 70px;">Pilih</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $index => $dt) : ?>
                <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td>
                        <?= $dt->username ?>
                    </td>
                    <td>
                        <?= $dt->nama ?>
                    </td>
                    <td>
                        <div><b><?= $dt->jk ?></b> <span class="badge badge-primary font-size-12">kelas <?= $dt->nm_tingkat ?>-<?= $dt->nm_kelas ?></span></div>
                        <div>NUM <?= $dt->num ?></div>
                        <span class="text-primary fw-600">HP :<?= $dt->no_hp ?></span>
                        <br>
                        Email :<?= $dt->email ?>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-outline-primary w-100" href="<?= base_url('super_admin/dashboard/do_pilih_role/') . encode_id($dt->id) ?>">Pilih</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tabel_show_data').DataTable();
    });
</script>