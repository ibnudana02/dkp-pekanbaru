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

$id = isset($profil->id_informasi) ? $profil->id_informasi : '';

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
                     <option value="Profil DKP" <?= (set_value('kategori_informasi',$profil->kategori_informasi) == 'Profil DKP') ? 'selected' : '' ?>>Profil DKP</option>
                     <option value="Informasi Publik" <?= (set_value('kategori_informasi',$profil->kategori_informasi) == 'Informasi Publik') ? 'selected' : '' ?>>Informasi Publik</option>
                    </select>
                    <span class='help-inline'><?php echo form_error('kategori_informasi'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('tgl_terbit_informasi') ? ' error' : ''; ?>">
                <?php echo form_label(lang('profil_field_tgl_terbit_profil') . lang('bf_form_label_required'), 'tgl_terbit_informasi', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='tgl_terbit_informasi' type='text' required='required' name='tgl_terbit_informasi' maxlength='1' value="<?php echo set_value('tgl_terbit_informasi', isset($profil->tgl_terbit_informasi) ? $profil->tgl_terbit_informasi : ''); ?>" />
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
                    <input type="hidden" name="foto_informasi" value="<?= $profil->foto_informasi ?>"/>
                    <input id='images' type='file' name='images'/>
                </div>
                <label class="control-label">Foto Informasi Saat Ini</label>
                <div class="controls">
                <?php if(file_exists('data/images/'.$profil->foto_informasi)) { ?>
                <img src="<?= base_url('data/images/'.$profil->foto_informasi) ?>" alt='foto informasi' />
                <?php } else { ?>
                <h4>Belum ada foto</h4>
                <?php } ?>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('profil_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/profil', lang('profil_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Profil.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('profil_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('profil_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>