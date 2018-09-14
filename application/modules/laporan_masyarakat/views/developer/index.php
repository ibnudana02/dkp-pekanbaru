<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Laporan_Masyarakat.Developer.Delete');
$can_edit		= $this->auth->has_permission('Laporan_Masyarakat.Developer.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('laporan_masyarakat_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('laporan_masyarakat_field_nama_pe_laporanmas'); ?></th>
					<th><?php echo lang('laporan_masyarakat_field_notel_laporanmas'); ?></th>
					<th><?php echo lang('laporan_masyarakat_field_email_laporanmas'); ?></th>
					<th><?php echo lang('laporan_masyarakat_field_kelurahan_laporanmas'); ?></th>
					<th><?php echo lang('laporan_masyarakat_field_kecamatan_laporanmas'); ?></th>
					<th><?php echo lang('laporan_masyarakat_field_isi_laporanmas'); ?></th>
					<th><?php echo lang('laporan_masyarakat_field_foto_laporanmas'); ?></th>
					<th><?php echo lang('laporan_masyarakat_field_id_tps'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('laporan_masyarakat_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id_laporanmas; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/developer/laporan_masyarakat/edit/' . $record->id_laporanmas, '<span class="icon-pencil"></span> ' .  $record->nama_pe_laporanmas); ?></td>
				<?php else : ?>
					<td><?php e($record->nama_pe_laporanmas); ?></td>
				<?php endif; ?>
					<td><?php e($record->notel_laporanmas); ?></td>
					<td><?php e($record->email_laporanmas); ?></td>
					<td><?php e($record->kelurahan_laporanmas); ?></td>
					<td><?php e($record->kecamatan_laporanmas); ?></td>
					<td><?php e($record->isi_laporanmas); ?></td>
					<td><?php e($record->foto_laporanmas); ?></td>
					<td><?php e($record->id_tps); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('laporan_masyarakat_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>