function showGrafikWeek(){
	var year 	= $("#yearMonotony").val();
	var month 	= $("#monthMonotony").val();
	
	$("#monotonyElement").html('<div class="progress"><div class="indeterminate"></div></div>');
	
	var options = {
		chart: {
			renderTo: 'monotonyElement',
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
		title: {
			text: 'Training Load Volume Chart Weekly'
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
				rotation: -45,
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
				allowDecimals: false,
				title: {
					text: ''
				}
			}
		],
		legend: {
			enabled: true,
		},
		series: [
			{
				type: 'spline',
				name: 'Training Load',
				data: [{}],
				color: "#d50000",
			},
			{
				type: 'column',
				name: 'Training Load',
				data: [{}],
				color:"#009688",
			},
		]
	};
	
	$.ajax({
		type : 'POST',
		url  : toUrl+'/monotony/monotonyChart',
		data : {year:year,month:month},
		dataType: "json",
		success: function(data){
			// $("#DataWellness").html(data);
			// alert(data);
			// return;
			options.xAxis.categories = data.categories;
			options.series[0].data = data.volume;
			options.series[1].data = data.volume;
			var chart = new Highcharts.Chart(options);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});	
}

function chartSessionMonotony(monotonyID){
	$("#DataMonotony").html('<div class="progress"><div class="indeterminate"></div></div>');
		
	var optionsSession = {
		chart: {
			renderTo: 'DataMonotony',
		},
		plotOptions: {
			spline: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			},
			column: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			},
		},
		title: {
			text: 'Training Load Per Session Chart'
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
				min:0,
				max:10,
			},
			{
				min:0,
				max:1000,
			},
		],
		legend: {
			enabled: true,
		},
		series: [
			{
				yAxis:0,
				type: 'column',
				name: 'Goal',
				data: [{}],
				color:"#009688"
			},
			{
				yAxis:0,
				type: 'column',
				name: 'Actual',
				data: [{}],
				color:"#F44336"
			},
			{
				yAxis:1,
				type: 'spline',
				name: 'Training Load',
				data: [{}],
				color:"#76FF03"
			},
		]
	};
	
	$.ajax({
		type : 'POST',
		url  : 'monotony/chartSessionMonotony',
		data : {monotonyID:monotonyID},
		dataType: "json",
		success: function(data){
			optionsSession.xAxis.categories = data.categories;
			optionsSession.series[2].data = data.load;
			optionsSession.series[0].data = data.rpe;
			optionsSession.series[1].data = data.actual;
			var chart = new Highcharts.Chart(optionsSession);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});	
}

function chartDayMonotony(monotonyID){
	$("#DataMonotony").html('<div class="progress"><div class="indeterminate"></div></div>');
	var options = {
		chart: {
			renderTo: 'DataMonotony',
		},
		plotOptions: {
			spline: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			},
			column: {
				dataLabels: {
					enabled: true,
					color: '#000000',
					style: {
						fontWeight: 'bold'
					}
				}
			},
		},
		title: {
			text: 'Training Load Per Day Chart'
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
				max: 20,
				allowDecimals: false,
				title: {
					text: ''
				}
			}
		],
		legend: {
			enabled: true,
		},
		series: [
			{
				type: 'spline',
				name: 'Training Load',
				data: [{}],
			},
			{
				type: 'column',
				name: 'Goal',
				data: [{}],
				yAxis:1,
				color:"#009688",
			},
			{
				type: 'column',
				name: 'Actual',
				data: [{}],
				yAxis:1,
				color:"#F44336",
			},
		]
	};
	
	$.ajax({
		type : 'POST',
		url  : toUrl+'/monotony/chartDayMonotony',
		data : {monotonyID:monotonyID},
		dataType: "json",
		success: function(data){
			// $("#DataMonotony").html(data);
			// alert(data);
			// return;
			options.xAxis.categories = data.categories;
			options.series[0].data = data.load;
			options.series[1].data = data.rpe;
			options.series[2].data = data.actual;
			var chart = new Highcharts.Chart(options);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}

function goToData(monotonyID){
	$.ajax({
		type	: 'POST',
		url		: toUrl+'/monotony/setMonotonyID',
		data	: {monotonyID:monotonyID},
		success: function(data){
			window.location.href = "monotonyData";
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	})
}

function deleteMonotony(monotonyID) {
    swal({
		title: 'Are you sure?',
		text: 'You will not be able to recover this Data!',
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Yes, delete it!',
		cancelButtonText: 'No, keep it',
		confirmButtonClass: "btn btn-success",
		cancelButtonClass: "btn btn-danger",
		buttonsStyling: false
	},function() {
		$.ajax({
			type	: 'POST',
			url		: toUrl+'/monotony/deleteMonotony',
			data	: {monotonyID:monotonyID},
			success: function(data){
				if(data == "sukses"){
					swal({
						title: 'Deleted!',
						text: 'Your Training Load Data has been deleted.',
						type: 'success',
						confirmButtonClass: "btn btn-success",
						buttonsStyling: false
					},function() {
						window.location.reload();
					});
				}else{
					swal({
						title: 'Failed',
						text: 'Failed To Delete Traning Load',
						type: 'error',
						confirmButtonClass: "btn btn-info",
						buttonsStyling: false
                    })
				}
			},error: function(xhr, ajaxOptions, thrownError){            
				swal({
					title: 'Failed',
					text: 'Failed To Delete Traning Load',
					type: 'error',
					confirmButtonClass: "btn btn-info",
					buttonsStyling: false
				})
			}
		});
	})
}

$("#stepOne").submit(function(event){
	event.preventDefault();
	
	var atletID = new Array();
		$.each($("input[name='atletID[]']:checked"), function() {
		atletID.push($(this).val());
	});
	
	var week	= $("#selectWeek").val();
	
	if(atletID == " "){
		demo.showSwal("atletIsEmpty");
		return;
	}
	
	$.ajax({
		type	: 'POST',
		url		: toUrl+'/setAtletMonotony',
		data	: {atletID:atletID,week:week},
		success: function(data){
			window.location.href = "stepTwo";
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	})
});



$("#monthMonotony").change(function(){
	var month	= $("#monthMonotony").val();
	var year	= $("#yearMonotony").val();
	
	$("#monotonyTable").html('<div class="progress"><div class="indeterminate"></div></div>');
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/filterMonotony",
		data : {month:month,year:year},
		// dataType: "json",
		success: function(data){
			$("#monotonyTable").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$("#yearMonotony").change(function(){
	var month	= $("#monthMonotony").val();
	var year	= $("#yearMonotony").val();
	
	$("#monotonyTable").html('<div class="progress"><div class="indeterminate"></div></div>');
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/filterMonotony",
		data : {month:month,year:year},
		// dataType: "json",
		success: function(data){
			$("#monotonyTable").html(data);
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