<body>
<div class="nobreak">
	{!!$image!!}
</div>
@if($background!==false)
	<div class="background"></div>
@endif
</body>
<style>
div.nobreak:before { clear:both; }
div.nobreak{ page-break-inside: avoid;
	/*position: relative;width: 1200px;height: 1200px;*/
  /* http://code.google.com/p/wkhtmltopdf/issues/detail?id=9#c21 */
}
	body{
		position: relative;
		margin: 0;padding: 0;
		overflow: hidden;
		/*width: 1200px;*/
		/*height: 1200px;*/
		 -webkit-box-sizing: border-box; -moz-box-sizing: border-box;
            box-sizing: border-box;
            page-break-before: avoid !important;
            page-break-before: avoid !important;
            page-break-inside: avoid !important;
	}
	svg, img{
		position: absolute;
		z-index: 2;
		/*left: 100px;*/
		/*top: 100px;*/
		/*width: 1000px;*/
		/*height: auto;*/
		/*max-height: 1000px;*/
		/*left: 50%;*/
		/*top: 50%;*/
		{{-- margin-left: -{{$width/18}}px; --}}
		{{-- margin-top: -{{$height/18}}px; --}}
		width: {{$width*4}}px;
		height: {{$height*4}}px;	
		left: 50%;
		top: 50%;
		margin-left: -{{$width*2}}px;
		margin-top: -{{$height*2}}px;
		 -webkit-box-sizing: border-box; -moz-box-sizing: border-box;
            box-sizing: border-box;
            page-break-before: avoid !important;
            page-break-before: avoid !important;
            page-break-inside: avoid !important;
	}
	.background{
		z-index: 1;
		position: absolute;
		left: 0;right: 0;top:0;bottom: 0;
		width: {{$width/7.5}}px;
		height: {{$height/7.5}}px;
		display: block;
		background: {{$background}};
		@if($radius) border-radius: 50%; @endif
		 -webkit-box-sizing: border-box; -moz-box-sizing: border-box;
            box-sizing: border-box;
            page-break-before: avoid !important;
            page-break-before: avoid !important;
            page-break-inside: avoid !important;
	}
	@if($background!==false)
		svg path, svg rect, svg polygon, svg circle, svg{
			fill: #fff !important;
			stroke: #fff !important;
		}
		svg, img{
			/*width: 700px;*/
			/*height: auto;*/
			width: {{$width/12}}px;
			height: {{$height/12}}px;
			left: 50%;
			top: 50%;
			margin-left: -{{$width/24}}px;
			margin-top: -{{$height/24}}px;
			/*max-height: 700px;*/
			/*left: 250px;*/
			/*top: 250px;*/
		}
	@endif
</style>