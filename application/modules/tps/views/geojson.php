<?php
//die('EKA WK WK WK');
header('Content-type: text/plain');
//var_dump($records);
//die();
 ?>
{
"type": "FeatureCollection",
"crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
"features": [
<?php if (isset($records) && is_array($records) && count($records)) : ?>

<?php
        //foreach ($records as $record) :
		for($i=0;$i<count($records);$i++){
        ?>
	{ "type": "Feature"
		, "properties": { 
			"id": "<?php echo $records[$i]->id;?>",
            "nama": "<?php echo $records[$i]->nama;?>",
            "luas": "<?php echo $records[$i]->luas;?>",
            "statuslahan": "<?php echo $records[$i]->status;?>",
            "kelurahan": "<?php echo $records[$i]->kelurahan;?>",
            "kecamatan": "<?php echo $records[$i]->kecamatan;?>",
            "volume": "<?php echo $records[$i]->volume;?>",
            "ket": "<?php echo $records[$i]->keterangan;?>",
            "lat": "<?php echo $records[$i]->lat;?>",
            "long": "<?php echo $records[$i]->long;?>",
            "zoom": "<?php echo $records[$i]->zoom;?>",
            "foto": "<?php echo $records[$i]->file_foto;?>"
		}
		,"geometry": {
            "type": "Point",
            "coordinates": [<?php echo $records[$i]->long;?>, <?php echo $records[$i]->lat;?>]
        } 
	}
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
