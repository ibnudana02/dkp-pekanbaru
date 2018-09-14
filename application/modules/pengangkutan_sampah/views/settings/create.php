<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('pengangkutan_sampah_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($pengangkutan_sampah->id_laporan) ? $pengangkutan_sampah->id_laporan : '';

?>
<div class='admin-box'>
    <h3>Pengangkutan Sampah</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('id_user') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pengangkutan_sampah_field_id_user'), 'id_user', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='id_user' type='text' name='id_user' maxlength='11' value="<?php echo set_value('id_user', isset($pengangkutan_sampah->id_user) ? $pengangkutan_sampah->id_user : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('id_user'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('id_tps') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pengangkutan_sampah_field_id_tps'), 'id_tps', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='id_tps' type='text' name='id_tps' maxlength='11' value="<?php echo set_value('id_tps', isset($pengangkutan_sampah->id_tps) ? $pengangkutan_sampah->id_tps : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('id_tps'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('tanggal_angkut') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pengangkutan_sampah_field_tanggal_angkut'), 'tanggal_angkut', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='tanggal_angkut' type='text' name='tanggal_angkut'  value="<?php echo set_value('tanggal_angkut', isset($pengangkutan_sampah->tanggal_angkut) ? $pengangkutan_sampah->tanggal_angkut : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('tanggal_angkut'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('waktu_angkut') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pengangkutan_sampah_field_waktu_angkut'), 'waktu_angkut', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='waktu_angkut' type='text' name='waktu_angkut'  value="<?php echo set_value('waktu_angkut', isset($pengangkutan_sampah->waktu_angkut) ? $pengangkutan_sampah->waktu_angkut : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('waktu_angkut'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('pengangkutan_sampah_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/settings/pengangkutan_sampah', lang('pengangkutan_sampah_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>