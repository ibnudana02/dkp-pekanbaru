<div class="container" style="margin:70px auto;min-height:80vh">
 <div class="row">
  <div class="col-md-8">
   <ol class="breadcrumb">
    <li><a href="<?= base_url('') ?>">Home</a></li>
    <li><a href="<?= base_url('home/gis') ?>">Peta Infomasi TPS</a></li>
    <li class="active"><span>Konfirmasi Laporan</span></li>
   </ol>
   <h2><?= $judul ?></h2>
   <?php if($success) { ?>
   <p>Terima kasih. Laporan Anda telah kami terima. Kami akan mengabari Anda mengenai perkembangan laporan tersebut melalui email.</p>
   <h3>Rincian Laporan</h3>
   <table class="table table-striped table-bordered table-responsive">
    <tr>
     <td>Nama Pelapor<br>
     <strong><?= $datalapor['nama_pe_laporanmas'] ?></strong></td>
     <td>Waktu Laporan<br>
     <strong><?= tanggal($datalapor['tgl_laporanmas']) ?></strong></td>
     <td>Alamat Email Pelapor<br>
     <strong><?= $datalapor['email_laporanmas'] ?></strong></td>
    </tr>
    <tr>
     <td colspan='3' style="height:20vh"><h4>Keluhan</h4>
     <?= $datalapor['isi_laporanmas'] ?></td>
    </tr>
    <tr>
     <td>Kelurahan<br>
     <strong><?= $datalapor['kelurahan_laporanmas'] ?></strong>
     </td>
     <td>Kecamatan<br>
     <strong><?= $datalapor['kecamatan_laporanmas'] ?></strong>
     </td>
     <td>TPS<br>
     <strong><?= ($tps == null)?$datalapor['id_tps']:$tps->nama ?></strong>
     </td>
    </tr>
   </table>
   <?php } else { ?>
   <p>Mohon maaf. Terdapat kesalahan pada sistem saat mengirim laporan. Cobalah beberapa saat lagi.</p>
   <?php } ?>
   <a href="<?= base_url('home/gis') ?>"><< Kembali ke Peta Informasi</a>
  </div>
 </div>
</div>