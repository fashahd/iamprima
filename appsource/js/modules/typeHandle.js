var el = document.getElementById('inputSessi');

function cekValue(e) {   
	// invalid character list
	var prohibited = "0";
	// get the actual character string value
	var key = String.fromCharCode(e.which);
	// check if the key pressed is prohibited    
	if(prohibited.indexOf(key) >= 0){
		demo.showSwal("errorFormMonotony");    
		return;
	}
	return true;    
};