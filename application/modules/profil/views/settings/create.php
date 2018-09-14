<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('profil_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($profil->id_profil) ? $profil->id_profil : '';

?>
<div class='admin-box'>
    <h3>Profil</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('judul_profil') ? ' error' : ''; ?>">
                <?php echo form_label(lang('profil_field_judul_profil') . lang('bf_form_label_required'), 'judul_profil', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='judul_profil' type='text' required='required' name='judul_profil' maxlength='30' value="<?php echo set_value('judul_profil', isset($profil->judul_profil) ? $profil->judul_profil : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('judul_profil'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('tgl_terbit_profil') ? ' error' : ''; ?>">
                <?php echo form_label(lang('profil_field_tgl_terbit_profil') . lang('bf_form_label_required'), 'tgl_terbit_profil', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='tgl_terbit_profil' type='text' required='required' name='tgl_terbit_profil' maxlength='1' value="<?php echo set_value('tgl_terbit_profil', isset($profil->tgl_terbit_profil) ? $profil->tgl_terbit_profil : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('tgl_terbit_profil'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('isi_profil') ? ' error' : ''; ?>">
                <?php echo form_label(lang('profil_field_isi_profil'), 'isi_profil', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'isi_profil', 'id' => 'isi_profil', 'rows' => '5', 'cols' => '80', 'value' => set_value('isi_profil', isset($profil->isi_profil) ? $profil->isi_profil : ''))); ?>
                    <span class='help-inline'><?php echo form_error('isi_profil'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('profil_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/settings/profil', lang('profil_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>