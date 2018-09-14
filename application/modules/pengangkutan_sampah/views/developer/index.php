<?php

$num_columns	= 4;
$can_delete	= $this->auth->has_permission('Pengangkutan_Sampah.Developer.Delete');
$can_edit		= $this->auth->has_permission('Pengangkutan_Sampah.Developer.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('pengangkutan_sampah_area_title'); ?>
	</h3>
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
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id_laporan; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/developer/pengangkutan_sampah/edit/' . $record->id_laporan, '<span class="icon-pencil"></span> ' .  $record->id_user); ?></td>
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
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>