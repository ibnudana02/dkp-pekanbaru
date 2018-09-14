
<div class='admin-box'>
    <h3>Laporan Masyarakat</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('nama_pe_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_nama_pe_laporanmas') . lang('bf_form_label_required'), 'nama_pe_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?= $laporan_masyarakat->nama_pe_laporanmas ?>
                </div>
            </div>

            <div class="control-group<?php echo form_error('notel_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_notel_laporanmas') . lang('bf_form_label_required'), 'notel_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
                   <?= $laporan_masyarakat->notel_laporanmas ?>
                </div>
            </div>

            <div class="control-group<?php echo form_error('email_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_email_laporanmas'), 'email_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
				<?= $laporan_masyarakat->email_laporanmas ?>
				</div>
            </div>

            <div class="control-group<?php echo form_error('kelurahan_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_kelurahan_laporanmas') . lang('bf_form_label_required'), 'kelurahan_laporanmas', array('class' => 'control-label')); ?>
                <div class="controls">
				<?= $laporan_masyarakat->kelurahan_laporanmas ?>
				</div>
            </div>

            <div class="control-group<?php echo form_error('kecamatan_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_kecamatan_laporanmas') . lang('bf_form_label_required'), 'kecamatan_laporanmas', array('class' => 'control-label')); ?>
                <div class='controls'>
				<?= $laporan_masyarakat->kecamatan_laporanmas ?>
				</div>
            </div>
			<div class="control-group<?php echo form_error('id_tps') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_id_tps') . lang('bf_form_label_required'), 'id_tps', array('class' => 'control-label')); ?>
                <div class='controls'>
				<?php if(count(explode('#',$laporan_masyarakat->id_tps)) > 1){
      $coord=explode('#', $laporan_masyarakat->id_tps);
      echo "Tidak diketahui <br><small>(".$coord[0]." ,".$coord[1].")</small>";
     } else { 
      echo $tpskita[$laporan_masyarakat->id_tps]['nama']." <br><small>(".$tpskita[$laporan_masyarakat->id_tps]['coord'].")</small>";
     } ?>
				</div>
            </div>

            <div class="control-group<?php echo form_error('isi_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_isi_laporanmas') . lang('bf_form_label_required'), 'isi_laporanmas', array('class' => 'control-label')); ?>
               <div class='controls'>
			    <p class="text-justify"><?= $laporan_masyarakat->isi_laporanmas ?></p>
			   </div>
            </div>

            <div class="control-group<?php echo form_error('foto_laporanmas') ? ' error' : ''; ?>">
                <?php echo form_label(lang('laporan_masyarakat_field_foto_laporanmas'), 'foto_laporanmas', array('class' => 'control-label')); ?>
				<div class='controls'>
                  <?php if(file_exists('data/images/'.$laporan_masyarakat->foto_laporanmas)) { ?>
				 <img src="<?= base_url('data/images/'.$laporan_masyarakat->foto_laporanmas) ?>" alt="Foto Laporan" style="max-width:500px" />
				 <?php } else { ?>
				 <h4>Belum ada foto</h4>
				 <?php } ?>
				 </div>
            </div>
            <div class="control-group">
                <?php echo form_label("Status Laporan", '', array('class' => 'control-label')); ?>
               <div class='controls'>
                <?= ($laporan_masyarakat->status_laporan)?"Telah Dibalas pada ".tanggal($laporan_masyarakat->tanggal_balasan) :"Belum Dibalas";?>
               </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <a href="<?= base_url('admin/reports/laporan_masyarakat/balas/'.$laporan_masyarakat->id_laporanmas) ?>" class="btn btn-primary">Balas Laporan Ini</a>
        </fieldset>
</div>