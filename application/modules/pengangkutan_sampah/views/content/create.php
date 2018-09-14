<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('pengangkutan_sampah_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($pengangkutan_sampah->id_laporan) ? $pengangkutan_sampah->id_laporan : '';

?>
<div class='admin-box'>
    <h3>Pengangkutan Sampah</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    
        <fieldset>
            

            <div class="control-group<?php echo form_error('id_user') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pengangkutan_sampah_field_id_user'), 'id_user', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='id_user' type='hidden' name='id_user' maxlength='11' value="<?php echo set_value('id_user', isset($pengangkutan_sampah->id_user) ? $pengangkutan_sampah->id_user : $user->id); ?>" /><span><?= $user->display_name ?></span>
                    <span class='help-inline'><?php echo form_error('id_user'); ?></span>
                </div>
            </div>

            

            <div class="control-group<?php echo form_error('tanggal_angkut') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pengangkutan_sampah_field_tanggal_angkut'), 'tanggal_angkut', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <!--input id='tanggal_angkut' type='text' name='tanggal_angkut'  value="<?php echo set_value('tanggal_angkut', isset($pengangkutan_sampah->tanggal_angkut) ? $pengangkutan_sampah->tanggal_angkut : date('Y-m-d')); ?>" /-->
                    <?= date('Y-m-d') ?>
                    <span class='help-inline'><?php echo form_error('tanggal_angkut'); ?></span>
                </div>
            </div>

            <!--div class="control-group<?php echo form_error('waktu_angkut') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pengangkutan_sampah_field_waktu_angkut'), 'waktu_angkut', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='waktu_angkut' type='text' name='waktu_angkut'  value="<?php echo set_value('waktu_angkut', isset($pengangkutan_sampah->waktu_angkut) ? $pengangkutan_sampah->waktu_angkut : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('waktu_angkut'); ?></span>
                </div>
            </div-->
            <!--div class="control-group<?php echo form_error('id_tps') ? ' error' : ''; ?>">
                <?php //echo form_label(lang('pengangkutan_sampah_field_id_tps'), 'id_tps', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='id_tps' type='text' name='id_tps' maxlength='11' value="<?php //echo set_value('id_tps', isset($pengangkutan_sampah->id_tps) ? $pengangkutan_sampah->id_tps : ''); ?>" />
                    <span class='help-inline'><?php //echo form_error('id_tps'); ?></span>
                </div>
            </div-->
             <div class="control-group">
             <?php
             $kolom=7;
             $curKolom=1;
             ?>
             <table class="table table-bordered">
              <tr>
               <?php 
               if(is_array($tpslist)){
                foreach($tpslist as $tps){ 
                 $is_done = isset($laporan[$tps->id]);
                ?>
                <td>
                 <label class="form-label" for="tps<?= $tps->id ?>"><?= $tps->nama ?></label>
                 <button type="button" class="btn <?= ($is_done)?"btn-success":"btn-primary" ?> lapor" tps-id="<?= $tps->id ?>" tps-status="0" <?= (!$is_done)?:"disabled" ?> ><span class="fa fa-check"></span> <?= ($is_done)?"Selesai":"Sudah Diangkut" ?></button>
                 <div class="status"><?= ($is_done)?"Diangkut pada: <br>".$laporan[$tps->id]['tanggal_angkut'] ." ".$laporan[$tps->id]['waktu_angkut']:"" ?></div>
                </td>
                 <?php 
                  $curKolom++;
                  if($curKolom == $kolom){
                   echo "</tr>";
                   echo "<tr>";
                   $curKolom = 1;
                  }
                 } 
                } else { ?>
                 <td> Tidak ada TPS Tersedia</td>
                <?php } ?>
               </tr>
             </table>
			 <br>
			 <a href="<?= base_url('admin/reports/pengangkutan_sampah') ?>" class="btn btn-primary" style="float:right;font-size:1.5em;font-weight:700;padding:10px">Selesai</a>
            </div>
        </fieldset>
        
        <!--fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('pengangkutan_sampah_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/pengangkutan_sampah', lang('pengangkutan_sampah_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset-->
    <?php echo form_close(); ?>
    <script>
     $(".lapor").click(function() {
      $this = $(this);
      $.post('<?= base_url('XHRequest/lapor') ?>',{
       
       id_user:'<?= $user->id ?>',
       id_tps:$this.attr('tps-id')
       
       },function(res,err) {
        if(res !== 'false'){
         data = $.parseJSON(res)
         $this.attr('disabled','disabled')
              .removeClass('btn-primary')
              .addClass('btn-success')
              .html('<span class="fa fa-check"></span> Selesai');
         $this.next().html("Diangkut pada: <br/>" + data['tanggal_angkut'] + " " + data['waktu_angkut'])
         console.log(data['session_id'])
        }
       
      });
     })
    </script>
</div>