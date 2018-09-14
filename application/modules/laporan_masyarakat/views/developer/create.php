<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('laporan_masyarakat_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($laporan_masyarakat->id_laporanmas) ? $laporan_masyarakat->id_laporanmas : '';

?>
<div class='admin-box'>
    <h3>Laporan Masyarakat</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('nama_pe_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_nama_pe_laporanmas') . lang('bf_form_label_required'), 'nama_pe_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='nama_pe_laporanmas' type='text' required='required' name='nama_pe_laporanmas' maxlength='25' value="<?php echo set_value('nama_pe_laporanmas', isset($laporan_masyarakat->nama_pe_laporanmas) ? $laporan_masyarakat->nama_pe_laporanmas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('nama_pe_laporanmas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('notel_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_notel_laporanmas') . lang('bf_form_label_required'), 'notel_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='notel_laporanmas' type='text' required='required' name='notel_laporanmas' maxlength='14' value="<?php echo set_value('notel_laporanmas', isset($laporan_masyarakat->notel_laporanmas) ? $laporan_masyarakat->notel_laporanmas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('notel_laporanmas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('email_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_email_laporanmas'), 'email_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='email_laporanmas' type='text' name='email_laporanmas' maxlength='30' value="<?php echo set_value('email_laporanmas', isset($laporan_masyarakat->email_laporanmas) ? $laporan_masyarakat->email_laporanmas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('email_laporanmas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('kelurahan_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_kelurahan_laporanmas') . lang('bf_form_label_required'), 'kelurahan_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='kelurahan_laporanmas' type='text' required='required' name='kelurahan_laporanmas' maxlength='25' value="<?php echo set_value('kelurahan_laporanmas', isset($laporan_masyarakat->kelurahan_laporanmas) ? $laporan_masyarakat->kelurahan_laporanmas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('kelurahan_laporanmas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('kecamatan_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_kecamatan_laporanmas') . lang('bf_form_label_required'), 'kecamatan_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='kecamatan_laporanmas' type='text' required='required' name='kecamatan_laporanmas' maxlength='25' value="<?php echo set_value('kecamatan_laporanmas', isset($laporan_masyarakat->kecamatan_laporanmas) ? $laporan_masyarakat->kecamatan_laporanmas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('kecamatan_laporanmas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('isi_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_isi_laporanmas') . lang('bf_form_label_required'), 'isi_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'isi_laporanmas', 'id' => 'isi_laporanmas', 'rows' => '5', 'cols' => '80', 'value' => set_value('isi_laporanmas', isset($laporan_masyarakat->isi_laporanmas) ? $laporan_masyarakat->isi_laporanmas : ''), 'required' => 'required')); ?>
                    <span class='help-inline'><?php echo form_error('isi_laporanmas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('foto_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_foto_laporanmas'), 'foto_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='foto_laporanmas' type='text' name='foto_laporanmas' maxlength='15' value="<?php echo set_value('foto_laporanmas', isset($laporan_masyarakat->foto_laporanmas) ? $laporan_masyarakat->foto_laporanmas : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('foto_laporanmas'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('id_tps') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_id_tps') . lang('bf_form_label_required'), 'id_tps', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='id_tps' type='text' required='required' name='id_tps' maxlength='5' value="<?php echo set_value('id_tps', isset($laporan_masyarakat->id_tps) ? $laporan_masyarakat->id_tps : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('id_tps'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('laporan_masyarakat_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/developer/laporan_masyarakat', lang('laporan_masyarakat_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>