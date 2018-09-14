<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('petugas_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($petugas->id_petugas) ? $petugas->id_petugas : '';

?>
<div class='admin-box'>
    <h3>Petugas</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('nama_petugas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('petugas_field_nama_petugas') . lang('bf_form_label_required'), 'nama_petugas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='nama_petugas' type='text' required='required' name='nama_petugas' maxlength='30' value="<?php echo set_value('nama_petugas', isset($petugas->nama_petugas) ? $petugas->nama_petugas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('nama_petugas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('no_hp_petugas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('petugas_field_no_hp_petugas'), 'no_hp_petugas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='no_hp_petugas' type='text' name='no_hp_petugas' maxlength='14' value="<?php echo set_value('no_hp_petugas', isset($petugas->no_hp_petugas) ? $petugas->no_hp_petugas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('no_hp_petugas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('shift_petugas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('petugas_field_shift_petugas'), 'shift_petugas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='shift_petugas' type='text' name='shift_petugas' maxlength='10' value="<?php echo set_value('shift_petugas', isset($petugas->shift_petugas) ? $petugas->shift_petugas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('shift_petugas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('id_rute') ? ' error' : ''; ?>">
                <?php echo form_label(lang('petugas_field_id_rute'), 'id_rute', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='id_rute' type='text' name='id_rute' maxlength='11' value="<?php echo set_value('id_rute', isset($petugas->id_rute) ? $petugas->id_rute : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('id_rute'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('kecamatan') ? ' error' : ''; ?>">
                <?php echo form_label(lang('petugas_field_kecamatan'), 'kecamatan', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='kecamatan' type='text' name='kecamatan' maxlength='30' value="<?php echo set_value('kecamatan', isset($petugas->kecamatan) ? $petugas->kecamatan : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('kecamatan'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('petugas_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/reports/petugas', lang('petugas_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Petugas.Reports.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('petugas_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('petugas_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>