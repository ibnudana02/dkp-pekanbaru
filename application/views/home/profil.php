<div class="container" style="margin:70px auto;min-height:80vh">
 <div class="row">
  <div class="col-md-8">
  <ol class="breadcrumb">
   <li><a href="<?= base_url('') ?>">Home</a></li>
   <?= ($profil->kategori_informasi=='Informasi Publik')?'<li><a href="'.base_url('home/informasi').'">Informasi Publik</a></li>':'' ?>
   <li class="active"><span><?= $profil->judul_informasi ?></span></li>
  </ol>
  <h2><?= $profil->judul_informasi ?></h2>
  <p><small>Ditulis pada <?= tanggal($profil->tgl_terbit_informasi,true) ?></small></p>
  <?php if($profil->foto_informasi != ''){ ?>
  <img src="<?= base_url('data/images/'.$profil->foto_informasi) ?>" class="img-responsive" />
  <?php } ?>
      <?= $profil->isi_informasi ?>
  </div>
  <?php if($profil->kategori_informasi == 'Profil DKP') { ?>
  <div class="col-md-4">
  <h4>Profil DKP Kota Pekanbaru</h4>
  <ul class="nav nav-pills nav-stacked">
   <?php foreach($prolist as $pro) { ?>
    <li <?= ($profil->id_informasi == $pro->id_informasi)?"class='active'":"" ?>><a href="<?= base_url('home/profil/'.$pro->id_informasi) ?>"><?= $pro->judul_informasi ?></a></li>
   <?php } ?>
  </ul>
  </div>
  <?php } ?>
 </div>
</div>