<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Tps.Reports.Delete');
$can_edit		= $this->auth->has_permission('Tps.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('tps_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('tps_field_nama'); ?></th>
					<th><?php echo lang('tps_field_status'); ?></th>
					<th><?php echo lang('tps_field_kelurahan'); ?></th>
					<th><?php echo lang('tps_field_kecamatan'); ?></th>
					<th><?php echo lang('tps_field_volume'); ?></th>
					<th><?php echo lang('tps_field_luas'); ?></th>
					<th><?php echo lang('tps_field_keterangan'); ?></th>
					<th><?php echo lang('tps_field_lat'); ?></th>
					<th><?php echo lang('tps_field_long'); ?></th>
					<th><?php echo lang('tps_field_zoom'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('tps_delete_confirm'))); ?>')" />
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
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/reports/tps/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->nama); ?></td>
				<?php else : ?>
					<td><?php e($record->nama); ?></td>
				<?php endif; ?>
					<td><?php e($record->status); ?></td>
					<td><?php e($record->kelurahan); ?></td>
					<td><?php e($record->kecamatan); ?></td>
					<td><?php e($record->volume); ?></td>
					<td><?php e($record->luas); ?></td>
					<td><?php e($record->keterangan); ?></td>
					<td><?php e($record->lat); ?></td>
					<td><?php e($record->long); ?></td>
					<td><?php e($record->zoom); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('tps_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>