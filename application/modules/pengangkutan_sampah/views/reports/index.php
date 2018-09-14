<?php

$num_columns	= 4;
$can_delete	= $this->auth->has_permission('Pengangkutan_Sampah.Reports.Delete');
$can_edit		= $this->auth->has_permission('Pengangkutan_Sampah.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('pengangkutan_sampah_area_title'); ?>
	</h3>
 <?= form_open("admin/reports/pengangkutan_sampah/",'name="tanggal"') ?>
 <div class="form-group">
  <label class="form-label" for="tanggal_awal">Dari</label>
  <input type="date" name="tanggal_awal" id="tanggal_awal" value="<?= $tgl[0] ?>" class="form-control"/>
 </div>
 <div class="form-group">
  <label class="form-label" for="tanggal_akhir">Hingga</label>
  <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="<?= $tgl[1] ?>" class="form-control"/>
 </div>
 <div class="form-group">
  <input type="submit" name="submit_tgl" class="btn btn-primary" value="Tampilkan"/>
  <button type="submit" name="download_pdf" class="btn btn-info">Unduh PDF</button>
 </div>
 </form>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('pengangkutan_sampah_field_id_user'); ?></th>
					<th><?php echo lang('pengangkutan_sampah_field_id_tps'); ?></th>
					<th><?php echo lang('pengangkutan_sampah_field_tanggal_angkut'); ?></th>
					<th><?php echo lang('pengangkutan_sampah_field_waktu_angkut'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('pengangkutan_sampah_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
   <?php foreach($records as $rc){ ?>
    <tr>
     <?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $rc->id_laporan; ?>' /></td>
					<?php endif;?>
     <td><?= $rc->display_name ?></td>
     <td><?= $rc->nama ?></td>
     <td><?= tanggal($rc->tanggal_angkut) ?></td>
     <td><?= $rc->waktu_angkut ?></td>
    </tr>
   <?php }  ?>
				<?php
				/*if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id_laporan; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/reports/pengangkutan_sampah/edit/' . $record->id_laporan, '<span class="icon-pencil"></span> ' .  $record->id_user); ?></td>
				<?php else : ?>
					<td><?php e($record->id_user); ?></td>
				<?php endif; ?>
					<td><?php e($record->id_tps); ?></td>
					<td><?php e($record->tanggal_angkut); ?></td>
					<td><?php e($record->waktu_angkut); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('pengangkutan_sampah_records_empty'); ?></td>
				</tr>
				<?php endif; */?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>