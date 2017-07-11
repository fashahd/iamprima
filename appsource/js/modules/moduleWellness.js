$("#formWellness").submit(function(event){
	event.preventDefault();
	
	var lama_tidur		= $("input[name='lama_tidur']:checked").val();
	var kualitas_tidur	= $("input[name='kualitas_tidur']:checked").val();
	var soreness		= $("input[name='soreness']:checked").val();
	var energi			= $("input[name='energi']:checked").val();
	var mood			= $("input[name='mood']:checked").val();
	var stress			= $("input[name='stress']:checked").val();
	var mental			= $("input[name='mental']:checked").val();
	var jml_nutrisi		= $("input[name='jml_nutrisi']:checked").val();
	var kwt_nutrisi		= $("input[name='kwt_nutrisi']:checked").val();
	var hydration		= $("input[name='hydration']:checked").val();
	var rhr				= $("input[name='rhr']").val();
	var berat_badan		= $("input[name='berat_badan']").val();
	var cidera			= $("input[name='cidera']").val();
	
	var dataWellness	= {
		lama_tidur:lama_tidur,
		kualitas_tidur:kualitas_tidur,
		soreness:soreness,
		energi:energi,
		mood:mood,
		stress:stress,
		mental:mental,
		jml_nutrisi:jml_nutrisi,
		kwt_nutrisi:kwt_nutrisi,
		hydration:hydration,
		rhr:rhr,
		berat_badan:berat_badan,
		cidera:cidera
	};
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/saveWellness",
		data : dataWellness,
		// dataType: "json",
		success: function(data){
			if(data == "sukses"){
				swal({   
					title: "Success",
					type: "success",
					text: "Wellness Berhasil Disimpan",   
					html: true 
				},function(){
					window.location.href="wellness";
				});
			}else{
				swal("Gagal", "Silahkan Coba LAgi atau Hubungi Team IAM PRIMA", "error");
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$("#month").change(function(){
	var month	= $("#month").val();
	var year	= $("#year").val();
	
	$("#wellnessElement").html("<h4>Loading.....</h4>");
	$("#wellnessElement2").html("");
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/filterWellness",
		data : {month:month,year:year},
		// dataType: "json",
		success: function(data){
			$("#wellnessElement").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$("#year").change(function(){
	var month	= $("#month").val();
	var year	= $("#year").val();
	
	$("#wellnessElement").html("<h4>Loading.....</h4>");
	$("#wellnessElement2").html("");
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/filterWellness",
		data : {month:month,year:year},
		// dataType: "json",
		success: function(data){
			$("#wellnessElement").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

function wellnessTable(){
	var month	= $("#month").val();
	var year	= $("#year").val();
	
	$("#wellnessElement").html("<h4>Loading.....</h4>");
	$("#wellnessElement2").html("");
	$("#btnWellness").html('<button onClick="wellnessGrafik()" class="btn btn-info btn-round">Wellness Chart</button>');
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/filterWellness",
		data : {month:month,year:year},
		// dataType: "json",
		success: function(data){
			$("#wellnessElement").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}
	
function wellnessGrafik(){
	var month 	= $("#month").val();
	var year 	= $("#year").val();
	
	$("#wellnessElement").html("<h4>Loading.....</h4>");
	$("#btnWellness").html('<button onClick="wellnessTable()" class="btn btn-danger btn-round">Wellness Table</button>');
	
	var options = {
		chart: {
			renderTo: 'wellnessElement',
		},
		plotOptions: {
			column: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			},
			spline: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			}
		},
		// colors: ["#c62828","#2e7d32","#2196f3"],
		title: {
			text: 'Grafik Wellness Fisiologi'
		},
		navigation: {
			buttonOptions: {
				align: "right",
				enabled: false,
			},
		},
		xAxis: {
			categories: [],
			crosshair: true
		},
		yAxis: [
			{
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			{
				min: 0,
				max: 5,
				allowDecimals: false,
				title: {
					text: ''
				}
			}
		],
		series: [
			{
				showInLegend :true,
				type: 'column',
				name: 'RHR',
				data: [{}],
				color: "#ffeb3b",
			},
			{
				showInLegend :true,
				type: 'column',
				name: 'BB',
				data: [{}],
				color: "#0d47a1",
			},
			// {
				// type: 'column',
				// margin: [ 50, 50, 100, 80],
				// name: 'BB',
				// data: [{}],
				// colors: ["#48485A"],
				// legend: {
					// enabled: true
				// }
			// },
			{
				showInLegend :true,
				type: 'spline',
				name: 'Fatigue',
				data: [{}],
				color: "#c62828",
				allowPointSelect: true,
				yAxis: 1
			},
			{
				showInLegend :true,
				type: 'spline',
				name: 'Soreness',
				data: [{}],
				color: "#2e7d32",
				allowPointSelect: true,
				yAxis: 1
			},
			{
				showInLegend :true,
				type: 'spline',
				name: 'Hidrasi',
				color: "#2196f3",
				data: [{}],
				allowPointSelect: true,
				yAxis: 1
			},
		]
	};
	
	var optionsPsiko = {
		chart: {
			renderTo: 'wellnessElement2',
		},
		plotOptions: {
			column: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			},
			spline: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			}
		},
		// colors: [],
		title: {
			text: 'Grafik Wellness Psychology'
		},
		navigation: {
			buttonOptions: {
				align: "right",
				enabled: false,
			},
		},
		xAxis: {
			categories: [],
			labels: {
				rotation: -90,
				align: 'right',
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		},
		yAxis: [
			{
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			{
				min: 0,
				max: 5,
				allowDecimals: false,
				title: {
					text: ''
				}
			}
		],
		series: [
			{
				type: 'column',
				name: 'Wellness',
				data: [{}],
				color: "#2196F3",
				legend: {
					enabled: true
				}
			},
			{
				type: 'spline',
				name: 'Mood',
				data: [{}],					
				yAxis: 1,
				color: "#2e7d32",
				legend: {
					enabled: true
				}
			},
			{
				type: 'spline',
				name: 'Stress',
				data: [{}],
				color: '#c62828',
				legend: {
					enabled: true
				}, 
				yAxis: 1
			},
			{
				type: 'spline',
				name: 'Focus',
				data: [{}],
				color: '#ffeb3b',
				legend: {
					enabled: true
				},
				yAxis: 1
			},
		]
	};
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/grafikWellness",
		data : {month:month,year:year},
		dataType: "json",
		success: function(data){
			options.xAxis.categories = data.categories;
			// options.colors = data.colors;
			options.series[0].data = data.nadi;
			options.series[1].data = data.berat;
			options.series[2].data = data.fatigue;
			options.series[3].data = data.soreness;
			options.series[4].data = data.hidrasi;
			
			optionsPsiko.xAxis.categories = data.categories;
			// options.colors = data.colors;
			optionsPsiko.series[0].data = data.wellness;
			optionsPsiko.series[1].data = data.mood;
			optionsPsiko.series[2].data = data.stress;
			optionsPsiko.series[3].data = data.focus;
			var chart 		= new Highcharts.Chart(options);
			var chart 		= new Highcharts.Chart(optionsPsiko);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
			window.location.reload();
		}
	});
}