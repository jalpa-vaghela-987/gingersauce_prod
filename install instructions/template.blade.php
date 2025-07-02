<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	<style>
		html, body{
			margin: 0;
			padding: 0;
		}
		.page-break {
		    page-break-after: always;
		}
		div[id^="page"]{
			position: relative;
			width: 201mm !important;
			height: 201mm !important;
			margin: 0;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
			overflow: hidden;
		}
		body{
			font-family: 'Montserrat', sans-serif;
			margin: 0;
			padding: 0;
		}
		* {
		  -webkit-box-sizing: border-box;
		  box-sizing: border-box;
		  font-family: 'Montserrat', sans-serif;
		}

		.page-number{
			position: absolute;
			left: 30px;
			bottom: 30px;
			right: 30px;
			font-size: 14px;
			line-height: 25px;
			z-index: 3;
			color: #000000;
		}
		.page-number.right{
			text-align: right;
		}
		.text-white{
			color: white;
		}
		.gradient-theme #page1{
			width: 221mm;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
		    @if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
				background: -webkit-gradient(linear,left top,right bottom, color-stop(6.88%,{{$data->colors_list[0]->id}}), color-stop(96.22%, {{$data->colors_list[1]->id}}));
			@endif
			position: relative;
		}
		.gradient-theme #page1 .logo, #page13 .logo{
			width: 40%;
			height: 40%;
			position: absolute;
			left: 30%;
			top: 30%;
		}
		.gradient-theme #page1 .logo{
			display: flex;
			align-items: center;
		}
		#page13 .logo{
			width: 40%;
			height: 40%;
			position: absolute;
			left: 30%;
			top: 30%;
			 background-image: url({{$data->logo_b64}});
			background-size: contain;
			background-position: center center;
			background-repeat: no-repeat;
		}

		.gradient-theme #page1 .logo svg{
			width: 100%;
			max-height: 100%;
			height: auto;
			margin: auto;
			display: block;
		}
		.gradient-theme #page1 .logo svg path, .gradient-theme #page1 .logo svg rect, .gradient-theme #page1 .logo svg circle, .gradient-theme #page1 .logo svg line{
			fill: #fff !important;
			stroke: #fff !important;
		}
		.gradient-theme #page1 .logo-gingersauce, #page36 .logo-gingersauce{
			color: #fff;
			font-style: normal;
			font-weight: normal;
			font-size: 6px;
			line-height: 6px;
			text-align: center;
			position: absolute;
			left: 0;
			right: 0;
			bottom: 34px;
			font-size: 12px;
			line-height: 18px;
			align-content: center;
		}
		.gradient-theme #page1 .logo-gingersauce svg path, #page36 .logo-gingersauce svg path{
			fill: #fff;
		}

		.gradient-theme #page1 .small-title, #page36 .small-title{
			font-style: normal;
			font-weight: normal;
			font-size: 24px;
			line-height: 29px;
			text-align: center;
			color: #FFFFFF;
			position: absolute;
			height: 29px;
			left: 0px;
			right: 0px;
			bottom: 66px;
		}
		#page2{
			width: 221mm;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
			background: -webkit-gradient(linear,right top,left bottom, color-stop(6.29%,#93989B), color-stop(123.12%, rgba(147, 152, 155, 0)));
		}
		#page3, #page5, #page7, #page8, #page9, #page10, #page11, #page12, #page14, #page16, #page18, #page19, #page20, #page24, #page25, #page26{
			padding: 170px 90px 0;
			position: relative;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
		}
		#page11, #page14, #page15, #page16, #page17, #page23, #page25, #page26, #page27, #page28, #page29, #page30, #page31{
			padding: 90px;
		}
		#page10{
			padding-top: 440px;
		}
		#page16{
			padding-top: 500px;
		}
		#page12, #page24, #page29{
			padding-top: 340px;
		}

		#page3 .contents .content-item{
			display: -webkit-box;
			display: -webkit-flex;
			display: flex;
		}
		#page3 .contents .content-item div{
			white-space: nowrap;
			line-height: 25px;
		}
		#page3 .contents .content-item div a{
			color: #000;
			text-decoration: none;
		}
		#page3 .contents .content-item .dots{
			flex-basis: 221mm;
			-webkit-box-flex: 1;
			-webkit-flex: 1;
			flex: 1;
			border-bottom: 2px dotted #999;
			margin-top: -5px;
			margin-left: 5px;
			margin-right: 5px;
		}
		h1.title{
			position: relative;
			margin-bottom: 17px;
		}
		h1.title:after{
			content: "";
			height: 6px;
			width: 108px;
			position: absolute;
			@if(isset($data->colors_list[0]))
				background: {{$data->colors_list[0]->id}};
			@endif
			bottom: -6px;
			left: 0;
		}
		#page5 h1.title:after,#page12 h1.title:after{
			@if(isset($data->colors_list[1]))
				background: {$data->colors_list[1]->id}};
			@endif
		}
		#page5 .text, #page10 .text, #page12 .text{
			font-size: 16px;
		}
		#page7 h1.title:after{
			background: #fff;
		}
		#page7 .text,#page8 .text{
			font-size: 28px;
		}
		#page7 h1.title{
			color: #fff;
			z-index: 3;
		}
		#page6, #page17, #page18{
			width: 221mm;
			position: relative;
			height: 221mm;
			-webkit-box-sizing: border-box;
		  box-sizing: border-box;
			overflow: hidden;
		}
		#page6 .gradient-block{
			width: 442mm;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
		    @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
				background: -webkit-gradient(linear,left top,right top, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));
			@else
				background: #ccc;
			@endif
		}
		#page12 .gradient-block{
			width: 221mm;
			position: absolute;
			z-index: 1;
			left: 0;
			top: 0;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
		    @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
				background: -webkit-gradient(linear,right top,left bottom, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));
			@endif
		}
		#page7{
			width: 221mm;
			position: relative;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
			overflow: hidden;
		}
		#page7 .gradient-block{
			width: 442mm;
			position: absolute;
			left: -221mm;
			top: 0;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
		    @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
				background: -webkit-gradient(linear,left top,right top, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));
			@endif
			z-index: 1;
		}
		#page7 .text{
			position: relative;
			z-index: 3;
		}
		#page4{
			position: relative;
			height: 221mm;
			-webkit-box-sizing: border-box;
		    box-sizing: border-box;
		}
		#page4 .gradient-block{
			position: absolute;
			display: block;
			left: 1px;
			top: 1px;
			height: 58px;
			width: 61%;
			@if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
				background: -webkit-gradient(linear,left top,right top, color-stop(24.97%,{{$data->colors_list[0]->id}}), color-stop(109.96%, {{$data->colors_list[1]->id}}));
			@endif
		}
		#page9 .gradient-block{
			position: absolute;
			right: 0;
			bottom: 0;
			width: 20mm;
			height: 20mm;
			@if(isset($data->colors_list[0]))
				background: -webkit-gradient(linear,left top,left bottom, color-stop(0%,{{$data->colors_list[0]->id}}), color-stop(109.96%, #fff));
			@endif
		}
		#page28 .gradient{
			left: 0;
			top: 0;
			position: absolute;
			width: 221mm;
			height: 221mm;
			z-index: 0;
			@if(isset($data->colors_list[1]))
				background: -webkit-gradient(linear,left top,right bottom, color-stop(0%,#fff), color-stop(109.96%, {{$data->colors_list[1]->id}}));
			@endif
		}
		#page10 .gradient-block{
			@if(isset($data->colors_list[1]) )
				background: -webkit-gradient(linear,left bottom,left top, color-stop(0%,{$data->colors_list[1]->id}}), color-stop(109.96%, #fff));
			@endif
			width: 20mm;
			height: 60mm;
			position: absolute;
			left: 0;
			top: 0;
		}
		#page11 .core-values{
			display: -webkit-box;
			display: -webkit-flex;
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
		}
		#page11 .core-values .core-value{
			flex-basis: 70mm;
			width: 70mm;
			float: left;
			padding-bottom: 10px;
			margin-bottom: 20px;
			height: 49mm;
			@if(isset($data->colors_list[0]))
				border-bottom: 3px solid {{$data->colors_list[0]->id}};
			@endif
		}
		#page11 .core-values .core-value .img{
			display: block;
			width: 10mm;
			height: 10mm;
			margin-bottom: 10px;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}
		#page11 .core-values .core-value .title{
			font-weight: 800;
			font-size: 18px;
			line-height: 22px;
			margin-bottom: 10px;
		}
		#page11 .core-values .core-value div{
			font-weight: normal;
			font-size: 12px;
			line-height: 20px;
			position: relative;
		}
		#page12 .title, #page12 .text{
			position: relative;z-index: 3;
		}
		#page13, #page14, #page15{
			width: 221mm;
			height: 221mm;
			position: relative;
		}
		#page13 .text{
			width: 100%;
			text-align: center;
			position: absolute;
			left: 0;
			top: 70%;
		}
		#page13 .text p{
			text-align: center;
		}
		#page14 .logo-versions{
			margin-top: 100px;
		}
		.logo-versions .logo-version{
			width: 50%;
			float: left;
		}
		.logo-versions .logo-version .logo-img{
			height: 100%;
			width: 70%;
			background-size: contain;
			background-repeat: no-repeat;
			display: inline-block;
			background-position: top center;
			height: 100px;
			margin-bottom: 20px;
		}
		.logo-versions .logo-version .logo-title{
			text-align: center;
			font-size: 12px;
			line-height: 25px;
			width: 70%;
			padding-top: 40px;
		}
		.logo-versions .logo-version.version1{
			float: right;
			text-align: right;
		}
		.logo-versions .logo-version.version1 .logo-title{
			float: right;
		}
		#page15 .logo-versions .logo-version{
			position: absolute;
			top: 0;
			bottom: 0;
			padding-top: 50%;
		}
		#page15 .logo-versions .logo-version.version2{
			left: 0;
			right: 50%;
			margin-top: -50px;
		}
		#page15{
			overflow: hidden;
		}
		#page15 .logo-versions .logo-version.version3{
			right: -1%;
			left: 50%;
			width: 51%;
			margin-top: -50px;
			text-align: right;
		}
		#page15 .logo-versions .logo-version .logo-img,#page15 .logo-versions .logo-version .logo-title{
			width: 100%;
		}
		#page16, #page17{
			position: relative;
		}
		#page16 .favicon{
			position: absolute;
			top: 50%;
			margin-top: -100px;
			margin-left: -100px;
			left: 50%;
			width: 200px;
			height: 200px;
			padding: 20px;
		}
		#page17 .favicons{
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
		}
		#page17 .favicon{
			position: relative;
			width: 100%;
			height: 200px;
			text-align: center;
			padding: 10px;
			display: inline-block;
			flex-basis: 40%;
		    justify-content: center;
		    text-align: center;
		}
		#page17 .favicon.first{
			margin-left: -60px;
		}
		#page17 .favicon.second{
			margin-left: 60px;
		}
		#page17 .favicon:nth-child(2n){
			margin-left: -60px;
		}
		#page17 .favicon:nth-child(2n+1){
			margin-left: 60px;
		}
		#page16 .favicon .logo-img, #page17 .favicon .logo-img{
			height: 70px;
			width: 70px;
			margin-left: 50px;
			background-size: contain;
			background-position: center;
			background-repeat: no-repeat;
		}

		#page17 .favicon{
			height: 200px;
			width: 100px;
		}

		#page17 .favicon .logo-img{
			padding: 10px;
			display: block;
		    margin: 0 auto;
		}
		#page17{
			position: relative;
		}
		#page17 .favicon{

		}
		#page17 .favicon .logo-img .image{
			width: 50px;
			height: 50px;
		}

		#page16 .favicon .logo-title, #page17 .favicon .logo-title{
			text-align: center;
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
			line-height: 25px;

			text-align: center;

			color: #000000;
			margin-top: 20px;
			width: 100%;
		}
		#page17 .favicon .logo-title{

		}
		#page18 .background{
			position: absolute;
			left: 0;
			z-index: 1;
			bottom: 0;
		}
		#page18{
			padding-top: 100px;
		}
		#page19, #page21{
			padding-top: 90px;
		}
		#page19 .logo, #page19 .icon,#page21 .logo, #page21 .icon{
			border: 1px solid #DADADA;
		}
		#page19 .logo, #page21 .logo{
			width: 300px;
			height: 200px;
			position: absolute;
			left: 30%;
			top: 120px;
			background-size: contain;
			background-position: center center;
			background-repeat: no-repeat;
		}
		#page21 .logo{
			width: {{$data->logo_w}}px;
			height: {{$data->logo_h}}px;
			left: 50%;
			margin-left: -{{$data->logo_w/2}}px;
		}
		#page25 .logo-image{
			width: 100%;
			height: 100px;
			background-size: contain;
			background-position: center center;
			background-repeat: no-repeat;
		}
		#page23 .logo{
			margin-top: 60px;
			left: 0;
			margin-left: 0;
			background-size: contain;
			background-position: left;
			background-repeat: no-repeat;
			width: 300px;
			height: 100px;
			border-bottom: 1px solid #999999;
			position: relative;
			padding-bottom: 20px;
		}
		#page23 .icon{
			margin-top: 40px;
			left: 0;
			margin-left: 0;
			background-size: contain;
			background-position: left;
			background-repeat: no-repeat;
			width: 70px;
			height: 70px;
			border-bottom: 1px solid #999999;
			position: relative;
			padding-bottom: 20px;
		}

		#page23 .logo_after .first, #page23 .icon_after .first{
			float: left;
			margin-left: -9px;
		}
		#page23 .logo_after{
			width: 300px;
		}
		#page23 .icon_after{
			width: 70px;
		}
		#page23 .logo_after .last, #page23 .icon_after .last{
			margin-right: -9px;
			float: right;
		}
		#page23 .logo_after .text{
			width: 280px;
			float: left;
			line-height: 51px;
			text-align: center;
			font-style: normal;
			font-weight: 500;
			font-size: 14px;

			text-align: center;

			color: #797979;
		}

		#page19 .logo{
			left: 50%;
			margin-left: -{{($data->logo_w+20)/2}}px;
		}
		#page19 .icon, #page21 .icon{
			width: 70px;
			height: 70px;
			position: absolute;
			left: 50%;
			margin-left: -35px;
			bottom: 180px;
		}
		#page19 .icon .logo-image, #page19 .logo .logo-image, #page21 .icon .logo-image, #page21 .logo .logo-image, #page23 .logo .logo-image, #page23 .icon .logo-image, #page25 .logo .logo-image{
			background-size: contain;
			background-position: center;
			background-repeat: no-repeat;
			width: 100%;
			height: 100%;
		}
		#page20 .text-explain{
			margin-top: 200px;
			line-height: 49px;
		}
		#page20 .text-explain .texted, #page20 .text-explain .icon{
			display: inline-block;
			line-height: 49px;
			vertical-align: middle;
		}
		#page20 .text-explain .texted{
			font-style: normal;
			font-weight: bold;
			margin-right: 10px;
			font-size: 28px;
			line-height: 49px;
			height: 49px;
			color: #000000;
		}
		#page20 .text-explain .icon{
			width: 49px;
			height: 49px;
			background-size: contain;
			background-position: center;
			background-repeat: no-repeat;
			background-image: url({{$data->icon_b64}});
		}
		#page20 .text-explain .description{
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
			line-height: 18px;
			color: #000000;
		}
		#page21 .logo-pre{
			position: absolute;
			left: -30px;
			right: -30px;
			top: -30px;
			border-top: 1px solid #dadada;
		}
		#page21 .logo-post{
			position: absolute;
			left: -30px;
			bottom: -30px;
			right: -30px;
			border-bottom: 1px solid #dadada;
		}
		#page21 .logo-pre .left, #page21 .logo-post .left{
			float: left;
			filter: grayscale(1);
		}
		#page21 .logo-post .left{
			position: relative;
		}
		#page21 .logo-post .left:before{
			height: {{$data->logo_h}}px;
			border-left: 1px solid #adadad;
			content: "";
			position: absolute;
			left: -1px;
			top: -{{$data->logo_h}}px;
		}

		#page21 .logo-pre .right:after{
			height: {{$data->logo_h}}px;
			border-left: 1px solid #adadad;
			content: "";
			position: absolute;
			right: 0;
			top: var(--y);
		}

		#page21 .logo-pre .left, #page21 .logo-post .right{
			position: relative;
		}
		#page21 .logo-pre .left:before{
			content: attr(data-x);
			background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACIAAAA0CAMAAADYFhp2AAAAPFBMVEUAAAD////39/fw8PDv7+/n5+ff39/X19fPz8/Hx8e/v7+4uLi3t7ewsLCoqKigoKCYmJiQkJCIiIiAgIAMSASWAAAAE3RSTlMAABAfIDBAUGBwgI+Qn6+/z9/v6yM3JQAAAG5JREFUeAHt1asCQjEMg2FaxrnsDMb6v/+74hGNANnoT2wR6e2fMTu6mSJDkteSJLgLssEpyIApyBvCU9IAtpTsK2J18aOuqytSpEiR73i7ruYpOQB6SlwPmU1Y4rknPAV5wK4H3hUZU1+S+UO7H7xHBud4jq8yAAAAAElFTkSuQmCC);
			position: absolute;
		    left: -34px;
		    width: 55px;
		    height: 30px;
		    background-repeat: no-repeat;
		    background-size: contain;
		    top: -1px;
		    background-position-x: 15px;
		    line-height: 30px;
		    font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 177.5%;
			color: #797979;
			height: 100%;
		    border-bottom: 1px solid;
		    border-top: 1px solid;
		    width: 34px;
		    background-size: cover;
			display: flex;
			align-items: center;
		}
		#page21 .logo-pre .right{
			border-right: 1px solid #dadada;
		}

		#page21 .logo-pre .left:after{
			content: attr(data-y);
			background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAhCAMAAACsowi2AAAAM1BMVEUAAAD////39/fv7+/n5+ff39/X19fPz8/Hx8e4uLi3t7ewsLCvr6+goKCQkJCIiIiAgIDgn7TpAAAAEHRSTlMAABAgMEBQYHCPkJ+gv9/vxbFLXQAAAFRJREFUeAHtz0sOgCAMhGHLWxGY+5/WFOq2utSk336Sf7YPI+YL6UqgaU1c3DtAOqDX5GTSBljVYWp5TTBlHdhoRcLS+SrsiHcYsfB438t9Y4z5vQvHtwW2elcEMwAAAABJRU5ErkJggg==);
			position: absolute;
		    left: -1px;
		    width: 30px;
		    height: 50px;
		    background-repeat: no-repeat;
		    background-size: contain;
		    top: -38px;
		    background-position-y: 20px;
		    line-height: 30px;
		    font-style: normal;
		    font-weight: 500;
		    font-size: 14px;
		    line-height: 177.5%;
		    color: #797979;
		    text-align: center;
		    border-left: 1px solid;
		    border-right: 1px solid;
		    width: 100%;
		    height: 36px;
		    background-size: cover;
		}
		#page21 .logo-pre .right, #page21 .logo-post .right{
			float: right;
			filter: grayscale(1);
		}
		#page21 .logo-pre .left, #page21 .logo-pre .right, #page21 .logo-post .left, #page21 .logo-post .right{
			width: 30px;
			height: 30px;
			background-size: contain;
			background-position: center;
			background-repeat: no-repeat;
			background-image: url(data:image/svg+xml;base64,{{base64_encode(preg_replace('/(#[0-9a-zA-Z]{3,6})/m', '#000', $data->icon))}});
			opacity: .5;
			border: 1px solid #adadad;
		}
		#page21 .icon-pre{
			position: absolute;
			left: -30px;
			top: -30px;
			right: -30px;
			height: 30px;
			border-top: 1px solid #dadada;
		}
		#page21 .logo{
			margin-right: 10px;
		}
		#page21 .icon-pre:before{
			height: 70px;
			content: "";
			border-left: 1px solid #dadada;
			position: absolute;
			top: 30px;
		}
		#page21 .icon-pre div{
			margin-top: -1px;
		}
		#page21 .icon-post:before{
			height: 70px;
			content: "";
			border-left: 1px solid #dadada;
			position: absolute;
			bottom: 30px;
			right: 0;
		}
		#page21 .icon-post{
			position: absolute;
			left: -30px;
			right: -30px;
			bottom: -30px;
			border-bottom: 1px solid #dadada;
			height: 30px;
		}
		#page21 .icon-post .left, #page21 .icon-pre .left{
			height: 30px;
			width: 30px;
			border: 1px solid #dadada;
			content: "x";
			color: #dadada;
			font-size: 14px;
			text-align: center;
			line-height: 30px;
			float: left;
		}
		#page21 .icon-post .right, #page21 .icon-pre .right{
			height: 30px;
			width: 30px;
			border: 1px solid #dadada;
			color: #dadada;
			font-size: 14px;
			text-align: center;
			line-height: 30px;
			float: right;
		}
		#page22{
			background: -webkit-gradient(linear,left top,left bottom, color-stop(-1.27%,rgba(147, 152, 155, 0.08)), color-stop(90.37%, rgba(147, 152, 155, 0.37)));
		}
		#page22 .background{
			position: absolute;
			left: 0;
			top: 0;
		}
		#page23 .description{
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
			line-height: 18px;
			clear: both;
			color: #000000;
		}
		#page24 .gradient{
			position: absolute;
			z-index: 0;
			left: 0;
			top: 0;
			right: 0;
			bottom: 0;
			@if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
			background: -webkit-gradient(linear,left top,right bottom, color-stop(0%,{{$data->colors_list[0]->id}}), color-stop(100%, {{$data->colors_list[1]->id}}));
			@endif
		}
		#page24 h1, #page24 .text{
			position: relative;
			z-index: 3;
		}
		#page24 .line{
			position: absolute;
			width: 836.55px;
			height: 0px;
			left: -100px;
			top: 385px;
			@if(isset($data->colors_list[0]))
			border: 14px solid rgba({{$data->colors_list[0]->color->rgb->r}}, {{$data->colors_list[0]->color->rgb->g}}, {{$data->colors_list[0]->color->rgb->b}}, 0.5);
			@endif
			box-sizing: border-box;
			-webkit-transform: rotate(144.65deg);
		}
		#page25 .rejected_item{
			float: left;
			width: 50%;
			margin-bottom: 20px;
			position: relative;
			padding-left: 10mm;
			padding-right: 10mm;
				height: 40mm;
		}
		#page25 .rejected_item svg{
			max-width: 100%;
		}
		#page25 .rejected_item .title{
			text-align: center;
			margin-top: 10px;
			font-size: 12px;
		}
		#page25 .rejected_item .line{
			border: 1px solid #FF0000;
			position: absolute;
			z-index: 3;
			left: 50%;
			top: 40px;
			width: 172px;
			margin-left: -86px;
			-webkit-transform: rotate(144.65deg);
		}
		#page26 .text-small{
			position: absolute;
			bottom: 90px;
			left: 90px;
			right: 90px;
			font-size: 12px;
		}
		#page26 .color-line{
			width: 70%;
			left: 15%;
			position: absolute;
			top: 50%;
			height: 100px;
			margin-top: -50px;
		}
		#page26 .color-line .line{
			height: 10px;
		}
		#page26 .color-line .line div{
			height: 100%;
			float: left;
		}
		#page26 .color-line .line div.p1{
			width: 5%;
			@if(isset($data->colors_list[0]))
			background-color: rgba({{$data->colors_list[0]->color->rgb->r}}, {{$data->colors_list[0]->color->rgb->g}}, {{$data->colors_list[0]->color->rgb->b}}, 0.5);
			@endif
		}
		#page26 .color-line .line div.p2{
			width: 5%;
			@if(isset($data->colors_list[0]))
			background-color: rgba({{$data->colors_list[0]->color->rgb->r}}, {{$data->colors_list[0]->color->rgb->g}}, {{$data->colors_list[0]->color->rgb->b}}, 0.8);
			@endif
		}
		#page26 .color-line .line div.p3{
			width: 30%;
			@if(isset($data->colors_list[0]))
			background-color: rgba({{$data->colors_list[0]->color->rgb->r}}, {{$data->colors_list[0]->color->rgb->g}}, {{$data->colors_list[0]->color->rgb->b}}, 1);
			@endif
		}
		#page26 .color-line .line div.p4{
			width: 5%;
			@if(isset($data->colors_list[1]))
			background-color: rgba({{$data->colors_list[1]->color->rgb->r}}, {{$data->colors_list[1]->color->rgb->g}}, {{$data->colors_list[1]->color->rgb->b}}, 0.5);
			@endif
		}
		#page26 .color-line .line div.p5{
			width: 5%;
			@if(isset($data->colors_list[1]))
			background-color: rgba({{$data->colors_list[1]->color->rgb->r}}, {{$data->colors_list[1]->color->rgb->g}}, {{$data->colors_list[1]->color->rgb->b}}, 0.8);
			@endif
		}
		#page26 .color-line .line div.p6{
			width: 25%;
			@if(isset($data->colors_list[1]))
			background-color: rgba({{$data->colors_list[1]->color->rgb->r}}, {{$data->colors_list[1]->color->rgb->g}}, {{$data->colors_list[1]->color->rgb->b}}, 1);
			@endif
		}
		#page26 .color-line .line div.p7{
			width: 5%;
			@if(isset($data->colors_list[2]))
			background-color: rgba({{$data->colors_list[2]->color->rgb->r}}, {{$data->colors_list[2]->color->rgb->g}}, {{$data->colors_list[2]->color->rgb->b}}, .5);
			@endif
		}
		#page26 .color-line .line div.p8{
			width: 5%;
			@if(isset($data->colors_list[0]))
			background-color: rgba({{$data->colors_list[2]->color->rgb->r}}, {{$data->colors_list[2]->color->rgb->g}}, {{$data->colors_list[2]->color->rgb->b}}, .8);
			@endif
		}
		#page26 .color-line .line div.p9{
			width: 15%;
			@if(isset($data->colors_list[0]))
			background-color: rgba({{$data->colors_list[2]->color->rgb->r}}, {{$data->colors_list[2]->color->rgb->g}}, {{$data->colors_list[2]->color->rgb->b}}, 1);
			@endif
		}
		#page26 .description{
			padding-top: 10px;
		}
		#page26 .description .textual-block{
			float: left;
			padding-right: 10px;
			overflow: hidden;
			font-size: 14px;
		}
		#page26 .description .textual-block .color-code{
			color: #adadad;
		}
		#page26 .description .textual-block.first{
			width: 40%;
		}
		#page26 .description .textual-block.second{
			width: 35%;
		}
		#page26 .description .textual-block.third{
			width: 25%;
		}
		#page26 .description .textual-block svg{
			margin-right: 10px;
		}
		#page27 .color-block {
			position: relative;
			width: 50%;
			float: left;
			text-align: center;
		}
		#page27 .color-block .title{
			margin-bottom: 10px;
		}
		#page27 .color-block .color-title{
			position: absolute;
			font-size: 10px;
			text-align: left;
			left: 10px;
			width: 120px;
		}
		#page27 .color-block .color-title.ct1{
			top: 38px;
		}
		#page27 .color-block .color-title.ct2{
			top: 78px;
		}
		#page27 .color-block .color-title.ct3{
			top: 119px;
		}
		#page27 .color-block .color-title.ct4{
			top: 161px;
		}
		#page27 .color-description-block {
			margin-top: 20px;
			margin-bottom: 50px;
		}
		#page27 .color-description-block .key-value{
			clear: both;
		}
		#page27 .color-description-block .key-value .key{
			float: left;
			font-style: normal;
			font-weight: normal;
			font-size: 10px;
			line-height: 20px;
			/* or 200% */
			width: 50%;
			text-align: left;
			padding-left: 10px;
			color: #999999;
		}
		#page27 .color-description-block .key-value .value{
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
			line-height: 20px;
			/* or 167% */
			text-align: left;
			width: 50%;
			float: left;
			color: #000000;
		}
		@foreach($data->fonts_main as $font_m)
			@font-face {
				font-display: swap;
				@if(isset($font_m['index']))
				font-family: "main{{$font_m['index']}}";
				@else
				font-family: "main1";
				@endif
				src: url("{{$font_m['font']}}");
			}
		@endforeach
		@foreach($data->fonts_secondary as $font_m)
			@font-face {
				font-display: swap;
				@if(isset($font_m['index']))
				font-family: "second{{$font_m['index']}}";
				@else
				font-family: "second1";
				@endif
				src: url("{{$font_m['font']}}");
			}
		@endforeach
		#page28 .huge-text, #page28 .huge-number{
			z-index: 2;
			border-bottom: 2px solid;
			position: absolute;
			left: 45px;
			top: 45px;
			font-size: 85px;
			line-height: 85px;
			right: 45px;
		}
		#page28 .huge-number{
			left: 50%;
			top: auto;
			bottom: 45px;
			right: 45px;
			font-size: 53px;
			line-height: 53px;
			text-align: right;
		}
		#page28 .huge-text small, #page28 .huge-number small{
			display: block;
			font-style: normal;
			font-weight: bold;
			font-size: 12px;
			line-height: 12px;
			position: absolute;
			right: 0;
			white-space: nowrap;
			bottom: 10px;
		}
		#page28 .huge-number small{
			right: auto;
			left: 0;
			text-align: left;
		}
		#page28 .huge-text.text-three, #page28 .huge-number.text-three{
			z-index: 5;
			@if(isset($data->colors_list[0]))
			color: {{$data->colors_list[0]->id}};
			border-color: {{$data->colors_list[0]->id}};
			@endif
			font-family: "main1";
		}
		#page28 .huge-text.text-two, #page28 .huge-number.text-two{
			z-index: 4;
			@if(isset($data->colors_list[2]))
			color: {{$data->colors_list[2]->id}};
			border-color: {{$data->colors_list[2]->id}};
			@endif
			font-family: "main2";
		}
		#page28 .huge-text.text-one, #page28 .huge-number.text-one{
			z-index: 3;
			@if(isset($data->colors_list[3]))
			color: {{$data->colors_list[3]->id}};
			border-color: {{$data->colors_list[3]->id}};
			@endif
			font-family: "main3";
		}
		#page28 .huge-number.text-two{
			bottom: 115px;
			left: 30%;
		}
		#page28 .huge-number.text-one{
			bottom: 185px;
			left: 50%;
		}
		#page28 .huge-number.text-three{
			bottom: 45px;
			left: 20%;
		}
		.fonts2-title{
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
			line-height: 14px;
			color: #000000;
		}
		.gradient-line{
			height: 10px;
			width: 80%;
			@if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
			background: -webkit-gradient(linear,left top,right bottom, color-stop(6.88%,{{$data->colors_list[0]->id}}), color-stop(96.22%, {{$data->colors_list[1]->id}}));
			@endif
			margin-top: 10px;
			margin-bottom: 10px;
		}
		.fonts2-weight{
			line-height: 26px;
			margin-bottom: 20px;
		}
		.fonts2-weight em{
			font-size: 16px;
			color: #777;
		}
		.fonts2-fontname{
			margin-top: 10px;
			margin-bottom: 15px;
			font-size: 20px;
			font-weight: bold;
		}
		#page30 p, #page31 p{
			margin-bottom: 0 !important;
			margin-top: 0;
			font-size: 16px;
			color: #777;
		}
		#page30 .fonts2-weight.font-1 p{
			font-family: "main1";
		}
		#page30 .fonts2-weight.font-2 p{
			font-family: "main2";
		}
		#page30 .fonts2-weight.font-3 p{
			font-family: "main3";
		}
		#page31 .fonts2-weight.font-1 p{
			font-family: "second1";
		}
		#page31 .fonts2-weight.font-2 p{
			font-family: "second2";
		}
		#page31 .fonts2-weight.font-3 p{
			font-family: "second3";
		}
		#page32{
			overflow: hidden;
			padding: 90px;
			padding-top: 400px;
		}
		#page33{
			overflow: hidden;
		}
		#page32 .gradient{
			width: 442mm;
			height: 221mm;
			@if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
			background: -webkit-gradient(linear,left bottom,right top, color-stop(6.88%,{{$data->colors_list[0]->id}}), color-stop(96.22%, {{$data->colors_list[1]->id}}));
			@endif
			position: absolute;
			z-index: 1;
			left: 0;
			top: 0;
		}
		#page33 .gradient{
			width: 442mm;
			height: 221mm;
			@if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
			background: -webkit-gradient(linear,left bottom,right top, color-stop(6.88%,{{$data->colors_list[0]->id}}), color-stop(96.22%, {{$data->colors_list[1]->id}}));
			@endif
			position: absolute;
			z-index: 1;
			left: -221mm;
			top: 0;
		}
		#page32 .user-info{
			position: relative;
			z-index: 3;
			margin-bottom: 20px;
			font-size: 14px;
		}
		#page32 .user-info .image{
			width: 66px;
			height: 66px;
			border: 3px solid rgba(255, 255, 255, 0.7);
			-webkit-box-sizing: border-box;
			-webkit-border-radius: 116.5px;
			float: left;
			margin-right: 10px;

		}
		#page32 .user-info .name{
			color: #fff;
			font-weight: bold;
			padding-top: 15px;
		}
		#page32 .user-info .position{
			color: #fff;
		}
		#page32 h1.title:after{
			background: #fff;
		}
		#page32 h1.title{
			margin-bottom: 20px;
		}
		#page32 .user-info .image img{
			width: 60px;
			height: 60px;
			display: block;
			border-radius: 116.5px;
		}
		#page32 .company, #page32 h1.title, #page32 .text{
			position: relative;
			z-index: 3;
		}
		#page32 .text{
			font-size: 12px;
		}
		#page32 .company{
			margin-top: 20px;
		}
		#page32 .company .company-logo{
			float: left;
			margin-right: 50px;
		}
		#page32 .company p{
			margin-bottom: 0;
			margin-top: 0;
			font-size: 11px;
			color: #fff;
		}
		#page32 .company .web{
			float: left;
			margin-right: 50px;
		}
		#page32 .company .contact{
			float: left;
		}
		#page34{
			padding: 90px;
			padding-top: 300px;
		}
		#page34 .text-center{
			text-align: center;
		}
		#page34 p{
			font-size: 14px;
			line-height: 14px;
			color: #000000;
		}
		#page34 .logo-gingersauce{
			font-size: 14px;
			color: #797979;
			margin-top: 20px;
		}
		#page34 .company-logo{
			margin-top: 20px;
			max-width: 200px;
			margin: 20px auto 0;
		}
		#page34 .company-logo img{
			width: 100%;
		}
		#page34 .logo-gingersauce svg path{
			fill: #797979;
		}
		#page35 .gradient{
			width: 221mm;
			height: 221mm;
			position: absolute;
			z-index: 1;
			left: 0;
			top: 0;
			@if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
			background: -webkit-gradient(linear,left top,right bottom, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, #fff));
			@endif
		}
		#page36 .gradient{
			width: 221mm;
			height: 221mm;
			position: absolute;
			z-index: 1;
			left: 0;
			top: 0;
			@if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
			background: -webkit-gradient(linear,left top,right bottom, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));
			@endif
		}
		#page36 .small-title, #page36 .logo-gingersauce{
			position: absolute;
			text-align: center;
			display: block;
			z-index: 2;
		}
	</style>
</head>
<body>
<div class="gradient-theme">
	<div id="page1">
		<div class="logo">
			{!!$data->logo!!}
		</div>
		<div class="small-title">
			{{$data->brand}} Brand Book
		</div>
		<div class="logo-gingersauce"><svg width="14" height="14" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"/></svg> Powered by gingersauce</div>
	</div>
	<div class="page-break"></div>
	<div id="page2"></div>
	<div class="page-break"></div>
	<div id="page3">
		<div class="page-number right">3</div>
		<h1 class="title">Contents</h1>
		<div class="contents">
			<div class="content-item">
				<div><a -href="#Introduction">Introduction</a></div>
				<div class="dots"></div>
				<div class="page">5</div>
			</div>
			<div class="content-item">
				<div><a -href="#Vision">Vision</a></div>
				<div class="dots"></div>
				<div class="page">7</div>
			</div>
			<div class="content-item">
				<div><a -href="#Mission">Mission</a></div>
				<div class="dots"></div>
				<div class="page">8</div>
			</div>
			<div class="content-item">
				<div><a -href="#Core Values">Core Values</a></div>
				<div class="dots"></div>
				<div class="page">10</div>
			</div>
			<div class="content-item">
				<div><a -href="#Our Logo">Our Logo</a></div>
				<div class="dots"></div>
				<div class="page">12</div>
			</div>
			<div class="content-item">
				<div><a -href="#Logo Versions">Logo Versions</a></div>
				<div class="dots"></div>
				<div class="page">14</div>
			</div>
			<div class="content-item">
				<div><a -href="#Icon & Favicon">Icon & Favicon</a></div>
				<div class="dots"></div>
				<div class="page">16</div>
			</div>
			<div class="content-item">
				<div><a -href="#Proportions">Proportions</a></div>
				<div class="dots"></div>
				<div class="page">18</div>
			</div>
			<div class="content-item">
				<div><a -href="#Clear Space">Clear Space</a></div>
				<div class="dots"></div>
				<div class="page">20</div>
			</div>
			<div class="content-item">
				<div><a -href="#Minimum Size">Minimum Size</a></div>
				<div class="dots"></div>
				<div class="page">23</div>
			</div>
			<div class="content-item">
				<div><a -href="#Logo Misuse">Logo Misuse</a></div>
				<div class="dots"></div>
				<div class="page">24</div>
			</div>
			<div class="content-item">
				<div><a -href="#Color Pallete">Color Pallete</a></div>
				<div class="dots"></div>
				<div class="page">26</div>
			</div>
			<div class="content-item">
				<div><a -href="#Our Fonts">Our Fonts</a></div>
				<div class="dots"></div>
				<div class="page">28</div>
			</div>
			<div class="content-item">
				<div><a -href="#Brandbook designer">Brandbook designer</a></div>
				<div class="dots"></div>
				<div class="page">32</div>
			</div>
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page4">
		<div class="page-number">4</div>
		<div class="gradient-block"></div>
	</div>
	<div class="page-break"></div>
	<div id="page5">
		<div class="page-number right" id="Introduction">5</div>

		<h1 class="title" contenteditable="true" data-title-field="introduction_title">{{!empty($data->introduction_title) ? $data->introduction_title : 'Introduction'}}</h1>
		<div class="text" id="edit-1" data-field="introduction_text">
			@if(!empty($data->introduction_text))
				{!!$data->introduction_text!!}
			@else
				<p>
					Welcome to the official brand guidelines of the {{$data->brand}} brand and assets. This document is intended to educate anyone who is responsible for creating internal or external communications using the {{$data->brand}} brand.
				</p>
				<p>
					It is important that we all share a basic understanding of how and when to use our identity. These Identity Standards are intended to introduce you to the basic usage. We want to make it easy for you to integrate {{$data->brand}} in all media formats while respecting our brand and legal/licensing restrictions.
				</p>
				<p>
					Note that by using these resources, you accept our Terms of Service. Usage of these resources may also be covered by the {{$data->brand}} End User Agreement and our Privacy Policy.
				</p>
			@endif
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page6">
		<div class="page-number text-white">6</div>
		<div class="gradient-block"></div>
	</div>
	<div class="page-break"></div>
	<div id="page7">
		<div class="page-number right text-white" id="Vision">7</div>
		<div class="gradient-block"></div>
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="vision_title)">{{!empty($data->vision_title) ? $data->vision_title : 'Vision'}}</h1>
		<div class="text text-white" data-field="vision_text">
			@if(!empty($data->introduction_text))
				{!!$data->vision_text!!}
			@else
				<p>
					{!!nl2br($data->vision)!!}
				</p>
			@endif
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page8">
		<div class="page-number" id="Mission">8</div>
		<div class="gradient-block"></div>
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="mission_title)">{{!empty($data->mission_title) ? $data->mission_title : 'Mission'}}</h1>
		<div class="text" data-field="mission_text">
			@if(!empty($data->mission_text))
				{!!$data->mission_text!!}
			@else
				<p>
					{!!nl2br($data->mission)!!}
				</p>
			@endif
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page9">
		<div class="page-number right text-white">9</div>
		<div class="gradient-block"></div>
	</div>
	<div class="page-break"></div>
	<div id="page10">
		<div class="page-number" id="Core Values">10</div>
		<div class="gradient-block"></div>
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="core_title">{{!empty($data->core_title) ? $data->core_title : 'Core Values'}}</h1>
		<div class="text" data-field="core_text">
			@if(!empty($data->core_text))
				{!!$data->core_text!!}
			@else
				<p>
					Company values matter. Every successful company has a set of company values to assist their employees in achieving their goals as well as the company`s. They are the essence of the company`s identity and summarises the purpose of their existence. Company values are a guide on how the company should run and they are normally integrated in the company`s mission statement. Companies should try to establish their company values as a team instead of just the leader or management. By doing so, everyone in the company would feel belong and they would feel needed and not neglected.
				</p>
			@endif
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page11">
		<div class="page-number right">11</div>
		<div class="core-values">
			{{--@foreach(is_array(json_decode($data->core_values, true)) ? json_decode($data->core_values, true) : collect([])  as $core_value)--}}
			{{-- {{dd($data->core_values)}} --}}
			@foreach($data->core_values as  $core_value)
				<div class="core-value">
					<div class="img" style="background-image: url({{$core_value['image']}})"></div>
					<div class="title">{{$core_value['title']}}</div>
					<div class="text">{{$core_value['description']}}</div>
				</div>
			@endforeach
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page12">
		<div class="page-number text-white" id="Our Logo">12</div>
		<div class="gradient-block"></div>
		<h1 class="title text-white" contenteditable="true" @blur="title_changed()" data-title)-field="logo_title">{{!empty($data->logo_title) ? $data->logo_title : 'Our Logo'}}</h1>
		<div class="text text-white" data-field="logo_text">
			@if(!empty($data->logo_text))
				{!!$data->logo_text!!}
			@else
				<p>
					We are very proud of our logo, and we require that you follow these guidelines to ensure it always looks its best.
				</p>
			@endif
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page13">
		<div class="page-number right" >13</div>
		<div class="logo"></div>
		<div class="text">
			<p>
				Masterbrand logo & slogan
			</p>
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page14">
		<div class="page-number" id="Logo Versions">14</div>
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="versions_title)">{{!empty($data->versions_title) ? $data->versions_title :'Logo Versions'}}</h1>
		<div class="text" data-field="versions_text">
			@if(!empty($data->versions_text))
				{!!$data->versions_text!!}
			@else
				<p>
					The {{$data->brand}} Logo should be used mostly with the @if(isset($data->colors_list[0])){{$data->colors_list[0]->color->name->value}}@endif and @if(isset($data->colors_list[1])){{$data->colors_list[1]->color->name->value}}@endif colors. The negative {{$data->brand}} Logo can be used on dark image backgounds with high contrast between them.<br>The Monochrome version logo should be used on documents that are printed in black & white.
				</p>
			@endif
		</div>
		<div class="logo-versions">
			@php
				$approved_count = 0;
			@endphp
			@foreach($data->approved as $approved)
				@if(empty($approved->background) || $approved->background=='transparent')
					@if($approved_count<2)
						@php
							$approved_count++;
						@endphp
						<div class="logo-version" style="background: {{$approved->background}}">
							<div class="logo-img" style="background-image: url({{$approved->logo_b64}})"></div>
							<div class="logo-title">
								{{$approved->title}}
							</div>
						</div>
					@endif
				@endif
			@endforeach
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page15">
		<div class="page-number right @if(isset($data->approved[3]) && $data->approved[3]->background!='transparent' && $data->approved[3]->background!='#ffffff') text-white @endif">15</div>
		<div class="logo-versions">
			@php
				$approved_count = 1;
			@endphp
			@foreach($data->approved as $approved)
				@if(!empty($approved->background) && $approved->background!='transparent')
					@if($approved_count<3)
						@php
							$approved_count++;
						@endphp
						<div class="logo-version version{{$approved_count}}" style="background: {{$approved->background}};padding-left: 20mm;padding-right: 20mm;">
							<div class="logo-img" style="background-image: url({{$approved->logo_b64}})"></div>
							<div class="logo-title @if($approved->background!='transparent' && $approved->background!='#ffffff') text-white @endif">
								{{$approved->title}}
							</div>
						</div>
					@endif
				@endif
			@endforeach
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page16">
		<div class="page-number" id="Our Icon & Favicon">16</div>
		@if(isset($data->icon_b64))
		<div class="favicon">
			<div class="logo-img" style="background-color: {{isset($data->approved_icon[0]->background)?$data->approved_icon[0]->background:'transparent'}};background-image: url({{isset($data->icon_b64)?$data->icon_b64:''}});background-repeat: no-repeat;background-position: center;"></div>
			<div class="logo-title"">
				{{isset($data->approved_icon[0]->title)?$data->approved_icon[0]->title:''}}
			</div>
		</div>
		@endif
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="icon_title)">{{!empty($data->icon_title) ? $data->icon_title : 'Our Icon & Favicon'}}</h1>
		<div class="text" data-field="icon_text">
			@if(!empty($data->icon_text))
				{!!$data->icon_text!!}
			@else
				The {{$data->brand}} icon should be used as the official Favicon only in {{$data->brand}} @if(isset($data->colors_list[0])){{$data->colors_list[0]->color->name->value}}@endif. The negative icon should be used for social as user/company image such as Whatsapp, Facebook, LinkedIn etc.
			@endif
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page17">
		<div class="page-number right">17</div>
		<div class="favicons">
			@foreach($data->approved_icon as $ind=>$apic)
				@if($ind>0)
				<div class="favicon icon-{{$ind}}">
					<div class="logo-img" style="background-color: {{isset($apic['background'])?$apic['background']:''}};@if(isset($apic['border_radius'])) border-radius: {{$apic['border_radius']}}@endif;">
						<div class="image" style="background-image: url({{isset($apic['icon_b64'])?$apic['icon_b64']:''}});background-repeat: no-repeat;background-position: center;background-size: contain;"></div>
					</div>
					<div class="logo-title"">
						{{isset($apic['title'])?$apic['title']:''}}
					</div>
				</div>
				@endif
			@endforeach
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page18">
		<div class="page-number" id="Proportions">18</div>
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="proportions_title)">{{!empty($data->proportions_title) ? $data->proportions_title : 'Logo & Icon Proportions'}}
		</h1>

		@php
			if($data->logo_w==0)
				$data->logo_w = 200;
			if($data->logo_h==0)
				$data->logo_h = 100;

			$ratio = floatval($data->logo_w / ($data->logo_h==0?1:$data->logo_h));
			$proportions_x = 'x';
			$proportions_y = 'x';
			$proportions_text = '';

			$proportions_fibo_active_active = false;

			$prop_x_val = ($ratio - floor($ratio)>0.1?number_format($ratio, 1):round($ratio));
			if($prop_x_val - floor($prop_x_val)<0.1)
				$prop_x_val = floor($prop_x_val);

			switch($data->proportions){
				case 'leonardo':

					if($ratio>1){
						$proportions_x = $prop_x_val.'x';//ceil($ratio).'x';
						if($proportions_x == '1x')
							$proportions_x = 'x';
						$proportions_y = 'x';
					}else{
						$prop_x_val = ((1/$ratio) - floor(1/$ratio)>0.1?number_format(1/$ratio, 1):round(1/$ratio));
						if($prop_x_val - floor($prop_x_val)<0.1)
							$prop_x_val = floor($prop_x_val);
						$proportions_y = $prop_x_val.'x';
						if($proportions_y == '1x')
							$proportions_y = 'x';
						$proportions_x = 'x';
					}
					$proportions_fibo_active_active = false;
					break;
				case 'michaelangelo':
					if($ratio>1){
						$proportions_y = '1/'.$prop_x_val.'x';
						if($proportions_y == '1/3x')
							$proportions_y = '&frac13;x';
						if($proportions_y == '1/2x')
							$proportions_y = '&frac12;x';
						if($proportions_y == '1/4x')
							$proportions_y = '&frac14;x';
						if($proportions_y == '1/5x')
							$proportions_y = '&frac15;x';
						if($proportions_y == '1/6x')
							$proportions_y = '&frac16;x';
						if($proportions_y == '1/7x')
							$proportions_y = '&frac17;x';
						if($proportions_y == '1/8x')
							$proportions_y = '&frac18;x';
						if($proportions_y == '1x')
							$proportions_y = 'x';
						$proportions_x = 'x';
					}else{
						$proportions_x = $prop_x_val.'x';
						if($proportions_x == '1x')
							$proportions_x = 'x';
						$proportions_y = 'x';
					}
					$proportions_fibo_active_active = false;

					break;
				case 'fibonacci':

					$proportions_fibo_active_active = true;
					if($ratio>=.613 && $ratio<=.86){
						$proportions_x = 'x';
						$proportions_y = '1.618 x';
					}else{
						if($ratio>1){
							$proportions_x = $prop_x_val.'x';
							if($proportions_x == '1x')
								$proportions_x = 'x';
							$proportions_y = 'x';
						}else{
							$prop_x_val = ((1/$ratio) - floor(1/$ratio)>0.1?number_format(1/$ratio, 1):round(1/$ratio));
							if($prop_x_val - floor($prop_x_val)<0.1)
								$prop_x_val = floor($prop_x_val);
							$proportions_y = $prop_x_val.'x';
							if($proportions_y == '1x')
								$proportions_y = 'x';
							$proportions_x = 'x';
						}
					}

					break;
				case 'vitruvious':
					if($ratio>1){
						$proportions_x = ceil(floatval($ratio)).'x';
						$proportions_y = 'x';
					}else{
						$proportions_y = ceil(floatval($ratio)).'x';
						$proportions_x = 'x';
					}
					break;
			}
			$proportions_fibo_active_golden = false;
			// $proportions_fibo_active_active = false;
			$proportions_fibo_active = [];
			$proportions_text_small='';

			if($ratio>=0.95 && $ratio<=1.05){
				$proportions_text = '1:1 Square Ratio';
				$proportions_text_small = $proportions_text;
				if($data->proportions == 'fibonacci')
					$proportions_text.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active[]=1;
			}else if($ratio>=2.9 && $ratio<=3.1){
				$proportions_text = '1:3 Ratio';
				$proportions_text_small = $proportions_text;
				if($data->proportions == 'fibonacci')
					$proportions_text.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active[]=3;
			}else if($ratio>=4.8 && $ratio<=5.2){
				$proportions_text = '1:5 Ratio';
				$proportions_text_small = $proportions_text;
				if($data->proportions == 'fibonacci')
					$proportions_text.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active[]=5;
			}else if($ratio>=7.8 && $ratio<=8.2){
				$proportions_text = '1:8 Ratio';
				$proportions_text_small = $proportions_text;
				if($data->proportions == 'fibonacci')
					$proportions_text.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active[]=8;
			}else if($ratio>=1.4 && $ratio<=1.58){
				$proportions_text = '2:3 Ratio';
				$proportions_text_small = $proportions_text;
				if($data->proportions == 'fibonacci')
					$proportions_text.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active[]=2;
				$proportions_fibo_active[]=3;
			}else if($ratio>=1.641 && $ratio<=1.7){
				$proportions_text = '3:5 Ratio';
				$proportions_text_small = $proportions_text;
				if($data->proportions == 'fibonacci')
					$proportions_text.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active[]=3;
				$proportions_fibo_active[]=5;
			}else if($ratio>=1.581 && $ratio<=1.64){
				$proportions_text = '1:1.681 Golden Ratio';
				$proportions_text_small = $proportions_text;
				if($data->proportions == 'fibonacci')
					$proportions_text.="<br>The proportion is the absolute Fibonacci Sequence";
				$proportions_fibo_active_golden = true;
			}else{
				$xx = floatval($proportions_x);
				$yy = floatval($proportions_y);
				if(is_nan($xx) || $xx==0)
					$xx = 1;
				if(is_nan($yy) || $yy==0)
					$yy = 1;

				if(strpos($proportions_x, '/')){
					$xx = str_replace('x', '', str_replace('y', '', $proportions_x));
				}
				if(strpos($proportions_y, '/')){
					$yy = str_replace('x', '', str_replace('y', '', $proportions_y));
				}

				if($proportions_x=='&frac12;x'){
					$xx=1;
					$yy=2;
				}
				if($proportions_x=='&frac13;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_x=='&frac14;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_x=='&frac15;x'){
					$xx=1;
					$yy=4;
				}
				if($proportions_x=='&frac16;x'){
					$xx=1;
					$yy=5;
				}
				if($proportions_x=='&frac17;x'){
					$xx=1;
					$yy=6;
				}
				if($proportions_x=='&frac18;x'){
					$xx=1;
					$yy=8;
				}

				if($proportions_y=='&frac12;x'){
					$xx=1;
					$yy=2;
				}
				if($proportions_y=='&frac13;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_y=='&frac14;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_y=='&frac15;x'){
					$xx=1;
					$yy=4;
				}
				if($proportions_y=='&frac16;x'){
					$xx=1;
					$yy=5;
				}
				if($proportions_y=='&frac17;x'){
					$xx=1;
					$yy=6;
				}
				if($proportions_y=='&frac18;x'){
					$xx=1;
					$yy=8;
				}


				$proportions_text = $xx.':'.$yy.' Ratio';
				$proportions_text_small = $xx.':'.$yy;
			}
		@endphp
		{{--icon calculations--}}
		@php
			$ratio_icon = floatval($icon_w / ($icon_h==0?1:$icon_h));
			$proportions_x_icon = 'x';
			$proportions_y_icon = 'x';
			$proportions_text_icon = '';

			$prop_x_val_icon = ($ratio_icon - floor($ratio_icon)>0.1?number_format($ratio_icon, 1):round($ratio_icon));
			if($prop_x_val_icon - floor($prop_x_val_icon)<0.1)
				$prop_x_val_icon = floor($prop_x_val_icon);

			switch($data->proportions){
				case 'leonardo':
					if($ratio_icon>1){
						$proportions_x_icon = $prop_x_val_icon.'x';//ceil($ratio).'x';
						if($proportions_x_icon == '1x')
							$proportions_x_icon = 'x';
						$proportions_y_icon = 'x';
					}else{
						$prop_x_val_icon = ((1/$ratio_icon) - floor(1/$ratio_icon)>0.1?number_format(1/$ratio_icon, 1):round(1/$ratio_icon));
						if($prop_x_val_icon - floor($prop_x_val_icon)<0.1)
							$prop_x_val_icon = floor($prop_x_val_icon);
						$proportions_y_icon = $prop_x_val_icon.'x';
						if($proportions_y_icon == '1x')
							$proportions_y_icon = 'x';
						$proportions_x_icon = 'x';
					}
					break;
				case 'michaelangelo':
					if($ratio_icon>1){
						$proportions_y_icon = '1/'.$prop_x_val_icon.'x';
						if($proportions_y_icon == '1/3x')
							$proportions_y_icon = '&frac13;x';
						if($proportions_y_icon == '1/2x')
							$proportions_y_icon = '&frac12;x';
						if($proportions_y_icon == '1/4x')
							$proportions_y_icon = '&frac14;x';
						if($proportions_y_icon == '1/5x')
							$proportions_y_icon = '&frac15;x';
						if($proportions_y_icon == '1/6x')
							$proportions_y_icon = '&frac16;x';
						if($proportions_y_icon == '1/7x')
							$proportions_y_icon = '&frac17;x';
						if($proportions_y_icon == '1/8x')
							$proportions_y_icon = '&frac18;x';
						if($proportions_y_icon == '1x')
							$proportions_y_icon = 'x';
						$proportions_x_icon = 'x';
					}else{
						$proportions_x_icon = $prop_x_val_icon.'x';
						if($proportions_x_icon == '1x')
							$proportions_x_icon = 'x';
						$proportions_y_icon = 'x';
					}
					break;
				case 'fibonacci':

					if($ratio_icon>=.613 && $ratio_icon<=.86){
						$proportions_x_icon = 'x';
						$proportions_y_icon = '1.618 x';
					}else{
						if($ratio_icon>1){
							$proportions_x_icon = $prop_x_val_icon.'x';
							if($proportions_x_icon == '1x')
								$proportions_x_icon = 'x';
							$proportions_y_icon = 'x';
						}else{
							$prop_x_val_icon = ((1/$ratio_icon) - floor(1/$ratio_icon)>0.1?number_format(1/$ratio_icon, 1):round(1/$_icon));
							if($prop_x_val_icon - floor($prop_x_val_icon)<0.1)
								$prop_x_val_icon = floor($prop_x_val_icon);
							$proportions_y_icon = $prop_x_val_icon.'x';
							if($proportions_y_icon == '1x')
								$proportions_y_icon = 'x';
							$proportions_x_icon = 'x';
						}
					}
					break;

			}

			// $proportions_fibo_active_active = false;
			$proportions_text_small_icon='';

			if($ratio_icon>=0.95 && $ratio_icon<=1.05){
				$proportions_text_icon = '1:1 Square Ratio';
				$proportions_text_small_icon = $proportions_text_icon;
				if($data->proportions_icon == 'fibonacci')
					$proportions_text_icon.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active_icon[]=1;
			}else if($ratio_icon>=2.9 && $ratio_icon<=3.1){
				$proportions_text_icon = '1:3 Ratio';
				$proportions_text_small_icon = $proportions_text_icon;
				if($data->proportions_icon == 'fibonacci')
					$proportions_text_icon.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active_icon[]=3;
			}else if($ratio_icon>=4.8 && $ratio_icon<=5.2){
				$proportions_text_icon = '1:5 Ratio';
				$proportions_text_small_icon = $proportions_text_icon;
				if($data->proportions_icon == 'fibonacci')
					$proportions_text_icon.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active_icon[]=5;
			}else if($ratio_icon>=7.8 && $ratio_icon<=8.2){
				$proportions_text_icon = '1:8 Ratio';
				$proportions_text_small_icon = $proportions_text_icon;
				if($data->proportions_icon == 'fibonacci')
					$proportions_text_icon.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active_icon[]=8;
			}else if($ratio_icon>=1.4 && $ratio_icon<=1.58){
				$proportions_text_icon = '2:3 Ratio';
				$proportions_text_small_icon = $proportions_text_icon;
				if($data->proportions_icon == 'fibonacci')
					$proportions_text_icon.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active_icon[]=2;
				$proportions_fibo_active_icon[]=3;
			}else if($ratio_icon>=1.641 && $ratio_icon<=1.7){
				$proportions_text_icon = '3:5 Ratio';
				$proportions_text_small_icon = $proportions_text_icon;
				if($data->proportions_icon == 'fibonacci')
					$proportions_text_icon.="<br>The proportion is linked to the Fibonacci Sequence";
				$proportions_fibo_active_icon[]=3;
				$proportions_fibo_active_icon[]=5;
			}else if($ratio_icon>=1.581 && $ratio_icon<=1.64){
				$proportions_text_icon = '1:1.681 Golden Ratio';
				$proportions_text_small_icon = $proportions_text_icon;
				if($data->proportions_icon == 'fibonacci')
					$proportions_text_icon.="<br>The proportion is the absolute Fibonacci Sequence";
				$proportions_fibo_active_golden_icon = true;
			}else{
				$xx = floatval($proportions_x_icon);
				$yy = floatval($proportions_y_icon);
				if(is_nan($xx) || $xx==0)
					$xx = 1;
				if(is_nan($yy) || $yy==0)
					$yy = 1;

				if(strpos($proportions_x_icon, '/')){
					$xx = str_replace('x', '', str_replace('y', '', $proportions_x_icon));
				}
				if(strpos($proportions_y_icon, '/')){
					$yy = str_replace('x', '', str_replace('y', '', $proportions_y_icon));
				}

				if($proportions_x_icon=='&frac12;x'){
					$xx=1;
					$yy=2;
				}
				if($proportions_x_icon=='&frac13;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_x_icon=='&frac14;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_x_icon=='&frac15;x'){
					$xx=1;
					$yy=4;
				}
				if($proportions_x_icon=='&frac16;x'){
					$xx=1;
					$yy=5;
				}
				if($proportions_x_icon=='&frac17;x'){
					$xx=1;
					$yy=6;
				}
				if($proportions_x_icon=='&frac18;x'){
					$xx=1;
					$yy=8;
				}

				if($proportions_y_icon=='&frac12;x'){
					$xx=1;
					$yy=2;
				}
				if($proportions_y_icon=='&frac13;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_y_icon=='&frac14;x'){
					$xx=1;
					$yy=3;
				}
				if($proportions_y_icon=='&frac15;x'){
					$xx=1;
					$yy=4;
				}
				if($proportions_y_icon=='&frac16;x'){
					$xx=1;
					$yy=5;
				}
				if($proportions_y_icon=='&frac17;x'){
					$xx=1;
					$yy=6;
				}
				if($proportions_y_icon=='&frac18;x'){
					$xx=1;
					$yy=8;
				}


				$proportions_text_icon = $xx.':'.$yy.' Ratio';
				$proportions_text_small_icon = $xx.':'.$yy;
			}
		@endphp

		<div class="text" data-field="proportions_text">
			@if(!empty($data->proportions_text))
				{!!$data->proportions_text!!}
			@else
			The {{$data->brand}} Logo has a neat proportion of {{$proportions_text_small}} width. These proportions were chosen carefully and they are not to be changed. The Icon has a perfect square proportion of {{$proportions_text_small_icon}} and acts as the Favicon as well.
			@endif
		</div>
		<div class="background">
			<svg width="250" height="471" viewBox="0 0 250 471" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M134.513 586.217L134.513 26.6945" stroke="#DADADA" stroke-width="4.78224"/>
				<path d="M135.041 2.78223L122.616 45.8224L147.466 45.8224L135.041 2.78223Z" fill="#DADADA"/>
				<path d="M249.814 2.52539L91.4744 2.51841" stroke="#DADADA" stroke-width="4.78224"/>
				<path d="M55.4574 351L32.1052 316.052L9.07512 351H-27.3221L13.7456 293.988L-25.5506 238.265H10.3635L32.9105 270.797L55.1353 238.265H89.5999L50.3038 292.7L92.1767 351H55.4574Z" fill="#DADADA"/>
			</svg>
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page19">
		<div class="page-number right">19</div>

		<div class="logo" data-x="{{$proportions_x}}" data-y="{{$proportions_y}}" style="@if($ratio<1) width: {{290*$ratio}}px; height: 290px;margin-left: -{{290*$ratio/2}}px @else width: 290px; height: {{290/$ratio}}px;margin-left: -145px @endif" data-h="{{$data->logo_h}}px" data-w="{{$data->logo_w}}px">
			<div class="prop_x" style="@if($ratio<1) width: {{290*$ratio}}px; height: 30px; position: absolute; top: 50%; left: 50%; margin-left: -{{290*$ratio/2}}px; margin-top: -185px; border-left: 1px solid #000; border-right: 1px solid #000 @else width: 290px; height: 30px; position: absolute; top: 50%; left: 50%; margin-left: -145px; margin-top: -{{145/$ratio+40}}px; border-left: 1px solid #000; border-right: 1px solid #000 @endif">
				<svg width="15" height="8"  class="x_first" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				<span>{!!$proportions_x!!}</span>
				<svg width="15" height="8"  class="x_last" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
			</div>
			<div class="prop_y" style="@if($ratio<1) width: 30px; height: 290px; position: absolute; top: 50%; left: 50%; margin-top: -145px; margin-left: -{{290*$ratio/2 + 40}}px; border-top: 1px solid #000; border-bottom: 1px solid #000  @else width: 30px; height: {{290/$ratio}}px; position: absolute; top: 50%; left: 50%; margin-top: -{{145/$ratio}}px; margin-left: -185px; border-top: 1px solid #000; border-bottom: 1px solid #000 @endif">
				<svg width="15"  class="y_first" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				<span>{!!$proportions_y!!}</span>
				<svg width="15" height="8"  class="y_last" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
			</div>
			{{-- <div class="proportions_logo" :style="{position: 'absolute', left: '50%', top: '50%', marginLeft: '-100px', marginTop: -(logo_h>0?logo_h/2+40:1)+'px'}">
				<img :src="logo_b64" @load="proportion_logo_loaded()" ref="proportions_logologo" style="width: 200px; height: auto;border: 1px solid #d9d9d9;">
			</div> --}}
			<div class="proportions_text" style="top: {{290/$ratio + 20}}px; width: 300%; margin-left: -100%;">{!!$proportions_text!!}</div>
			@if($proportions_fibo_active_active)
				<div class="propositions_fibonacci_container" style="top: {{290/$ratio + 70}}px">
					<div class="proportions_fibonacci @if($proportions_fibo_active_golden) golden @endif">
						@foreach([1, 1, 2, 3, 5, 8, 13, 21, 34, 55] as $ndx=>$i)
							<span class="@if(in_array($i, $proportions_fibo_active)) @if($ndx==0&&$i==1) @else active @endif @endif">{{$i}}</span>
						@endforeach
					</div>
				</div>
			@endif
			<div class="logo-image" style="background-image: url({{$data->logo_b64}})"></div>
		</div>
		<div class="icon" style="bottom: 110px; @if($ratio_icon<1) width: {{70*$ratio_icon}}px; height: 70px; @else width: 70px; height: {{70/$ratio_icon}}px; @endif">
			<div class="prop_x" style="width: 100%; height: 30px; position: absolute; top: -30px; left: 0; border-left: 1px solid #000; border-right: 1px solid #000">
				<svg width="15" height="8"  class="x_first" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				<span>{!!$proportions_x_icon!!}</span>
				<svg width="15" height="8"  class="x_last" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
			</div>
			<div class="prop_y" style="width: 30px; height: 100%; position: absolute; top: 0; left: -30px;  border-top: 1px solid #000; border-bottom: 1px solid #000">
				<svg width="15"  class="y_first" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				<span>{!!$proportions_y_icon!!}</span>
				<svg width="15" height="8"  class="y_last" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
			</div>
			@if(isset($data->approved_icon[0]))
			<div class="logo-image" style="background-image: url({{isset($data->icon_b64)?$data->icon_b64:''}})"></div>
			@endif
		</div>
	</div>
	<style>
		.prop_x {
	  display: flex;
	  justify-content: center;
	  color: #000;
	  font-size: 12px;
	  line-height: 10px;
	}
	.prop_x .x_last {
	  position: absolute;
	  top: 11px;
	  transform: rotate(0deg);
	  right: 0px;
	}
	.prop_x .x_first {
	  position: absolute;
	  top: 11px;
	  transform: rotate(-180deg);
	  left: 0px;
	}
	.prop_x:after {
	  content: "";
	  display: block;
	  position: absolute;
	  left: 0px;
	  top: 15px;
	  width: 100%;
	  height: 1px;
	  background: #000;
	}

	.prop_y {
	  display: flex;
	  align-items: center;
	  color: #000;
	  font-size: 12px;
	}
	.prop_y .y_last {
	  position: absolute;
	  bottom: 2px;
	  transform: rotate(90deg);
	  left: 8px;
	}
	.prop_y .y_first {
	  position: absolute;
	  top: 2px;
	  transform: rotate(-90deg);
	  left: 8px;
	}
	.prop_y:after {
	  content: "";
	  display: block;
	  position: absolute;
	  left: 15px;
	  top: 0;
	  width: 1px;
	  height: 100%;
	  background: #000;
	}
	.prop_y span {
	  margin-left: -10px;
	}
	.propositions_fibonacci_container{
		display: flex;
		justify-content: center;
		position: absolute;
		width: 100%;
		height: 30px;
		/*bottom: 30px;*/
		white-space: nowrap;
	}
	.proportions_text{
		text-align: center;
	    opacity: .6;
	    position: absolute;
	    width: 100%;
	    /*bottom: 70px;*/
	}
	.proportions_fibonacci {
	  padding: 3px 8px;
	  border: 1px solid #999;
	  display: inline-block;
	  border-radius: 15px;
	}
	.proportions_fibonacci.golden {
	  @if(isset($data->colors_list[0]->id))
	  border-color: {{$data->colors_list[0]->id}};
	  @endif
	}
	.proportions_fibonacci span {
	  margin: 0 2px;
	}
	.proportions_fibonacci span.active {
	  @if(isset($data->colors_list[0]->id))
	  background: {{$data->colors_list[0]->id}};
	  @endif
	  padding: 3px 4px;
	  margin: 0;
	  border-radius: 3px;
	}
	</style>
	<div class="page-break"></div>
	<div id="page20">
		<div class="page-number" id="Clear Space">20</div>
		<h1 class="title" contenteditable="true" data-title-field="space_title)">{{!empty($data->space_title) ? $data->space_title : 'Clear Space'}}
		</h1>
		<div class="text" data-field="space_text">
			@if(!empty($data->space_text))
				{!!$data->space_text!!}
			@else
			Clear space is the area surrounding the global signature and Icon that must be kept free of any elements, including text, graphics, borders, or other logos. The minimum clear space required for the preferred global signature is equal to &quot;x&quot;, or the height and width of the {{$data->brand}} Icon
			@endif
		</div>
		{{-- <div class="text-explain">
			<div class="texted">x = </div><div class="icon"></div>
			<div class="description">
				Minimum Clear Space - using the icon from the logo as a reference<br>unit for the clear space
			</div>
		</div> --}}
	</div>
	<div class="page-break"></div>
	<div id="page21">
		<div class="page-number right">21</div>

				@php

					// $shorter = 1;
					// $longer = 1;
					// if($data->logo_w<$data->logo_h){
					// 	$shorter = $data->logo_w;
					// 	$longer = $data->logo_h;
					// }
					// else{
					// 	$shorter = $data->logo_h;
					// 	$longer = $data->logo_w;
					// }

					// // echo "<h1>".$data->logo_w."</h1>"; echo $data->space;
					// if($shorter==0)
					// 	$shorter = 1;
					// $new_r = $longer / $shorter;
					// // print_r($data);
					$free_space_x = 0;
					$free_space_y = 0;
					$free_space_x_w = 0;
					$free_space_y_h = 0;

					// switch($data->space){
					// 	case 'newton':
					// 		if($new_r>=1 && $new_r<=1.6){
					// 			$free_space_x = '&frac13;x';
					// 			$free_space_y = '&frac13;x';
					// 			$free_space_x_w = $shorter/3;
					// 			$free_space_y_h = $shorter/3;
					// 		}
					// 		if($new_r>=1.61 && $new_r<=10){
					// 			$free_space_x = '&frac12;x';
					// 			$free_space_y = '&frac12;x';
					// 			$free_space_x_w = $shorter/2;
					// 			$free_space_y_h = $shorter/2;
					// 		}
					// 		break;
					// 	case 'hawkins':
					// 		if($new_r>=1 && $new_r<=1.6){
					// 			$free_space_x = '&frac12;x';
					// 			$free_space_y = '&frac12;x';
					// 			$free_space_x_w = $shorter/2;
					// 			$free_space_y_h = $shorter/2;
					// 		}
					// 		if($new_r>=1.61 && $new_r<=10){
					// 			$free_space_x = 'x';
					// 			$free_space_y = 'x';
					// 			$free_space_x_w = $shorter;
					// 			$free_space_y_h = $shorter;
					// 		}
					// 		break;
					// 	case 'einstein':
					// 		if($new_r>=1 && $new_r<=1.39){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac23;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer*2/3;
					// 		}
					// 		if($new_r>=1.4 && $new_r<=1.99){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac12;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer/2;
					// 		}
					// 		if($new_r>=2 && $new_r<=2.99){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac13;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer/3;
					// 		}
					// 		if($new_r>=3 && $new_r<=3.99){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac14;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer/4;
					// 		}
					// 		if($new_r>=4 && $new_r<=4.99){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac15;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer/5;
					// 		}
					// 		if($new_r>=5 && $new_r<=5.99){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac16;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer/6;
					// 		}
					// 		if($new_r>=6 && $new_r<=6.99){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac17;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer/7;
					// 		}
					// 		if($new_r>=7 && $new_r<=7.99){
					// 			$free_space_x = '&frac23;x';
					// 			$free_space_y = '&frac18;y';
					// 			$free_space_x_w = $shorter*2/3;
					// 			$free_space_y_h = $longer/8;
					// 		}
					// 		break;
					// 	case 'pithagoras':
					// 		$diag = sqrt($shorter*$shorter + $longer*$longer);
					// 		if($new_r>=1 && $new_r<=1.5){
					// 			$free_space_x = '&frac12;c';
					// 			$free_space_y = '&frac12;c';
					// 			$free_space_x_w = $diag/2;
					// 			$free_space_y_h = $diag/2;
					// 		}
					// 		if($new_r>=1.51 && $new_r<=1.3){
					// 			$free_space_x = '&frac13;c';
					// 			$free_space_y = '&frac13;c';
					// 			$free_space_x_w = $diag/3;
					// 			$free_space_y_h = $diag/3;
					// 		}
					// 		if($new_r>=1.301 && $new_r<=1.4){
					// 			$free_space_x = '&frac14;c';
					// 			$free_space_y = '&frac14;c';
					// 			$free_space_x_w = $diag/4;
					// 			$free_space_y_h = $diag/4;
					// 		}
					// 		if($new_r>=1.401 && $new_r<=1.5){
					// 			$free_space_x = '&frac15;c';
					// 			$free_space_y = '&frac15;c';
					// 			$free_space_x_w = $diag/5;
					// 			$free_space_y_h = $diag/5;
					// 		}
					// 		if($new_r>=1.501 && $new_r<=1.6){
					// 			$free_space_x = '&frac16;c';
					// 			$free_space_y = '&frac16;c';
					// 			$free_space_x_w = $diag/6;
					// 			$free_space_y_h = $diag/6;
					// 		}
					// 		if($new_r>=1.601 && $new_r<=1.8){
					// 			$free_space_x = '&frac18;c';
					// 			$free_space_y = '&frac18;c';
					// 			$free_space_x_w = $diag/8;
					// 			$free_space_y_h = $diag/8;
					// 		}
					// 		break;
					// }

					$shorter = 0;
					$longer = 0;
					$shorter_text = 'x';
					$longer_text = 'y';

					if($data->logo_w<$data->logo_h){
						$shorter = $data->logo_w;
						$longer = $data->logo_h;
						$shorter_text = 'x';
						$longer_text = 'y';
					}elseif($data->logo_w==$data->logo_h){
						$shorter = $data->logo_h;
						$longer = $data->logo_h;
						$shorter_text = 'x';
						$longer_text = 'x';
					}else{
						$shorter = $data->logo_h;
						$longer = $data->logo_w;
						$shorter_text = 'y';
						$longer_text = 'x';
					}

					$new_r = $longer / $shorter;
					if($shorter != $longer){
						$free_sp_y_text = 'y';
						$free_sp_x_text = 'x';
					}else{
						$free_sp_y_text = 'x';
						$free_sp_x_text = 'x';
					}

					$free_space_x = 'x';
					$free_space_y = 'x';
					$free_sp_c_text = '';
					$clear_space_text = '';
					$show_clear_icon = false;
					switch($data->space){
						case 'newton':
							$show_clear_icon = false;
							if($new_r>=1 && $new_r<=1.6){
								$free_space_x = '&frac13;'.$shorter_text;
								$free_space_y = '&frac13;'.$shorter_text;
								$free_space_x_w = $shorter/3;
								$free_space_y_h = $shorter/3;
							}
							if($new_r>1.6 && $new_r<=10){
								$free_space_x = '&frac12;'.$shorter_text;
								$free_space_y = '&frac12;'.$shorter_text;
								$free_space_x_w = $shorter/2;
								$free_space_y_h = $shorter/2;
							}
							// if(r>=1.3){
							// 	this.free_space_x = '&frac13;x'
							// 	this.free_space_y = '&frac13;x'
							// 	this.free_space_x_w = this.logo_h/3
							// 	this.free_space_y_h = this.logo_h/3
							// }
							break;
						case 'hawkins':
							$show_clear_icon = false;
							if($new_r>=1 && $new_r<=1.6){
								$free_space_x = '&frac12;'.$shorter_text;
								$free_space_y = '&frac12;'.$shorter_text;
								$free_space_x_w = $shorter/2;
								$free_space_y_h = $shorter/2;
							}
							if($new_r>1.6 && $new_r<=10){
								$free_space_x = $shorter_text;
								$free_space_y = $shorter_text;
								$free_space_x_w = $shorter;
								$free_space_y_h = $shorter;
							}
							// this.free_space_x = Math.ceil(this.logo_w / r)
							// this.free_space_y = Math.ceil(this.logo_h / r)
							// this.free_space_x_w = this.logo_w/r
							// this.free_space_y_h = this.logo_h/r
							break;
						case 'einstein':
							$show_clear_icon = false;
							$free_sp_y_text = 'y';
							$free_sp_x_text = 'x';
							$free_sp_c_text = '';
							if($new_r>=1 && $new_r<=1.39){
								$show_clear_icon = true;
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac23;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer*2/3;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac23;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer*2/3;
								}
							}
							if($new_r>1.39 && $new_r<=1.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac12;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/2;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac12;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/2;
								}
							}
							if($new_r>1.99 && $new_r<=2.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac13;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/3;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac13;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/3;
								}
							}
							if($new_r>2.99 && $new_r<=3.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac14;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/4;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac14;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/4;
								}
							}
							if($new_r>3.99 && $new_r<=4.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$longer_text;
									$free_space_y = '&frac15;'.$shorter_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/5;
								}else{
									$free_space_y = '&frac23;'.$longer_text;
									$free_space_x = '&frac15;'.$shorter_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/5;
								}
							}
							if($new_r>4.99 && $new_r<=5.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'+$shorter_text;
									$free_space_y = '&frac16;'+$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/6;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac16;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/6;
								}
							}
							if($new_r>5.99 && $new_r<=6.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac17;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/7;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac17;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/7;
								}
							}
							if($new_r>6.99 && $new_r<=7.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac18;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/8;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac18;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/8;
								}
							}
							break;
						case 'pithagoras':
							$free_sp_y_text = 'y';
							$free_sp_c_text = 'c';
							$free_sp_x_text = 'x';
							$show_clear_icon = false;
							$clear_space_text = 'X&sup2; + Y&sup2; = C&sup2;';
							$diag = sqrt($shorter*$shorter + $longer*$longer);
							if($new_r>=1 && $new_r<=1.5){
								// var c = Math.sqrt(this.logo_/w*this.logo_w+this.logo_h*this.logo_h)/2
								$free_space_x = '&frac12;c';
								$free_space_y = '&frac12;c';
								$free_space_x_w = $diag/2;
								$free_space_y_h = $diag/2;
							}
							if($new_r>1.5 && $new_r<=3){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/3
								$free_space_x = '&frac13;c';
								$free_space_y = '&frac13;c';
								$free_space_x_w = $diag/3;
								$free_space_y_h = $diag/3;
							}
							if($new_r>3 && $new_r<=4){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/4
								$free_space_x = '&frac14;c';
								$free_space_y = '&frac14;c';
								$free_space_x_w = $diag/4;
								$free_space_y_h = $diag/4;
							}
							if($new_r>4 && $new_r<=5){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
								$free_space_x = '&frac15;c';
								$free_space_y = '&frac15;c';
								$free_space_x_w = $diag/5;
								$free_space_y_h = $diag/5;
							}
							if($new_r>5 && $new_r<=6){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
								$free_space_x = '&frac16;c';
								$free_space_y = '&frac16;c';
								$free_space_x_w = $diag/6;
								$free_space_y_h = $diag/6;
							}
							if($new_r>6 && $new_r<=8){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
								$free_space_x = '&frac18;c';
								$free_space_y = '&frac18;c';
								$free_space_x_w = $diag/8;
								$free_space_y_h = $diag/8;
							}
							break;
					}

				@endphp
			<div class="view-block" style="position: relative;padding-top: {{($data->logo_h>0?$data->logo_h/2+2*$free_space_y_h:1)}}px;@if($data->logo_w/$data->logo_h<1)transform:scale(.8)@endif">
				<div class="logogsspace space_x" style="background-image: @if($show_clear_icon) url({{$data->logo_b64}}) @else none @endif;background-size: contain; background-position: center; background-repeat: no-repeat;  width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: -{{($data->logo_w/2+$free_space_x_w)}}px; margin-top: -{{($data->logo_h>0?$data->logo_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<div class="first">
						<span>{!!$free_space_y!!}</span>
						<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
						<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					</div>
					<div class="seond"><span>{!!$free_space_x!!}</span><svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
						<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg></div>
				</div>
				<div class="logogsspace space_x2" style="background-image: @if($show_clear_icon) url({{$data->logo_b64}}) @else none @endif; background-size: contain; background-position: center; background-repeat: no-repeat; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: {{$data->logo_w/2}}px; margin-top: {{($data->logo_h>0?$data->logo_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<!--<div class="first" v-html=free_space_x></div>-->
					<!--<div class="seond" v-html=free_space_y></div>-->
				</div>
				<div class="logogsspace space_x3" style="background-image: @if($show_clear_icon) url({{$data->logo_b64}}) @else none @endif; background-size: contain; background-position: center; background-repeat: no-repeat; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: -{{($data->logo_w/2+$free_space_x_w)}}px; margin-top: {{($data->logo_h>0?$data->logo_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<!--<div class="first" v-html=free_space_x></div>-->
					<!--<div class="seond" v-html=free_space_y></div>-->
				</div>
				<div class="logogsspace space_x4" style="background-image: @if($show_clear_icon) url({{$data->logo_b64}}) @else none @endif; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%;background-size: contain; background-position: center; background-repeat: no-repeat;  left: 50%; margin-left: {{$data->logo_w/2}}px; margin-top: -{{($data->logo_h>0?$data->logo_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<!--<div class="first" v-html=free_space_x></div>-->
					<!--<div class="seond" v-html=free_space_y></div>-->
				</div>
				<div class="logo-sponge-space_x" style="--width: {{$data->logo_w}}px; --height: {{$data->logo_h}}px">
					<span>{{$free_sp_x_text}}</span>
					<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				</div>
				<div class="logo-sponge-space_y" style="--height: {{$data->logo_h}}px; --width: {{$data->logo_w}}px">
					<span>{{$free_sp_y_text}}</span>
					<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				</div>
				@if($data->space=='pithagoras')
				<div class="logo-sponge-space_c" style="--pyw: {{sqrt($data->logo_w*$data->logo_w + $data->logo_h*$data->logo_h)}}px; --width: {{$data->logo_w}}px; --height: {{$data->logo_h}}px; --degree: {{(asin($data->logo_h/sqrt($data->logo_w*$data->logo_w + $data->logo_h*$data->logo_h))*180/pi())}}deg">
					<span>{{$free_sp_c_text}}</span>
					<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				</div>
				@endif

				{{-- <div class="logo-pre" style="left: -{{$free_space_x_w}}px; top: -{{$free_space_y_h}}px;right: -{{$free_space_x_w}}px;">
					<div class="left" style="width: {{$free_space_x_w}}px;height: {{$free_space_y_h}}px;background-image: url({{$data->approved[0]->logo_b64}});--x:{{$free_space_x_w}}px;--y:{{$free_space_y_h}}px" data-x='{!!$free_space_x!!}' data-y='{!!$free_space_y!!}'>
					</div>
					<div class="right" style="width: {{$free_space_x_w}}px;height: {{$free_space_y_h}}px;background-image: url({{$data->approved[0]->logo_b64}});--x:{{$free_space_x_w}}px;--y:{{$free_space_y_h}}px"></div>
				</div> --}}
			<div class="logo" style="    position: absolute;
	    left: 50%;
	    top: 50%;
	    margin-left: -{{$data->logo_w/2}}px;
	    width: {{$data->logo_w}}px;
	    height: {{$data->logo_h}}px;
	   margin-top: -{{$data->logo_h/2}}px;
	 	--sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px;
	   ">
				@if(isset($data->approved[0]))
				<div class="proportions_logo logo-image" style="width: {{$data->logo_w}}px;height: {{$data->logo_h}}px;background-image: url({{$data->approved[0]->logo_b64}})"></div>
				@endif
				@if($clear_space_text!=='')
					<div class="proportions_text" style="bottom: -{{($data->logo_h/2+60)}}px;">
						{!!$clear_space_text!!}
					</div>
				@endif
				{{-- <div class="logo-post" style="left: -{{$free_space_x_w}}px; bottom: -{{$free_space_y_h}}px;right: -{{$free_space_x_w}}px;">
					<div class="left" style="width: {{$free_space_x_w}}px;height: {{$free_space_y_h}}px;background-image: url({{$data->approved[0]->logo_b64}})"></div>
					<div class="right" style="width: {{$free_space_x_w}}px;height: {{$free_space_y_h}}px;background-image: url({{$data->approved[0]->logo_b64}})"></div>
				</div> --}}
				<style>
					.logogsspace {
					  filter: grayscale(1);
					  background-size: cover;
					}
					.logogsspace .first span {
					  margin-left: -20px;
					  font-size: 14px;
					}
					.logogsspace .first .logosp_arr_1 {
					  transform: rotate(-90deg);
					  position: absolute;
					  left: 21px;
					  top: 2px;
					}
					.logogsspace .first .logosp_arr_2 {
					  transform: rotate(90deg);
					  position: absolute;
					  left: 21px;
					  bottom: 2px;
					}
					.logogsspace .first:after {
					  content: "";
					  height: 100%;
					  width: 1px;
					  position: absolute;
					  left: 28px;
					  top: 0px;
					  background: #000;
					}
					.logogsspace .seond span {
					  margin-top: 0px;
					  font-size: 14px;
					  display: block;
					}
					.logogsspace .seond .logosp_arr_1 {
					  transform: rotate(-180deg);
					  position: absolute;
					  left: 0;
					  top: 21px;
					}
					.logogsspace .seond .logosp_arr_2 {
					  position: absolute;
					  right: 0;
					  top: 21px;
					}
					.logogsspace .seond:after {
					  content: "";
					  height: 1px;
					  width: 100%;
					  position: absolute;
					  left: 0;
					  top: 24px;
					  background: #000;
					}
					#page21 .logo:before {
					    content: "";
					    display: block;
					    border-top: 1px solid #999;
					    border-bottom: 1px solid #999;
					    height: {{$data->logo_h + 2*$free_space_y_h}}px;
					    position: absolute;
					    top: -{{$free_space_y_h + 1}}px;
					    left: -1px;
					    width: 101%;
					}
					#page21 .logo:after {
					    content: "";
					    display: block;
					    border-left: 1px solid #999;
					    border-right: 1px solid #999;
					    width: {{$data->logo_w + 2*$free_space_x_w}}px;
					    position: absolute;
					    left: -{{$free_space_x_w+1}}px;
					    top: -1px;
					    height: 102%;
					}
					.space_x .first, .space_x2 .first {
					  font-size: 30px;
					  text-align: center;
					  padding-left: 15px;
					  position: absolute;
					  left: -80px;
					  height: 100%;
					  display: flex;
					  align-items: center;
					  color: #000;
					  border-top: 1px solid #000;
					  border-bottom: 1px solid #000;
					  background-repeat: no-repeat;
					  background-size: contain;
					  width: 60px;
					  left: -60px;
					}
					.space_x .seond, .space_x2 .seond {
					  font-size: 30px;
					  position: absolute;
					  top: -80px;
					  width: 100%;
					  text-align: center;
					  color: #000;
					  border-left: 1px solid #000;
					  border-right: 1px solid #000;
					  background-repeat: no-repeat;
					  background-size: contain;
					  height: 60px;
					  top: -60px;
					}


					.logo-sponge-space_x {
					  position: absolute;
					  left: 50%;
					  width: var(--width);
					  margin-left: -{{$data->logo_w/2}}px;
					  margin-bottom: {{$data->logo_h/2}}px;
					  bottom: 50%;
					  height: 40px;

					}
					.logo-sponge-space_x:after {
					  content: "";
					  height: 1px;
					  width: 100%;
					  position: absolute;
					  background: #000;
					  left: 0;
					  top: 24px;
					}
					.logo-sponge-space_x .logosp_arr_1 {
					  transform: rotate(-180deg);
					  position: absolute;
					  top: 21px;
					  left: 0;
					}
					.logo-sponge-space_x .logosp_arr_2 {
					  position: absolute;
					  top: 21px;
					  right: 0;
					}
					.logo-sponge-space_x span {
					  width: 100%;
					  text-align: center;
					  display: block;
					  font-size: 14px;
					  position: absolute;
					  top: 0px;
					  color: #000;
					}

					.logo-sponge-space_y {
					  height: {{$data->logo_h}}px;
					  position: absolute;
					  top: 50%;
					  margin-top: -{{$data->logo_h/2}}px;
					  /*left: 50%;*/
					  margin-right: {{$data->logo_w/2}}px;
						right: 50%;
					  left: unset;
					  /*margin-left: -30px;*/
					  {{-- margin-left: -{{$data->logo_w/2 - 30}}px; --}}
					  width: 30px;
					}
					.logo-sponge-space_y:after {
					  content: "";
					  height: 100%;
					  width: 1px;
					  position: absolute;
					  background: #000;
					  left: 7px;
					  top: 0px;
					}
					.logo-sponge-space_y .logosp_arr_1 {
					  transform: rotate(-90deg);
					  position: absolute;
					  top: 2px;
					  left: 0;
					}
					.logo-sponge-space_y .logosp_arr_2 {
					  position: absolute;
					  bottom: 2px;
					  left: 0;
					  transform: rotate(90deg);
					}
					.logo-sponge-space_y span {
					  width: 30px;
					  text-align: center;
					  display: block;
					  font-size: 14px;
					  position: absolute;
					  top: 0px;
					  height: 100%;
					  display: flex;
					  align-items: center;
					  left: -10px;
					  color: #000;
					}

					.logo-sponge-space_c {
					  width: {{sqrt($data->logo_w*$data->logo_w + $data->logo_h*$data->logo_h)}}px;
					  transform: rotate({{(asin($data->logo_h/sqrt($data->logo_w*$data->logo_w + $data->logo_h*$data->logo_h))*180/pi())}}deg);
					  position: absolute;
					  top: 50%;
					  margin-top: -15px;
					  left: 50%;
					  margin-left: -{{sqrt($data->logo_w*$data->logo_w + $data->logo_h*$data->logo_h)/2}}px;
					  height: 30px;
					  z-index: 4;
					}
					.logo-sponge-space_c:after {
					  content: "";
					  height: 1px;
					  width: 100%;
					  position: absolute;
					  background: #000;
					  left: 0px;
					  top: 14px;
					}
					.logo-sponge-space_c .logosp_arr_1 {
					  transform: rotate(0deg);
					  position: absolute;
					  top: 11px;
					  right: 0;
					}
					.logo-sponge-space_c .logosp_arr_2 {
					  position: absolute;
					  bottom: 10px;
					  left: 3px;
					  transform: rotate(-180deg);
					}
					.logo-sponge-space_c span {
					  width: 100%;
					  text-align: center;
					  display: block;
					  font-size: 14px;
					  position: absolute;
					  top: -10px;
					  height: 30px;
					  left: 0px;
					  color: #000;
					  text-shadow: 0 0 3px rgba(255, 255, 255, 0.7);
					}
				</style>
			</div>
		</div>
		@php

					$shorter = 0;
					$longer = 0;
					$shorter_text = 'x';
					$longer_text = 'y';

					if($icon_w>$icon_h){
						$data->icon_w = 120;
						$data->icon_h = $icon_h*120/$icon_w;
					}else{
						$data->icon_h = 120;
						$data->icon_w = $icon_w*120/$icon_h;
					}

					// $data->icon_w = $icon_w;
					// $data->icon_h = $icon_h;

					if($data->icon_w<$data->icon_h){
						$shorter = $data->icon_w;
						$longer = $data->icon_h;
						$shorter_text = 'x';
						$longer_text = 'y';
					}elseif($data->icon_w==$data->icon_h){
						$shorter = $data->icon_h;
						$longer = $data->icon_h;
						$shorter_text = 'x';
						$longer_text = 'x';
					}else{
						$shorter = $data->icon_h;
						$longer = $data->icon_w;
						$shorter_text = 'y';
						$longer_text = 'x';
					}

					$new_r = $longer / $shorter;
					if($shorter != $longer){
						$free_sp_y_text = 'y';
						$free_sp_x_text = 'x';
					}else{
						$free_sp_y_text = 'x';
						$free_sp_x_text = 'x';
					}


					$free_sp_c_text = '';
					$clear_space_text = '';
					$show_clear_icon = false;
					switch($data->space){
						case 'newton':
							$show_clear_icon = false;
							if($new_r>=1 && $new_r<=1.6){
								$free_space_x = '&frac13;'.$shorter_text;
								$free_space_y = '&frac13;'.$shorter_text;
								$free_space_x_w = $shorter/3;
								$free_space_y_h = $shorter/3;
							}
							if($new_r>1.6 && $new_r<=10){
								$free_space_x = '&frac12;'.$shorter_text;
								$free_space_y = '&frac12;'.$shorter_text;
								$free_space_x_w = $shorter/2;
								$free_space_y_h = $shorter/2;
							}
							// if(r>=1.3){
							// 	this.free_space_x = '&frac13;x'
							// 	this.free_space_y = '&frac13;x'
							// 	this.free_space_x_w = this.logo_h/3
							// 	this.free_space_y_h = this.logo_h/3
							// }
							break;
						case 'hawkins':
							$show_clear_icon = false;
							if($new_r>=1 && $new_r<=1.6){
								$free_space_x = '&frac12;'.$shorter_text;
								$free_space_y = '&frac12;'.$shorter_text;
								$free_space_x_w = $shorter/2;
								$free_space_y_h = $shorter/2;
							}
							if($new_r>1.6 && $new_r<=10){
								$free_space_x = $shorter_text;
								$free_space_y = $shorter_text;
								$free_space_x_w = $shorter;
								$free_space_y_h = $shorter;
							}
							// this.free_space_x = Math.ceil(this.logo_w / r)
							// this.free_space_y = Math.ceil(this.logo_h / r)
							// this.free_space_x_w = this.logo_w/r
							// this.free_space_y_h = this.logo_h/r
							break;
						case 'einstein':
							$show_clear_icon = false;
							$free_sp_y_text = 'y';
							$free_sp_x_text = 'x';
							$free_sp_c_text = '';
							if($new_r>=1 && $new_r<=1.39){
								$show_clear_icon = true;
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac23;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer*2/3;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac23;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer*2/3;
								}
							}
							if($new_r>1.39 && $new_r<=1.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac12;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/2;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac12;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/2;
								}
							}
							if($new_r>1.99 && $new_r<=2.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac13;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/3;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac13;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/3;
								}
							}
							if($new_r>2.99 && $new_r<=3.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac14;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/4;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac14;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/4;
								}
							}
							if($new_r>3.99 && $new_r<=4.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$longer_text;
									$free_space_y = '&frac15;'.$shorter_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/5;
								}else{
									$free_space_y = '&frac23;'.$longer_text;
									$free_space_x = '&frac15;'.$shorter_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/5;
								}
							}
							if($new_r>4.99 && $new_r<=5.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'+$shorter_text;
									$free_space_y = '&frac16;'+$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/6;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac16;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/6;
								}
							}
							if($new_r>5.99 && $new_r<=6.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac17;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/7;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac17;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/7;
								}
							}
							if($new_r>6.99 && $new_r<=7.99){
								if($shorter_text == 'x'){
									$free_space_x = '&frac23;'.$shorter_text;
									$free_space_y = '&frac18;'.$longer_text;
									$free_space_x_w = $shorter*2/3;
									$free_space_y_h = $longer/8;
								}else{
									$free_space_y = '&frac23;'.$shorter_text;
									$free_space_x = '&frac18;'.$longer_text;
									$free_space_y_h = $shorter*2/3;
									$free_space_x_w = $longer/8;
								}
							}
							break;
						case 'pithagoras':
							$free_sp_y_text = 'y';
							$free_sp_c_text = 'c';
							$free_sp_x_text = 'x';
							$show_clear_icon = false;
							$clear_space_text = 'X&sup2; + Y&sup2; = C&sup2;';
							$diag = sqrt($shorter*$shorter + $longer*$longer);
							if($new_r>=1 && $new_r<=1.5){
								// var c = Math.sqrt(this.logo_/w*this.logo_w+this.logo_h*this.logo_h)/2
								$free_space_x = '&frac12;c';
								$free_space_y = '&frac12;c';
								$free_space_x_w = $diag/2;
								$free_space_y_h = $diag/2;
							}
							if($new_r>1.5 && $new_r<=3){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/3
								$free_space_x = '&frac13;c';
								$free_space_y = '&frac13;c';
								$free_space_x_w = $diag/3;
								$free_space_y_h = $diag/3;
							}
							if($new_r>3 && $new_r<=4){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/4
								$free_space_x = '&frac14;c';
								$free_space_y = '&frac14;c';
								$free_space_x_w = $diag/4;
								$free_space_y_h = $diag/4;
							}
							if($new_r>4 && $new_r<=5){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
								$free_space_x = '&frac15;c';
								$free_space_y = '&frac15;c';
								$free_space_x_w = $diag/5;
								$free_space_y_h = $diag/5;
							}
							if($new_r>5 && $new_r<=6){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
								$free_space_x = '&frac16;c';
								$free_space_y = '&frac16;c';
								$free_space_x_w = $diag/6;
								$free_space_y_h = $diag/6;
							}
							if($new_r>6 && $new_r<=8){
								// var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
								$free_space_x = '&frac18;c';
								$free_space_y = '&frac18;c';
								$free_space_x_w = $diag/8;
								$free_space_y_h = $diag/8;
							}
							break;
					}
		@endphp
		<div class="icon iconster" style="width: {{$data->icon_w}}px; height: {{$data->icon_h}}px;margin-left: -{{$data->icon_w/2}}px;">
			<div class="logogsspace space_x icon" style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif;background-size: contain; background-position: center; background-repeat: no-repeat;  width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: -{{($data->icon_w/2+$free_space_x_w)}}px; margin-top: -{{($data->icon_h>0?$data->icon_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<div class="first">
						<span>{!!$free_space_y!!}</span>
						<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
						<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					</div>
					<div class="seond"><span>{!!$free_space_x!!}</span><svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
						<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg></div>
				</div>
				<div class="logogsspace space_x2" style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif;background-size: contain; background-position: center; background-repeat: no-repeat;  width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: {{$data->icon_w/2}}px; margin-top: {{($data->icon_h>0?$data->icon_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<!--<div class="first" v-html=free_space_x></div>-->
					<!--<div class="seond" v-html=free_space_y></div>-->
				</div>
				<div class="logogsspace space_x3" style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif; background-size: contain; background-position: center; background-repeat: no-repeat; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: -{{($data->icon_w/2+$free_space_x_w)}}px; margin-top: {{($data->icon_h>0?$data->icon_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<!--<div class="first" v-html=free_space_x></div>-->
					<!--<div class="seond" v-html=free_space_y></div>-->
				</div>
				<div class="logogsspace space_x4" style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif;background-size: contain; background-position: center; background-repeat: no-repeat;  width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: {{$data->icon_w/2}}px; margin-top: -{{($data->icon_h>0?$data->icon_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
					<!--<div class="first" v-html=free_space_x></div>-->
					<!--<div class="seond" v-html=free_space_y></div>-->
				</div>
				<div class="logo-sponge-space_x iconed" style="--width: {{$data->icon_w}}px; --height: {{$data->icon_h}}px">
					<span>{{$free_sp_x_text}}</span>
					<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				</div>
				<div class="logo-sponge-space_y iconed" style="--height: {{$data->icon_h}}px; --width: {{$data->icon_w}}px">
					<span>{{$free_sp_y_text}}</span>
					<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				</div>
				@if($data->space=='pithagoras')
				<div class="logo-sponge-space_c iconed" style="--pyw: {{sqrt($data->logo_w*$data->icon_w + $data->icon_h*$data->icon_h)}}px; --width: {{$data->icon_w}}px; --height: {{$data->icon_h}}px; --degree: {{(asin($data->icon_h/sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h))*180/pi())}}deg">
					<span>{{$free_sp_c_text}}</span>
					<svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
					<svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/></svg>
				</div>
				@endif
			@if(isset($data->icon_b64))
			<div class="logo-image" style="width: {{$data->icon_w}}px; height: {{$data->icon_h}}px;background-image: url({{isset($data->icon_b64)?$data->icon_b64:''}})"></div>
			@endif
			<style>
				.logo-sponge-space_x.iconed{
				  	margin-left: -{{$data->icon_w/2}}px;
				  	margin-bottom: {{$data->icon_h/2}}px;
				  }
				 .logo-sponge-space_y.iconed{
				  	/*margin-left: -{{$data->icon_w/2}}px;
				  	margin-bottom: {{$data->icon_h/2}}px;*/

				  	 margin-top: -{{$data->icon_h/2}}px;
					  margin-right: {{$data->icon_w/2}}px;
					  height: {{$data->icon_h}}px;
				  }
				 .logo-sponge-space_c.iconed{
				  	width: {{sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h)}}px;
					  transform: rotate({{(asin($data->icon_h/sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h))*180/pi())}}deg);
					  position: absolute;
					  top: 50%;
					  margin-top: -15px;
					  left: 50%;
					  margin-left: -{{sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h)/2}}px;
				  }
				  #page21 .icon.iconster:before {
					    content: "";
					    display: block;
					    border-top: 1px solid #999;
					    border-bottom: 1px solid #999;
					    height: {{$data->icon_h + 2*$free_space_y_h}}px;
					    position: absolute;
					    top: -{{$free_space_y_h + 1}}px;
					    left: -1px;
					    width: 101%;
					}
					#page21 .icon.iconster:after {
					    content: "";
					    display: block;
					    border-left: 1px solid #999;
					    border-right: 1px solid #999;
					    width: {{$data->icon_w + 2*$free_space_x_w}}px;
					    position: absolute;
					    left: -{{$free_space_x_w+1}}px;
					    top: -1px;
					    height: 102%;
					}
			</style>
			{{-- <div class="icon-post"><div class="left">x</div><div class="right">x</div></div> --}}
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page22">
		<div class="background">
			<svg width="749" height="303" viewBox="0 0 749 303" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect x="95" y="-240" width="343" height="343" stroke="white" stroke-width="4"/>
			<g clip-path="url(#clip0)">
			<line x1="98.0234" y1="139.105" x2="438.279" y2="139.105" stroke="white" stroke-width="5"/>
			<path d="M96.3721 240.674L123.541 287.732H69.2031L96.3721 240.674Z" fill="white"/>
			<path d="M96.3721 135L96.3721 240.674" stroke="white" stroke-width="3" stroke-dasharray="26.42 13.21"/>
			<path d="M436.628 240.674L463.797 287.732H409.459L436.628 240.674Z" fill="white"/>
			<path d="M436.628 135L436.628 240.674" stroke="white" stroke-width="3" stroke-dasharray="26.42 13.21"/>
			</g>
			<line x1="75" y1="106" x2="-170" y2="106" stroke="white" stroke-width="2" stroke-dasharray="8 8"/>
			<line x1="749" y1="106" x2="468" y2="106" stroke="white" stroke-width="2" stroke-dasharray="8 8"/>
			<defs>
			<clipPath id="clip0">
			<rect x="65" y="135" width="403" height="168" fill="white"/>
			</clipPath>
			</defs>
			</svg>
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page23">
		<div class="page-number right" id="Minimum Size">23</div>
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="size_title)">{{!empty($data->size_title) ? $data->size_title :'Minimum Size'}}
		</h1>
		<div class="text" data-field="size_text">
			@if(!empty($data->size_text))
				{!!$data->size_text!!}
			@else
			Establishing a minimum size ensures that the impact and legibility of the logo is not compromised in application.
			@endif
		</div>
		<div class="logo" style="height: auto; width: @if($data->size=='quark')71px;@endif @if($data->size=='neutron')100px;@endif @if($data->size=='atom')160px;@endif @if($data->size=='molecule')214px;@endif">
			@if(isset($data->approved[0]))
			<img class="logo-image" src="{{$data->approved[0]->logo_b64}}" style="
			width: @if($data->size=='quark')71px;@endif @if($data->size=='neutron')100px;@endif @if($data->size=='atom')160px;@endif @if($data->size=='molecule')214px;@endif
			display: block;margin: 0 auto; height: auto;
			">
			@endif
		</div>
		<div class="logo_after" style="
			width: @if($data->size=='quark')71px;@endif @if($data->size=='neutron')100px;@endif @if($data->size=='atom')160px;@endif @if($data->size=='molecule')214px;@endif
			">
			<svg width="19" height="51" class="first" viewBox="0 0 19 51" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/><path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/></svg>
			<div class="text" style="
			width: @if($data->size=='quark')51px;@endif @if($data->size=='neutron')80px;@endif @if($data->size=='atom')140px;@endif @if($data->size=='molecule')194px;@endif
			@if($data->size=='quark' || $data->size=='neutron')line-height: 1em;padding-top: 10px;@endif
			">@if($data->size=='quark') 71px / 20mm @endif @if($data->size=='neutron') 100px / 28mm @endif @if($data->size=='atom') 160px / 45mm @endif @if($data->size=='molecule') 214px / 60mm @endif</div>
			<svg width="19" height="51" class="last" viewBox="0 0 19 51" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/><path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/></svg>
		</div>
		<div class="description">
			The {{$data->brand}} logo should never be smaller than<br>@if($data->size=='quark') 71px @endif @if($data->size=='neutron') 100px @endif @if($data->size=='atom') 160px @endif @if($data->size=='molecule') 214px @endif in digital or @if($data->size=='quark') 20mm @endif @if($data->size=='neutron') 28mm @endif @if($data->size=='atom') 45mm @endif @if($data->size=='molecule') 60mm @endif in print.
		</div>
		<div class="icon" style="height: auto;width: @if($data->size=='quark')10px;@endif @if($data->size=='neutron')14px;@endif @if($data->size=='atom')22px;@endif @if($data->size=='molecule')30px;@endif">
			<img class="logo-image"  src="{{$data->icon_b64}}" style="
			width: @if($data->size=='quark')10px;@endif @if($data->size=='neutron')14px;@endif @if($data->size=='atom')22px;@endif @if($data->size=='molecule')30px;@endif
			display: block;margin: 0 auto; height: auto;
			">
		</div>
		<div class="icon_after" style="display: flex;justify-content: space-between;
			width: @if($data->size=='quark')10px;@endif @if($data->size=='neutron')14px;@endif @if($data->size=='atom')22px;@endif @if($data->size=='molecule')30px;@endif
			">
			<svg width="19" height="51" class="first" viewBox="0 0 19 51" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/><path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/></svg>
			<svg width="19" height="51" class="last" viewBox="0 0 19 51" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/><path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/></svg>
		</div>
		<div class="description">
			The {{$data->brand}} icon should never be smaller than<br> @if($data->size=='quark') 10px @endif @if($data->size=='neutron') 14px @endif @if($data->size=='atom') 22px @endif @if($data->size=='molecule') 30px @endif in digital or @if($data->size=='quark') 2.8mm @endif @if($data->size=='neutron') 3.9mm @endif @if($data->size=='atom') 6.3mm @endif @if($data->size=='molecule') 8.4mm @endif in print.
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page24">
		<div class="page-number text-white" id="Logo Misuse">24</div>
		<h1 class="title text-white" contenteditable="true" @blur="title_changed()" data-title-field="misuse_title">{{!empty($data->misuse_title) ? $data->misuse_title : 'Logo Misuse'}}</h1>
		<div class="text text-white" data-field="misuse_text">
			@if(!empty($data->misuse_text))
				{!!$data->misuse_text!!}
			@else
			It is important that the appearance of the logo remains consistent. The logo should not be misinterpreted, modified, or added to. No attempt should be made to alter the logo in any way. Its orientation, colour and composition should remain as indicated in this document &mdash; there are no exceptions.
			@endif
		</div>
		<div class="gradient"></div>
		<div class="line"></div>
	</div>
	<div class="page-break"></div>
	<div id="page25">
		<div class="page-number right">25</div>
		@if($data->state == 'rebrand')
			<div class="rejected_item">
				<div class="logo-image" style="background-image: url({{$data->old_logo}})"></div>
				<div class="title">Do not use old version of logo</div>
				<div class="line"></div>
			</div>
		@endif
		<div class="rejected_item">
			<div class="logo-image" style="background-image: url({{$data->logo_b64}});transform: scaleY(.5)"></div>
			<div class="title">Do not distort or alter the proportions of the logo</div>
			<div class="line"></div>
		</div>
		<div class="rejected_item">
			<div class="logo-image logo-contours-part">
				{!!$data->logo!!}
			</div>
			<style>
				.logo-contours-part svg{
					height: 100%;
				    display: block;
				    margin: 0 auto;
				}
				.logo-contours-part svg path:nth-child(2n), .logo-contours-part svg rect:nth-child(2n), .logo-contours-part svg circle:nth-child(2n){
					fill: cyan;
					stroke: green;
					stroke-width: 1%;
					transform: scale(.9);
				}
			</style>
			<div class="title">Do not change any elements respective to one another</div>
			<div class="line"></div>
		</div>
		<div class="rejected_item">
			<div class="logo-image logo-contours">
				{!!$data->logo!!}
			</div>
			<div class="title">Do not add contours to the logo</div>
			<div class="line"></div>
			<style>
				.logo-contours svg{
					height: 100%;
				    display: block;
				    margin: 0 auto;
				}
				.logo-contours svg path, .logo-contours svg rect, .logo-contours svg circle{
					fill: transparent;
					stroke: #000;
					stroke-width: 1%;
				}
			</style>
		</div>
		<div class="rejected_item">
			<div class="logo-image" style="background-image: url({{$data->logo_b64}});transform: rotate(25deg)"></div>
			<div class="title">Do not turn the logo to any angle</div>
			<div class="line"></div>
		</div>
		@if(isset($data->rejected) && is_array($data->rejected))
			@foreach($data->rejected as $rejected)
				<div class="rejected_item" style="background-color: {{$rejected->background}}">
					<div class="logo-image" style="background-image: url({{$rejected->logo_b64}})"></div>
					<div class="title">{{$rejected->title}}</div>
					<div class="line"></div>
				</div>
			@endforeach
		@endif
	</div>
	<div class="page-break"></div>
	<div id="page26">
		<div class="page-number" id="Color Pallete">26</div>
		<h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="pallette_title)">{{!empty($data->pallette_title) ? $data->pallette_title : 'Our Color Pallete'}}</h1>
		<div class="text" data-field="pallette_text">
			@if(!empty($data->pallette_text))
				{!!$data->pallette_text!!}
			@else
			The colors selected for the {{$data->brand}} signature reflect the company's values. The colors have been specifically chosen to represent the brand and should not be altered under any circumstance.<br> For Printing instances, a Rich Black should be used for text with C40 M10 Y0 K100.
			@endif
		</div>
		<div class="color-line">
			<div class="line">
				<div class="p1"></div>
				<div class="p2"></div>
				<div class="p3"></div>
				<div class="p4"></div>
				<div class="p5"></div>
				<div class="p6"></div>
				<div class="p7"></div>
				<div class="p8"></div>
				<div class="p9"></div>
			</div>
			<div class="description">
				<div class="textual-block first">
					<svg width="323" height="57" viewBox="0 0 323 57" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M323 0.5H56.5L1 56" stroke="#C7C7C7"/></svg>
					Primary Color
					<div class="color-code">
						@if(isset($data->colors_list[0]))
						{{$data->colors_list[0]->id}}
						@endif
					</div>
				</div>
				<div class="textual-block second">
					<svg width="196" height="33" viewBox="0 0 196 33" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M196 0.5H33L1 32.5" stroke="#C7C7C7"/></svg>
					Secondary Color
					<div class="color-code">
						@if(isset($data->colors_list[1]))
						{{$data->colors_list[1]->id}}
						@endif
					</div>
				</div>
				<div class="textual-block third">
					<svg width="62" height="15" viewBox="0 0 62 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M62 0.5H14L0.5 14" stroke="#C7C7C7"/></svg>
					Tertiary Color
					<div class="color-code">
						@if(isset($data->colors_list[2]))
						{{$data->colors_list[2]->id}}
						@endif
					</div>
				</div>

			</div>
		</div>
		<div class="text-small">
			Instead of the colors referred to on this page, you may use the PANTONE&reg; colors listed above, the standards for which can be found in the current edition of the PANTONE COLOR FORMULA GUIDE. The colors shown on this page and throughout this guideline have not been evaluated by PANTONE, Inc. for accuracy and may not match the PANTONE color standards. PANTONE&reg; is a registered trademark of PANTONE, Inc.
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page27">
		<div class="page-number right">27</div>
		@foreach($data->colors_list as $c=>$color)
			@if($c<4)
				@if(isset($color->color))
				<div class="color-block">
					<div class="title">{{$color->color->name->value}}</div>
					<svg width="231" height="155" viewBox="0 0 231 155" fill="none" xmlns="http://www.w3.org/2000/svg">
						@if(isset($color->color->scheme->colors[2]))
						<path d="M141.377 114.623C147.482 120.728 154.998 125.233 163.26 127.739C171.522 130.246 180.274 130.676 188.742 128.991C197.21 127.307 205.132 123.56 211.806 118.083C218.48 112.606 223.7 105.567 227.004 97.5909C230.308 89.6144 231.593 80.9462 230.747 72.3541C229.901 63.762 226.949 55.5112 222.152 48.3326C217.356 41.1539 210.863 35.269 203.248 31.1991C195.634 27.1292 187.134 25 178.5 25L178.5 77.5L141.377 114.623Z" fill="{{$color->color->scheme->colors[2]->hex->value}}"/>
						<path d="M141.377 114.623C136.502 109.748 132.635 103.96 129.996 97.5909C127.358 91.2213 126 84.3944 126 77.5L178.5 77.5L141.377 114.623Z" fill="{{$color->color->scheme->colors[2]->hex->value}}"/>
						@endif
						@if(isset($color->color->scheme->colors[3]))
						<path d="M178.5 130C171.606 130 164.779 128.642 158.409 126.004C152.04 123.365 146.252 119.498 141.377 114.623L178.5 77.5L178.5 130Z" fill="black" fill-opacity="0.3"/>
						<path d="M126 77.5C126 70.6056 127.358 63.7787 129.996 57.4091C132.635 51.0395 136.502 45.252 141.377 40.3769L178.5 77.5L126 77.5Z" fill="{{$color->color->scheme->colors[3]->hex->value}}"/>
						@endif
						@if(isset($color->color->scheme->colors[4]))
						<path d="M141.377 40.3769C146.252 35.5018 152.04 31.6347 158.409 28.9963C164.779 26.358 171.606 25 178.5 25L178.5 77.5L141.377 40.3769Z" fill="{{$color->color->scheme->colors[4]->hex->value}}"/>
						<ellipse cx="84" cy="16" rx="16" ry="16" transform="rotate(-180 84 16)" fill="{{$color->color->scheme->colors[4]->hex->value}}"/>
						@endif
						@if(isset($color->color->scheme->colors[3]))
						<ellipse cx="84" cy="57" rx="16" ry="16" transform="rotate(-180 84 57)" fill="{{$color->color->scheme->colors[3]->hex->value}}"/>
						@endif
						@if(isset($color->color->scheme->colors[1]))
						<ellipse cx="84" cy="98" rx="16" ry="16" transform="rotate(-180 84 98)" fill="{{$color->color->scheme->colors[1]->hex->value}}"/>
						@endif
						@if(isset($color->color->scheme->colors[0]))
						<ellipse cx="84" cy="139" rx="16" ry="16" transform="rotate(-180 84 139)" fill="{{$color->color->scheme->colors[0]->hex->value}}"/>
						@endif
						<path d="M80.9963 17.728H80.0043V19H78.9963V17.728H75.9243V17.008L78.6843 13.4H79.7963L77.1963 16.848H79.0283V15.72H80.0043V16.848H80.9963V17.728ZM83.77 19.08C83.322 19.08 82.922 18.968 82.57 18.744C82.218 18.5147 81.9407 18.184 81.738 17.752C81.5354 17.3147 81.434 16.7973 81.434 16.2C81.434 15.6027 81.5354 15.088 81.738 14.656C81.9407 14.2187 82.218 13.888 82.57 13.664C82.922 13.4347 83.322 13.32 83.77 13.32C84.218 13.32 84.618 13.4347 84.97 13.664C85.3274 13.888 85.6074 14.2187 85.81 14.656C86.0127 15.088 86.114 15.6027 86.114 16.2C86.114 16.7973 86.0127 17.3147 85.81 17.752C85.6074 18.184 85.3274 18.5147 84.97 18.744C84.618 18.968 84.218 19.08 83.77 19.08ZM83.77 18.176C84.17 18.176 84.4847 18.0107 84.714 17.68C84.9487 17.3493 85.066 16.856 85.066 16.2C85.066 15.544 84.9487 15.0507 84.714 14.72C84.4847 14.3893 84.17 14.224 83.77 14.224C83.3754 14.224 83.0607 14.3893 82.826 14.72C82.5967 15.0507 82.482 15.544 82.482 16.2C82.482 16.856 82.5967 17.3493 82.826 17.68C83.0607 18.0107 83.3754 18.176 83.77 18.176ZM88.0648 16.416C87.6648 16.416 87.3422 16.2747 87.0968 15.992C86.8515 15.7093 86.7288 15.3387 86.7288 14.88C86.7288 14.4213 86.8515 14.0507 87.0968 13.768C87.3422 13.4853 87.6648 13.344 88.0648 13.344C88.4648 13.344 88.7875 13.4853 89.0328 13.768C89.2835 14.0453 89.4088 14.416 89.4088 14.88C89.4088 15.344 89.2835 15.7173 89.0328 16C88.7875 16.2773 88.4648 16.416 88.0648 16.416ZM91.4248 13.4H92.2088L88.3848 19H87.6008L91.4248 13.4ZM88.0648 15.856C88.2835 15.856 88.4515 15.7707 88.5688 15.6C88.6915 15.4293 88.7528 15.1893 88.7528 14.88C88.7528 14.5707 88.6915 14.3307 88.5688 14.16C88.4515 13.9893 88.2835 13.904 88.0648 13.904C87.8568 13.904 87.6888 13.992 87.5608 14.168C87.4382 14.3387 87.3768 14.576 87.3768 14.88C87.3768 15.184 87.4382 15.424 87.5608 15.6C87.6888 15.7707 87.8568 15.856 88.0648 15.856ZM91.7368 19.056C91.3368 19.056 91.0142 18.9147 90.7688 18.632C90.5235 18.3493 90.4008 17.9787 90.4008 17.52C90.4008 17.0613 90.5235 16.6907 90.7688 16.408C91.0142 16.1253 91.3368 15.984 91.7368 15.984C92.1368 15.984 92.4595 16.1253 92.7048 16.408C92.9555 16.6907 93.0808 17.0613 93.0808 17.52C93.0808 17.9787 92.9555 18.3493 92.7048 18.632C92.4595 18.9147 92.1368 19.056 91.7368 19.056ZM91.7368 18.496C91.9502 18.496 92.1182 18.4107 92.2408 18.24C92.3635 18.064 92.4248 17.824 92.4248 17.52C92.4248 17.216 92.3635 16.9787 92.2408 16.808C92.1182 16.632 91.9502 16.544 91.7368 16.544C91.5235 16.544 91.3555 16.6293 91.2328 16.8C91.1102 16.9707 91.0488 17.2107 91.0488 17.52C91.0488 17.8293 91.1102 18.0693 91.2328 18.24C91.3555 18.4107 91.5235 18.496 91.7368 18.496Z" fill="white"/>
						<path d="M76.9658 134.6H75.5498V136H74.6938V134.6H73.2778V133.8H74.6938V132.4H75.5498V133.8H76.9658V134.6ZM80.0563 133.712C80.5736 133.776 80.9683 133.952 81.2403 134.24C81.5123 134.528 81.6483 134.888 81.6483 135.32C81.6483 135.645 81.5656 135.941 81.4003 136.208C81.235 136.475 80.9843 136.688 80.6483 136.848C80.3176 137.003 79.9123 137.08 79.4323 137.08C79.0323 137.08 78.6456 137.024 78.2723 136.912C77.9043 136.795 77.5896 136.635 77.3283 136.432L77.7763 135.624C77.979 135.795 78.2243 135.931 78.5123 136.032C78.8056 136.128 79.107 136.176 79.4163 136.176C79.7843 136.176 80.0723 136.101 80.2803 135.952C80.4936 135.797 80.6003 135.589 80.6003 135.328C80.6003 135.067 80.499 134.864 80.2963 134.72C80.099 134.571 79.795 134.496 79.3843 134.496H78.8723V133.784L80.1443 132.272H77.6003V131.4H81.4163V132.096L80.0563 133.712ZM84.6646 137.08C84.2166 137.08 83.8166 136.968 83.4646 136.744C83.1126 136.515 82.8352 136.184 82.6326 135.752C82.4299 135.315 82.3286 134.797 82.3286 134.2C82.3286 133.603 82.4299 133.088 82.6326 132.656C82.8352 132.219 83.1126 131.888 83.4646 131.664C83.8166 131.435 84.2166 131.32 84.6646 131.32C85.1126 131.32 85.5126 131.435 85.8646 131.664C86.2219 131.888 86.5019 132.219 86.7046 132.656C86.9072 133.088 87.0086 133.603 87.0086 134.2C87.0086 134.797 86.9072 135.315 86.7046 135.752C86.5019 136.184 86.2219 136.515 85.8646 136.744C85.5126 136.968 85.1126 137.08 84.6646 137.08ZM84.6646 136.176C85.0646 136.176 85.3792 136.011 85.6086 135.68C85.8432 135.349 85.9606 134.856 85.9606 134.2C85.9606 133.544 85.8432 133.051 85.6086 132.72C85.3792 132.389 85.0646 132.224 84.6646 132.224C84.2699 132.224 83.9552 132.389 83.7206 132.72C83.4912 133.051 83.3766 133.544 83.3766 134.2C83.3766 134.856 83.4912 135.349 83.7206 135.68C83.9552 136.011 84.2699 136.176 84.6646 136.176ZM88.9594 134.416C88.5594 134.416 88.2367 134.275 87.9914 133.992C87.746 133.709 87.6234 133.339 87.6234 132.88C87.6234 132.421 87.746 132.051 87.9914 131.768C88.2367 131.485 88.5594 131.344 88.9594 131.344C89.3594 131.344 89.682 131.485 89.9274 131.768C90.178 132.045 90.3034 132.416 90.3034 132.88C90.3034 133.344 90.178 133.717 89.9274 134C89.682 134.277 89.3594 134.416 88.9594 134.416ZM92.3194 131.4H93.1034L89.2794 137H88.4954L92.3194 131.4ZM88.9594 133.856C89.178 133.856 89.346 133.771 89.4634 133.6C89.586 133.429 89.6474 133.189 89.6474 132.88C89.6474 132.571 89.586 132.331 89.4634 132.16C89.346 131.989 89.178 131.904 88.9594 131.904C88.7514 131.904 88.5834 131.992 88.4554 132.168C88.3327 132.339 88.2714 132.576 88.2714 132.88C88.2714 133.184 88.3327 133.424 88.4554 133.6C88.5834 133.771 88.7514 133.856 88.9594 133.856ZM92.6314 137.056C92.2314 137.056 91.9087 136.915 91.6634 136.632C91.418 136.349 91.2954 135.979 91.2954 135.52C91.2954 135.061 91.418 134.691 91.6634 134.408C91.9087 134.125 92.2314 133.984 92.6314 133.984C93.0314 133.984 93.354 134.125 93.5994 134.408C93.85 134.691 93.9754 135.061 93.9754 135.52C93.9754 135.979 93.85 136.349 93.5994 136.632C93.354 136.915 93.0314 137.056 92.6314 137.056ZM92.6314 136.496C92.8447 136.496 93.0127 136.411 93.1354 136.24C93.258 136.064 93.3194 135.824 93.3194 135.52C93.3194 135.216 93.258 134.979 93.1354 134.808C93.0127 134.632 92.8447 134.544 92.6314 134.544C92.418 134.544 92.25 134.629 92.1274 134.8C92.0047 134.971 91.9434 135.211 91.9434 135.52C91.9434 135.829 92.0047 136.069 92.1274 136.24C92.25 136.411 92.418 136.496 92.6314 136.496ZM76.7239 143.088C77.0332 143.189 77.2786 143.36 77.4599 143.6C77.6412 143.835 77.7319 144.128 77.7319 144.48C77.7319 144.965 77.5452 145.341 77.1719 145.608C76.7986 145.869 76.2546 146 75.5399 146H72.7559V140.4H75.3799C76.0412 140.4 76.5506 140.531 76.9079 140.792C77.2652 141.048 77.4439 141.403 77.4439 141.856C77.4439 142.133 77.3799 142.379 77.2519 142.592C77.1239 142.805 76.9479 142.971 76.7239 143.088ZM73.7959 141.216V142.76H75.2679C75.6306 142.76 75.9079 142.696 76.0999 142.568C76.2972 142.435 76.3959 142.243 76.3959 141.992C76.3959 141.736 76.2972 141.544 76.0999 141.416C75.9079 141.283 75.6306 141.216 75.2679 141.216H73.7959ZM75.4759 145.184C76.2812 145.184 76.6839 144.915 76.6839 144.376C76.6839 143.837 76.2812 143.568 75.4759 143.568H73.7959V145.184H75.4759ZM78.7458 140.064H79.7458V146H78.7458V140.064ZM82.6903 141.68C83.3197 141.68 83.7997 141.832 84.1303 142.136C84.4663 142.435 84.6343 142.888 84.6343 143.496V146H83.6903V145.48C83.5677 145.667 83.3917 145.811 83.1623 145.912C82.9383 146.008 82.6663 146.056 82.3463 146.056C82.0263 146.056 81.7463 146.003 81.5063 145.896C81.2663 145.784 81.0797 145.632 80.9463 145.44C80.8183 145.243 80.7543 145.021 80.7543 144.776C80.7543 144.392 80.8957 144.085 81.1783 143.856C81.4663 143.621 81.917 143.504 82.5303 143.504H83.6343V143.44C83.6343 143.141 83.5437 142.912 83.3623 142.752C83.1863 142.592 82.9223 142.512 82.5703 142.512C82.3303 142.512 82.093 142.549 81.8583 142.624C81.629 142.699 81.4343 142.803 81.2743 142.936L80.8823 142.208C81.1063 142.037 81.3757 141.907 81.6903 141.816C82.005 141.725 82.3383 141.68 82.6903 141.68ZM82.5543 145.328C82.805 145.328 83.0263 145.272 83.2183 145.16C83.4157 145.043 83.5543 144.877 83.6343 144.664V144.168H82.6023C82.0263 144.168 81.7383 144.357 81.7383 144.736C81.7383 144.917 81.8103 145.061 81.9543 145.168C82.0983 145.275 82.2983 145.328 82.5543 145.328ZM87.9168 146.056C87.4741 146.056 87.0768 145.963 86.7248 145.776C86.3728 145.589 86.0981 145.331 85.9008 145C85.7034 144.664 85.6048 144.285 85.6048 143.864C85.6048 143.443 85.7034 143.067 85.9008 142.736C86.0981 142.405 86.3701 142.147 86.7168 141.96C87.0688 141.773 87.4688 141.68 87.9168 141.68C88.3381 141.68 88.7061 141.765 89.0208 141.936C89.3408 142.107 89.5808 142.352 89.7408 142.672L88.9728 143.12C88.8501 142.923 88.6954 142.776 88.5088 142.68C88.3274 142.579 88.1274 142.528 87.9088 142.528C87.5354 142.528 87.2261 142.651 86.9808 142.896C86.7354 143.136 86.6128 143.459 86.6128 143.864C86.6128 144.269 86.7328 144.595 86.9728 144.84C87.2181 145.08 87.5301 145.2 87.9088 145.2C88.1274 145.2 88.3274 145.152 88.5088 145.056C88.6954 144.955 88.8501 144.805 88.9728 144.608L89.7408 145.056C89.5754 145.376 89.3328 145.624 89.0128 145.8C88.6981 145.971 88.3328 146.056 87.9168 146.056ZM92.3102 144.168L91.5662 144.872V146H90.5662V140.064H91.5662V143.648L93.6382 141.728H94.8382L93.0542 143.52L95.0062 146H93.7902L92.3102 144.168Z" fill="white"/>
						<path d="M76.4403 95.4V101H75.4003V96.272H74.2163V95.4H76.4403ZM79.8872 101.08C79.4392 101.08 79.0392 100.968 78.6872 100.744C78.3352 100.515 78.0579 100.184 77.8552 99.752C77.6526 99.3147 77.5512 98.7973 77.5512 98.2C77.5512 97.6027 77.6526 97.088 77.8552 96.656C78.0579 96.2187 78.3352 95.888 78.6872 95.664C79.0392 95.4347 79.4392 95.32 79.8872 95.32C80.3352 95.32 80.7352 95.4347 81.0872 95.664C81.4446 95.888 81.7246 96.2187 81.9272 96.656C82.1299 97.088 82.2312 97.6027 82.2312 98.2C82.2312 98.7973 82.1299 99.3147 81.9272 99.752C81.7246 100.184 81.4446 100.515 81.0872 100.744C80.7352 100.968 80.3352 101.08 79.8872 101.08ZM79.8872 100.176C80.2872 100.176 80.6019 100.011 80.8312 99.68C81.0659 99.3493 81.1832 98.856 81.1832 98.2C81.1832 97.544 81.0659 97.0507 80.8312 96.72C80.6019 96.3893 80.2872 96.224 79.8872 96.224C79.4926 96.224 79.1779 96.3893 78.9432 96.72C78.7139 97.0507 78.5992 97.544 78.5992 98.2C78.5992 98.856 78.7139 99.3493 78.9432 99.68C79.1779 100.011 79.4926 100.176 79.8872 100.176ZM85.27 101.08C84.822 101.08 84.422 100.968 84.07 100.744C83.718 100.515 83.4407 100.184 83.238 99.752C83.0354 99.3147 82.934 98.7973 82.934 98.2C82.934 97.6027 83.0354 97.088 83.238 96.656C83.4407 96.2187 83.718 95.888 84.07 95.664C84.422 95.4347 84.822 95.32 85.27 95.32C85.718 95.32 86.118 95.4347 86.47 95.664C86.8274 95.888 87.1074 96.2187 87.31 96.656C87.5127 97.088 87.614 97.6027 87.614 98.2C87.614 98.7973 87.5127 99.3147 87.31 99.752C87.1074 100.184 86.8274 100.515 86.47 100.744C86.118 100.968 85.718 101.08 85.27 101.08ZM85.27 100.176C85.67 100.176 85.9847 100.011 86.214 99.68C86.4487 99.3493 86.566 98.856 86.566 98.2C86.566 97.544 86.4487 97.0507 86.214 96.72C85.9847 96.3893 85.67 96.224 85.27 96.224C84.8754 96.224 84.5607 96.3893 84.326 96.72C84.0967 97.0507 83.982 97.544 83.982 98.2C83.982 98.856 84.0967 99.3493 84.326 99.68C84.5607 100.011 84.8754 100.176 85.27 100.176ZM89.5648 98.416C89.1648 98.416 88.8422 98.2747 88.5968 97.992C88.3515 97.7093 88.2288 97.3387 88.2288 96.88C88.2288 96.4213 88.3515 96.0507 88.5968 95.768C88.8422 95.4853 89.1648 95.344 89.5648 95.344C89.9648 95.344 90.2875 95.4853 90.5328 95.768C90.7835 96.0453 90.9088 96.416 90.9088 96.88C90.9088 97.344 90.7835 97.7173 90.5328 98C90.2875 98.2773 89.9648 98.416 89.5648 98.416ZM92.9248 95.4H93.7088L89.8848 101H89.1008L92.9248 95.4ZM89.5648 97.856C89.7835 97.856 89.9515 97.7707 90.0688 97.6C90.1915 97.4293 90.2528 97.1893 90.2528 96.88C90.2528 96.5707 90.1915 96.3307 90.0688 96.16C89.9515 95.9893 89.7835 95.904 89.5648 95.904C89.3568 95.904 89.1888 95.992 89.0608 96.168C88.9382 96.3387 88.8768 96.576 88.8768 96.88C88.8768 97.184 88.9382 97.424 89.0608 97.6C89.1888 97.7707 89.3568 97.856 89.5648 97.856ZM93.2368 101.056C92.8368 101.056 92.5142 100.915 92.2688 100.632C92.0235 100.349 91.9008 99.9787 91.9008 99.52C91.9008 99.0613 92.0235 98.6907 92.2688 98.408C92.5142 98.1253 92.8368 97.984 93.2368 97.984C93.6368 97.984 93.9595 98.1253 94.2048 98.408C94.4555 98.6907 94.5808 99.0613 94.5808 99.52C94.5808 99.9787 94.4555 100.349 94.2048 100.632C93.9595 100.915 93.6368 101.056 93.2368 101.056ZM93.2368 100.496C93.4502 100.496 93.6182 100.411 93.7408 100.24C93.8635 100.064 93.9248 99.824 93.9248 99.52C93.9248 99.216 93.8635 98.9787 93.7408 98.808C93.6182 98.632 93.4502 98.544 93.2368 98.544C93.0235 98.544 92.8555 98.6293 92.7328 98.8C92.6102 98.9707 92.5488 99.2107 92.5488 99.52C92.5488 99.8293 92.6102 100.069 92.7328 100.24C92.8555 100.411 93.0235 100.496 93.2368 100.496Z" fill="white"/>
						<path d="M80.5877 54.4V55.096L78.4117 60H77.2997L79.4037 55.28H77.2037V56.232H76.2357V54.4H80.5877ZM83.4107 60.08C82.9627 60.08 82.5627 59.968 82.2107 59.744C81.8587 59.5147 81.5813 59.184 81.3787 58.752C81.176 58.3147 81.0747 57.7973 81.0747 57.2C81.0747 56.6027 81.176 56.088 81.3787 55.656C81.5813 55.2187 81.8587 54.888 82.2107 54.664C82.5627 54.4347 82.9627 54.32 83.4107 54.32C83.8587 54.32 84.2587 54.4347 84.6107 54.664C84.968 54.888 85.248 55.2187 85.4507 55.656C85.6533 56.088 85.7547 56.6027 85.7547 57.2C85.7547 57.7973 85.6533 58.3147 85.4507 58.752C85.248 59.184 84.968 59.5147 84.6107 59.744C84.2587 59.968 83.8587 60.08 83.4107 60.08ZM83.4107 59.176C83.8107 59.176 84.1253 59.0107 84.3547 58.68C84.5893 58.3493 84.7067 57.856 84.7067 57.2C84.7067 56.544 84.5893 56.0507 84.3547 55.72C84.1253 55.3893 83.8107 55.224 83.4107 55.224C83.016 55.224 82.7013 55.3893 82.4667 55.72C82.2373 56.0507 82.1227 56.544 82.1227 57.2C82.1227 57.856 82.2373 58.3493 82.4667 58.68C82.7013 59.0107 83.016 59.176 83.4107 59.176ZM87.7055 57.416C87.3055 57.416 86.9828 57.2747 86.7375 56.992C86.4921 56.7093 86.3695 56.3387 86.3695 55.88C86.3695 55.4213 86.4921 55.0507 86.7375 54.768C86.9828 54.4853 87.3055 54.344 87.7055 54.344C88.1055 54.344 88.4281 54.4853 88.6735 54.768C88.9241 55.0453 89.0495 55.416 89.0495 55.88C89.0495 56.344 88.9241 56.7173 88.6735 57C88.4281 57.2773 88.1055 57.416 87.7055 57.416ZM91.0655 54.4H91.8495L88.0255 60H87.2415L91.0655 54.4ZM87.7055 56.856C87.9241 56.856 88.0921 56.7707 88.2095 56.6C88.3321 56.4293 88.3935 56.1893 88.3935 55.88C88.3935 55.5707 88.3321 55.3307 88.2095 55.16C88.0921 54.9893 87.9241 54.904 87.7055 54.904C87.4975 54.904 87.3295 54.992 87.2015 55.168C87.0788 55.3387 87.0175 55.576 87.0175 55.88C87.0175 56.184 87.0788 56.424 87.2015 56.6C87.3295 56.7707 87.4975 56.856 87.7055 56.856ZM91.3775 60.056C90.9775 60.056 90.6548 59.9147 90.4095 59.632C90.1641 59.3493 90.0415 58.9787 90.0415 58.52C90.0415 58.0613 90.1641 57.6907 90.4095 57.408C90.6548 57.1253 90.9775 56.984 91.3775 56.984C91.7775 56.984 92.1001 57.1253 92.3455 57.408C92.5961 57.6907 92.7215 58.0613 92.7215 58.52C92.7215 58.9787 92.5961 59.3493 92.3455 59.632C92.1001 59.9147 91.7775 60.056 91.3775 60.056ZM91.3775 59.496C91.5908 59.496 91.7588 59.4107 91.8815 59.24C92.0041 59.064 92.0655 58.824 92.0655 58.52C92.0655 58.216 92.0041 57.9787 91.8815 57.808C91.7588 57.632 91.5908 57.544 91.3775 57.544C91.1641 57.544 90.9961 57.6293 90.8735 57.8C90.7508 57.9707 90.6895 58.2107 90.6895 58.52C90.6895 58.8293 90.7508 59.0693 90.8735 59.24C90.9961 59.4107 91.1641 59.496 91.3775 59.496Z" fill="white"/>
						<path d="M104 16H140.901L150 28" stroke="#C7C7C7"/>
						<path d="M104 139H140.901L150 127" stroke="#C7C7C7"/>
						<path d="M104 57H116.429L122 61" stroke="#C7C7C7"/>
						<path d="M104 99H116.429L122 95" stroke="#C7C7C7"/>
						</svg>
						@if(isset($color->color->scheme->colors[4]))
						<div class="color-title ct1">{{$color->color->scheme->colors[4]->hex->value}}</div>
						@endif
						@if(isset($color->color->scheme->colors[3]))
						<div class="color-title ct2">{{$color->color->scheme->colors[3]->hex->value}}</div>
						@endif
						@if(isset($color->color->scheme->colors[1]))
						<div class="color-title ct3">{{$color->color->scheme->colors[1]->hex->value}}</div>
						@endif
						@if(isset($color->color->scheme->colors[0]))
						<div class="color-title ct4">{{$color->color->scheme->colors[0]->hex->value}}</div>
						@endif
						<div class="color-description-block">
							<div class="key-value">
								<div class="key">Hex</div>
								<div class="value">{{$color->color->hex->value}}</div>
							</div>
							<div class="key-value">
								<div class="key">RGB</div>
								<div class="value">{{$color->color->rgb->r}} {{$color->color->rgb->g}} {{$color->color->rgb->b}}</div>
							</div>
							<div class="key-value">
								<div class="key">CMYK</div>
								<div class="value">{{$color->color->cmyk->c}} {{$color->color->cmyk->m}} {{$color->color->cmyk->y}} {{$color->color->cmyk->k}}</div>
							</div>
							@if($color->pantone!=null)
								<div class="key-value">
									<div class="key">Pantone</div>
									<div class="value">{{$color->pantone->getName()}}</div>
								</div>
							@endif
						</div>
				</div>
				@endif
			@endif
		@endforeach
	</div>
	<div class="page-break"></div>
	<div id="page28">
		<div class="page-number" id="Our Fonts">28</div>
		<div class="gradient"></div>
		@php
			$cv = $data->core_values;
		@endphp
		@if(isset($data->fonts_main[3]))
		<div class="huge-text text-one">
			@if(isset($cv[0]))
			{!!str_replace(' ', '<br>', $cv[0]['title'])!!}
			@else
			SPICE<br>UP<br>YOUR<br>BRAND
			@endif
			<small>
				{{$data->fonts_main[3]['font_face']}} {{$data->fonts_main[3]['weight']}} 100 Pt
			</small>
		</div>
		<div class="huge-number text-one">
			25%
			<small>
				{{$data->fonts_main[3]['font_face']}} {{$data->fonts_main[3]['weight']}} 70 Pt
			</small>
		</div>
		@endif
		@if(isset($data->fonts_main[2]))
		<div class="huge-text text-two">
			@if(isset($cv[1]))
			{!!str_replace(' ', '<br>', $cv[1]['title'])!!}
			@else
			NOT ALL<br>FONTS WERE<br>CREATED<br>EQUAL
			@endif
			<small>
				{{$data->fonts_main[2]['font_face']}} {{$data->fonts_main[2]['weight']}} 100 Pt
			</small>
		</div>
		<div class="huge-number text-two">
			$1,0000
			<small>
				{{$data->fonts_main[2]['font_face']}} {{$data->fonts_main[2]['weight']}} 70 Pt
			</small>
		</div>
		@endif
		@if(isset($data->fonts_main[1]))
		<div class="huge-text text-three">
			@if(isset($cv[2]))
			{!!str_replace(' ', '<br>', $cv[2]['title'])!!}
			@else
			FONT<br>WEIGHT,<br>COLOR<br>& SIZE
			@endif
			<small>
				{{$data->fonts_main[1]['font_face']}} {{$data->fonts_main[1]['weight']}} 100 Pt
			</small>
		</div>
		<div class="huge-number text-three">
			{{$data->colors_list[0]->id}}
			<small>
				{{$data->fonts_main[1]['font_face']}} {{$data->fonts_main[1]['weight']}} 70 Pt
			</small>
		</div>
		@endif
	</div>
	<div class="page-break"></div>
	<div id="page29">
		<div class="page-number right">29</div>
		<h1 class="title">Our Fonts</h1>
		<div class="text">
			@if(isset($data->fonts_main) && isset($data->fonts_main[1]))
				The primary font is
				{{$data->fonts_main[1]['font_face']}}
				and it has
				{{count($data->fonts_main)}}
				{{Str::plural('weight', count($data->fonts_main))}}:
				@if(count($data->fonts_main)==3)
					{{$data->fonts_main[2]['weight']}}, {{$data->fonts_main[1]['weight']}} & {{$data->fonts_main[3]['weight']}}
				@elseif(count($data->fonts_main)==3)
					{{$data->fonts_main[1]['weight']}} & {{$data->fonts_main[2]['weight']}}
				@else
					{{$data->fonts_main[1]['weight']}}
				@endif.
			@endif
			@if(isset($data->fonts_secondary) && isset($data->fonts_secondary[1]))
				Our secondary font is {{$data->fonts_secondary[1]['font_face']}} and it has {{count($data->fonts_secondary)}} {{Str::plural('weight', count($data->fonts_secondary))}}:
				@if(count($data->fonts_secondary)==3)
					{{$data->fonts_secondary[2]['weight']}},
					{{$data->fonts_secondary[1]['weight']}} & {{$data->fonts_secondary[3]['weight']}}
				@elseif(count($data->fonts_secondary)==2)
					{{$data->fonts_secondary[1]['weight']}}
					@if(isset($data->fonts_secondary[2])) & {{$data->fonts_secondary[2]['weight']}}
					@endif
				@else
					{{$data->fonts_secondary[1]['weight']}}
				@endif.
			@endif
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page30">
		<div class="page-number">30</div>
		<div class="fonts2-title">Primary Font</div>
		<div class="gradient-line"></div>
		@if(isset($data->fonts_main) && isset($data->fonts_main[1]))
		<div class="fonts2-fontname">{{$data->fonts_main[1]['font_face']}}</div>
		@endif
		@foreach($data->fonts_main as $fm)
			@if(isset($fm['index']))
				<div class="fonts2-weight font-{{$fm['index']}}">
					@if(isset($fm['weight']))<em>{{$fm['weight']}}</em>@endif
					<p>ABCDEFGHIJKLMNOPQRSTUVWXYZ</p>
					<p>abcdefghijklmnopqrstuvwxyz</p>
					<p>1234567890</p>
				</div>
			@endif
		@endforeach
	</div>
	<div class="page-break"></div>
	<div id="page31">
		<div class="page-number right">31</div>
		<div class="fonts2-title">Secondary Font</div>
		<div class="gradient-line"></div>
		@if(isset($data->fonts_secondary) && isset($data->fonts_secondary[1]))
		<div class="fonts2-fontname">{{$data->fonts_secondary[1]['font_face']}}</div>
		@endif
		@foreach($data->fonts_secondary as $fs)
			@if(isset($fs['index']))
			<div class="fonts2-weight font-{{$fs['index']}}">
				<em>{{$fs['weight']}}</em>
				<p>ABCDEFGHIJKLMNOPQRSTUVWXYZ</p>
				<p>abcdefghijklmnopqrstuvwxyz</p>
				<p>1234567890</p>
			</div>
			@endif
		@endforeach
	</div>
	<div class="page-break"></div>
	<div id="page32">
		<div class="page-number text-white" id="Brandbook designer">32</div>
		<div class="gradient"></div>
		<div class="user-info">
			<div class="image">
				<img src="{{$data->user->avatar}}" alt="">
			</div>
			<div class="name">{{$data->user->name}}</div>
			<div class="position">{{$data->user->position}}</div>
		</div>
		<h1 class="title text-white">Brand Book Designer</h1>
		<div class="text text-white">
			{{$data->user->description}}
		</div>

		<div class="company">
			<div class="company-logo">
				<img src="{{$data->user->company_logo}}" alt="">
			</div>
			<div class="web">
				<p>{{$data->user->company_web}}</p>
				<p>{{$data->user->company_dribble}}</p>
				<p>{{$data->user->company_behance}}</p>
			</div>
			<div class="contact">
				<p>Contact</p>
				<p>{{$data->user->company_phone}}</p>
				<p>{{$data->user->company_email}}</p>
			</div>
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page33">
		<div class="page-number text-white right">33</div>
		<div class="gradient"></div>
	</div>
	<div class="page-break"></div>
	<div id="page34">
		<div class="page-number">34</div>
		<div class="text-center">
			<p>Designed by</p>
			<div class="company-logo">
				<img src="{{$data->user->company_logo_full}}" alt="">
			</div>
			<div class="logo-gingersauce"><svg width="14" height="14" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"/></svg> Powered by gingersauce</div>
		</div>
	</div>
	<div class="page-break"></div>
	<div id="page35">
		<div class="page-number right">35</div>
		<div class="gradient"></div>
	</div>
	<div class="page-break"></div>
	<div id="page36">
		<div class="gradient"></div>
		<div class="small-title">
			{{$data->brand}} Brand Book
		</div>
		<div class="logo-gingersauce"><svg width="14" height="14" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"/></svg> Powered by gingersauce</div>
	</div>
</div>
</body>
</html>
