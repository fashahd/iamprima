function goToPMC(monotonyID){
	$.ajax({
		type	: 'POST',
		url		: toUrl+'/pmc/setMonotonyID',
		data	: {monotonyID:monotonyID},
		success: function(data){
			window.location.href = "pmc/pmcData";
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	})
}

$("#formPMC").submit(function(event){
	event.preventDefault();
    var form = $(this);
    $("#loading").html('<div class="progress"><div class="indeterminate"></div></div>');
    $.ajax({
        type : 'POST',
        url  : toUrl+'/pmc/savePMC',
        data : form.serialize(),
        success: function(data){
           if(data == "sukses"){
               $("#loading").html("");
                swal({
                    title: 'Saved',
                    text: 'PMC Berhasil Di Update',
                    type: 'success',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                });
           }else{
               $("#loading").html("");
                swal({
                    title: 'Error',
                    text: 'Check Your Connection or contact our customer service',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                });
           }
        },error: function(xhr, ajaxOptions, thrownError){            
            alert(xhr.responseText);
        }
    });	
	
});

function showPMCYear(){
    var year 	= $("#yearPMC").val();
    
    
    $("#monotonyElement").html("<div class='progress'><div class='indeterminate'></div></div>");
    
    var options = {
        chart: {
            renderTo: 'monotonyElement',
        },
        xAxis: {
            type: 'datetime',
            labels: {
                overflow: 'justify'
            }
        },
        yAxis: {
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
        },
        plotOptions: {
            spline: {
                lineWidth: 4,
                states: {
                    hover: {
                        lineWidth: 5
                    }
                },
                marker: {
                    enabled: false
                },
            }
        },
        exporting: { 
            enabled: false 
        },
        series: [
            {
                type: 'spline',
                name: 'Fatigue',
                data: [{}],
                color: "#f44336",
                yAxis:0
            },
            {
                type: 'spline',
                name: 'Fitness',
                data: [{}],
                color: "#0D47A1",
                yAxis:0
            },
            {
                type: 'spline',
                name: 'Form',
                data: [{}],
                color: "#FFEB3B",
                yAxis:0
            }
        ]
    };
    
    $.ajax({
        type : 'POST',
        url  : toUrl+'/pmc/showPMCYear',
        data : {year:year},
        dataType: "json",
        success: function(data){
            $("#DataWellness").html(data);
            options.xAxis.categories = data.categories;
            options.series[0].data = data.fatigue;
            options.series[1].data = data.fitness;
            options.series[2].data = data.tsb;
            
            var chart 		= new Highcharts.Chart(options);
        },error: function(xhr, ajaxOptions, thrownError){            
            alert(xhr.responseText);
        }
    });
}

function showPMCMonth(){
    var year 	= $("#yearPMC").val();
    var month 	= $("#monthPMC").val();
    
    
    $("#monotonyElement").html("<div class='progress'><div class='indeterminate'></div></div>");
    
    var options = {
        chart: {
            renderTo: 'monotonyElement',
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
        exporting: { 
            enabled: false 
        },
        series: [
            {
                type: 'spline',
                name: 'Fatigue',
                data: [{}],
                color: "#f44336",
                yAxis:0
            },
            {
                type: 'spline',
                name: 'Fitness',
                data: [{}],
                color: "#0D47A1",
                yAxis:0
            },
            {
                type: 'spline',
                name: 'Form',
                data: [{}],
                color: "#FFEB3B",
                yAxis:0
            }
        ]
    };
    
    $.ajax({
        type : 'POST',
        url  : toUrl+'/pmc/showPMCMonth',
        data : {year:year,month:month},
        dataType: "json",
        success: function(data){
            $("#DataWellness").html(data);
            options.xAxis.categories = data.categories;
            options.series[0].data = data.fatigue;
            options.series[1].data = data.fitness;
            options.series[2].data = data.tsb;
            
            var chart 		= new Highcharts.Chart(options);
        },error: function(xhr, ajaxOptions, thrownError){            
            alert(xhr.responseText);
        }
    });
}