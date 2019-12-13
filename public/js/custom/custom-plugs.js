


// console.log( BASE_URL)
function get_url_val(url){
	var split = url.split('=');
	return split[1];
}

loadPage();
console.log(window.location.href)

function loadPage() {
   var data = window.location.href.split('/').slice(4,10);
}