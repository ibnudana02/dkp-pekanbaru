<?php

$num_columns	= 3;
$can_delete	= $this->auth->has_permission('Jalan.Content.Delete');
$can_edit		= $this->auth->has_permission('Jalan.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<style>
.dataTables_length{float:right}
.dataTables_filter{float:left}
</style>
<div class='admin-box'>
	<h3>
		<?php echo lang('jalan_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped' id="tablekita">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('jalan_field_nama'); ?></th>
					<th><?php echo "Supir" ?></th>
					<th><?php echo lang('jalan_field_armada'); ?></th>
					<th><?php echo "Kecamatan" ?></th>
					<th><?php echo lang('jalan_field_geom'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('jalan_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/content/jalan/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->nama); ?></td>
				<?php else : ?>
					<td><?php e($record->nama); ?></td>
				<?php endif; ?>
					<td><?php e($record->supir); ?></td>
					<td><?php e($record->armada); ?></td>
					<td><?php e($record->kecamatan); ?></td>
					<td><?php e(substr($record->geom, 0,50)."..."); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('jalan_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>
