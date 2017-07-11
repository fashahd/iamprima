//  $("formProfiling").submit(function (event) {
//     event.preventDefault();
//     var form = $(this);
//     $.ajax({
//         url: toUrl+'/performance/saveProfiling',
//         type: "POST",
//         data: form.serialize(),
//         success: function(result){
//             alert(result);
//             return;
//         }
//     });
// });

$("#formProfiling").submit(function(event){
	event.preventDefault();
    var form = $(this);
    $.ajax({
        type : 'POST',
        url  : toUrl+'/performance/saveProfiling',
        data : form.serialize(),
        dataType: "json",
        success: function(data){
            // alert(data);
           if(data.status == "sukses"){
                swal({
                    title: 'Saved',
                    text: 'Profiling Data '+data.atletName+' has been created.',
                    type: 'success',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                });
           }else{
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

function showTable(performanceID,jenis,user_id,date,catatan){ 
    if(catatan == ""){
        catatan = 'NULL';
    }   
    // alert(toUrl+'/performance/showTableAjax/'+performanceID+'/'+jenis+'/'+user_id+'/'+date+'/'+catatan);
    // return;
    $("#grafik_"+performanceID).html("<div class='progress'><div class='indeterminate'></div></div>");
    $("#btnGrafik_"+performanceID).html("<i class='small mdi-editor-insert-chart' onclick='showGrafik(\""+performanceID+"\",\""+jenis+"\",\""+user_id+"\",\""+date+"\",\""+catatan+"\")'></i>");
    $.ajax({
        type : 'POST',
        url  : toUrl+'/performance/showTableAjax/'+performanceID+'/'+jenis+'/'+user_id+'/'+date+'/'+catatan,
        data : {performanceID:performanceID},
        // dataType: "json",
        success: function(data){
            // alert(data);
            $("#grafik_"+performanceID).html(data);
        },error: function(xhr, ajaxOptions, thrownError){            
            alert(xhr.responseText);
        }
    });	
}
function showGrafik(performanceID,jenis,user_id,date,catatan){
    // alert(performanceID);
    $("#grafik_"+performanceID).html("<div class='progress'><div class='indeterminate'></div></div>");
    $("#btnGrafik_"+performanceID).html("<i class='mdi-action-view-list small' onclick='showTable(\""+performanceID+"\",\""+jenis+"\",\""+user_id+"\",\""+date+"\",\""+catatan+"\")'></i>");
    var options = {
        colors: ['#FF00B2', '#293696', '#FCFC00', '#DDDF00', '#24CBE5', '#64E572', 
        '#FF9655', '#FFF263', '#6AF9C4'],
            
        chart: {
            polar: true,
            type: 'line',
            renderTo: 'grafik_'+performanceID,
        },

        title: {
            text: '',
            x: -80
        },

        pane: {
            size: '80%'
        },

        navigation: {
            buttonOptions: {
                align: "right",
                enabled: true,
            },
        },
        
        xAxis: {
            categories: [],
            tickmarkPlacement: 'on',
            lineWidth: 0
        },

        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            min: 0
        },

        tooltip: {
            shared: true,
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f}</b><br/>'
        },

        // legend: {
            // align: 'right',
            // verticalAlign: 'top',
            // y: 70,
            // layout: 'vertical'
        // },
        
        series: [{},{}]

        // series: [{
            // name: 'Achievment',
            // data: [10,10,10],
            // pointPlacement: 'on'
        // }, {
            // name: 'Goal',
            // data: [10,10,10],
            // pointPlacement: 'on'
        // },{
            // name: 'Messo',
            // data: [10,10,10],
            // pointPlacement: 'on'
        // }]
    };
    
    $.ajax({
        type : 'POST',
        url  : toUrl+'/performance/getGrafik',
        data : {performanceID:performanceID},
        dataType: "json",
        success: function(data){
            options.xAxis.categories = data.categories;
            options.series[0].name = 'Benchmark';
            options.series[0].data = data.benchmark;
            options.series[1].name = 'Current';
            options.series[1].data = data.current;
            var chart = new Highcharts.Chart(options);
        },error: function(xhr, ajaxOptions, thrownError){            
            alert(xhr.responseText);
        }
    });	
}

function deleteProfiling(performanceID) {
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
			url		: toUrl+'/performance/deleteProfiling',
            data	: {performanceID:performanceID},
			success: function(data){
				if(data == "sukses"){
					swal({
						title: 'Deleted!',
						text: 'Your Profiling Data has been deleted.',
						type: 'success',
						confirmButtonClass: "btn btn-success",
						buttonsStyling: false
					},function() {
						window.location.reload();
					});
				}else{
					swal({
						title: 'Failed',
						text: 'Failed To Delete Profiling',
						type: 'error',
						confirmButtonClass: "btn btn-info",
						buttonsStyling: false
                    })
				}
			},error: function(xhr, ajaxOptions, thrownError){            
				swal({
					title: 'Failed',
					text: 'Failed To Delete Profiling',
					type: 'error',
					confirmButtonClass: "btn btn-info",
					buttonsStyling: false
				})
			}
		});
	});
}

var i = 1;
function addKomponen() {
    //menentukan target append
    var komponenRow = document.getElementById('komponenRow');
    
    //membuat element
    var hr = document.createElement('hr');
    var row = document.createElement('div');
    row.setAttribute('class','row');
   
    //membuat button delete
    var deleteRow   = document.createElement('div');
    deleteRow.setAttribute('class','col-md-2 col-xs-2');
    deleteRow.innerHTML = '<i class="fa fa-trash fa-2x"></i>';

    //membuat form-group Komponen
    var labelKomponen   = document.createElement("label");
    labelKomponen.setAttribute('class','col-md-3 label-on-left');
    labelKomponen.appendChild(document.createTextNode('Komponen'));
    var colKomponen = document.createElement('div');
    colKomponen.setAttribute('class','col-md-7 col-xs-10');
    var komponen    = document.createElement('div');
    komponen.setAttribute('class','form-group label-floating is-empty');
    var inputKomponen   =   document.createElement("input");
    inputKomponen.setAttribute('class','form-control');
    inputKomponen.setAttribute('name','komponen['+i+']');
    inputKomponen.setAttribute('required','required');
    komponen.appendChild(inputKomponen);
    colKomponen.appendChild(komponen);

    //membuat form-group Benchmark
    var labelBenchmark   = document.createElement("label");
    labelBenchmark.setAttribute('class','col-md-3 label-on-left');
    labelBenchmark.appendChild(document.createTextNode('Benchmark'));
    var colBenchmark = document.createElement('div');
    colBenchmark.setAttribute('class','col-md-7 col-xs-10');
    var Benchmark    = document.createElement('div');
    Benchmark.setAttribute('class','form-group label-floating is-empty');
    var inputBenchmark   =   document.createElement("input");
    inputBenchmark.setAttribute('class','form-control');
    inputBenchmark.setAttribute('type','number');
    inputBenchmark.setAttribute('name','benchmark['+i+']');
    inputBenchmark.setAttribute('required','required');
    Benchmark.appendChild(inputBenchmark);
    colBenchmark.appendChild(Benchmark);

    //membuat form-group Current
    var labelCurrent   = document.createElement("label");
    labelCurrent.setAttribute('class','col-md-3 label-on-left');
    labelCurrent.appendChild(document.createTextNode('Current'));
    var colCurrent = document.createElement('div');
    colCurrent.setAttribute('class','col-md-7 col-xs-10');
    var Current    = document.createElement('div');
    Current.setAttribute('class','form-group label-floating is-empty');
    var inputCurrent   =   document.createElement("input");
    inputCurrent.setAttribute('class','form-control');
    inputCurrent.setAttribute('type','number');
    inputCurrent.setAttribute('name','current['+i+']');
    inputCurrent.setAttribute('required','required');
    Current.appendChild(inputCurrent);
    colCurrent.appendChild(Current);
    
    //membuat form-group Current
    // var labelPoint   = document.createElement("label");
    // labelPoint.setAttribute('class','col-md-3 label-on-left');
    // labelPoint.appendChild(document.createTextNode('Point Type'));

    // var colAscending = document.createElement('div');
    // colAscending.setAttribute('class','col-md-3 col-xs-5 checkbox-radios');
    // var Ascending    = document.createElement('div');
    // Ascending.setAttribute('class','radio');
    // var labelAscending  = document.createElement("label");
    // var inputAscending  =   document.createElement("input");
    // inputAscending.setAttribute('type','radio');
    // inputAscending.appendChild(document.createTextNode('Ascendning'));
    // labelAscending.appendChild(inputAscending);
    // Ascending.appendChild(labelAscending);
    // colAscending.appendChild(Ascending);


    komponenRow.appendChild(row);
    row.appendChild(hr);
    row.appendChild(labelKomponen);
    row.appendChild(colKomponen);
    row.appendChild(deleteRow);
    row.appendChild(labelBenchmark);
    row.appendChild(colBenchmark);
    row.appendChild(labelCurrent);
    row.appendChild(colCurrent);
    
    deleteRow.onclick = function () {
        row.parentNode.removeChild(row);
    };

    i++;
}