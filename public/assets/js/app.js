var map, featureList, tpsSearch = [], ruteSearch = [], pekanbaruSearch = [];

$(window).resize(function () {
	sizeLayerControl();
});

$(document).on("click", ".feature-row", function (e) {
	$(document).off("mouseout", ".feature-row", clearHighlight);
	sidebarClick(parseInt($(this).attr("id"), 10));
});

if (!("ontouchstart" in window)) {
	$(document).on("mouseover", ".feature-row", function (e) {
		highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
	});
}

$(document).on("mouseout", ".feature-row", clearHighlight);

$("#about-btn").click(function () {
	$("#aboutModal").modal("show");
	$(".navbar-collapse.in").collapse("hide");
	return false;
});

$("#legend-btn").click(function () {
	$("#legendModal").modal("show");
	$(".navbar-collapse.in").collapse("hide");
	return false;
});

$("#login-btn").click(function () {
	$("#loginModal").modal("show");
	$(".navbar-collapse.in").collapse("hide");
	return false;
});

$("#list-btn").click(function () {
	animateSidebar();
	return false;
});

$("#nav-btn").click(function () {
	$(".navbar-collapse").collapse("toggle");
	return false;
});

$("#sidebar-toggle-btn").click(function () {
	animateSidebar();
	return false;
});

$("#sidebar-hide-btn").click(function () {
	animateSidebar();
	return false;
});



function animateSidebar() {
	$("#sidebar").animate({
		width: "toggle"
	}, 350, function () {
		map.invalidateSize();
	});
}

function geoBalik(data){
    var out=[];
    for(i=0;i<data.length;i++){
        out.push([data[i][1],data[i][0]]);
    }
    return out;
}

function sizeLayerControl() {
	$(".leaflet-control-layers").css("max-height", $("#map").height() - 50);
}

function clearHighlight() {
	highlight.clearLayers();
}

function sidebarClick(id) {
	var layer = markerClusters.getLayer(id);
	map.setView([layer.getLatLng().lat, layer.getLatLng().lng], 17);
	layer.fire("click");
	/* Hide sidebar and go to the map on small screens */
	if (document.body.clientWidth <= 767) {
		$("#sidebar").hide();
		map.invalidateSize();
	}
}

function syncSidebar() {
	/* Empty sidebar features */
	$("#feature-list tbody").empty();
	/* Loop through theaters layer and add only features which are in the map bounds */
	tps.eachLayer(function (layer) {
		if (map.hasLayer(tpsLayer)) {
			if (map.getBounds().contains(layer.getLatLng())) {
				$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="../assets/images/bin.png"></td><td class="feature-name">' + layer.feature.properties.nama + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
			}
		}
	});
	/* Update list.js featureList */
	featureList = new List("features", {
			valueNames: ["feature-name"]
		});
	featureList.sort("feature-name", {
		order: "asc"
	});
}

function animateMarker(geom){
    marker1anim = L.Marker.movingMarker(geom, 60000).addTo(map);
    marker1anim.start();
}

/* Basemap Layers */
var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});


var googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

var osm = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
		maxZoom: 20,
		subdomains: ['a' , 'b' , 'c'],
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>" '
		});

var cartoLight = L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png", {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>'
	});
	
var usgsImagery = L.layerGroup([L.tileLayer("http://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}", {
				maxZoom: 15,
			}), L.tileLayer.wms("http://raster.nationalmap.gov/arcgis/services/Orthoimagery/USGS_EROS_Ortho_SCALE/ImageServer/WMSServer?", {
				minZoom: 16,
				maxZoom: 19,
				layers: "0",
				format: 'image/jpeg',
				transparent: true,
				attribution: "Aerial Imagery courtesy USGS"
			})]);

/* Overlay Layers */
var highlight = L.geoJson(null);
var highlightStyle = {
	stroke: false,
	fillColor: "#00FFFF",
	fillOpacity: 0.7,
	radius: 10
};

var kecamatanColors = {
	"Bukit Raya": "rgba(210,199,72,1.0)",
	"Lima Puluh": "rgba(130,233,209,1.0)",
	"Marpoyan Damai": "rgba(46,187,230,1.0)",
	"Payung Sekaki": "rgba(132,116,220,1.0)",
	"Pekanbaru": "rgba(218,63,63,1.0)",
	"Rumbai": "rgba(107,214,139,1.0)",
	"Rumbai Pesisir": "rgba(162,218,72,1.0)",
	"Sail": "rgba(221,112,212,1.0)",
	"Senapelan": "rgba(121,151,219,1.0)",
	"Sukajadi": "rgba(204,156,117,1.0)",
	"Tampan": "rgba(89,222,62,1.0)",
	"Tenayan Raya": "rgba(159,78,209,1.0)"
};

/** fungsi untuk style kelurahan dikategorikan ke kecamatan
 */
function style_kelurahan(feature) {
	return {
		opacity: 1,
		color: 'rgba(0,0,0,0.1)',
		dashArray: '',
		lineCap: 'butt',
		lineJoin: 'miter',
		weight: 1.0,
		fillOpacity: 0.2,
		fillColor: kecamatanColors[feature.properties['Kecamatan']]
	};
}

var pekanbaru = L.geoJson(null, {
		style: style_kelurahan,
		onEachFeature: function (feature, layer) {
			pekanbaruSearch.push({
				name: layer.feature.properties.Kelurahan, //sesuaikan ini dengan nama di JSON kita
				source: "Kelurahan",
				id: L.stamp(layer),
				bounds: layer.getBounds()
			});
			//tampilkan modal kalau kelurahan di click
			if (feature.properties) {
				var content = "<table class='table table-striped table-bordered table-condensed'>"
					 + "<tr><th>Kelurahan</th><td>" + feature.properties.Kelurahan + "</td></tr>"
					 + "<tr><th>Kecamatan</th><td>" + feature.properties.Kecamatan + "</td></tr>"
					 + "<tr><th>Luas</th><td>" + feature.properties.luas_ha + " ha</td></tr>"
					 + "<table>";
				layer.on({
					click: function (e) {
                        if(!map.kepo.enabled()){
                            $("li#tab_aduan").css('display','none');
                            $(".nav-tabs a[href='#feature-info']").tab('show');
                        }
						//untuk sementara, judulnya digunakan Kelurahan saja, sesuaikan dengan JSON
						$("#feature-title").html(feature.properties.Kelurahan);
						//timpa keterangan dengan content kita
						$("#feature-info").html(content);
						$("input#form_id_tps").val(lat + " # " + lng);
						$("input#form_id_kec").val(feature.properties.Kecamatan)
						$("input#form_id_kel").val(feature.properties.Kelurahan)
						$("#span_id_tps").html(lat + " , " + lng);
						$("#span_id_kec").html(feature.properties.Kecamatan)
						$("#span_id_kel").html(feature.properties.Kelurahan)
						//tampilkan
						$("#featureModal").modal("show");
                        
					}
				});
			}

		}
	});
$.getJSON("../data/kelurahan.php", function (data) {
	pekanbaru.addData(data);
    
});

var ruteColors = {
	"Dump Truck": "#ff3135",
	"L-300": "#00ff00"
};
var marker1 = L.Marker.movingMarker([[0,0],[0,0]], 1000);

var ruteLines = L.geoJson(null, {
		style: function (feature) {
			return {
				color: ruteColors[feature.properties.armada],
				weight: 3,
				opacity: 1
			};
		},
		onEachFeature: function (feature, layer) {
			ruteSearch.push({
				name: layer.feature.properties.Nama_Ruas,
				source: "Rute",
				id: L.stamp(layer),
				bounds: layer.getBounds()
			});
			if (feature.properties) {
				var content = "<table class='table table-striped table-bordered table-condensed'>"
					 + "<tr><th>Rute</th><td>" + feature.properties.Nama_Ruas + "</td></tr>"
					 + "<tr><th>Armada</th><td>" + feature.properties.armada + "</td></tr>"
					 + "<table>";
				layer.on({
					click: function (e) {
                        $("li#tab_aduan").css('display','none');
                        if(map.kepo.enabled()){
                            $(".nav-tabs a[href='#feature-info']").tab('show');
                        }
						//untuk sementara, judulnya digunakan Nama_Ruas saja, sesuaikan dengan JSON
						$("#feature-title").html(feature.properties.Nama_Ruas);
						//timpa keterangan dengan content kita
						$("#feature-info").html(content);
						//tampilkan
                        marker1.moveTo(geoBalik(feature.geometry.coordinates[0])[0],0);
                        marker1.addTo(map);
                        geoBalik(feature.geometry.coordinates[0]).forEach(function(ltln) {
                            //console.log(ltln);
                            marker1.addLatLng(ltln, 5000);
                        });
                        marker1.bindPopup("<strong>Jalan "+feature.properties.Nama_Ruas+"<br>Armada: "+feature.properties.armada+"</strong><br>Dari Pukul "+feature.properties.JadwalMulai+" sampai "+feature.properties.JadwalSelesai+"<br><a href='#' id='buka_fiturmod'>Lihat Info</a>", {autoPan:false}).openPopup();
                        marker1.start();
                        $("a#buka_fiturmod").click(function() {
                            $("#featureModal").modal('show');
                        });
						//$("#featureModal").modal("show");
                        //animateMarker(feature.geometry.coordinates[0]);
					}
				});
			}
			layer.on({
				mouseover: function (e) {
					var layer = e.target;
					layer.setStyle({
						weight: 3,
						color: "#00FFFF",
						opacity: 1
					});
					if (!L.Browser.ie && !L.Browser.opera) {
						layer.bringToFront();
					}
				},
				mouseout: function (e) {
					ruteLines.resetStyle(e.target);
				}
			});
		}
	});
$.getJSON("../jalan/geojson", function (data) {
	ruteLines.addData(data);
});

/* Single marker cluster layer to hold all clusters */
var markerClusters = new L.MarkerClusterGroup({
		spiderfyOnMaxZoom: true,
		showCoverageOnHover: false,
		zoomToBoundsOnClick: true,
		disableClusteringAtZoom: 16
	});

var tpsLayer = L.geoJson(null);
tps = L.geoJson(null, {
		pointToLayer: function (feature, latlng) {
			return L.marker(latlng, {
				icon: L.icon({
					iconUrl: "../assets/images/bin.png",
					iconSize: [24, 28],
					iconAnchor: [12, 28],
					popupAnchor: [0, -25]
				}),
				title: feature.properties.nama,
				riseOnHover: true
			});
		},
		onEachFeature: function (feature, layer) {
			if (feature.properties) {
				var content = "<table class='table table-striped table-bordered table-condensed'>"
					 + "<tr><th>Nama</th><td>" + feature.properties.nama + "</td></tr>"
					 + "<tr><th>Status Lahan</th><td>" + feature.properties.statuslahan + "</td></tr>"
					 + "<tr><th>Kelurahan</th><td>" + feature.properties.kelurahan + "</td></tr>"
					 + "<tr><th>Kecamatan</th><td>" + feature.properties.kecamatan + "</td></tr>"
					 + "<tr><th>Keterangan</th><td>" + feature.properties.ket + "</td></tr>"
					 + "<tr><th>Luas</th><td>" + feature.properties.luas + "</td></tr>"
					 + "<tr><th>Volume</th><td>" + feature.properties.volume + "</td></tr>"
                     + "<tr><td colspan='2'>Foto TPS<br> <img class='img-responsive' src='../data/images/" + feature.properties.foto + "' alt='Foto TPS tidak tersedia' /></td></tr>"
					 + "<table>";
                
				layer.on({
					click: function (e) {
                        $("li#tab_aduan").css('display','table-cell');
						$("#feature-title").html(feature.properties.nama);
						$("#feature-info").html(content);
						$("input#form_id_tps").val(feature.properties.id);
						$("input#form_id_kec").val(feature.properties.kecamatan)
						$("input#form_id_kel").val(feature.properties.kelurahan)
						$("#span_id_tps").html(feature.properties.nama);
						$("#span_id_kec").html(feature.properties.kecamatan)
						$("#span_id_kel").html(feature.properties.kelurahan)
						$("#featureModal").modal("show");
						highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
					},
                    
				});
				$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="../assets/images/bin.png"></td><td class="feature-name">' + layer.feature.properties.nama + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				tpsSearch.push({
					name: layer.feature.properties.nama,
					address: layer.feature.properties.kelurahan,
					source: "TPS",
					id: L.stamp(layer),
					lat: layer.feature.geometry.coordinates[1],
					lng: layer.feature.geometry.coordinates[0]
				});
			}
		}
	});
$.getJSON("../tps/geojson", function (data) {
	tps.addData(data);
	map.addLayer(tpsLayer);
});
map = L.map("map", {
		zoom: 10,
		center: [0.54, 101.5],
		layers: [osm, pekanbaru, ruteLines, markerClusters, highlight],
		zoomControl: false,
		attributionControl: false
	});
markKepo = L.marker([0,0]).bindTooltip("Pilih lokasi masalah persampahan").openTooltip();
L.handleMarkKepo = L.Handler.extend({
    addHooks: function() {
        map.on("mousemove", function (ev) {
            lat = ev.latlng.lat;
            lng = ev.latlng.lng;
            markKepo.setLatLng([lat,lng]);
        });
        
        markKepo.addTo(map);
        $("li#tab_aduan").css('display','table-cell');
        $(".nav-tabs a[href='#form-aduan']").tab('show');
    },
    removeHooks: function() {
        map.removeLayer(markKepo);
        $("li#tab_aduan").css('display','none');
        $(".nav-tabs a[href='#feature-info']").tab('show');
    }
})
map.addHandler('kepo',L.handleMarkKepo);
/* Layer control listeners that allow for a single markerClusters layer */
map.on("overlayadd", function (e) {
	if (e.layer === tpsLayer) {
		markerClusters.addLayer(tps);
		syncSidebar();
	}
});

map.on("overlayremove", function (e) {
	if (e.layer === tpsLayer) {
		markerClusters.removeLayer(tps);
		syncSidebar();
	}
});

/* Filter sidebar feature list to only show features in current map bounds */
map.on("moveend", function (e) {
	syncSidebar();
});

/* Clear feature highlight when map is clicked */
map.on("click", function (e) {
	highlight.clearLayers();
});

map.on("mousemove", function (ev) {
	lat = ev.latlng.lat;
	lng = ev.latlng.lng;
    //markKepo.setLatLng([lat,lng]);
});
L.Control.PointMark = L.Control.extend({
    onAdd: function(map) {
        var divh1 = L.DomUtil.create('div','leaflet-draw leaflet-control'),
        divh2 = L.DomUtil.create('div','leaflet-draw-section',divh1)
        divh3 = L.DomUtil.create('div','lapor-control',divh2),
        anchor = L.DomUtil.create('a','leaflet-draw-draw-marker',divh3),
        anchor.href = '#';
        anchor.title = 'Pilih sebuah tempat untuk melaporkan';
        anchor.innerHTML = "<span class='fa fa-map-marker'></span> Laporkan Masalah Persampahan"
        anchor.style = "background-color:#fff;padding:10px;box-shadow: 0 1px 5px rgba(0,0,0,0.4);"
        L.DomEvent.addListener(anchor, 'click' , this._markerAktif, this);
        return divh1;
    },
    onRemove: function(map){
        //nothing
    },
    _markerAktif: function(){
        //var markKepo = L.marker([lat,lng]);
        //markKepo.setLatLng([lat,lng]);
        //markKepo.addTo(map)
        if(map.kepo.enabled()){
            map.kepo.disable();
            $("a.leaflet-draw-draw-marker").css("background-color","#fff")
        } else {
            map.kepo.enable();
            $("a.leaflet-draw-draw-marker").css("background-color","#ddd")
        }
    }
});
L.control.pointmark = function(opts){
    return new L.Control.PointMark(opts);
}
L.control.pointmark({position: 'topleft' }).addTo(map);

L.Control.PlaybackCon = L.Control.extend({
    onAdd: function(map) {
        var divbtn = L.DomUtil.create('div','playback');
        buttonPause = L.DomUtil.create('button','btn btn-primary playbtn',divbtn);
		buttonPause.innerHTML = "<span class='fa fa-pause'></span> Pause";
		L.DomEvent.addListener(buttonPause, 'click', this._markerToggle, this);
		//L.DomEvent.addListener(buttonResume, 'click', marker1.resume(), this);
        //L.DomEvent.addListener(buttonPause, 'click' , this._markerAktif, this);
        return divbtn;
    },
    onRemove: function(map){
        //nothing
    },
	_markerToggle: function() {
		if(marker1.isRunning()){
			marker1.pause();
			$(".playbtn").html("<span class='fa fa-play'></span> Resume");
		} else {
			marker1.resume();
			$(".playbtn").html("<span class='fa fa-pause'></span> Pause");
		}
	}
});
L.control.playbackcon = function(opts) {
	return new L.Control.PlaybackCon(opts);
}
L.control.playbackcon({position:'bottomleft'}).addTo(map);

/* Attribution control */
function updateAttribution(e) {
	$.each(map._layers, function (index, layer) {
		if (layer.getAttribution) {
			$("#attribution").html((layer.getAttribution()));
		}
	});
}
map.on("layeradd", updateAttribution);
map.on("layerremove", updateAttribution);

var attributionControl = L.control({
		position: "bottomright"
	});
attributionControl.onAdd = function (map) {
	var div = L.DomUtil.create("div", "leaflet-control-attribution");
	div.innerHTML = "<span class='hidden-xs'>Developed by <a href='http://bryanmcbride.com'>bryanmcbride.com</a> | </span><a href='#' onclick='$(\"#attributionModal\").modal(\"show\"); return false;'>Attribution</a>";
	return div;
};
map.addControl(attributionControl);
/* drawnItems = L.featureGroup([pekanbaru]).addTo(map);
map.addControl(new L.Control.Draw({
    edit: {
        featureGroup: drawnItems,
        polygon: false,
        feature: false,
        simpleshape: false,
        rectangle: false,
        circle: false,
        polyline: false,
        edit: false
    },
    draw: {
        polygon: false,
        feature: false,
        simpleshape: false,
        rectangle: false,
        circle: false,
        polyline: false
    }    
})); */

/* map.on(L.Draw.Event.CREATED, function(e,f) {
    var layer = e.layer;
    clickedLayer = L.GeometryUtil.closestLayer(map, [pekanbaru], layer.toGeoJSON().geometry.coordinates)
    //apala = leafletPip.pointInLayer(layer.toGeoJSON().geometry.coordinates, pekanbaru);
    //console.log(apala.toGeoJSON());
    console.log(clickedLayer.layer.toGeoJSON());
    console.log(layer.toGeoJSON());
    haha = '';
    $.getJSON("../data/kelurahan.php", function(d){
        haha = d;
        wuwu = L.geoJson(haha, {
            filter: function(feature) {
              //return feature.geometry.coordinates == clickedLayer.layer.toGeoJSON().geometry.coordinates  
              return feature.properties.Kecamatan == 'Sukajadi'
            },
            onEachFeature: function(feature,layer) {
                console.log(feature.geometry);
                }
        });
    })
    
    
    //console.log(wuwu);
    drawnItems.addLayer(layer);
}); */
        
var zoomControl = L.control.zoom({
		position: "bottomright"
	}).addTo(map);

/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({
		position: "bottomright",
		drawCircle: true,
		follow: true,
		setView: true,
		keepCurrentZoomLevel: true,
		markerStyle: {
			weight: 1,
			opacity: 0.8,
			fillOpacity: 0.8
		},
		circleStyle: {
			weight: 1,
			clickable: false
		},
		icon: "fa fa-location-arrow",
		metric: false,
		strings: {
			title: "My location",
			popup: "You are within {distance} {unit} from this point",
			outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
		},
		locateOptions: {
			maxZoom: 18,
			watch: true,
			enableHighAccuracy: true,
			maximumAge: 10000,
			timeout: 10000
		}
	}).addTo(map);

/* Larger screens get expanded layer control and visible sidebar */
if (document.body.clientWidth <= 767) {
	var isCollapsed = true;
} else {
	var isCollapsed = false;
}

var baseLayers = {
	"Open Street Map": osm,
	"Google Hybrid": googleHybrid,
	"Google Satellite": googleSat,
	"Google Streets": googleStreets,
	"CartoDB Light": cartoLight,
	"Arial Imagery": usgsImagery,
};

var groupedOverlays = {
	"Point Of Interest": {
		"<img src='../assets/images/bin.png' width='24' height='28'>&nbsp;TPS": tpsLayer
	},
	"Referensi": {
		"Kecamatan": pekanbaru,
		"Rute Pengangkut": ruteLines
	}
};

var layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
		collapsed: isCollapsed
	}).addTo(map);

/* Highlight search box text on click */
$("#searchbox").click(function () {
	$(this).select();
});

/* Prevent hitting enter from refreshing the page */
$("#searchbox").keypress(function (e) {
	if (e.which == 13) {
		e.preventDefault();
	}
});

$("#featureModal").on("hidden.bs.modal", function (e) {
	$(document).on("mouseout", ".feature-row", clearHighlight);
});

/* Typeahead search functionality */
$(document).one("ajaxStop", function () {
	$("#loading").hide();
	sizeLayerControl();
	map.fitBounds(pekanbaru.getBounds());
	featureList = new List("features", {
			valueNames: ["feature-name"]
		});
	featureList.sort("feature-name", {
		order: "asc"
	});

	var tpsBH = new Bloodhound({
			name: "TPS",
			datumTokenizer: function (d) {
				return Bloodhound.tokenizers.whitespace(d.name);
			},
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			local: tpsSearch,
			limit: 10
		});

	var geonamesBH = new Bloodhound({
			name: "GeoNames",
			datumTokenizer: function (d) {
				return Bloodhound.tokenizers.whitespace(d.name);
			},
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: "http://api.geonames.org/searchJSON?username=bootleaf&featureClass=P&maxRows=5&countryCode=US&name_startsWith=%QUERY",
				filter: function (data) {
					return $.map(data.geonames, function (result) {
						return {
							name: result.name + ", " + result.adminCode1,
							lat: result.lat,
							lng: result.lng,
							source: "GeoNames"
						};
					});
				},
				ajax: {
					beforeSend: function (jqXhr, settings) {
						settings.url += "&east=" + map.getBounds().getEast() + "&west=" + map.getBounds().getWest() + "&north=" + map.getBounds().getNorth() + "&south=" + map.getBounds().getSouth();
						$("#searchicon").removeClass("fa-search").addClass("fa-refresh fa-spin");
					},
					complete: function (jqXHR, status) {
						$('#searchicon').removeClass("fa-refresh fa-spin").addClass("fa-search");
					}
				}
			},
			limit: 10
		});
	tpsBH.initialize();
	geonamesBH.initialize();

	/* instantiate the typeahead UI */
	$("#searchbox").typeahead({
		minLength: 3,
		highlight: true,
		hint: false
	}, {
		name: "TPS",
		displayKey: "name",
		source: tpsBH.ttAdapter(),
		templates: {
			header: "<h4 class='typeahead-header'><img src='../assets/images/bin.png' width='24' height='28'>&nbsp;TPS</h4>",
			suggestion: Handlebars.compile(["{{name}}<br>&nbsp;<small>{{address}}</small>"].join(""))
		}
	}, {
		name: "GeoNames",
		displayKey: "name",
		source: geonamesBH.ttAdapter(),
		templates: {
			header: "<h4 class='typeahead-header'><img src='../assets/img/globe.png' width='25' height='25'>&nbsp;GeoNames</h4>"
		}
	}).on("typeahead:selected", function (obj, datum) {
		if (datum.source === "Boroughs") {
			map.fitBounds(datum.bounds);
		}
		if (datum.source === "TPS") {
			if (!map.hasLayer(tpsLayer)) {
				map.addLayer(tpsLayer);
			}
			map.setView([datum.lat, datum.lng], 17);
			if (map._layers[datum.id]) {
				map._layers[datum.id].fire("click");
			}
		}
		if (datum.source === "GeoNames") {
			map.setView([datum.lat, datum.lng], 14);
		}
		if ($(".navbar-collapse").height() > 50) {
			$(".navbar-collapse").collapse("hide");
		}
	}).on("typeahead:opened", function () {
		$(".navbar-collapse.in").css("max-height", $(document).height() - $(".navbar-header").height());
		$(".navbar-collapse.in").css("height", $(document).height() - $(".navbar-header").height());
	}).on("typeahead:closed", function () {
		$(".navbar-collapse.in").css("max-height", "");
		$(".navbar-collapse.in").css("height", "");
	});
	$(".twitter-typeahead").css("position", "static");
	$(".twitter-typeahead").css("display", "block");
});

// Leaflet patch to make layer control scrollable on touch browsers
var container = $(".leaflet-control-layers")[0];
/* if (!L.Browser.touch) {
	L.DomEvent
	.disableClickPropagation(container)
	.disableScrollPropagation(container);
} else {
	L.DomEvent.disableClickPropagation(container);
} */
