<?php
Assets::add_js('tinymce/tinymce.min.js');
Assets::add_js("tinymce.init({selector:'textarea#email_content'});", 'inline');
?>
<div class='admin-box'>
    <h3>Balas Laporan Masyarakat</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            <div class='control-group'>
                <label class='control-label' for='email_to'>Kepada</label>
                <div class='controls'>
                    <input type="text" size="50" name="email_to" id="email_to" value="<?= $laporan_masyarakat->email_laporanmas ?>" />
                </div>
            </div>
            <div class='control-group'>
                <label class='control-label' for='email_subject'>Subjek Email</label>
                <div class='controls'>
                    <input type="text" size="50" name="email_subject" id="email_subject" value="<?php if (isset($email_subject)) { e($email_subject); } ?>" />
                </div>
            </div>
            <div class='control-group'>
                <label class='control-label' for='email_content'>Isi Balasan</label>
                <div class='controls'>
                    <textarea name="email_content" id="email_content" rows="15"><?php
                        if (isset($email_content)) {
                            echo $email_content;
                        }
                    ?></textarea>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <button type="submit" name="save" class="btn btn-primary">Balas Laporan Ini</button>
        </fieldset>
</div>