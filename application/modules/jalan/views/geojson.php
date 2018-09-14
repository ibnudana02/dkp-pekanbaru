<?php
//die(var_dump($records));

//$hiddenFields = array('id',);
?>{
"type": "FeatureCollection",
"crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
"features": [
<?php if (isset($records) && is_array($records) && count($records)) : ?>

<?php
        //foreach ($records as $record) :
		for($i=0;$i<count($records);$i++){
        ?>
	{ "type": "Feature", "properties": { 
		"Nama_Ruas": "<?php echo $records[$i]->nama;?>"
		,"armada": "<?php echo $records[$i]->armada;?>"
		, "No_Ruas": "10.A.002", "Fungsi": "Arteri", "JadwalMulai":"<?= $records[$i]->jadwal_mulai?:'00:00' ?>", "JadwalSelesai":"<?= $records[$i]->jadwal_selesai?:'00:00' ?>","Kecamatan": "Kec. Pekanbaru", "Nama_Pangk": null, "Nama_Ujung": null, "Lebar_jala": null, "Panjang": 0.235 }
		, "geometry": { "type": "MultiLineString", "coordinates": [ <?php echo $records[$i]->geom;?> ] } }
<?php 
		if($i<count($records)-1) echo ',';
		//endforeach; 
		}
?>
	
<?php

endif; 

?>
]
}
