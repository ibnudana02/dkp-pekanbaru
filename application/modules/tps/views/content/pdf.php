<?php ob_start(); ?>
 <!--style>
	.kop{display:block;width:100%;}
 .head1{color:#F7AD00}
 .head3{font-size:.8em;}
 h1,h2,h3,h4,h5{margin:2px auto;}
 .underline{text-decoration:underline}
 </style-->

<page backtop="150px" backbottom="20px" backleft="1px" backright="1px">
 <bookmark title="Rekap Senarai TPS di Pekanbaru" level="0"></bookmark>
 <page_header>
 <table style="width:100%">
  <tr>
   <td style="width:100%;text-align:center">
    <h3 style="line-height:0">REKAPITULASI DATA EXISTING TEMPAT PENAMPUNGAN SEMENTARA (TPS) SAMPAH<br></h3>
	<h3 style="line-height:0">KECAMATAN SE - KOTA PEKANBARU TAHUN 2017</h3>
    <h2>DINAS KEBERSIHAN DAN PERTAMANAN</h2>
   </td>
  </tr>
  <tr>
   <td><hr style="border:solid 1px #000"/></td>
  </tr>
 </table>
 </page_header>

 <div style="width:100%;padding-left:20px">
 <table cellspacing="0" style="width:80%;margin:auto" border="1" align="center">
  <tr style="text-align:center" nobr="true">
   <th style="width:2%;padding:5px">No</th>
   <th style="width:20%;padding:5px">NAMA</th>
   <th style="width:10%;padding:5px">STATUS</th>
   <th style="width:10%;padding:5px">KELURAHAN</th>
   <th style="width:10%;padding:5px">KECAMATAN</th>
   <th style="width:10%;padding:5px">VOLUME</th>
   <th style="width:8%;padding:5px">LUAS</th>
   <th style="width:10%;padding:5px">KOORDINAT</th>
   <th style="width:5%;padding:5px">KETERANGAN</th>
  </tr>
 <?php $c = 1; foreach($hasil as $dt){ 
?>
  <tr nobr="true">
    <td style="width:2%;padding:5px"><?= $c++  ?></td>
   <td style="width:20%;padding:5px"><?= $dt->nama ?></td>
   <td style="width:10%;padding:5px"><?= $dt->status ?></td>
   <td style="width:15%;padding:5px"><?= $dt->kelurahan ?></td>
   <td style="width:15%;padding:5px"><?= $dt->kecamatan ?></td>
   <td style="width:10%;padding:5px"><?= $dt->volume ?></td>
   <td style="width:8%;padding:5px"><?= $dt->luas ?></td>
   <td style="width:20%;padding:5px"><?= $dt->lat ?> , <br><?= $dt->long ?><br><?= $dt->zoom ?></td>
   <td style="width:15%;padding:5px"><?= $dt->keterangan ?></td>
  </tr>
 <?php } ?>
 </table>
 </div>
</page>
<?php
//require_once 'vendor/autoload.php';
$html = ob_get_clean();
$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'Legal', 'en',true,'UTF-8',array(5,5,5,8));
$html2pdf->pdf->SetAuthor('DKPPKU');
$html2pdf->pdf->SetTitle('Laporan Tempat Pengangkutan Sampah');
$html2pdf->writeHTML($html);
$html2pdf->output('laporan.pdf','D');
// $pdf = new mPDF();
// $pdf->WriteHTML($html);
// $pdf->Output(); 
?>