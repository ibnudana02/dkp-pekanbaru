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

            <?php /*<div class="control-group<?php echo form_error('id_rute') ? ' error' : ''; ?>">
                <?php echo form_label(lang('petugas_field_id_rute'), 'id_rute', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='id_rute' type='text' name='id_rute' maxlength='11' value="<?php echo set_value('id_rute', isset($petugas->id_rute) ? $petugas->id_rute : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('id_rute'); ?></span>
                </div>
            </div> */ ?>

            <div class="control-group<?php echo form_error('kecamatan') ? ' error' : ''; ?>">
                <?php echo form_label(lang('petugas_field_kecamatan'), 'kecamatan', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <select name="kecamatan">
                    <?php foreach(kecamatan_list() as $kc){ ?>
                    <option value="<?= $kc ?>" <?php echo set_value('kecamatan', isset($petugas->kecamatan) ? 'selected' : ''); ?>><?= $kc ?></option>
                    <?php } ?>
                    </select>
                    <span class='help-inline'><?php echo form_error('kecamatan'); ?></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo form_label("Pengguna Terkait", 'id_user', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <select name="id_user">
                    <option disabled selected>Pilih salah satu</option>
                     <?php foreach($userlist as $usr){ ?>
                     <option value="<?= $usr->id ?>"><?= $usr->username." (".$usr->display_name.")" ?></option>
                     <?php } ?>
                    </select>
                    
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('petugas_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/petugas', lang('petugas_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>