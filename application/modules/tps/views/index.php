<?php

$hiddenFields = array('id',);
?>
<h1 class='page-header'>
    <?php echo lang('tps_area_title'); ?>
</h1>
<?php if (isset($records) && is_array($records) && count($records)) : ?>
<table class='table table-striped table-bordered'>
    <thead>
        <tr>
            
            <th>Nama</th>
            <th>Status Lahan</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Volume</th>
            <th>Luas</th>
            <th>Keterangan</th>
            <th>Lat</th>
            <th>Long</th>
            <th>Zoom</th>
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
                    e(($value > 0) ? lang('tps_true') : lang('tps_false'));
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
