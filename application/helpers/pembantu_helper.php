<?php

function tanggal($dt,$with_timestamp=false){
 //format harus yyyy-mm-dd
 $bulan=array(
  "01" => "Januari",
  "02" => "Februari",
  "12" => "Desember",
  "03" => "Maret",
  "04" => "April",
  "05" => "Mei",
  "06" => "Juni",
  "07" => "Juli",
  "08" => "Agustus",
  "09" => "September",
  "10" => "Oktober",
  "11" => "November"
 );
 $date=explode("-",$dt);
 $tahun=substr($date[2],0,2); //fix date with timestamp format
 $tanggal=$tahun." ".$bulan[$date[1]]." ".$date[0];
 if($with_timestamp){
  $tanggal .= " ".substr($date[2],3);
 }
 return $tanggal;
}

function umur($tgl,$thnonly=false){
 $endperiod=mktime(0,0,0,7,1,2017);
 $bnperiod=date('U',strtotime($tgl));
 $thn=($endperiod-$bnperiod)/31556952; //detik perbedaan tanggal dibagi detik setahun. setahun ada 31556952 detik
 
 $bln=floor(($thn-floor($thn))*12); //tahun float dikurang floor tahun lalu dikali 12 bulan, dan di floor-kan
 if($thnonly){
  return floor($thn);
 } else {
  return floor($thn)." th ".$bln." bln";
 }
}

function specialRemove($string){
	//return preg_replace('/[^A-Za-z0-9*,.@\-\/\\/ \n]/', '', $string);
	return htmlspecialchars($string,ENT_QUOTES,'ISO-8859-1');
}

function text_preview($text, $limit){
 $raw = explode('. ',strip_tags($text,"<p><a>"),$limit+1);
 unset($raw[$limit]);
 $join = implode('. ',$raw);
 return $join;
}

function kecamatan_list(){
 $arr = array("Sukajadi","Pekanbaru","Sail","Lima Puluh","Bukit Raya","Payung Sekaki","Rumbai","Rumbai Pesisir","Tampan","Marpoyan Damai","Tenayan Raya","Senapelan");
 return $arr;
}