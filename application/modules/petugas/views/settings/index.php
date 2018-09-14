<?php

$num_columns	= 5;
$can_delete	= $this->auth->has_permission('Petugas.Settings.Delete');
$can_edit		= $this->auth->has_permission('Petugas.Settings.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('petugas_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('petugas_field_nama_petugas'); ?></th>
					<th><?php echo lang('petugas_field_no_hp_petugas'); ?></th>
					<th><?php echo lang('petugas_field_shift_petugas'); ?></th>
					<th><?php echo lang('petugas_field_id_rute'); ?></th>
					<th><?php echo lang('petugas_field_kecamatan'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('petugas_delete_confirm'))); ?>')" />
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
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id_petugas; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/settings/petugas/edit/' . $record->id_petugas, '<span class="icon-pencil"></span> ' .  $record->nama_petugas); ?></td>
				<?php else : ?>
					<td><?php e($record->nama_petugas); ?></td>
				<?php endif; ?>
					<td><?php e($record->no_hp_petugas); ?></td>
					<td><?php e($record->shift_petugas); ?></td>
					<td><?php e($record->id_rute); ?></td>
					<td><?php e($record->kecamatan); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('petugas_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>