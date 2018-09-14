<?php
Assets::add_js('tinymce/tinymce.min.js');
Assets::add_js("tinymce.init({selector:'textarea#isi_informasi'});", 'inline');
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
    <h3>Informasi Publik</h3>
    <?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('judul_profil') ? ' error' : ''; ?>">
                <?php echo form_label(lang('profil_field_judul_profil') . lang('bf_form_label_required'), 'judul_informasi', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='judul_informasi' type='text' required='required' name='judul_informasi' maxlength='30' value="<?php echo set_value('judul_informasi', isset($profil->judul_informasi) ? $profil->judul_informasi : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('judul_informasi'); ?></span>
                </div>
            </div>
            
            <div class="control-group<?php echo form_error('kategori_infomasi') ? ' error' : ''; ?>">
                <?php echo form_label("Kategori", 'kategori_informasi', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <select name="kategori_informasi" id="kategori_informasi">
                     <option value="Profil DKP">Profil DKP</option>
                     <option value="Informasi Publik">Informasi Publik</option>
                    </select>
                    <span class='help-inline'><?php echo form_error('kategori_informasi'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('tgl_terbit_informasi') ? ' error' : ''; ?>">
                <?php echo form_label(lang('profil_field_tgl_terbit_profil') . lang('bf_form_label_required'), 'tgl_terbit_informasi', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='tgl_terbit_informasi' type='text' required='required' name='tgl_terbit_informasi' maxlength='1' value="<?php echo set_value('tgl_terbit_profil', isset($profil->tgl_terbit_profil) ? $profil->tgl_terbit_profil : date('Y-m-d H:i:s')); ?>" />
                    <span class='help-inline'><?php echo form_error('tgl_terbit_informasi'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('isi_informasi') ? ' error' : ''; ?>">
                <?php echo form_label(lang('profil_field_isi_profil'), 'isi_informasi', array('class' => 'control-label')); ?>
                <div class='controls'>
                   <textarea name="isi_informasi" rows="8" id="isi_informasi">
                    <?= set_value('isi_informasi', isset($profil->isi_informasi) ? $profil->isi_informasi : '') ?>
                   </textarea>
                    <span class='help-inline'><?php echo form_error('isi_informasi'); ?></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo form_label('Foto Informasi', 'images', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input type="hidden" name="foto_informasi" value=""/>
                    <input id='images' type='file' name='images'/>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('profil_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/profil', lang('profil_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>