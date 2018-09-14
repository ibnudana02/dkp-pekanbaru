<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('tps_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($tps->id) ? $tps->id : '';

?>
<div class='admin-box'>
    <h3>tps</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('nama') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_nama') . lang('bf_form_label_required'), 'nama', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='nama' type='text' required='required' name='nama' maxlength='30' value="<?php echo set_value('nama', isset($tps->nama) ? $tps->nama : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('nama'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    &#039;Pinggir Jalan&#039; => &#039;Pinggir Jalan&#039;,
                    &#039;Lahan Kosong&#039; => &#039;Lahan Kosong&#039;,
                );
                echo form_dropdown(array('name' => 'status'), $options, set_value('status', isset($tps->status) ? $tps->status : ''), lang('tps_field_status'));
            ?>

            <div class="control-group<?php echo form_error('kelurahan') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_kelurahan'), 'kelurahan', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='kelurahan' type='text' name='kelurahan' maxlength='30' value="<?php echo set_value('kelurahan', isset($tps->kelurahan) ? $tps->kelurahan : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('kelurahan'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('kecamatan') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_kecamatan'), 'kecamatan', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='kecamatan' type='text' name='kecamatan' maxlength='30' value="<?php echo set_value('kecamatan', isset($tps->kecamatan) ? $tps->kecamatan : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('kecamatan'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('volume') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_volume'), 'volume', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='volume' type='text' name='volume'  value="<?php echo set_value('volume', isset($tps->volume) ? $tps->volume : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('volume'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('luas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_luas'), 'luas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='luas' type='text' name='luas'  value="<?php echo set_value('luas', isset($tps->luas) ? $tps->luas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('luas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('keterangan') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_keterangan'), 'keterangan', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'keterangan', 'id' => 'keterangan', 'rows' => '5', 'cols' => '80', 'value' => set_value('keterangan', isset($tps->keterangan) ? $tps->keterangan : ''))); ?>
                    <span class='help-inline'><?php echo form_error('keterangan'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('lat') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_lat'), 'lat', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='lat' type='text' name='lat' maxlength='15' value="<?php echo set_value('lat', isset($tps->lat) ? $tps->lat : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('lat'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('long') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_long'), 'long', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='long' type='text' name='long' maxlength='15' value="<?php echo set_value('long', isset($tps->long) ? $tps->long : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('long'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('zoom') ? ' error' : ''; ?>">
                <?php echo form_label(lang('tps_field_zoom'), 'zoom', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='zoom' type='text' name='zoom'  value="<?php echo set_value('zoom', isset($tps->zoom) ? $tps->zoom : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('zoom'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('tps_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/reports/tps', lang('tps_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Tps.Reports.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('tps_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('tps_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>