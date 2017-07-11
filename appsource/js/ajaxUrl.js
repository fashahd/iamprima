var getUrl 	= window.location;
var toUrl 	= getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
var circle  = '<div class="col s12 m12 center"><div class="preloader-wrapper big active">'
            +'<div class="spinner-layer spinner-blue-only"><div class="circle-clipper left">'
            +'<div class="circle"></div></div><div class="gap-patch"><div class="circle"></div>'
            +'</div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>';