window.addEventListener('load', ()=>{
	var iframe = document.createElement('iframe');
	iframe.src = '{{$url}}';
	iframe.style.width = '100%';
	iframe.style.height = '500px';
	document.getElementById('gsec').appendChild(iframe);
});