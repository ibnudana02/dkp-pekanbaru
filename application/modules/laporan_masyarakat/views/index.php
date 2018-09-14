<?php

$hiddenFields = array('id_laporanmas',);
?>
<h1 class='page-header'>
    <?php echo lang('laporan_masyarakat_area_title'); ?>
</h1>
<?php if (isset($records) && is_array($records) && count($records)) : ?>
<table class='table table-striped table-bordered'>
    <thead>
        <tr>
            
            <th>Nama Anda</th>
            <th>Nomor Telepon</th>
            <th>Email</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Keluhan</th>
            <th>Upload Foto</th>
            <th>TPS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($records as $record) :
        ?>
        <tr>
            <?php
            foreach($record as $field => $value) :
                if ( ! in_array($field, $hiddenFields)) :
            ?>
            <td>
                <?php
                if ($field == 'deleted') {
                    e(($value > 0) ? lang('laporan_masyarakat_true') : lang('laporan_masyarakat_false'));
                } else {
                    e($value);
                }
                ?>
            </td>
            <?php
                endif;
            endforeach;
            ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php

endif; ?>