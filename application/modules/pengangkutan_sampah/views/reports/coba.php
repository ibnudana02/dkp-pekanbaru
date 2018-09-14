<?php ob_start(); ?>
 <!--style>
	.kop{display:block;width:100%;}
 .head1{color:#F7AD00}
 .head3{font-size:.8em;}
 h1,h2,h3,h4,h5{margin:2px auto;}
 .underline{text-decoration:underline}
 </style-->

<page backtop="150px" backbottom="20px" backleft="20px" backright="20px">
 <bookmark title="Rekap Laporan Pengangkutan Sampah" level="0"></bookmark>
 <page_header>
 <table style="width:100%">
  <tr>
   <td style="width:100%;text-align:center">
    <h3 style="line-height:0">DINAS KEBERSIHAN DAN PERTAMANAN</h3>
    <h2>KOTA PEKANBARU</h2>
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
   <th style="width:30%;padding:5px">TANGGAL ANGKUT</th>
   <th style="width:20%;padding:5px">PENGANGKUT</th>
   <th style="width:30%;padding:5px">TPS</th>
   <th style="width:20%;padding:5px">WAKTU ANGKUT</th>
  </tr>
 <?php $c = 1; foreach($hasil as $dt){ 
 if(($c-1) % 20 == 0) {  
  if($c!=1){ 
 ?> 
 </table>
 </div>
 </page>
 <page backtop="150px" backbottom="20px" backleft="20px" backright="20px">
 <div style="width:100%;padding-left:20px">
 <table cellspacing="0" style="width:80%;margin:auto" border="1" align="center">
  <tr style="text-align:center" nobr="true">
   <th style="width:30%;padding:5px">TANGGAL ANGKUT</th>
   <th style="width:25%;padding:5px">PENGANGKUT</th>
   <th style="width:25%;padding:5px">TPS</th>
   <th style="width:20%;padding:5px">WAKTU ANGKUT</th>
  </tr>
  <?php } } ?>
  <tr nobr="true">
   <td style="padding:5px"><?= tanggal($dt->tanggal_angkut) ?></td>
   <td style="padding:5px"><?= $dt->display_name ?></td>
   <td style="padding:5px"><?= $dt->nama ?></td>
   <td style="padding:5px"><?= $dt->waktu_angkut ?></td>
  </tr>
 <?php } ?>
 </table>
 </div>
</page>
<?php
//require_once 'vendor/autoload.php';
$html = ob_get_clean();
$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en',true,'UTF-8',array(10,10,25,10));
$html2pdf->pdf->SetAuthor('DKPPKU');
$html2pdf->pdf->SetTitle('Laporan Pengangkutan Sampah');
$html2pdf->writeHTML($html);
$html2pdf->output('laporan.pdf','D');
// $pdf = new mPDF();
// $pdf->WriteHTML($html);
// $pdf->Output(); 
?>