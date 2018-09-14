<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('jalan_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($jalan->id) ? $jalan->id : '';

?>
<div class='admin-box'>
    <h3>jalan</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('nama') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_nama'), 'nama', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='nama' type='text' name='nama' maxlength='50' value="<?php echo set_value('nama', isset($jalan->nama) ? $jalan->nama : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('nama'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('html') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_html'), 'html', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'html', 'id' => 'html', 'rows' => '5', 'cols' => '80', 'value' => set_value('html', isset($jalan->html) ? $jalan->html : ''))); ?>
                    <span class='help-inline'><?php echo form_error('html'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('geom') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_geom'), 'geom', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'geom', 'id' => 'geom', 'rows' => '5', 'cols' => '80', 'value' => set_value('geom', isset($jalan->geom) ? $jalan->geom : ''))); ?>
                    <span class='help-inline'><?php echo form_error('geom'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('jalan_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/developer/jalan', lang('jalan_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Jalan.Developer.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('jalan_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('jalan_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>