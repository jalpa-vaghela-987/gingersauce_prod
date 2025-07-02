@php
    $approved_primary_color = false;
    $approved_secondary_color = false;

    $white_bg_logo = $data->logo_b64;
    if(
        optional($data->logo_versions[0])->white_bg_logo_type == 'white' &&
        ($white_bg_logo_object = optional($data->logo_versions[0])->white_bg_logo)
    )
    {
        $white_bg_logo = $white_bg_logo_object->logo_b64;
    }

    foreach($data->approved as $approved) {
        if(!empty($approved->title) && $approved->title=='Primary Color Positive') {
            $approved_primary_color = true;
        }
        if(!empty($approved->title) && $approved->title=='Secondary Color Positive') {
            $approved_secondary_color = true;
        }
    }
@endphp
<html>
<head>

    @if(!empty($data->custom['body_family']))
        <link
            href="https://fonts.googleapis.com/css?family={{$data->custom['body_family']}}:{{$data->custom['body_weight']}}&display=swap"
            rel="stylesheet">
    @endif

    @if(!empty($data->custom['title_family']))
        <link
            href="https://fonts.googleapis.com/css?family={{$data->custom['title_family']}}:{{$data->custom['title_weight']}}&display=swap"
            rel="stylesheet">
    @endif

    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <style>
        html, body {
            margin: 0;
            padding: 0;
        }

        /*ARCHETYPES*/
        div#page-voices-1, div#page-voices-2 {
            position: relative;
            padding: 40px;
        }

        svg.voices-figure-1 {
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .archetype-image-wrap path.fill_white {
            fill: white;
        }

        .archetype-image-wrap path.fill_black {
            fill: black;
        }


        svg.voices-figure-2 {
            position: absolute;
            top: 0;
            right: 0;
        }

        .double .archetype-image-wrap:first-child {
            text-align: left;
        }

        .voices-wrap-left {
            position: absolute;
            color: black;
            left: 40px;
            bottom: 40px;
            padding-right: 100px;
        }

        .voices-wrap-left h1.title {
            font-size: 60px;
            font-style: normal;
            font-weight: 400;
            line-height: 46px;
            letter-spacing: 0em;
            text-align: left;
        }

        .voices-wrap-left .voices-text {
            color: black;
            z-index: 9999;
            position: relative;
        }

        .double .archetype-image-wrap {
            height: 100%;
            float: left;
            width: 50%;
            position: relative;
            z-index: 999;
        }

        .and {
            position: absolute;
            font-family: Abril Fatface;
            font-size: 103px;
            font-style: normal;
            font-weight: 400;
            line-height: 79px;
            letter-spacing: 0em;
            left: 42%;
            z-index: 999;
            top: 159px;
        }

        .voices-names {
            font-weight: 500;
            font-size: 28px;
        }

        .archetype-descritpion p {
            padding-right: 40px;
        }

        .voices-images {
            height: 115%;
        }

        .single .voices-images {
            text-align: center;
            height: 300px;
            position: relative;
            z-index: 9;
        }

        .voices-descritpion-short {
            font-weight: bold;
            padding-right: 40px;
        }

        .archetype-descritpion.archetype-descritpion-left {
            float: left;
            width: 50%;
        }

        .archetype-descritpion.archetype-descritpion-right {
            float: right;
            width: 50%;
            padding-left: 20px;
        }

        .single .archetype-descritpion.archetype-descritpion-left {
            padding-left: 80px;
            padding-right: 100px;
            text-align: center;
            position: relative;
            top: -60px;
            float: none;
            width: 100%;
        }

        .single .archetype-image-wrap {
            height: 100%;
            width: 100%;
        }

        .archetype-image-wrap svg {
            height: 100%;
        }

        .single .archetype-image-wrap svg {
            width: 270px;
            padding-top: 40px;
        }

        .archetype-name, .archetype-and {
            font-size: 34px;
            font-style: normal;
            font-weight: 500;
            line-height: 51px;
            letter-spacing: 0em;
        }

        .single .voices-description {
            position: absolute;
            bottom: 80px;
        }

        @if(isset($data->colors_list[1]))
        .archetype-image-wrap path.secondary_color {
            fill: {{$data->colors_list[1]->id}};
        }

        @endif

        @if(isset($data->colors_list[0]))
        .archetype-image-wrap path.main_color {
            fill: {{$data->colors_list[0]->id}};
        }

        @endif

        .voices-images {
            text-align: center;
            height: 60%;
        }

        .page-break {
            page-break-after: always;
        }

        img.watermark-draft {
            width: 20%;
            position: absolute;
            bottom: 10%;
            left: 50%;
            opacity: 0.5;
            margin: auto;
            margin-left: -10%;
        }

        div[id^="page"] {
            position: relative;
            width: 760px !important;
            height: 760px !important;
            margin: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            overflow: hidden;
            /*border: 1px solid black;*/
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        .page-number {
            position: absolute;
            left: 30px;
            bottom: 30px;
            right: 30px;
            font-size: 14px;
            line-height: 25px;
            z-index: 3;
            /* or 179% */


            color: #000000;
        }

        .page-number.right {
            text-align: right;
        }

        .text-white {
            color: white;
        }

        .white-theme #page1 {
            width: 760px;
            height: 760px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            background: #fff;
            position: relative;
        }

        .white-theme #page1 .logo, #page13 .logo, #page36 .logo {
            width: 40%;
            height: 40%;
            position: absolute;
            left: 30%;
            top: 30%;
            /* background-image: url(












        {{$data->logo_b64}}             ); */
            /*background-size: contain;*/
            /*background-position: center center;
	background-repeat: no-repeat;*/


        }

        .white-theme #page1 .logo {
            display: flex;
            align-items: center;
        }

        .white-theme #page1 .logo, #page13 .logo {
            width: 40%;
            height: 40%;
            position: absolute;
            left: 30%;
            top: 30%;
            background-image: url({{$white_bg_logo}});
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;


        }

        .white-theme #page1 .logo svg {
            /*width: 200px !important;*/
            width: 100%;
            max-height: 100%;
            height: auto;
            margin: auto;
            display: block;
        }

        .white-theme #page1 .logo svg path, .white-theme #page1 .logo svg rect, .white-theme #page1 .logo svg circle, .white-theme #page1 .logo svg line {
            /*	fill: #fff !important;
	stroke: #fff !important;*/
        }

        .white-theme #page1 .logo-gingersauce, #page36 .logo-gingersauce {
            color: #93989B;
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
            /*display: flex;*/
            /*justify-content: center;*/
            align-content: center;
        }

        .white-theme #page1 .logo-gingersauce svg path, #page36 .logo-gingersauce svg path {
            fill: #93989B;
        }

        .white-theme #page1 .small-title, #page36 .small-title {
            font-style: normal;
            font-weight: normal;
            font-size: 24px;
            line-height: 29px;
            text-align: center;

            color: #93989B;
            position: absolute;
            height: 29px;
            left: 0px;
            right: 0px;
            bottom: 66px;

        }

        #page13 .logo {
            width: 40%;
            height: 40%;
            position: absolute;
            left: 30%;
            top: 30%;
            background-image: url({{$white_bg_logo}});
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;


        }

        #page36 .logo-gingersauce {
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
            /*display: flex;*/
            /*justify-content: center;*/
            align-content: center;
        }

        #page36 .logo-gingersauce svg path {
            fill: #fff;
        }

        #page36 .small-title {
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

        #page2 {
            width: 221mm;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            /*background: -webkit-gradient(linear,right top,left bottom, color-stop(6.29%,#93989B), color-stop(123.12%, rgba(147, 152, 155, 0)));*/
            background: #EAEAEA;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #page2 svg {
            width: 200px;
        }

        #page2 svg path, #page2 svg rect, #page2 svg circle, #page2 svg polygon {
            fill: #fff !important;
        }

        #page3, #page5, #page7, #page8, #page9, #page10, #page11, #page12, #page14, #page16, #page18, #page19, #page20, #page24, #page25, #page26 {
            padding: 170px 90px 0;
            position: relative;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        #page11, #page14, #page15, #page16, #page16-1, #page17, #page17-1, #page23, #page25, #page26, #page27, #page27-1, #page26-26, #page28, #page29, #page30, #page31 {
            padding: 90px;
        }

        #page10 {
            /*padding-top: 440px;*/
            /*padding-left: 0;*/
            padding-top: 30px;
        }

        #page10 .title, #page10 .text {
            /*padding-left: 90px;*/
        }

        #page16 {
            /*padding-top: 500px;*/
            padding: 150px;
        }

        #page12, #page24, #page29 {
            padding-top: 340px;
        }

        #page3 .contents .content-item {
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
        }

        #page3 .contents .content-item div {
            white-space: nowrap;
            line-height: 25px;
        }

        #page3 .contents .content-item div a {
            color: #000;
            text-decoration: none;
        }

        #page3 .contents .content-item .dots {
            flex-basis: 221mm;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            border-bottom: 2px dotted #999;
            margin-top: -5px;
            margin-left: 5px;
            margin-right: 5px;
        }

        .white-theme h1.title {
            position: relative;
            @if(!empty($data->custom['title_family']))
                       font-family: {{ $data->custom['title_family'] }},{{ $data->custom['title_category'] }};
            font-weight: {{ $data->custom['title_weight'] }};
            @if(strpos($data->custom['title_weight'], 'italic'))
       font-style: italic;
            @endif
        @else
       font-family: 'Abril Fatface', cursive;
            @endif
                           font-size: 60px;
            line-height: 46px;
            margin-bottom: 27px;
            z-index: 2;
        }

        .white-theme h1.title:after {
            content: "";
            height: 6px;
            width: 108px;
            position: absolute;
            @if(isset($data->colors_list[0]))
                 background: {{$data->colors_list[0]->id}};
            @endif
                 bottom: -6px;
            left: 0;
            display: none;
        }

        .grey-theme h1.title:after {
            display: none;
        }

        .grey-theme h1.title {
            font-weight: 300;

        }

        #page5 h1.title:after, #page12 h1.title:after {
            @if(isset($data->colors_list[1]))
                               background: {{ $data->colors_list[1]->id }};
        @endif















        }

        @if(!empty($data->custom['body_family']))
        .text, .text p, .content-item {
            font-family: {{ $data->custom['body_family'] }}, {{ $data->custom['body_category'] }}              !important;
            font-style: {{ $data->custom['body_weight'] }}              !important;
            @if(strpos($data->custom['body_weight'], 'italic'))
                       font-style: italic;
        @endif








        }

        @endif


        #page5 .text, #page10 .text, #page12 .text {
            font-size: 16px;
        }

        #page7 h1.title:after {
            background: #fff;
        }

        #page7 .text, #page8 .text {
            font-size: 28px;
        }

        #page7 h1.title {
            color: #fff;
            z-index: 3;
        }

        /*background: linear-gradient(51.68deg, #93989B 2.66%, #A2224C 91.52%);*/
        #page6, #page17, #page18 {
            width: 221mm;
            position: relative;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            overflow: hidden;
        }

        #page6 .gradient-block {
            width: 442mm;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
                 background: -webkit-gradient(linear, left top, right top, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));

            @else
                 background: #ccc;
        @endif

















        }

        #page12 .gradient-block {
            width: 221mm;
            position: absolute;
            z-index: 1;
            left: 0;
            top: 0;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
                             background: -webkit-gradient(linear, right top, left bottom, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));
        @endif

















        }

        #page7 {
            width: 221mm;
            position: relative;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            overflow: hidden;
        }

        #page7 .gradient-block {
            width: 442mm;
            position: absolute;
            left: -221mm;
            top: 0;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
                 background: -webkit-gradient(linear, left top, right top, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));
            @endif
                 z-index: 1;
        }

        #page7 .text {
            position: relative;
            z-index: 3;
        }

        #page4 {
            position: relative;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        #page4 .gradient-block {
            position: absolute;
            display: block;
            left: 1px;
            top: 1px;
            height: 58px;
            width: 61%;
            @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
                 background: -webkit-gradient(linear, left top, right top, color-stop(24.97%,{{$data->colors_list[0]->id}}), color-stop(109.96%, {{$data->colors_list[1]->id}}));
        @endif

















        }

        #page9 .gradient-block {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 20mm;
            height: 20mm;
            @if(isset($data->colors_list[0]))
                           background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,{{$data->colors_list[0]->id}}), color-stop(109.96%, #fff));
        @endif















        }

        #page28 .gradient {
            left: 0;
            top: 0;
            position: absolute;
            width: 221mm;
            height: 221mm;
            z-index: 0;
            @if(isset($data->colors_list[1]))
               background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, #fff), color-stop(109.96%, {{$data->colors_list[1]->id}}));
        @endif















        }

        #page10 .gradient-block {

        @if(isset($data->colors_list[1]) )
                    background:
        -webkit-gradient

        (
        linear, left bottom, left top,
        color-stop

        (
        0
        %
        ,
        {
            $ data- > colors_list [1] -> id
        }
        }
        )
        ,
        color-stop

        (
        109.96
        %
        ,
        #fff

        )
        )
        ;
        @endif
                width:

        20
        mm

        ;
        height:

        60
        mm

        ;
        position: absolute

        ;
        left:

        0
        ;
        top:

        0
        ;
        }
        #page11 .core-values, #page10 .core-values {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            height: 308px;
            bottom: 90px;
            position: absolute;
        }

        #page11 .core-values .core-value, #page10 .core-values .core-value {
            display: flex;
            flex-wrap: nowrap;
            height: 64px;
            margin-bottom: 40px;
            flex-basis: 100%;
            align-items: center;

            /*-webkit-box-flex: 1;
      -webkit-flex: 1;
      flex: 1;*/

        }

        #page11 .core-values .core-value .img, #page10 .core-values .core-value .img {
            display: block;
            /*flex-basis: 40px;*/
            margin-right: 18px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            height: 40px;
            width: 40px;
            max-width: 40px;
        }

        #page11 .core-values .core-value .title, #page10 .core-values .core-value .title {
            font-weight: 300;
            font-size: 24px;
            flex-basis: 290px;
            line-height: 24px;
            margin-right: 40px;
            max-width: 290px;
        }

        #page11 .core-values .core-value div, #page10 .core-values .core-value div {
            font-weight: normal;
            font-size: 12px;
            line-height: 20px;
            flex-basis: 300px;
            max-width: 300px;
            margin-right: 40px;
        }

        #page12 .title, #page12 .text {
            position: relative;
            z-index: 3;
        }

        #page13, #page14, #page15, #page16-1.page16-oneside {
            width: 221mm;
            height: 221mm;
            position: relative;
        }

        #page13 .text {
            width: 100%;
            text-align: center;
            position: absolute;
            left: 0;
            top: 70%;
        }

        #page13 .text p {
            text-align: center;
        }


        .logo-versions .logo-version {
            width: 50%;
            float: left;
            text-align: center;
        }

        .logo-versions .logo-version .logo-img {
            width: 70%;
            background-size: contain;
            background-repeat: no-repeat;
            display: inline-block;
            background-position: center;
            height: 25%;
            margin-top: 35%;
        }

        .logo-versions .logo-version .logo-title {
            text-align: center;
            font-size: 12px;
            line-height: 25px;
            width: 70%;
        }

        .logo-versions .logo-version.version1 {
            float: right;
            text-align: right;
        }

        .logo-versions .logo-version.version1 .logo-title {
            float: right;
        }

        #page16, #page17 {
            position: relative;
        }

        #page16 .favicon {
            position: absolute;
            top: 50%;
            margin-top: 100px;
            margin-left: -100px;
            left: 50%;
            width: 200px;
            height: 200px;
            padding: 20px;
        }

        #page17 .favicons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        #page17 .favicon {
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

        #page17 .favicon.first {
            margin-left: -60px;
        }

        #page17 .favicon.second {
            margin-left: 60px;
        }

        #page17 .favicon:nth-child(2n) {
            margin-left: -60px;
        }

        #page17 .favicon:nth-child(2n+1) {
            margin-left: 60px;
        }

        #page16 .favicon .logo-img, #page17 .favicon .logo-img {
            height: 70px;
            width: 70px;
            margin-left: 50px;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        #page17 .favicon {
            height: 200px;
            width: 100px;
            /*left: 50%;*/
            /*margin-top: 50px;*/
        }

        #page17 .favicon .logo-img {
            padding: 10px;
            /*margin-left: -50px;*/
            display: block;
            margin: 0 auto;
        }

        #page17 {
            position: relative;
        }

        #page17 .favicon {
            /*position: absolute;*/
        }

        #page17 .favicon .logo-img .image {
            width: 50px;
            height: 50px;
        }

        #page16 .favicon .logo-title, #page17 .favicon .logo-title {
            text-align: center;
            font-style: normal;
            font-weight: normal;
            font-size: 12px;
            line-height: 25px;
            /* or 208% */

            text-align: center;

            color: #000000;
            margin-top: 20px;
            width: 100%;
        }

        #page17 .favicon .logo-title {
            /*width: 300px;	*/
            /*margin-left: -175px;*/
        }

        #page18 .background {
            position: absolute;
            left: 0;
            z-index: 1;
            bottom: 0;
        }

        .grey-theme #page18 .background {
            left: unset;
        }

        #page18 {
            padding-top: 100px;
        }

        #page19, #page21 {
            padding-top: 90px;
        }

        #page19 .logo, #page19 .icon, #page21 .logo, #page21 .icon, #page20 .icon {
            border: 1px solid #DADADA;
        }

        #page19 .logo, #page21 .logo {
            width: 300px;
            height: 200px;
            position: absolute;
            left: 30%;
            top: 120px;
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
        }

        #page21 .logo {
            width: {{$data->logo_w}}px;
            height: {{$data->logo_h}}px;
            left: 50%;
            margin-left: -{{$data->logo_w/2}}px;
        }

        #page25 .logo-image {
            width: 100%;
            height: 100px;
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
        }

        #page23 .logo {
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

        #page23 .icon {
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

        #page23 .logo_after .first, #page23 .icon_after .first {
            float: left;
            margin-left: -9px;
        }

        #page23 .logo_after {
            width: 300px;
        }

        #page23 .icon_after {
            width: 70px;
        }

        #page23 .logo_after .last, #page23 .icon_after .last {
            margin-right: -9px;
            float: right;
        }

        #page23 .logo_after .text {
            width: 280px;
            float: left;
            line-height: 51px;
            text-align: center;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            /* or 25px */

            text-align: center;

            color: #797979;
        }

        #page19 .logo {
            left: 50%;
            margin-left: -{{($data->logo_w+20)/2}}px;
        {{-- margin-left: calc(-1 * calc(calc({{$data->logo_w}}px + 20px) / 2)); --}}

















        }

        #page19 .icon, #page21 .icon, #page20 .icon {
            width: 70px;
            height: 70px;
            position: absolute;
            left: 50%;
            margin-left: -35px;
            bottom: 180px;
        }

        #page19 .icon .logo-image, #page19 .logo .logo-image, #page21 .icon .logo-image, #page20 .icon .logo-image, #page21 .logo .logo-image, #page23 .logo .logo-image, #page23 .icon .logo-image, #page25 .logo .logo-image {
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
        }

        #page20 .text-explain {
            margin-top: 200px;
            line-height: 49px;
        }

        #page20 .text-explain .texted, #page20 .text-explain .icon {
            display: inline-block;
            line-height: 49px;
            vertical-align: middle;
        }

        #page20 .text-explain .texted {
            font-style: normal;
            font-weight: bold;
            margin-right: 10px;
            font-size: 28px;
            line-height: 49px;
            /* or 89% */
            height: 49px;


            color: #000000;
        }

        #page20 .text-explain .icon {
            width: 49px;
            height: 49px;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url({{$data->icon_b64}});
        }

        #page20 .text-explain .description {
            font-style: normal;
            font-weight: normal;
            font-size: 12px;
            line-height: 18px;
            /* or 150% */


            color: #000000;
        }

        #page21 .logo-pre {
            position: absolute;
            left: -30px;
            right: -30px;
            top: -30px;
            border-top: 1px solid #dadada;
        }

        #page21 .logo-post {
            position: absolute;
            left: -30px;
            bottom: -30px;
            right: -30px;
            border-bottom: 1px solid #dadada;
        }

        #page21 .logo-pre .left, #page21 .logo-post .left {
            float: left;
            filter: grayscale(1);
        }

        #page21 .logo-post .left {
            position: relative;
        }

        #page21 .logo-post .left:before {
            height: {{$data->logo_h}}px;
            border-left: 1px solid #adadad;
            content: "";
            position: absolute;
            left: -1px;
            top: -{{$data->logo_h}}px; /*-200px;*/
        }

        #page21 .logo-pre .right:after {
            height: {{$data->logo_h}}px;
            border-left: 1px solid #adadad;
            content: "";
            position: absolute;
            right: 0;
            top: var(--y);
        }

        #page21 .logo-pre .left, #page21 .logo-post .right {
            position: relative;
        }

        #page21 .logo-pre .left:before {
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
            /* or 25px */


            color: #797979;
            height: 100%;
            border-bottom: 1px solid;
            border-top: 1px solid;
            width: 34px;
            background-size: cover;
            display: flex;
            align-items: center;
        }

        #page21 .logo-pre .right {
            border-right: 1px solid #dadada;
        }

        #page21 .logo-pre .left:after {
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

        #page21 .logo-pre .right, #page21 .logo-post .right {
            float: right;
            filter: grayscale(1);
        }

        #page21 .logo-pre .left, #page21 .logo-pre .right, #page21 .logo-post .left, #page21 .logo-post .right {
            width: 30px;
            height: 30px;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url(data:image/svg+xml;base64,{{base64_encode(preg_replace('/(#[0-9a-zA-Z]{3,6})/m', '#000', $data->icon))}});
            opacity: .5;
            border: 1px solid #adadad;
        }

        #page21 .icon-pre, #page20 .icon-pre {
            position: absolute;
            left: -30px;
            top: -30px;
            right: -30px;
            height: 30px;
            border-top: 1px solid #dadada;
        }

        #page21 .logo {
            margin-right: 10px;
        }

        #page21 .icon-pre:before, #page20 .icon-pre:before {
            height: 70px;
            content: "";
            border-left: 1px solid #dadada;
            position: absolute;
            top: 30px;
        }

        #page21 .icon-pre div, #page20 .icon-pre div {
            margin-top: -1px;
        }

        #page21 .icon-post:before, #page20 .icon-post:before {
            height: 70px;
            content: "";
            border-left: 1px solid #dadada;
            position: absolute;
            bottom: 30px;
            right: 0;
        }

        #page21 .icon-post, #page20 .icon-post {
            position: absolute;
            left: -30px;
            right: -30px;
            bottom: -30px;
            border-bottom: 1px solid #dadada;
            height: 30px;
        }

        #page21 .icon-post .left, #page21 .icon-pre .left, #page20 .icon-post .left, #page20 .icon-pre .left {
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

        #page21 .icon-post .right, #page21 .icon-pre .right, #page20 .icon-post .right, #page20 .icon-pre .right, {
            height: 30px;
            width: 30px;
            border: 1px solid #dadada;
            color: #dadada;
            font-size: 14px;
            text-align: center;
            line-height: 30px;
            float: right;
        }

        #page22 {
            background: -webkit-gradient(linear, left top, left bottom, color-stop(-1.27%, rgba(147, 152, 155, 0.08)), color-stop(90.37%, rgba(147, 152, 155, 0.37)));
        }

        #page22 .background {
            position: absolute;
            left: 0;
            top: 0;
        }

        #page23 .description {
            font-style: normal;
            font-weight: normal;
            font-size: 12px;
            line-height: 18px;
            /* or 150% */

            clear: both;
            color: #000000;
        }

        #page24 .gradient {
            position: absolute;
            z-index: 0;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            @if(isset($data->colors_list[1]) && isset($data->colors_list[0]))
                 background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,{{$data->colors_list[0]->id}}), color-stop(100%, {{$data->colors_list[1]->id}}));
        @endif

















        }

        #page24 h1, #page24 .text {
            position: relative;
            z-index: 3;
        }

        #page24 .line {
            position: absolute;
            width: 836.55px;
            height: 0px;
            left: -100px;
            top: 385px;
            border: 14px solid #EAEAEA;
            box-sizing: border-box;
            -webkit-transform: rotate(144.65deg);
        }

        #page25 .rejected_item {
            float: left;
            width: 50%;
            margin-bottom: 20px;
            position: relative;
            padding-left: 10mm;
            padding-right: 10mm;
            height: 40mm;
        }

        #page25 .rejected_item svg {
            max-width: 100%;
        }

        #page25 .rejected_item .title {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
        }

        #page25 .rejected_item .line {
            border: 1px solid #FF0000;
            position: absolute;
            z-index: 3;
            left: 50%;
            top: 40px;
            width: 172px;
            margin-left: -86px;
            -webkit-transform: rotate(144.65deg);
        }

        #page26 .text-small, #page27-27 .text-small, #page26-26 .text-small {
            position: absolute;
            bottom: 90px;
            left: 90px;
            right: 90px;
            font-size: 12px;
        }

        #page26 .color-line {
            width: 70%;
            left: 15%;
            position: absolute;
            top: 50%;
            height: 100px;
            margin-top: -50px;
        }

        #page26 .color-line .line {
            height: 10px;
        }

        #page26 .color-line .line div {
            height: 100%;
            float: left;
        }

        #page26 .color-line .line div.p1 {
            width: 5%;
            @if(isset($data->colors_list[0]))
                 background-color: rgba({{$data->colors_list[0]->color->rgb->r}}, {{$data->colors_list[0]->color->rgb->g}}, {{$data->colors_list[0]->color->rgb->b}}, 0.5);
        @endif

















        }

        #page26 .color-line .line div.p2 {
            width: 5%;
            @if(isset($data->colors_list[0]))
                             background-color: rgba({{$data->colors_list[0]->color->rgb->r}}, {{$data->colors_list[0]->color->rgb->g}}, {{$data->colors_list[0]->color->rgb->b}}, 0.8);
        @endif

















        }

        #page26 .color-line .line div.p3 {
            width: 30%;
            @if(isset($data->colors_list[0]))
                             background-color: rgba({{$data->colors_list[0]->color->rgb->r}}, {{$data->colors_list[0]->color->rgb->g}}, {{$data->colors_list[0]->color->rgb->b}}, 1);
        @endif

















        }

        #page26 .color-line .line div.p4 {
            width: 5%;
            @if(isset($data->colors_list[1]))
                             background-color: rgba({{$data->colors_list[1]->color->rgb->r}}, {{$data->colors_list[1]->color->rgb->g}}, {{$data->colors_list[1]->color->rgb->b}}, 0.5);
        @endif

















        }

        #page26 .color-line .line div.p5 {
            width: 5%;
            @if(isset($data->colors_list[1]))
                             background-color: rgba({{$data->colors_list[1]->color->rgb->r}}, {{$data->colors_list[1]->color->rgb->g}}, {{$data->colors_list[1]->color->rgb->b}}, 0.8);
        @endif

















        }

        #page26 .color-line .line div.p6 {
            width: 25%;
            @if(isset($data->colors_list[1]))
                             background-color: rgba({{$data->colors_list[1]->color->rgb->r}}, {{$data->colors_list[1]->color->rgb->g}}, {{$data->colors_list[1]->color->rgb->b}}, 1);
        @endif

















        }

        #page26 .color-line .line div.p7 {
            width: 5%;
            @if(isset($data->colors_list[2]))
                             background-color: rgba({{$data->colors_list[2]->color->rgb->r}}, {{$data->colors_list[2]->color->rgb->g}}, {{$data->colors_list[2]->color->rgb->b}}, .5);
        @endif

















        }

        #page26 .color-line .line div.p8 {
            width: 5%;
            @if(isset($data->colors_list[0]))
                             background-color: rgba({{$data->colors_list[2]->color->rgb->r}}, {{$data->colors_list[2]->color->rgb->g}}, {{$data->colors_list[2]->color->rgb->b}}, .8);
        @endif

















        }

        #page26 .color-line .line div.p9 {
            width: 15%;
            @if(isset($data->colors_list[0]))
                             background-color: rgba({{$data->colors_list[2]->color->rgb->r}}, {{$data->colors_list[2]->color->rgb->g}}, {{$data->colors_list[2]->color->rgb->b}}, 1);
        @endif

















        }

        #page26 .description {
            padding-top: 10px;
        }

        #page26 .description .textual-block {
            float: left;
            padding-right: 10px;
            overflow: hidden;
            font-size: 14px;
        }

        #page26 .description .textual-block .color-code {
            color: #adadad;
        }

        #page26 .description .textual-block.first {
            width: 40%;
        }

        #page26 .description .textual-block.second {
            width: 35%;
        }

        #page26 .description .textual-block.third {
            width: 25%;
        }

        #page26 .description .textual-block svg {
            margin-right: 10px;
        }

        @foreach($data->fonts_main as $font_m)
        @font-face {
            /*font-display: swap;*/
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
            /*font-display: swap;*/
            @if(isset($font_m['index']))
                 font-family: "second{{$font_m['index']}}";
            @else
                 font-family: "second1";
            @endif
                 src: url("{{$font_m['font']}}");
        }

        @endforeach
        #page28 .huge-text, #page28 .huge-number {
            z-index: 2;
            border-bottom: 2px solid;
            position: absolute;
            left: 45px;
            top: 45px;
            font-size: 85px;
            line-height: 85px;
            right: 45px;
        }

        #page28 .huge-number {
            left: 50%;
            top: auto;
            bottom: 45px;
            right: 45px;
            font-size: 53px;
            line-height: 53px;
            text-align: right;
        }

        #page28 .huge-text small, #page28 .huge-number small {
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

        #page28 .huge-number small {
            right: auto;
            left: 0;
            text-align: left;
        }

        #page28 .huge-text.text-three, #page28 .huge-number.text-three {
            z-index: 5;
            @if(isset($data->colors_list[0]))
                 color: {{$data->colors_list[0]->id}};
            border-color: {{$data->colors_list[0]->id}};
            @endif
                 font-family: "main1";
        }

        #page28 .huge-text.text-two, #page28 .huge-number.text-two {
            z-index: 4;
            @if(isset($data->colors_list[1]))
                 color: {{$data->colors_list[1]->id}};
            border-color: {{$data->colors_list[1]->id}};
            @endif
                 font-family: "main2";
        }

        #page28 .huge-text.text-one, #page28 .huge-number.text-one {
            z-index: 3;
            @if(isset($data->colors_list[2]))
                 color: {{$data->colors_list[2]->id}};
            border-color: {{$data->colors_list[2]->id}};
            @endif
                 font-family: "main3";
        }

        #page28 .huge-number.text-two {
            bottom: 115px;
            left: 30%;
        }

        #page28 .huge-number.text-one {
            bottom: 185px;
            left: 50%;
        }

        #page28 .huge-number.text-three {
            bottom: 45px;
            left: 20%;
        }

        #page28 .huge-text.text-four {
            font-family: "main1";
            @if(isset($data->colors_list[3]))
                 color: {{$data->colors_list[3]->id}};
            border-color: {{$data->colors_list[3]->id}};
            @endif
                 font-size: 26px;
            line-height: 52px;
            margin-top: 296px;
            width: 60%;
        }

        #page28 .huge-text.text-four div, #page28 .huge-text.text-three div, #page28 .huge-text.text-two div, #page28 .huge-text.text-one div {
            font-family: "main1";
        }

        #page28 .huge-text.text-three {
            font-family: "main1";
            font-size: 43px;
            line-height: 86px;
            margin-top: 190px;
            width: 70%;
            @if(isset($data->colors_list[2]))
                 color: {{$data->colors_list[2]->id}};
            border-color: {{$data->colors_list[2]->id}};
        @endif

















        }

        #page28 .huge-text.text-two {
            font-family: "main1";
            font-size: 60px;
            line-height: 80px;
            margin-top: 100px;
            width: 80%;
            @if(isset($data->colors_list[1]))
                             color: {{$data->colors_list[1]->id}};
            border-color: {{$data->colors_list[1]->id}};
        @endif

















        }

        #page28 .huge-text.text-one {
            font-family: "main1";
            font-size: 85px;
            @if(isset($data->colors_list[0]))
                             color: {{$data->colors_list[0]->id}};
            border-color: {{$data->colors_list[0]->id}};
        @endif

















        }

        .fonts2-title {
            font-style: normal;
            font-weight: normal;
            font-size: 12px;
            line-height: 14px;
            /* or 87% */


            color: #000000;
        }

        .gradient-line {
            height: 10px;
            width: 80%;
            @if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
                 background: -webkit-gradient(linear, left top, right bottom, color-stop(6.88%,{{$data->colors_list[0]->id}}), color-stop(96.22%, {{$data->colors_list[1]->id}}));
            @endif
                 margin-top: 10px;
            margin-bottom: 10px;
        }

        .fonts2-weight {
            line-height: 26px;
            margin-bottom: 20px;
        }

        .fonts2-weight em {
            font-size: 16px;
            color: #777;
        }

        .fonts2-fontname {
            margin-top: 10px;
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: bold;
        }

        #page30 p, #page31 p {
            margin-bottom: 0 !important;
            margin-top: 0;
            font-size: 16px;
            color: #777;
        }

        #page30 .fonts2-weight.font-1 p {
            font-family: "main1";
        }

        #page30 .fonts2-weight.font-2 p {
            font-family: "main2";
        }

        #page30 .fonts2-weight.font-3 p {
            font-family: "main3";
        }

        #page31 .fonts2-weight.font-1 p {
            font-family: "second1";
        }

        #page31 .fonts2-weight.font-2 p {
            font-family: "second2";
        }

        #page31 .fonts2-weight.font-3 p {
            font-family: "second3";
        }

        #page32 {
            overflow: hidden;
            padding: 90px;
            padding-top: 400px;
        }

        #page33 {
            overflow: hidden;
        }

        #page32 .gradient {
            width: 442mm;
            height: 221mm;
            @if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
                 background: -webkit-gradient(linear, left bottom, right top, color-stop(6.88%,{{$data->colors_list[0]->id}}), color-stop(96.22%, {{$data->colors_list[1]->id}}));
            @endif
                 position: absolute;
            z-index: 1;
            left: 0;
            top: 0;
        }

        #page33 .gradient {
            width: 442mm;
            height: 221mm;
            @if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
                 background: -webkit-gradient(linear, left bottom, right top, color-stop(6.88%,{{$data->colors_list[0]->id}}), color-stop(96.22%, {{$data->colors_list[1]->id}}));
            @endif
                 position: absolute;
            z-index: 1;
            left: -221mm;
            top: 0;
        }

        #page32 .user-info {
            position: relative;
            z-index: 3;
            margin-bottom: 20px;
            font-size: 14px;
        }

        #page32 .user-info .image {
            width: 66px;
            height: 66px;
            border: 3px solid rgba(255, 255, 255, 0.7);
            -webkit-box-sizing: border-box;
            -webkit-border-radius: 116.5px;
            /*overflow: hidden;*/
            float: left;
            margin-right: 10px;

        }

        #page32 .user-info .name {
            color: #fff;
            font-weight: bold;
            padding-top: 15px;
        }

        #page32 .user-info .position {
            color: #fff;
        }

        #page32 h1.title:after {
            background: #fff;
        }

        #page32 h1.title {
            margin-bottom: 20px;
        }

        #page32 .user-info .image img {
            width: 60px;
            height: 60px;
            display: block;
            border-radius: 116.5px;
        }

        #page32 .company, #page32 h1.title, #page32 .text {
            position: relative;
            z-index: 3;
        }

        #page32 .text {
            font-size: 12px;
        }

        #page32 .company {
            margin-top: 20px;
        }

        #page32 .company .company-logo {
            float: left;
            margin-right: 50px;
        }

        #page32 .company p {
            margin-bottom: 0;
            margin-top: 0;
            font-size: 11px;
            color: #fff;
        }

        #page32 .company .web {
            float: left;
            margin-right: 50px;
        }

        #page32 .company .contact {
            float: left;
        }

        #page34 {
            padding: 90px;
            padding-top: 300px;
        }

        #page34 .text-center {
            text-align: center;
        }

        #page34 p {
            font-size: 14px;
            line-height: 14px;
            /* or 100% */


            color: #000000;
        }

        #page34 .logo-gingersauce {
            font-size: 14px;
            color: #797979;
            margin-top: 20px;
        }

        #page34 .company-logo {
            margin-top: 20px;
            max-width: 200px;
            margin: 20px auto 0;
        }

        #page34 .company-logo img {
            width: 100%;
        }

        #page34 .logo-gingersauce svg path {
            fill: #797979;
        }

        #page35 .gradient {
            width: 221mm;
            height: 221mm;
            position: absolute;
            z-index: 1;
            left: 0;
            top: 0;
            @if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
                 background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, #fff));
        @endif

















        }

        #page36 .gradient {
            width: 221mm;
            height: 221mm;
            position: absolute;
            z-index: 1;
            left: 0;
            top: 0;
            @if(isset($data->colors_list[0]) && isset($data->colors_list[1]))
                             background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,{{$data->colors_list[1]->id}}), color-stop(100%, {{$data->colors_list[0]->id}}));
        @endif

















        }

        #page36 .small-title, #page36 .logo-gingersauce {
            position: absolute;
            text-align: center;
            display: block;
            z-index: 2;
        }


        .logo-versions .logo-version .logo-title {
            text-align: center;
            font-size: 12px;
            line-height: 25px;
            width: 100%;
        }

        .logo-versions .logo-version.version1 {
            float: right;
            text-align: right;
        }

        .logo-versions .logo-version.version1 .logo-title {
            float: right;
        }

        #page15 .logo-versions, #page17-1 .logo-versions, #page16-1.page16-oneside .logo-versions {
            display: flex;
            flex-wrap: wrap;
            /* align-items: unset; */
            height: 570px;
            align-items: center;
            justify-content: center;
        }

        #page15 .logo-versions .logo-version, #page17-1 .logo-versions .logo-version, #page16-1.page16-oneside .logo-versions .logo-version {
            height: 190px;
            height: unset;
            width: 100%;
            flex-basis: 100%;
            flex-basis: 51%;
            margin-bottom: 20px;

        }

        #page15 .logo-versions .logo-version .logo-title, #page17-1 .logo-versions .logo-version .logo-title, #page16-1.page16-oneside .logo-versions .logo-version .logo-title {
            padding-top: 0;
        }

        #page16-1 .logo-versions-block {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-wrap: nowrap;
        }

        #page16-1 .logo-versions-block .logo-versions {
            flex-basis: 50%;
            display: flex;
            flex-wrap: wrap;
            height: 570px;
            align-items: center;
            justify-content: center;
        }

        #page16-1 .logo-versions-block .logo-versions .logo-version {
            flex-basis: 100%;
            flex-basis: 75%;
        }

        #page16-1 .logo-versions-block .logo-versions .logo-version .logo-title {
            padding-top: 0;
        }

        #page16, #page17, #page27-1 {
            position: relative;
        }

        #page16 .favicon {
            position: absolute;
            top: 50%;
            margin-top: 100px;
            margin-left: -100px;
            left: 50%;
            width: 200px;
            height: 200px;
            padding: 20px;
        }

        #page17 .favicons, #page27-1 .favicons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            height: 570px;
        }

        #page27-1 .favicons .favicon .logo-img {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            justify-content: center;
        }

        #page27-1 .favicons.favicons-1-4 .favicon {
            flex-basis: 50%;
        }

        #page27-1 .favicons.favicons-5-9 .favicon {
            flex-basis: 33%;
        }

        #page27-1 .favicons.favicons-10-12 .favicon {
            flex-basis: 25%;
        }

        #page17 .favicons.favicons-4 {
            flex-wrap: wrap;
        }

        #page17 .favicons.favicons-3 .favicon, #page17 .favicons.favicons-2 .favicon {
            flex-basis: 100%;
            margin: 0 !important;
        }

        #page17 .favicons.favicons-4 .favicon {
            flex-basis: 50% !important;
            margin: 0;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center !important;
        }

        #page17 .favicons.favicons-4 .favicon .logo-img {
            border-radius: 0;
            flex-basis: 70px;
            margin: 0 20px;
        }

        #page17 .favicons.favicons-4 .favicon .logo-title {
            flex-basis: 100% !important;
            text-align: center;
        }

        #page17 .favicons.favicons-5-9 .favicon {
            flex-basis: 50% !important;
            margin: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center !important;
        }

        #page17 .favicons.favicons-5-9 .favicon .logo-img {
            border-radius: 0;
            flex-basis: 70px;
            margin: 0 20px;
        }

        #page17 .favicons.favicons-5-9 .favicon .logo-title {
            flex-basis: 50% !important;
            text-align: center;
        }

        #page17 .favicon .logo-img {
            width: 70px;
        }

        #page17 .favicon, #page27-1 .favicon {
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

        #page17 .favicon.first {
            margin-left: -60px;
        }

        #page17 .favicon.second {
            margin-left: 60px;
        }

        #page17 .favicon:nth-child(2n) {
            margin-left: -60px;
        }

        #page17 .favicon:nth-child(2n+1) {
            margin-left: 60px;
        }

        #page16 .favicon .logo-img, #page17 .favicon .logo-img,

        ,
        #page27-1 .favicon .logo-img {
            height: 70px;
            width: 70px;
            margin-left: 50px;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        #page17 .favicon {
            height: 200px;
            width: 100px;
            /*left: 50%;*/
            /*margin-top: 50px;*/
        }

        #page27-1 .favicon {
            height: 100px;
            width: 100px;
            /*left: 50%;*/
            /*margin-top: 50px;*/
        }

        #page17 .favicon .logo-img, #page27-1 .favicon .logo-img {
            padding: 15px;
            /*margin-left: -50px;*/
            display: block;
            margin: 0 auto;
        }

        #page17, #page27-1 {
            position: relative;
        }

        #page17 .favicon {
            /*position: absolute;*/
        }

        #page17 .favicon .logo-img .image, #page27-1 .favicon .logo-img .image {
            width: 40px;
            height: 40px;
        }

        #page16 .favicon .logo-title, #page17 .favicon .logo-title, #page27-1 .favicon .logo-title {
            text-align: center;
            font-style: normal;
            font-weight: normal;
            font-size: 12px;
            line-height: 25px;
            /* or 208% */

            text-align: center;

            color: #000000;
            margin-top: 20px;
            width: 100%;
        }

        .mockup-wrapper {
            width: 760px;
            height: 760px;
            overflow: hidden;
            position: absolute;
            left: 0;
            top: 0;
        }

        .mockup-photo {
            height: 760px;
            background-size: cover;
            position: absolute;
            top: 0;
        }

        .mockup-photo.mockup-photo-left-half {
            width: 1140px;
            left: 380px;
        }

        .mockup-photo.mockup-photo-right-full-left-half {
            width: 1140px;
            right: 0;
        }

        .mockup-photo.mockup-photo-left-full {
            width: 1520px;
            left: 0;
        }

        .mockup-photo.mockup-photo-right-full {
            width: 1520px;
            top: 0;
            right: 0px;
        }

        .mockup-photo.mockup-photo-right-half {
            width: 1140px;
            right: 380px;
        }

        .mockup-photo.mockup-photo-left-full-right-half {
            width: 1140px;
            left: 0;
        }

        .mockup-wrapper .mockup-title {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            align-items: center;
            padding: 0 20mm;
            height: 760px;
            padding: 50px;
            width: 380px;
        }

        .mockup-wrapper .mockup-title.right {
            float: right;
        }

        .logo-size-1 .logo-versions, .logo-size-2 .logo-versions {
            display: flex;
            flex-wrap: wrap;
            /* align-items: unset; */
            height: 760px;
            align-items: center;
            justify-content: center;
        }

        .logo-size-2 .logo-version.version {
            flex-basis: 100%;
        }

        .logo-size-2 .logo-version, .logo-size-4 .logo-version {
            height: 380px;
        }

        .logo-size-2 .logo-versions .logo-version .logo-img {
            margin-top: 15%;
            width: 40%;
            height: 40%;
        }

        .logo-size-1 .logo-versions .logo-version .logo-img {
            width: 40%;
            height: 40%;
            margin-top: 25%;
        }

        .logo-size-1 .logo-versions .logo-version {
            width: 100%;
            height: 100%;
        }

        .logo-size-2 .logo-version:first-child {
            border-bottom: 1px solid #dadada;
        }


        .logo-size-4 .logo-version:first-child {
            border-bottom: 1px solid #dadada;
            border-right: 1px solid #dadada;
        }

        .logo-size-4 .logo-version:last-child {
            border-top: 1px solid #dadada;
            border-left: 1px solid #dadada;
        }

        .logo-versions .logo-version .logo-title{
            margin-top: 40px;
        }

        .background-primary {
            @if(isset($data->colors_list[0]))
                  background: {{$data->colors_list[0]->id}};
        @endif


        }

        .background-black {
            background: black;
        }

        #page14{
            padding: 0 !important;
        }
        #page14 .title{
            padding: 90px 90px 0 90px;
        }
        #page14 .text{
            padding: 0 90px 0px 90px;
        }

        #page14 .logo-versions {
            height: 380px;
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #dadada;
        }

        #page14 .logo-version .logo-img{
            margin-top: 12%;
        }
    </style>
    <meta charset="utf-8">
</head>
<body>
<div class="white-theme">
    <div id="page1" @if($data->custom_logo)
    style="background-image: url({{public_path( config('app.images_path') . $data->user_id . '/' . $data->id . '/' . $data->custom_logo)}});
        background-repeat: no-repeat;
        background-size: cover;"
        @endif
    >
        @if(empty($data->custom_logo))

            <div class="logo">
            </div>
            <div class="small-title">
                {{$data->brand}} {{trans('themes.brand_book')}}
            </div>
            <div class="logo-gingersauce" style="display: none">
                <svg width="14" height="14" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"/>
                </svg>
                {{trans('themes.powered_by')}} gingersauce
            </div>
        @endif
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb1"></div>
    <div id="page2">
        @if(isset($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
            {!!$data->icon!!}
        @endif
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb2"></div>
    <div id="page3">
        <div class="page-number right">3</div>
        <h1 class="title">{{trans('themes.contents')}}</h1>
        <div class="contents">
            <div class="content-item">
                <div><a -href="#Introduction">{{trans('themes.introduction')}}</a></div>
                <div class="dots"></div>
                <div class="page">5</div>
            </div>
            @if(isset($data->mockups[0]))
                @php
                    $page_number_sm = 7;
                @endphp
            @else
                @php
                    $page_number_sm = 5;
                @endphp
            @endif
            @if(isset($data->vision) || isset($data->vision_text))
                @php
                    $page_number_sm += 2;
                @endphp
                <div class="content-item">
                    <div><a -href="#Vision">{{trans('themes.vision')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm}}</div>
                </div>
            @endif
            @if(isset($data->mission) || isset($data->mission_text))
                @php
                    $page_number_sm += 1;
                @endphp
                <div class="content-item">
                    <div><a -href="#Mission">{{trans('themes.mission')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm}}</div>
                </div>
            @endif
            @if(count($data->core_values)>0)
                @php
                    $page_number_sm += 2;
                @endphp
                <div class="content-item">
                    <div><a -href="#Core Values">{{trans('themes.core_values')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm}}</div>
                </div>
            @endif
            @php
                $page_number_sm += 2;
            @endphp
            <div class="content-item">
                <div><a -href="#Our Logo">{{trans('themes.our_logo')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
            @if(count($data->approved))
                @php
                    $page_number_sm += 2;
                @endphp
                <div class="content-item">
                    <div><a -href="#Logo Versions">{{trans('themes.logo_versions')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm}}</div>
                </div>
                @php
                    $page_number_sm += 2;
                @endphp
            @endif
            @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
                @php
                    $page_number_sm += 2;
                @endphp
                <div class="content-item">
                    <div><a -href="#Icon & Favicon">{{trans('themes.icon_favicon')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm}}</div>
                </div>
            @endif
            @if(isset($data->mockups[1]))
                @php
                    $page_number_sm += 2;
                @endphp
            @endif
            @php
                $page_number_sm += 2;
            @endphp
            <div class="content-item">
                <div><a -href="#Proportions">{{trans('themes.proportions')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
            @php
                $page_number_sm += 2;
            @endphp
            <div class="content-item">
                <div><a -href="#Clear Space">{!! trans('themes.clear_space') !!}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
            @php
                $page_number_sm += 2;
            @endphp
            <div class="content-item">
                <div><a -href="#Minimum Size">{{trans('themes.minimum_size')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
            @if(isset($data->mockups[2]))
                @php
                    $page_number_sm += 2;
                @endphp
            @endif
            @php
                $page_number_sm += 2;
            @endphp
            <div class="content-item">
                <div><a -href="#Logo Misuse">{{trans('themes.logo_misuse')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
            @if(count($data->icon_family)>0)
                @php
                    $page_number_sm += 2;
                @endphp
                <div class="content-item">
                    <div><a -href="#Color Palette">{{trans('themes.feature_icons')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm}}</div>
                </div>
            @endif
            @php
                $page_number_sm += 2;
            @endphp
            <div class="content-item">
                <div><a -href="#Color Palette">{{trans('themes.color_palette')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
            @php
                $page_number_sm += 4;
            @endphp
            <div class="content-item">
                <div><a -href="#Our Fonts">{{trans('themes.our_fonts')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
            @if(isset($data->mockups[3]))
                @php
                    $page_number_sm += 2;
                @endphp
            @endif
            @php
                $page_number_sm += 4;
            @endphp
            <div class="content-item">
                <div><a -href="#Brandbook designer">{{trans('themes.brand_book_designer')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm}}</div>
            </div>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb3"></div>
    <div id="page4">
        <div class="page-number">4</div>
        <div class="svg-block"
             style="position: absolute;    position: absolute;left: 472px;bottom: 0;width: 1128px;height: 476px;">
            <svg width="1128" height="476" viewBox="0 0 1128 476" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.7492 42.0233H207.889V53.9926H173.241V471.031H207.889V483H15.7492V471.031H50.3973V53.9926H15.7492V42.0233ZM231.493 183.136H383.315V241.093C390.035 221.774 400.324 206.235 414.183 194.475C428.043 182.716 449.042 176.836 477.18 176.836C542.277 176.836 574.825 211.904 574.825 282.041V471.661H610.103V483H431.823V471.661H457.651V266.921C457.651 241.723 455.971 225.554 452.611 218.414C449.252 210.854 443.162 207.075 434.342 207.075C420.903 207.075 408.934 215.894 398.434 233.533C388.355 251.172 383.315 272.591 383.315 297.79V471.661H410.404V483H231.493V471.661H266.141V194.475H231.493V183.136ZM646.848 392.915V194.475H612.2V183.136H646.848V101.87L764.022 72.8916V183.136H845.917V194.475H764.022V406.774C764.022 426.513 765.912 441.002 769.691 450.242C773.891 459.481 782.291 464.101 794.89 464.101C807.489 464.101 818.409 457.801 827.648 445.202C837.308 432.603 843.607 415.384 846.547 393.545L857.257 394.805C853.897 423.783 844.657 446.882 829.538 464.101C814.419 480.9 789.43 489.3 754.572 489.3C719.714 489.3 693.045 482.37 674.566 468.511C656.087 454.651 646.848 429.453 646.848 392.915ZM1073.68 200.775C1058.15 200.775 1044.5 210.854 1032.74 231.013C1020.98 251.172 1015.1 275.111 1015.1 302.83V471.661H1059.83V483H863.276V471.661H897.924V194.475H863.276V183.136H1015.1V243.613C1020.56 222.194 1031.06 205.815 1046.6 194.475C1062.14 182.716 1079.77 176.836 1099.51 176.836C1119.25 176.836 1135.21 182.506 1147.39 193.845C1159.99 204.765 1166.29 220.514 1166.29 241.093C1166.29 261.252 1161.67 276.791 1152.43 287.71C1143.19 298.63 1128.91 304.089 1109.59 304.089C1090.69 304.089 1076.62 297.79 1067.39 285.19C1058.57 272.591 1057.52 255.162 1064.24 232.903H1086.91C1097.41 211.484 1093 200.775 1073.68 200.775ZM209.779 841.897V788.349C209.779 747.612 207.469 718.003 202.849 699.524C198.65 680.625 188.57 671.176 172.611 671.176C163.371 671.176 155.812 673.905 149.932 679.365C144.472 684.405 140.483 693.014 137.963 705.194C134.183 724.093 132.293 752.861 132.293 791.499V840.637C132.293 886.414 133.553 913.923 136.073 923.162C139.013 932.402 141.953 939.961 144.892 945.841C149.512 955.921 158.542 960.96 171.981 960.96C188.36 960.96 199.069 951.511 204.109 932.612C207.889 919.172 209.779 888.934 209.779 841.897ZM170.721 972.3C118.224 972.3 78.5359 958.86 51.6573 931.982C24.7787 905.103 11.3394 866.675 11.3394 816.698C11.3394 766.301 25.6186 727.663 54.1771 700.784C83.1556 673.485 123.683 659.836 175.761 659.836C227.838 659.836 266.686 672.435 292.305 697.634C317.923 722.413 330.733 760.421 330.733 811.658C330.733 918.752 277.395 972.3 170.721 972.3Z"
                    fill="#EAEAEA"/>
            </svg>

        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb4"></div>
    <div id="page5">
        <div class="page-number right" id="Introduction">5</div>
        <div class="svg-block"
             style="position: absolute;    position: absolute;left: -294px;bottom: 0;width: 1128px;height: 476px;">
            <svg width="1128" height="476" viewBox="0 0 1128 476" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.7492 42.0233H207.889V53.9926H173.241V471.031H207.889V483H15.7492V471.031H50.3973V53.9926H15.7492V42.0233ZM231.493 183.136H383.315V241.093C390.035 221.774 400.324 206.235 414.183 194.475C428.043 182.716 449.042 176.836 477.18 176.836C542.277 176.836 574.825 211.904 574.825 282.041V471.661H610.103V483H431.823V471.661H457.651V266.921C457.651 241.723 455.971 225.554 452.611 218.414C449.252 210.854 443.162 207.075 434.342 207.075C420.903 207.075 408.934 215.894 398.434 233.533C388.355 251.172 383.315 272.591 383.315 297.79V471.661H410.404V483H231.493V471.661H266.141V194.475H231.493V183.136ZM646.848 392.915V194.475H612.2V183.136H646.848V101.87L764.022 72.8916V183.136H845.917V194.475H764.022V406.774C764.022 426.513 765.912 441.002 769.691 450.242C773.891 459.481 782.291 464.101 794.89 464.101C807.489 464.101 818.409 457.801 827.648 445.202C837.308 432.603 843.607 415.384 846.547 393.545L857.257 394.805C853.897 423.783 844.657 446.882 829.538 464.101C814.419 480.9 789.43 489.3 754.572 489.3C719.714 489.3 693.045 482.37 674.566 468.511C656.087 454.651 646.848 429.453 646.848 392.915ZM1073.68 200.775C1058.15 200.775 1044.5 210.854 1032.74 231.013C1020.98 251.172 1015.1 275.111 1015.1 302.83V471.661H1059.83V483H863.276V471.661H897.924V194.475H863.276V183.136H1015.1V243.613C1020.56 222.194 1031.06 205.815 1046.6 194.475C1062.14 182.716 1079.77 176.836 1099.51 176.836C1119.25 176.836 1135.21 182.506 1147.39 193.845C1159.99 204.765 1166.29 220.514 1166.29 241.093C1166.29 261.252 1161.67 276.791 1152.43 287.71C1143.19 298.63 1128.91 304.089 1109.59 304.089C1090.69 304.089 1076.62 297.79 1067.39 285.19C1058.57 272.591 1057.52 255.162 1064.24 232.903H1086.91C1097.41 211.484 1093 200.775 1073.68 200.775ZM209.779 841.897V788.349C209.779 747.612 207.469 718.003 202.849 699.524C198.65 680.625 188.57 671.176 172.611 671.176C163.371 671.176 155.812 673.905 149.932 679.365C144.472 684.405 140.483 693.014 137.963 705.194C134.183 724.093 132.293 752.861 132.293 791.499V840.637C132.293 886.414 133.553 913.923 136.073 923.162C139.013 932.402 141.953 939.961 144.892 945.841C149.512 955.921 158.542 960.96 171.981 960.96C188.36 960.96 199.069 951.511 204.109 932.612C207.889 919.172 209.779 888.934 209.779 841.897ZM170.721 972.3C118.224 972.3 78.5359 958.86 51.6573 931.982C24.7787 905.103 11.3394 866.675 11.3394 816.698C11.3394 766.301 25.6186 727.663 54.1771 700.784C83.1556 673.485 123.683 659.836 175.761 659.836C227.838 659.836 266.686 672.435 292.305 697.634C317.923 722.413 330.733 760.421 330.733 811.658C330.733 918.752 277.395 972.3 170.721 972.3Z"
                    fill="#EAEAEA"/>
            </svg>

        </div>
        <h1 class="title" contenteditable="true" data-title-field="introduction_title"
            style="position: relative;z-index: 2">{!!
!empty($data->introduction_title) ? $data->introduction_title : trans('themes.introduction') !!}</h1>
        <div class="text" id="edit-1" data-field="introduction_text" style="position: relative;z-index: 2">
            @if(!empty($data->introduction_text))
                {!!$data->introduction_text!!}
            @else
                <p>
                    {{trans('themes.welcome_to_the_officisal', ['brand' => $data->brand])}}
                </p>
                <p>
                    {{trans('themes.it_is_important_that', ['brand' => $data->brand])}}
                </p>
                <p>
                    {{trans('themes.note_that_by_using', ['brand' => $data->brand])}}
                </p>
            @endif
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb5"></div>
    @php
        $page_number = 5;
    @endphp
    @if(isset($data->mockups[0]))
        @if(!empty($data->mockups[0]->title))
            <div id="page-mockup-1-0">
                @php
                    $page_number++;
                @endphp
                <div class="page-number">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-title">
                        {{$data->mockups[0]->title}}
                    </div>
                    <div class="mockup-photo mockup-photo-left-half"
                         style="background-image: url({{$data->mockups[0]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
            <div id="page-mockup-1-1">
                @php
                    $page_number++;
                @endphp
                <div class="page-number right">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-right-full-left-half"
                         style="background-image: url({{$data->mockups[0]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @else
            <div id="page-mockup-1-0">
                @php
                    $page_number++;
                @endphp
                <div class="page-number">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-left-full"
                         style="background-image: url({{$data->mockups[0]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
            <div id="page-mockup-1-1">
                @php
                    $page_number++;
                @endphp
                <div class="page-number right">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-right-full"
                         style="background-image: url({{$data->mockups[0]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @endif
    @endif

    @if(!empty($data->vision_text) || !empty($data->vision))
        <div id="page6" style="">
            @php
                $page_number++;
            @endphp
            <div class="page-number text-white">{{$page_number}}</div>
            {{-- <div class="gradient-block"></div> --}}
            <div class="svg-block">
                <svg width="1433" height="840" style="height: 760px; width: auto;" viewBox="0 0 1433 840" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M468.751 286.418C511.7 -176.335 1060.21 -224.317 1009.6 -497.216C991.631 -537.971 927.229 -580.779 949.523 -470.73C996.914 -236.795 498.651 -156.944 463.159 286.119C441.385 557.935 23.9228 751.072 -210.423 935.227C-444.769 1119.38 -1.05275 1244.51 1.83308 1008.54C4.71894 772.577 443.856 554.644 468.751 286.418Z"
                        fill="#DCDCDC"/>
                    <path
                        d="M185.621 781.921C192.085 788.205 193.661 803.687 185.061 812.533C176.461 821.379 165.878 825.396 157.459 822.152C145.288 817.462 148.858 798.144 157.459 789.297C166.059 780.451 174.829 771.429 185.621 781.921Z"
                        fill="#D7D7D7"/>
                </svg>


            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb6"></div>
        <div id="page7" style="">
            @php
                $page_number++;
            @endphp
            <div class="page-number right" id="Vision">{{$page_number}}</div>
            {{-- <div class="gradient-block"></div> --}}
            <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="vision_title"
                style="color: #000;">{!! !empty($data->vision_title) ? $data->vision_title : trans('themes.vision') !!}</h1>
            <div class="text" data-field="vision_text">
                @if(!empty($data->vision_text))
                    {!!$data->vision_text!!}
                @else
                    <p>
                        {!!nl2br($data->vision)!!}
                    </p>
                @endif
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb7"></div>
    @endif
    @if(!empty($data->mission_text) || !empty($data->mission))
        <div id="page8">
            @php
                $page_number++;
            @endphp
            <div class="svg-block" style="position: absolute; left: 675px; top: 0;">
                <svg width="933" height="838" style="height: 760px; width: auto" viewBox="0 0 933 838" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M654.297 0.923793H988.191V24.6841H919.411V852.542H988.191V876.303H606.776V852.542H675.556V70.9541H670.554L482.972 876.303H326.655L106.56 67.2025H101.557V852.542H170.337V876.303H0.263532V852.542H69.0433V24.6841H0.263532V0.923793H337.91L504.232 644.953L654.297 0.923793Z"
                        fill="#D7D7D7"/>
                </svg>


            </div>
            <div class="page-number" id="Mission">{{$page_number}}</div>
            {{-- <div class="gradient-block"></div> --}}
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb8"></div>
        <div id="page9">
            @php
                $page_number++;
            @endphp
            <div class="page-number right text-white">{{$page_number}}</div>
            <div class="svg-block" style="position: absolute;left: -92px;bottom: 0;">
                <svg width="933" height="838" style="height: 760px; width: auto" viewBox="0 0 933 838" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M654.297 0.923793H988.191V24.6841H919.411V852.542H988.191V876.303H606.776V852.542H675.556V70.9541H670.554L482.972 876.303H326.655L106.56 67.2025H101.557V852.542H170.337V876.303H0.263532V852.542H69.0433V24.6841H0.263532V0.923793H337.91L504.232 644.953L654.297 0.923793Z"
                        fill="#D7D7D7"/>
                </svg>

            </div>
            <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="mission_title"
                style="position: relative;z-index: 2;color: #fff">{!! !empty($data->mission_title) ? $data->mission_title : trans('themes.mission') !!}</h1>
            <div class="text" data-field="mission_text"
                 style="position: relative;z-index: 2;border-bottom: 1px solid #000;">
                @if(!empty($data->mission_text))
                    {!!$data->mission_text!!}
                @else
                    <p>
                        {!!nl2br($data->mission)!!}
                    </p>
                @endif
            </div>
            {{-- <div class="gradient-block"></div> --}}
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb9"></div>
    @endif

    @if(count($data->core_values)>0)
        <div id="page10">
            @php
                $page_number++;
            @endphp
            <div class="page-number" id="Core Values">{{$page_number}}</div>
            <div class="svg-block" style="position: absolute;left: 0;top: 0;">
                <svg width="350" height="200" viewBox="0 0 350 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M312.723 81.9922C314.77 86.1759 324.596 87.757 333.378 82.8827C342.159 78.0083 348.372 71.7341 349.009 66.4835C349.93 58.8934 335.823 60.2884 327.041 65.1627C318.26 70.037 309.305 75.0079 312.723 81.9922Z"
                        fill="#D7D7D7"/>
                    <path
                        d="M27.2876 198.452C-74.5194 187.01 -112.058 70.4339 -43.954 13.9607C17.6962 -33.8685 85.2355 61.6388 123.776 43.9352C185.657 15.5103 304.822 -17.1421 291.506 67.614C278.832 148.281 110.093 207.758 27.2876 198.452Z"
                        fill="#EAEAEA"/>
                </svg>


            </div>
            <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="core_title"
                style="position: relative;z-index: 2;">{!! !empty($data->core_title) ? $data->core_title :
trans('themes.core_values') !!}</h1>
            <div class="text" data-field="core_text" style="position: relative;z-index: 2;">
                @if(!empty($data->core_text))
                    {!!$data->core_text!!}
                @else
                    <p>
                        {{trans('themes.company_values_matter')}}
                    </p>
                @endif
            </div>
            <div class="core-values">
                {{--@foreach(is_array(json_decode($data->core_values, true)) ? json_decode($data->core_values, true) : collect([])  as $core_value)--}}
                {{-- {{dd($data->core_values)}} --}}
                @foreach($data->core_values as  $c=>$core_value)
                    @if($c<count($data->core_values)/2)
                        <div class="core-value">
                            <div class="img" style="background-image: url({{$core_value['image']}})"></div>
                            <div class="title">{{$core_value['title']}}</div>
                            <div class="text">{{$core_value['description']}}</div>
                        </div>
                    @endif
                @endforeach
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb10"></div>
        <div id="page11">
            @php
                $page_number++;
            @endphp
            <div class="page-number right">{{$page_number}}</div>
            <div class="core-values">
                {{--@foreach(is_array(json_decode($data->core_values, true)) ? json_decode($data->core_values, true) : collect([])  as $core_value)--}}
                {{-- {{dd($data->core_values)}} --}}
                @foreach($data->core_values as  $c=>$core_value)
                    @if($c>=count($data->core_values)/2)
                        <div class="core-value">
                            <div class="img" style="background-image: url({{$core_value['image']}})"></div>
                            <div class="title">{{$core_value['title']}}</div>
                            <div class="text">{{$core_value['description']}}</div>
                        </div>
                    @endif
                @endforeach
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb11"></div>
    @endif
    @if(!empty($data->voices))
        <div id="page-voices-2" class="{{count($data->voices) === 1 ? 'single' : ''}}">
            @php
                $page_number++;
            @endphp
            <div class="page-number right">{{$page_number}}</div>
            <div class="voices-wrapper">
                <div class="voices-wrap-left">
                    <h1 class="title">
                        {{trans('themes.Brand_Archetype')}}
                    </h1>
                    <div class="voices-text">{{trans('themes.archetype_text')}}</div>
                </div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
            <svg class="voices-figure-1" width="595" height="420" viewBox="0 0 595 420" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M37.7392 711.176C174.624 912.728 460.98 885.206 504.039 692.255C536.106 520.572 260.723 466.547 255.163 370.275C246.235 215.699 182.678 -61.9502 19.504 42.5896C-135.797 142.085 -73.5966 547.244 37.7392 711.176Z"
                    fill="#D7D7D7"/>
            </svg>
        </div>
        <div id="page-voices-1" class="{{count($data->voices) === 1 ? 'single' : 'double'}}">
            @php
                $page_number++;
            @endphp
            <div class="page-number">{{$page_number}}</div>
            <div class="voices-wrapper">

                <div class="voices-images">
                    <div class="archetype-image-wrap">
                        {!! \App\BrandBookCreator\BrandBookHelper::getSVG_src($data->voices[0]) !!}
                        @if(empty($data->voices[1]))
                            <div class="archetype-name">{{$data->voices[0]}}</div>@endif
                    </div>
                    @if(!empty($data->voices[1]))
                        <div class="and">&</div>
                        <div class="archetype-image-wrap">
                            {!! \App\BrandBookCreator\BrandBookHelper::getSVG_src($data->voices[1]) !!}
                        </div>
                    @endif
                </div>
                <div class="clear"></div>
                <div class="voices-description">

                    <div class="archetype-descritpion archetype-descritpion-left">
                        @if(!empty($data->voices[1]))
                            <div class="voices-names">
                                {{$data->voices[0]}}
                            </div>
                        @endif
                        <p>{!! \App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[0]]['description']!!}</p>
                        <div
                            class="voices-descritpion-short">{{\App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[0]]['short_description']}}</div>
                    </div>
                    @if(!empty($data->voices[1]))
                        <div class="archetype-descritpion archetype-descritpion-right">
                            <div class="voices-names">
                                {{$data->voices[1]}}
                            </div>
                            <p>{{\App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[1]]['description']}}</p>
                            <div
                                class="voices-descritpion-short">{{\App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[1]]['short_description']}}</div>
                        </div>
                    @endif
                </div>

            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
            <svg class="voices-figure-2" width="651" height="336" viewBox="0 0 651 336" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M598.343 -27.7182C646.287 -198.718 498.344 -354.172 371.746 -292.52C261.998 -234.002 359.786 -48.2571 309.156 -1.64376C227.863 73.199 103.874 235.486 237.285 284.054C364.259 330.278 559.349 111.365 598.343 -27.7182Z"
                    fill="#D7D7D7"/>
            </svg>
        </div>
    @endif

    <div id="page12">
        @php
            $page_number++;
        @endphp
        <div class="page-number" id="Our Logo">{{$page_number}}</div>
        {{-- <div class="gradient-block"></div> --}}
        <div class="svg-block" style="position: absolute;left: 0;top: 298px;">
            <svg width="279" height="429" viewBox="0 0 279 429" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M-197.898 364.032C-75.7816 169.846 103.961 71.5237 211.424 51.446C224.045 49.0881 248.933 51.4176 254.862 83.1517C261.825 120.418 236.698 141.102 224.078 143.46C136.439 159.834 -14.2223 224.216 -128.267 366.734C-151.046 365.834 -174.33 364.932 -197.898 364.032Z"
                    fill="#EAEAEA"/>
            </svg>

        </div>
        <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="logo_title"
            style="position: relative;z-index: 2">{!! !empty($data->logo_title) ? $data->logo_title : trans('themes.our_logo') !!}</h1>
        <div class="text" data-field="logo_text" style="position: relative;z-index: 2">
            @if(!empty($data->logo_text))
                {!!$data->logo_text!!}
            @else
                <p>
                    {{trans('themes.we_are_proud_logo')}}
                </p>
            @endif
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb12"></div>
    <div id="page13">
        @php
            $page_number++;
        @endphp
        <div class="page-number right">{{$page_number}}</div>
        <div class="logo"></div>
        <div class="text">
            <p>
                {{trans('themes.master_and_slogan')}}
            </p>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb13"></div>
    @if(count($data->approved)>0 || count($data->logo_versions) > 1)
        <div id="page14" class="logo-size-1">
            @php
                $page_number++;
            @endphp
            <div class="page-number" id="Logo Versions">{{$page_number}}</div>
            <h1 class="title" contenteditable="true" @blur="title_changed()"
                data-title-field="versions_title">{!! !empty($data->versions_title) ? $data->versions_title : trans('themes.logo_versions') !!}</h1>
            <div class="text" data-field="versions_text">
                @if(!empty($data->versions_text))
                    {!!$data->versions_text!!}
                @else
                    <p>
                        @php
                            $color1 = isset($data->colors_list[0]) ? $data->colors_list[0]->color->name->value : '';
                            $color2 = isset($data->colors_list[1]) ? $data->colors_list[1]->color->name->value : '';
                        @endphp
                        {!! trans('themes.logo_colors', ['brand' => $data->brand, 'color1' => $color1, 'color2' => $color2]) !!}
                    </p>
                @endif
            </div>
            @if( (count($data->approved) + count($data->logo_versions) -1) === 11)
                <div class="logo-versions" style="justify-content: center;">
                    <div class="logo-version">
                        <div class="logo-img"
                             style="background-image: url({{$data->logo_versions[1]->logo_b64}})"></div>
                        <div class="logo-title">
                            {{$data->logo_versions[1]->title}}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="page-break pb14"></div>
        @foreach(\App\BrandBookCreator\BrandBookHelper::chunkLogoVariations($data->approved, $data->logo_versions) as $index => $chunk)
            <div id="page15-{{$index}}" class="logo-size-{{count($chunk)}}">
                @php
                    $page_number++;
                @endphp
                <div class="page-number right text-white">{{$page_number}}</div>
                <div class="logo-versions" style="position: relative; z-index: 2;">
                    @foreach($chunk as $logo)
                        <div class="logo-version version" style="background: {{$logo['background']}}">
                            <div class="logo-img" style="background-image: url({{$logo['logo']}})"></div>
                            @php
                                $background = $logo['background'] === 'transparent' ? '#ffffff' : $logo['background'];
                            @endphp
                            <div class="logo-title"
                                 style="color : {{\App\BrandBookCreator\BrandBookHelper::getLogoTextColor($background)}}">
                                {{$logo['title']}}
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
            @if(in_array($index, [0,2,4]))
                <div class="page-break pb15-{{$index}}"></div>
            @endif
        @endforeach
    @endif
    @if(isset($data->mockups[1]))
        @if(!empty($data->mockups[1]->title))
            <div id="page-mockup-2-0">
                @php
                    $page_number++;
                @endphp
                <div class="page-number">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-left-full-right-half"
                         style="background-image: url({{$data->mockups[1]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
            <div id="page-mockup-2-1">
                @php
                    $page_number++;
                @endphp
                <div class="page-number right">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-right-half"
                         style="background-image: url({{$data->mockups[1]->image}})"></div>
                    <div class="mockup-title right">
                        {{$data->mockups[1]->title}}
                    </div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @else
            <div id="page-mockup-2-0">
                @php
                    $page_number++;
                @endphp
                <div class="page-number">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-left-full"
                         style="background-image: url({{$data->mockups[1]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
            <div id="page-mockup-2-1">
                @php
                    $page_number++;
                @endphp
                <div class="page-number right">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-right-full"
                         style="background-image: url({{$data->mockups[1]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @endif
    @endif

    @if($data->icon!='skipped' && !empty($data->icon) && $data->icon!='[]')
        <div id="page16" style="padding: 470px 90px 90px">
            @php
                $page_number++;
            @endphp
            <div class="page-number" id="Our Icon & Favicon">{{$page_number}}</div>
            {{-- {{dd($data->approved_icon)}} --}}

            <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="icon_title"
                style="margin-bottom: 50px;text-align: center;position: relative;z-index: 2">{!!
!empty($data->icon_title) ? $data->icon_title : 'Our Icon & Favicon' !!}</h1>
            <div class="text" data-field="icon_text" style="position: relative;z-index: 2">
                @if(!empty($data->icon_text))
                    {!!$data->icon_text!!}
                @else
                    @php
                        $color = isset($data->colors_list[0]) ? $data->colors_list[0]->color->name->value : '';
                    @endphp
                    {{trans('themes.icon_text', ['brand' => $data->brand, 'color' => $color])}}
                @endif
            </div>
            @if(isset($data->icon_b64))
                <div class="favicon" style="margin-top: -150px;">
                    <div class="logo-img"
                         style="background-color: {{isset($data->approved_icon[0]->background)?$data->approved_icon[0]->background:'transparent'}};background-image: url({{isset($data->icon_b64)?$data->icon_b64:''}});background-repeat: no-repeat;background-position: center;background-size: contain;height: 100px;width: 100px;margin: 0 auto; padding: 0;"></div>
                    <div class="logo-title"
                    ">
                    {{isset($data->approved_icon[0]->title)?$data->approved_icon[0]->title:''}}
                </div>

        </div>
    @endif
    <div class="svg-block" style="position: absolute;bottom: 0;left: 0;">
        <svg width="851" height="388" viewBox="0 0 851 388" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M378.778 427.298V358.279C378.778 244.491 373.182 172.674 361.99 142.828C349.554 108.629 331.833 87.4879 308.826 79.4045C295.769 74.4302 279.913 71.943 261.259 71.943C242.605 71.943 226.439 74.4302 212.759 79.4045C199.702 84.3789 188.82 93.084 180.115 105.52C171.41 117.956 164.259 131.013 158.663 144.693C153.689 158.372 149.647 177.648 146.538 202.52C142.807 238.584 140.942 291.747 140.942 362.01V429.164C140.942 505.023 143.74 559.119 149.336 591.452C155.554 623.164 163.016 645.859 171.721 659.539C190.996 690.006 220.843 705.24 261.259 705.24C310.381 705.24 342.092 684.721 356.394 643.683C371.317 602.023 378.778 529.894 378.778 427.298ZM259.394 724.827C155.554 724.827 77.8299 696.846 26.221 640.885C-24.7661 584.301 -50.2597 502.846 -50.2597 396.52C-50.2597 289.571 -22.9007 205.629 31.8172 144.693C87.1569 83.1353 165.192 52.3565 265.923 52.3565C366.653 52.3565 442.512 81.5808 493.499 140.029C545.108 197.856 570.913 280.244 570.913 387.193C570.913 494.141 544.797 577.151 492.567 636.221C440.958 695.292 363.233 724.827 259.394 724.827Z"
                fill="#D7D7D7"/>
        </svg>

    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
{{-- {{dd($data->approved_icon)}} --}}
<div class="page-break pb16"></div>
<div id="page17">
    @php
        $page_number++;
    @endphp
    <div class="page-number right">{{$page_number}}</div>
    <div class="favicons favicons-{{count($data->approved_icon)}}">
        @foreach($data->approved_icon as $ind=>$apic)
            {{-- @if($ind>0) --}}
            <div class="favicon icon-{{$ind}}">
                <div class="logo-img"
                     style="background-color: {{isset($apic['background'])?$apic['background']:''}};@if(isset($apic['border_radius'])) border-radius: {{$apic['border_radius']}}@endif;">
                    <div class="image"
                         style="background-image: url({{isset($apic['icon_b64'])?$apic['icon_b64']:''}});background-repeat: no-repeat;background-position: center;background-size: contain;"></div>
                </div>
                <div class="logo-title">
                    {{isset($apic['title'])?$apic['title']:''}}
                </div>
            </div>
            {{-- @endif --}}
        @endforeach
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb17"></div>
@endif
<div id="page18" style="padding-top: 450px;">
    @php
        $page_number++;
    @endphp
    <div class="page-number" id="Proportions">{{$page_number}}</div>
    <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="proportions_title"
        style="font-size: 52px">{!! !empty($data->proportions_title) ? $data->proportions_title : trans('themes.logo_and_icon_proportions') !!}
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
        $proportions_text = '1:1 ' . trans('themes.square_ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=1;
        }else if($ratio>=2.9 && $ratio<=3.1){
        $proportions_text = '1:3 ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=3;
        }else if($ratio>=4.8 && $ratio<=5.2){
        // $xval = (floatval($proportions_x) > 0) ? floatval($proportions_x) : $proportions_x=='x'? str_replace('x', '', $proportions_y):1;
        if(floatval($proportions_x)>0){
        $xval = floatval($proportions_x);
        }else{
        if($proportions_x==="x"){
        $xval = str_replace('x', '', $proportions_y);
        }else{
        $xval = str_replace('x', '', $proportions_x);
        }
        }
        $proportions_text = '1:'.$xval.' ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=5;
        }else if($ratio>=7.8 && $ratio<=8.2){
        $proportions_text = '1:8 ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=8;
        }else if($ratio>=1.4 && $ratio<=1.58){
        $proportions_text = '2:3 Ratio';
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=2;
        $proportions_fibo_active[]=3;
        }else if($ratio>=1.641 && $ratio<=1.7){
        $proportions_text = '3:5 Ratio';
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=3;
        $proportions_fibo_active[]=5;
        }else if($ratio>=1.581 && $ratio<=1.64){
        $proportions_text = '1:1.681 ' . trans('themes.golden_ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_is_absolute_fib_seq');
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
        $yy=4;
        }
        if($proportions_x=='&frac15;x'){
        $xx=1;
        $yy=5;
        }
        if($proportions_x=='&frac16;x'){
        $xx=1;
        $yy=6;
        }
        if($proportions_x=='&frac17;x'){
        $xx=1;
        $yy=7;
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
        $yy=4;
        }
        if($proportions_y=='&frac15;x'){
        $xx=1;
        $yy=5;
        }
        if($proportions_y=='&frac16;x'){
        $xx=1;
        $yy=6;
        }
        if($proportions_y=='&frac17;x'){
        $xx=1;
        $yy=7;
        }
        if($proportions_y=='&frac18;x'){
        $xx=1;
        $yy=8;
        }


        $proportions_text = $xx.':'.$yy.' ' . trans('themes.ratio');
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
        $prop_x_val_icon = ((1/$ratio_icon) - floor(1/$ratio_icon)>0.1?number_format(1/$ratio_icon, 1):round(1/$ratio_icon));
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
        $proportions_text_icon = '1:1 ' . trans('themes.square_ratio');
        $proportions_text_small_icon = $proportions_text_icon;
        if($data->proportions_icon == 'fibonacci')
        $proportions_text_icon.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active_icon[]=1;
        }else if($ratio_icon>=2.9 && $ratio_icon<=3.1){
        $proportions_text_icon = '1:3 ' . trans('themes.ratio');
        $proportions_text_small_icon = $proportions_text_icon;
        if($data->proportions_icon == 'fibonacci')
        $proportions_text_icon.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active_icon[]=3;
        }else if($ratio_icon>=4.8 && $ratio_icon<=5.2){
        $proportions_text_icon = '1:5 ' . trans('themes.ratio');
        $proportions_text_small_icon = $proportions_text_icon;
        if($data->proportions_icon == 'fibonacci')
        $proportions_text_icon.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active_icon[]=5;
        }else if($ratio_icon>=7.8 && $ratio_icon<=8.2){
        $proportions_text_icon = '1:8 ' . trans('themes.ratio');
        $proportions_text_small_icon = $proportions_text_icon;
        if($data->proportions_icon == 'fibonacci')
        $proportions_text_icon.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active_icon[]=8;
        }else if($ratio_icon>=1.4 && $ratio_icon<=1.58){
        $proportions_text_icon = '2:3 ' . trans('themes.ratio');
        $proportions_text_small_icon = $proportions_text_icon;
        if($data->proportions_icon == 'fibonacci')
        $proportions_text_icon.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active_icon[]=2;
        $proportions_fibo_active_icon[]=3;
        }else if($ratio_icon>=1.641 && $ratio_icon<=1.7){
        $proportions_text_icon = '3:5 ' . trans('themes.ratio');
        $proportions_text_small_icon = $proportions_text_icon;
        if($data->proportions_icon == 'fibonacci')
        $proportions_text_icon.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active_icon[]=3;
        $proportions_fibo_active_icon[]=5;
        }else if($ratio_icon>=1.581 && $ratio_icon<=1.64){
        $proportions_text_icon = '1:1.681 ' . trans('themes.golden_ratio');
        $proportions_text_small_icon = $proportions_text_icon;
        if($data->proportions_icon == 'fibonacci')
        $proportions_text_icon.="<br>" . trans('themes.prop_is_absolute_fib_seq');
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


        $proportions_text_icon = $xx.':'.$yy.' ' . trans('themes.ratio');
        $proportions_text_small_icon = $xx.':'.$yy;
        }
    @endphp
    <div class="text" data-field="proportions_text">
        @if(!empty($data->proportions_text))
            {!!$data->proportions_text!!}
        @else
            {{trans('themes.prop_text', ['brand' => $data->brand, 'prop_text_small' => $proportions_text_small, 'prop_text' => $proportions_text_small_icon])}}
        @endif
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb18"></div>
<div id="page19">
    @php
        $page_number++;
    @endphp
    <div class="page-number right">{{$page_number}}</div>
    <div class="logo" data-x="{{$proportions_x}}" data-y="{{$proportions_y}}"
         style="@if($ratio<1) width: {{290*$ratio}}px; height: 290px;margin-left: -{{290*$ratio/2}}px; @if(empty($data->icon) || $data->icon=='skipped' || $data->icon=='[]') top: 50%; margin-top: -145px; @endif @else width: 290px; height: {{290/$ratio}}px;margin-left: -145px; @if(empty($data->icon) || $data->icon=='skipped' || $data->icon=='[]') top: 50%; margin-top: -{{145/$ratio}}px; @endif  @endif"
         data-h="{{$data->logo_h}}px" data-w="{{$data->logo_w}}px">
        <div class="prop_x"
             style="@if($ratio<1) width: {{290*$ratio}}px; height: 30px; position: absolute; top: 50%; left: 50%; margin-left: -{{290*$ratio/2}}px; margin-top: -185px; border-left: 1px solid #000; border-right: 1px solid #000 @else width: 290px; height: 30px; position: absolute; top: 50%; left: 50%; margin-left: -145px; margin-top: -{{145/$ratio+40}}px; border-left: 1px solid #000; border-right: 1px solid #000 @endif">
            <svg width="15" height="8" class="x_first" viewBox="0 0 15 8" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
            <span>{!!$proportions_x!!}</span>
            <svg width="15" height="8" class="x_last" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
        </div>
        <div class="prop_y"
             style="@if($ratio<1) width: 30px; height: 290px; position: absolute; top: 50%; left: 50%; margin-top: -145px; margin-left: -{{290*$ratio/2 + 40}}px; border-top: 1px solid #000; border-bottom: 1px solid #000;  @else width: 30px; height: {{290/$ratio}}px; position: absolute; top: 50%; left: 50%; margin-top: -{{145/$ratio}}px; margin-left: -185px; border-top: 1px solid #000; border-bottom: 1px solid #000 @endif">
            <svg width="15" class="y_first" height="8" viewBox="0 0 15 8" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
            <span>{!!$proportions_y!!}</span>
            <svg width="15" height="8" class="y_last" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
        </div>
        {{-- <div class="proportions_logo" :style="{position: 'absolute', left: '50%', top: '50%', marginLeft: '-100px', marginTop: -(logo_h>0?logo_h/2+40:1)+'px'}">
            <img :src="logo_b64" @load="proportion_logo_loaded()" ref="proportions_logologo" style="width: 200px; height: auto;border: 1px solid #d9d9d9;">
        </div> --}}
        <div class="proportions_text"
             style="top: {{290/$ratio + 20}}px; width: 300%; margin-left: -100%;">{!!$proportions_text!!}</div>
        @if($proportions_fibo_active_active)
            <div class="propositions_fibonacci_container" style="top: {{290/$ratio + 70}}px">
                <div class="proportions_fibonacci @if($proportions_fibo_active_golden) golden @endif">
                    @foreach([1, 1, 2, 3, 5, 8, 13, 21, 34, 55] as $ndx=>$i)
                        <span
                            class="@if(in_array($i, $proportions_fibo_active)) @if($ndx==0&&$i==1) @else active @endif @endif">{{$i}}</span>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="logo-image" style="background-image: url({{$white_bg_logo}})"></div>
    </div>
    @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
        <div class="icon"
             style="bottom: 110px; @if($ratio_icon<1) width: {{70*$ratio_icon}}px; height: 70px; @else width: 70px; height: {{70/$ratio_icon}}px; @endif">
            <div class="prop_x"
                 style="width: 100%; height: 30px; position: absolute; top: -30px; left: 0; border-left: 1px solid #000; border-right: 1px solid #000">
                <svg width="15" height="8" class="x_first" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
                <span>{!!$proportions_x_icon!!}</span>
                <svg width="15" height="8" class="x_last" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
            </div>
            <div class="prop_y"
                 style="width: 30px; height: 100%; position: absolute; top: 0; left: -30px;  border-top: 1px solid #000; border-bottom: 1px solid #000">
                <svg width="15" class="y_first" height="8" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
                <span>{!!$proportions_y_icon!!}</span>
                <svg width="15" height="8" class="y_last" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
            </div>
            @if(isset($data->icon[0]))
                <div class="logo-image"
                     style="background-image: url({{isset($data->icon_b64)?$data->icon_b64:''}})"></div>
            @endif
        </div>
    @endif
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
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

    .propositions_fibonacci_container {
        display: flex;
        justify-content: center;
        position: absolute;
        width: 100%;
        height: 30px;
        /*bottom: 30px;*/
        white-space: nowrap;
    }

    .proportions_text {
        text-align: center;
        opacity: 1 !important;
        position: absolute;
        width: 100%;
        color: #999;
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
                 color: #fff;
        padding: 3px 4px;
        margin: 0;
        border-radius: 3px;
    }
</style>
<div class="page-break pb19"></div>
<div id="page20">
    @php
        $page_number++;
    @endphp
    <div class="svg-block" style="position: absolute;left: 0;top: 0;">
        <svg width="472" height="307" viewBox="0 0 472 307" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M280.521 143.753C279.2 138.141 287.621 128.325 300.166 125.371C312.711 122.417 323.842 122.941 328.661 127.259C335.626 133.5 320.61 144.201 308.065 147.155C295.52 150.109 282.727 153.122 280.521 143.753Z"
                fill="#EAEAEA"/>
            <path
                d="M53.7897 63.3446C-37.411 160.474 18.6425 300.26 130.835 294.626C229.769 286.48 220.099 140.688 272.212 124.309C355.886 98.0094 499.387 26.9282 418.614 -40.1828C341.738 -104.056 127.968 -15.6559 53.7897 63.3446Z"
                fill="#D7D7D7"/>
        </svg>

    </div>
    <div class="page-number" id="Clear Space">{{$page_number}}</div>
    <h1 class="title" contenteditable="true" data-title-field="space_title" style="position: relative;z-index: 2">
        {!!
            !empty($data->space_title) ?
                $data->space_title :
                trans('themes.clear_space')
        !!}
    </h1>
    <div class="text" data-field="space_text" style="position: relative;z-index: 2">
        @if(!empty($data->space_text))
            {!!$data->space_text!!}
        @else
            <p>
                {!! trans('themes.clear_space_text', ['brand' => $data->brand]) !!}
            </p>
        @endif
    </div>
    @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
        @php
            $shorter = 0;
            $longer = 0;
            $shorter_text = 'x';
            $longer_text = 'y';

            if($icon_w>$icon_h){
            $data->icon_w = 60;
            $data->icon_h = $icon_h*60/$icon_w;
            }else{
            $data->icon_h = 60;
            $data->icon_w = $icon_w*60/$icon_h;
            }

            // $data->icon_w = $icon_w;
            // $data->icon_h = $icon_h;

            if($data->icon_w<$data->icon_h){
            $shorter = $data->icon_w;
            $longer = $data->icon_h;
            $shorter_text = 'x';
            $longer_text = 'y';
            }elseif(ceil($data->icon_w)==ceil($data->icon_h)){
            $shorter = $data->icon_h;
            $longer = $data->icon_h;
            if($shorter>100){
            $shorter = 70;
            $longer = 70;
            $data->icon_h = 70;
            $data->icon_w = 70;
            }
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
        <div class="icon iconster space-{{$data->space}}"
             style="width: {{$data->icon_w}}px; height: {{$data->icon_h}}px;margin-left: -{{$data->icon_w/2}}px;bottom: {{60+110}}px; {{--top: {{$logo_fsy+60}}px--}}">
            <div class="logogsspace space_x icon"
                 style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif;background-size: contain; background-position: center; background-repeat: no-repeat;  width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: -{{($data->icon_w/2+$free_space_x_w)}}px; margin-top: -{{($data->icon_h>0?$data->icon_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
                <div class="first">
                    <span>{!!$free_space_y!!}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                    </svg>
                </div>
                <div class="seond"><span>{!!$free_space_x!!}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                    </svg>
                </div>
            </div>
            <div class="logogsspace space_x2"
                 style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif;background-size: contain; background-position: center; background-repeat: no-repeat;  width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: {{$data->icon_w/2}}px; margin-top: {{($data->icon_h>0?$data->icon_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
                <!--<div class="first" v-html=free_space_x></div>-->
                <!--<div class="seond" v-html=free_space_y></div>-->
            </div>
            <div class="logogsspace space_x3"
                 style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif; background-size: contain; background-position: center; background-repeat: no-repeat; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: -{{($data->icon_w/2+$free_space_x_w)}}px; margin-top: {{($data->icon_h>0?$data->icon_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
                <!--<div class="first" v-html=free_space_x></div>-->
                <!--<div class="seond" v-html=free_space_y></div>-->
            </div>
            <div class="logogsspace space_x4"
                 style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif;background-size: contain; background-position: center; background-repeat: no-repeat;  width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: {{$data->icon_w/2}}px; margin-top: -{{($data->icon_h>0?$data->icon_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
                <!--<div class="first" v-html=free_space_x></div>-->
                <!--<div class="seond" v-html=free_space_y></div>-->
            </div>
            <div class="logo-sponge-space_x iconed" style="--width: {{$data->icon_w}}px; --height: {{$data->icon_h}}px">
                <span>{{$free_sp_x_text}}</span>
                <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
                <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
            </div>
            <div class="logo-sponge-space_y iconed" style="--height: {{$data->icon_h}}px; --width: {{$data->icon_w}}px">
                <span>{{$free_sp_y_text}}</span>
                <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
                <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
            </div>
            @if($data->space=='pithagoras')
                <div class="logo-sponge-space_c iconed"
                     style="--pyw: {{sqrt($data->logo_w*$data->icon_w + $data->icon_h*$data->icon_h)}}px; --width: {{$data->icon_w}}px; --height: {{$data->icon_h}}px; --degree: {{(asin($data->icon_h/sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h))*180/pi())}}deg">
                    <span>{{$free_sp_c_text}}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                    </svg>
                </div>
            @endif
            @if(isset($data->icon_b64))
                <div class="logo-image"
                     style="width: {{$data->icon_w}}px; height: {{$data->icon_h}}px;background-image: url({{isset($data->icon_b64)?$data->icon_b64:''}})"></div>
            @endif
            <style>
                .logo-sponge-space_x.iconed {
                    margin-left: -{{$data->icon_w/2}}px;
                    margin-bottom: {{$data->icon_h/2}}px;
                }

                .logo-sponge-space_y.iconed {
                    /*margin-left: -






                {{$data->icon_w/2}}       px;
              margin-bottom:






                {{$data->icon_h/2}}       px;*/

                    margin-top: -{{$data->icon_h/2}}px;
                    margin-right: {{$data->icon_w/2}}px;
                    height: {{$data->icon_h}}px;
                }

                .logo-sponge-space_c.iconed {
                    width: {{sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h)}}px;
                    transform: rotate({{(asin($data->icon_h/sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h))*180/pi())}}deg);
                    position: absolute;
                    top: 50%;
                    margin-top: -15px;
                    left: 50%;
                    margin-left: -{{sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h)/2}}px;
                }

                #page21 .icon.iconster:before, #page20 .icon.iconster:before {
                    content: "";
                    display: block;
                    border-top: 1px solid #999;
                    border-bottom: 1px solid #999;
                    height: {{($data->icon_h + 2*$free_space_y_h)-2}}px;
                    position: absolute;
                    top: -{{$free_space_y_h + 1}}px;
                    left: -1px;
                    width: 103%;
                }

                #page21 .icon.iconster:after, #page20 .icon.iconster:after {
                    content: "";
                    display: block;
                    border-left: 1px solid #999;
                    border-right: 1px solid #999;
                    width: {{($data->icon_w + 2*$free_space_x_w)-2}}px;
                    position: absolute;
                    left: -{{$free_space_x_w+1}}px;
                    top: -1px;
                    height: 103%;
                }

                .icon.iconster .space_x .first, .icon.iconster .space_x2 .first {
                    height: {{$free_space_y_h}}px;
                }
            </style>
            {{-- <div class="icon-post"><div class="left">x</div><div class="right">x</div></div> --}}
        </div>
    @endif
    {{-- <div class="text-explain">
        <div class="texted">x = </div><div class="icon"></div>
        <div class="description">
            Minimum Clear Space - using the icon from the logo as a reference<br>unit for the clear space
        </div>
    </div> --}}
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb20"></div>
<div id="page21">
    @php
        $page_number++;
    @endphp
    <div class="page-number right">{{$page_number}}</div>

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
        if($longer>140){
        $longer = 140;
        $shorter = $shorter*140/$data->logo_h;
        $data->logo_h = 140;
        $data->logo_w = $shorter;
        }
        $shorter_text = 'x';
        $longer_text = 'y';
        }elseif(ceil($data->logo_w)==ceil($data->logo_h)){
        $shorter = $data->logo_h;
        $longer = $data->logo_h;
        if($shorter>200){
        $shorter = 140;
        $longer = 140;
        $data->logo_h = 140;
        $data->logo_w = 140;
        }
        $shorter_text = 'x';
        $longer_text = 'x';
        }else{
        $shorter = $data->logo_h;
        $longer = $data->logo_w;
        if($longer>200){
        $longer = 200;
        $shorter = $shorter*200/$data->logo_w;
        $data->logo_w = 200;
        $data->logo_h = $shorter;
        }
        if($longer<200){
        $longer = 200;
        $shorter = $shorter*200/$data->logo_w;
        $data->logo_w = 200;
        $data->logo_h = $shorter;
        }
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
        $logo_fsy = 3*$free_space_y_h + $data->logo_h;
    @endphp
    <div class="view-block space-{{$data->space}}"
         style="position: relative;top:{{($data->logo_h>0?$data->logo_h/2+$free_space_y_h:1)+200}}px;
         @if($data->logo_w/$data->logo_h<1 && $data->logo_h>=100)transform:scale(.8)@endif
         @if(empty($data->icon) || $data->icon=='skipped' || $data->icon=='[]') top: 50%; margin-top: -{{$data->logo_h/2}}px; @endif
             ">
        <div class="logogsspace space_x"
             style="background-image: @if($show_clear_icon) url({{$white_bg_logo}}) @else none @endif;
                 background-size: contain; background-position: center; background-repeat: no-repeat;
                 width: {{$free_space_x_w}}px;
                 height: {{$free_space_y_h}}px;
                 position: absolute; top: 50%; left: 50%;
                 margin-left: -{{($data->logo_w/2+$free_space_x_w)}}px;
                 margin-top: -{{($data->logo_h>0?$data->logo_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
            <div class="first">
                <span>{!!$free_space_y!!}</span>
                <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
                <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
            </div>
            <div class="seond"><span>{!!$free_space_x!!}</span>
                <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
                <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
            </div>
        </div>
        <div class="logogsspace space_x2"
             style="background-image: @if($show_clear_icon) url({{$white_bg_logo}}) @else none @endif; background-size: contain; background-position: center; background-repeat: no-repeat; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: {{$data->logo_w/2}}px; margin-top: {{($data->logo_h>0?$data->logo_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
            <!--<div class="first" v-html=free_space_x></div>-->
            <!--<div class="seond" v-html=free_space_y></div>-->
        </div>
        <div class="logogsspace space_x3"
             style="background-image: @if($show_clear_icon) url({{$white_bg_logo}}) @else none @endif; background-size: contain; background-position: center; background-repeat: no-repeat; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%; left: 50%; margin-left: -{{($data->logo_w/2+$free_space_x_w)}}px; margin-top: {{($data->logo_h>0?$data->logo_h/2:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
            <!--<div class="first" v-html=free_space_x></div>-->
            <!--<div class="seond" v-html=free_space_y></div>-->
        </div>
        <div class="logogsspace space_x4"
             style="background-image: @if($show_clear_icon) url({{$white_bg_logo}}) @else none @endif; width: {{$free_space_x_w}}px; height: {{$free_space_y_h}}px; position: absolute; top: 50%;background-size: contain; background-position: center; background-repeat: no-repeat;  left: 50%; margin-left: {{$data->logo_w/2}}px; margin-top: -{{($data->logo_h>0?$data->logo_h/2+$free_space_y_h:1)}}px; border: 1px solid #999; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
            <!--<div class="first" v-html=free_space_x></div>-->
            <!--<div class="seond" v-html=free_space_y></div>-->
        </div>
        <div class="logo-sponge-space_x" style="--width: {{$data->logo_w}}px; --height: {{$data->logo_h}}px">
            <span>{{$free_sp_x_text}}</span>
            <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
            <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
        </div>
        <div class="logo-sponge-space_y" style="--height: {{$data->logo_h}}px; --width: {{$data->logo_w}}px">
            <span>{{$free_sp_y_text}}</span>
            <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
            <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
            </svg>
        </div>
        @if($data->space=='pithagoras')
            <div class="logo-sponge-space_c"
                 style="--pyw: {{sqrt($data->logo_w*$data->logo_w + $data->logo_h*$data->logo_h)}}px; --width: {{$data->logo_w}}px; --height: {{$data->logo_h}}px; --degree: {{(asin($data->logo_h/sqrt($data->logo_w*$data->logo_w + $data->logo_h*$data->logo_h))*180/pi())}}deg">
                <span>{{$free_sp_c_text}}</span>
                <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
                <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="black"/>
                </svg>
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
            @if(isset($white_bg_logo))
                <div class="proportions_logo logo-image"
                     style="width: {{$data->logo_w}}px;height: {{$data->logo_h}}px;background-image: url({{$white_bg_logo}})"></div>
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

                .space-newton .logogsspace .first .logosp_arr_1 {
                    transform: rotate(90deg);
                    top: -10px;
                }

                .space-newton .logogsspace .first .logosp_arr_2 {
                    transform: rotate(-90deg);
                    bottom: -10px;
                }

                .space-newton .logogsspace .seond .logosp_arr_1 {
                    transform: rotate(0deg);
                    left: -12px;
                }

                .space-newton .logogsspace .seond .logosp_arr_2 {
                    transform: rotate(180deg);
                    right: -12px;
                }

                #page21 .logo:before {
                    content: "";
                    display: block;
                    border-top: 1px solid #999;
                    border-bottom: 1px solid #999;
                    height: {{$data->logo_h + 2*$free_space_y_h-2}}px;
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
                    width: {{$data->logo_w + 2*$free_space_x_w-2}}px;
                    position: absolute;
                    left: -{{$free_space_x_w+1}}px;
                    top: -1px;
                    height: 108%;
                }

                .space_x .first, .space_x2 .first {
                    font-size: 30px;
                    text-align: center;
                    padding-left: 15px;
                    position: absolute;
                    left: -80px;
                    top: -1px;
                    height: {{$free_space_y_h}}px;
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
                    left: -1px;
                    width: {{$free_space_x_w}}px;
                    text-align: center;
                    color: #000;
                    border-left: 1px solid #000;
                    border-right: 1px solid #000;
                    background-repeat: no-repeat;
                    background-size: contain;
                    height: 60px;
                    top: -60px;
                }


                .icon .space_x .first, .space_x2 .first {
                    height: {{$free_space_y_h-1}}px;
                }

                .icon .space_x .seond, .space_x2 .seond {
                    width: {{$free_space_x_w-1}}px;
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
                    top: 30px;
                }

                .logo-sponge-space_x .logosp_arr_1 {
                    transform: rotate(-180deg);
                    position: absolute;
                    top: 27px;
                    left: 0;
                }

                .logo-sponge-space_x .logosp_arr_2 {
                    position: absolute;
                    top: 27px;
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
                 width: {{ceil($free_space_x_w)}}px;
                }

                .logo-sponge-space_y:after {
                    content: "";
                    height: 100%;
                    width: 1px;
                    position: absolute;
                    background: #000;
                    left: {{ceil($free_space_x_w/2)-1}}px;
                    top: 0px;
                }

                .logo-sponge-space_y .logosp_arr_1 {
                    transform: rotate(-90deg);
                    position: absolute;
                    top: 2px;
                    left: {{ceil($free_space_x_w/2)-8}}px;
                }

                .logo-sponge-space_y .logosp_arr_2 {
                    position: absolute;
                    bottom: 2px;
                    left: {{ceil($free_space_x_w/2)-8}}px;
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
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb21"></div>
<div id="page22" style="padding: 280px 170px;background: #fff">
    @php
        $page_number++;
    @endphp
    <div class="page-number" id="Minimum Size">{{$page_number}}</div>
    <div class="svg-block"
         style="position: absolute; text-align: center; left: 50%;top: 50%;margin-top: -90px;margin-left: -94px;">
        <svg width="189" height="180" viewBox="0 0 189 180" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M21.0816 139.818C47.3856 174.545 111.015 195.686 146.597 165.116C182.179 134.547 197.789 90.6891 183.794 49.9459C163.562 -8.95049 84.6183 -10.4704 49.0366 20.0993C13.4549 50.6689 -22.8315 81.844 21.0816 139.818Z"
                fill="#EAEAEA"/>
        </svg>

    </div>
    <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="size_title"
        style="position: relative;z-index: 2">{!! !empty($data->size_title) ? $data->size_title :trans('themes.minimum_size') !!}
    </h1>
    <div class="text" data-field="size_text" style="position: relative;z-index: 2">
        @if(!empty($data->size_text))
            {!!$data->size_text!!}
        @else
            <p>{{trans('themes.establishing')}}</p>
        @endif
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb22"></div>
<div id="page23">
    @php
        $page_number++;
    @endphp
    <div class="page-number right" id="Minimum Size">{{$page_number}}</div>
    <div style="display: flex; flex-wrap: nowrap;justify-content: center;align-items:  center; height: 570px;">
        <div class="lgo" style="text-align: center;margin: 0 20px;">
            <div class="logo"
                 style="height: auto; margin: 0 auto; width: @if($data->size=='quark')71px;@endif @if($data->size=='neutron')100px;@endif @if($data->size=='atom')160px;@endif @if($data->size=='molecule')214px;@endif">
                @if(isset($white_bg_logo))
                    <img class="logo-image" src="{{$white_bg_logo}}" style="
                        width: @if($data->size=='quark')71px;@endif @if($data->size=='neutron')100px;@endif @if($data->size=='atom')160px;@endif @if($data->size=='molecule')214px;@endif
                        display: block;margin: 0 auto; height: auto;
                        ">
                @endif
            </div>
            <div class="logo_after" style="margin: 0 auto;
                width: @if($data->size=='quark')71px;@endif @if($data->size=='neutron')100px;@endif @if($data->size=='atom')160px;@endif @if($data->size=='molecule')214px;@endif
                ">
                <svg width="19" height="51" class="first" viewBox="0 0 19 51" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/>
                    <path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/>
                </svg>
                <div class="text" style="
                    width: @if($data->size=='quark')51px;@endif @if($data->size=='neutron')80px;@endif @if($data->size=='atom')140px;@endif @if($data->size=='molecule')194px;@endif
                @if($data->size=='quark' || $data->size=='neutron')line-height: 1em;padding-top: 10px;@endif
                    ">@if($data->size=='quark') 71px / 20mm @endif @if($data->size=='neutron') 100px /
                    28mm @endif @if($data->size=='atom') 160px / 45mm @endif @if($data->size=='molecule') 214px /
                    60mm @endif</div>
                <svg width="19" height="51" class="last" viewBox="0 0 19 51" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/>
                    <path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/>
                </svg>
            </div>
            <div class="description">
                {{trans('themes.not_smaller_in_digital_logo', ['brand' => $data->brand])}}<br>@if($data->size=='quark')
                    71px @endif @if($data->size=='neutron') 100px @endif @if($data->size=='atom')
                    160px @endif @if($data->size=='molecule')
                    214px @endif {{trans('themes.in_digital_or')}} @if($data->size=='quark')
                    20mm @endif @if($data->size=='neutron') 28mm @endif @if($data->size=='atom')
                    45mm @endif @if($data->size=='molecule') 60mm @endif {{trans('themes.in_print')}}.
            </div>
        </div>
        @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
            <div class="icn" style="text-align: center;margin: 0 20px;">
                <div class="icon"
                     style="margin: 0 auto;height: auto;width: @if($data->size=='quark')10px;@endif @if($data->size=='neutron')14px;@endif @if($data->size=='atom')22px;@endif @if($data->size=='molecule')30px;@endif">
                    <img class="logo-image" src="{{$data->icon_b64}}" style="
                        width: @if($data->size=='quark')10px;@endif @if($data->size=='neutron')14px;@endif @if($data->size=='atom')22px;@endif @if($data->size=='molecule')30px;@endif
                        display: block;margin: 0 auto; height: auto;
                        ">
                </div>
                <div class="icon_after" style="margin: 0 auto;display: flex;justify-content: space-between;
                    width: @if($data->size=='quark')10px;@endif @if($data->size=='neutron')14px;@endif @if($data->size=='atom')22px;@endif @if($data->size=='molecule')30px;@endif
                    ">
                    <svg width="19" height="51" class="first" viewBox="0 0 19 51" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/>
                        <path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/>
                    </svg>
                    <svg width="19" height="51" class="last" viewBox="0 0 19 51" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.5 32L17.7272 46.25H1.27276L9.5 32Z" fill="#999999"/>
                        <path d="M9.5 2.18554e-08L9.5 32" stroke="#999999" stroke-width="1" stroke-dasharray="8 4"/>
                    </svg>
                </div>
                <div class="description">
                    {{trans('themes.not_smaller_in_digital', ['brand' => $data->brand])}}<br>
                    @if($data->size=='quark') 10px @endif
                    @if($data->size=='neutron') 14px @endif
                    @if($data->size=='atom') 22px @endif
                    @if($data->size=='molecule') 30px @endif
                    {{trans('themes.in_digital_or')}}
                    @if($data->size=='quark') 2.8mm @endif
                    @if($data->size=='neutron') 3.9mm @endif
                    @if($data->size=='atom') 6.3mm @endif
                    @if($data->size=='molecule') 8.4mm @endif {{trans('themes.in_print')}}.
                </div>
            </div>
        @endif
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb23"></div>
@if(isset($data->mockups[2]))
    @if(!empty($data->mockups[2]->title))
        <div id="page-mockup-3-0">
            @php
                $page_number++;
            @endphp
            <div class="page-number">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-title">
                    {{$data->mockups[2]->title}}
                </div>
                <div class="mockup-photo mockup-photo-left-half"
                     style="background-image: url({{$data->mockups[2]->image}})"></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div id="page-mockup-3-1">
            @php
                $page_number++;
            @endphp
            <div class="page-number right">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-photo mockup-photo-right-full-left-half"
                     style="background-image: url({{$data->mockups[2]->image}})"></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @else
        <div id="page-mockup-1-0">
            @php
                $page_number++;
            @endphp
            <div class="page-number">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-photo mockup-photo-left-full"
                     style="background-image: url({{$data->mockups[2]->image}})"></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div id="page-mockup-1-1">
            @php
                $page_number++;
            @endphp
            <div class="page-number right">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-photo mockup-photo-right-full"
                     style="background-image: url({{$data->mockups[2]->image}})"></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endif
@endif
@if(!empty($data->missuses))
    <div id="page24">
        @php
            $page_number++;
        @endphp
        <div class="page-number" id="Logo Misuse">{{$page_number}}</div>
        <h1 class="title text-white" contenteditable="true" @blur="title_changed()" data-title-field="misuse_title"
            style="color: #000;position: relative;z-index: 2">
            {!! !empty($data->misuse_title) ? $data->misuse_title : trans('themes.logo_misuse') !!}</h1>
        <div class="text text-white" data-field="misuse_text" style="color: #000; position: relative;z-index: 2">
            @if(!empty($data->misuse_text))
                {!!$data->misuse_text!!}
            @else
                <p>{!! trans('themes.it_is_important_that_appearance') !!}</p>
            @endif
        </div>
        <div class="svg-block"
             style="position: absolute;left: 50%;top: 50%;margin-left: -324px; margin-top: -239px;">
            <svg width="649" height="479" viewBox="0 0 649 479" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M109.402 292.649L158.883 264.152L160.911 267.673L150.719 273.543L221.373 396.227L231.566 390.357L233.594 393.878L177.07 426.431L175.042 422.91L185.235 417.04L118.529 301.212L117.788 301.639L158.723 436.997L135.558 450.338L33.8869 349.218L33.1456 349.645L100.172 466.028L110.364 460.158L112.392 463.679L87.1883 478.195L85.1604 474.674L95.3532 468.803L24.6983 346.119L14.5055 351.989L12.4777 348.468L62.5151 319.651L142.129 400.898L109.402 292.649ZM209.127 273.469C202.578 277.24 196.923 278.276 192.16 276.577C187.521 274.806 183.778 271.45 180.932 266.508C178.086 261.566 177.221 256.635 178.336 251.715C179.575 246.724 183.283 242.45 189.46 238.892C195.638 235.334 201.186 234.113 206.106 235.228C210.955 236.22 214.945 239.434 218.076 244.87C221.135 250.183 222.046 255.334 220.807 260.326C219.568 265.317 215.675 269.698 209.127 273.469ZM188.507 302.372L233.911 276.224L282.793 361.102L293.172 355.125L295.093 358.461L240.051 390.16L238.13 386.824L248.323 380.954L201.362 299.411L190.428 305.708L188.507 302.372ZM304.2 355.684L285.095 322.511L287.319 321.23C296.722 330.129 305.386 335.175 313.313 336.369C321.239 337.562 329.28 335.811 337.434 331.115C350.036 323.857 354.025 316.213 349.4 308.182C347.407 304.723 344.369 303.018 340.284 303.067C333.9 303.124 326.513 304.581 318.123 307.439C308.441 310.053 299.691 311.144 291.873 310.71C282.516 310.176 275.063 305.091 269.513 295.454C263.963 285.817 262.517 276.449 265.174 267.351C267.76 258.128 273.995 250.671 283.879 244.979C289.933 241.492 296.99 239.32 305.051 238.462C307.968 238.098 310.044 237.561 311.28 236.849C312.515 236.138 313.316 235.1 313.683 233.737C314.05 232.375 314.175 230.164 314.059 227.105L316.097 225.931L332.427 254.285L330.203 255.566C314.652 243.133 300.267 240.724 287.047 248.337C281.24 251.681 277.521 255.222 275.889 258.959C274.185 262.572 274.223 265.923 276.002 269.012C277.069 270.865 278.356 272.098 279.861 272.712C281.295 273.203 282.401 273.553 283.18 273.762C283.959 273.972 285.082 274.065 286.55 274.043C287.947 273.896 289.122 273.795 290.077 273.739C290.961 273.559 292.286 273.289 294.053 272.93C295.944 272.499 297.296 272.132 298.108 271.829C307.719 269.09 314.84 267.457 319.472 266.929C324.032 266.277 328.62 266.102 333.237 266.405C342.736 267.186 350.509 272.828 356.557 283.33C362.534 293.708 363.999 303.394 360.953 312.388C357.835 321.258 350.901 328.788 340.153 334.978C332.493 339.39 324.048 341.868 314.819 342.412C312.767 342.277 311.308 342.459 310.444 342.957C307.726 344.522 306.386 348.338 306.424 354.403L304.2 355.684ZM486.192 248.405L443.938 272.74L434.108 260.385C434.978 266.465 434.218 272.003 431.83 276.998C429.494 281.798 424.496 286.404 416.836 290.816C397.686 301.844 382.17 297.042 370.287 276.41L338.162 220.627L327.783 226.604L325.862 223.268L370.711 197.44L407.319 261.006C411.588 268.419 414.893 273.014 417.233 274.793C419.697 276.5 422.473 276.464 425.562 274.685C428.774 272.835 430.513 269.283 430.778 264.03C431.043 258.777 429.219 252.753 425.306 245.958L392.647 189.249L384.122 194.158L382.201 190.823L425.196 166.061L474.078 250.94L484.271 245.07L486.192 248.405ZM495.315 245.619L476.21 212.446L478.434 211.165C487.837 220.064 496.501 225.11 504.428 226.304C512.354 227.497 520.395 225.746 528.549 221.05C541.151 213.792 545.14 206.148 540.515 198.118C538.522 194.658 535.484 192.953 531.399 193.002C525.015 193.059 517.628 194.516 509.238 197.374C499.556 199.989 490.806 201.079 482.988 200.646C473.631 200.111 466.178 195.026 460.628 185.389C455.078 175.752 453.632 166.384 456.289 157.286C458.875 148.064 465.11 140.606 474.994 134.914C481.048 131.428 488.106 129.255 496.167 128.397C499.083 128.033 501.159 127.496 502.395 126.784C503.63 126.073 504.431 125.036 504.798 123.673C505.165 122.31 505.29 120.099 505.174 117.04L507.212 115.866L523.542 144.22L521.318 145.501C505.767 133.069 491.382 130.659 478.162 138.272C472.355 141.617 468.636 145.157 467.004 148.894C465.301 152.507 465.338 155.858 467.117 158.947C468.185 160.8 469.471 162.034 470.976 162.648C472.41 163.138 473.517 163.488 474.295 163.697C475.074 163.907 476.197 164.001 477.665 163.978C479.062 163.832 480.237 163.731 481.192 163.674C482.076 163.494 483.401 163.225 485.168 162.865C487.059 162.434 488.411 162.067 489.223 161.764C498.834 159.026 505.955 157.392 510.587 156.864C515.147 156.212 519.735 156.037 524.352 156.34C533.851 157.122 541.625 162.763 547.673 173.265C553.649 183.643 555.115 193.329 552.068 202.323C548.95 211.193 542.017 218.723 531.268 224.914C523.608 229.325 515.163 231.803 505.934 232.347C503.882 232.212 502.424 232.394 501.559 232.892C498.841 234.457 497.501 238.273 497.539 244.338L495.315 245.619ZM620.148 173.727C604.21 182.906 589.878 185.73 577.151 182.201C564.477 178.477 553.941 169.326 545.545 154.747C537.078 140.044 535.051 126.24 539.464 113.333C544 100.356 553.187 89.8821 567.025 81.913C595.07 65.7613 616.649 72.0902 631.76 100.9L579.498 130.998L583.661 138.225C590.634 150.333 597.444 158.586 604.09 162.985C610.736 167.383 617.89 167.377 625.55 162.966C639.881 154.712 644.86 141.644 640.484 123.763L644.14 122.397C646.916 132.645 646.638 142.018 643.307 150.518C640.099 158.946 632.379 166.683 620.148 173.727ZM577.549 127.184L596.637 116.191L591.408 107.11C585.644 97.1028 581.113 90.6634 577.814 87.792C574.568 84.7259 571.153 84.2246 567.57 86.288C564.111 88.2803 562.655 91.7513 563.202 96.701C563.801 101.456 566.841 108.59 572.319 118.103L577.549 127.184Z"
                    fill="#EAEAEA"/>
            </svg>

        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb24"></div>
    <div id="page25">
        @php
            $page_number++;
        @endphp
        <div class="page-number right">{{$page_number}}</div>
        @foreach($data->missuses as $missuse)
            <div class="rejected_item">
                <div class="logo-image"
                     style="@foreach($missuse->style as $key=>$value) {{\App\BrandBookCreator\BrandBookHelper::fromCamelCase($key)}}: @if($value=='rotate(45deg)') rotate(20deg) @else{{$value}}@endif;@endforeach background-image: url({{$missuse->logo_b64}})"></div>
                <div class="title">{{$missuse->title}}</div>
                <div class="line"></div>
            </div>
        @endforeach
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb25"></div>
@endif
@if(count($data->icon_family)>0)
    <div id="page26-1" style="padding: 90px;padding-top: 300px;">
        @php
            $page_number++;
        @endphp
        <div class="page-number">{{$page_number}}</div>
        <h1 class="title" style="position: relative;z-index: 2">{{trans('themes.feature_icons')}}</h1>
        <div class="text" style="position: relative;z-index: 2">
            <p>{{trans('themes.icons_are_the_visual')}}</p>
        </div>
        <div class="svg-block" style="position: absolute;left: 0;top: 50%;margin-top: -420px;">
            <svg width="425" height="840" viewBox="0 0 425 840" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M36.228 665.147C274.865 694.778 419.031 464.339 291.456 306.761C174.325 171.188 -27.9439 340.392 -107.267 281.84C-234.629 187.828 -490.931 54.2335 -502.841 243.395C-514.177 423.43 -157.868 641.047 36.228 665.147Z"
                    fill="#D7D7D7"/>
            </svg>

        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb26-1"></div>
    <div id="page27-1">
        @php
            $page_number++;
        @endphp
        <div class="page-number right">{{$page_number}}</div>
        <div
            class="favicons @if(count($data->icon_family)<5) favicons-1-4 @endif @if(count($data->icon_family)>=5 && count($data->icon_family)<10) favicons-5-9 @endif @if(count($data->icon_family)>=10) favicons-10-12 @endif"
            style="justify-content: center;">
            @foreach($data->icon_family as $ind=>$icon)
                <div class="favicon icon-{{$ind}}">
                    <div class="logo-img">
                        <div class="image"
                             style="background-image: url({{isset($icon['b64'])?$icon['b64']:''}});background-repeat: no-repeat;background-position: center;background-size: contain;width: 100px;height: 100px;"></div>
                    </div>
                    <div class="logo-title" style="margin-top: 0">
                        {{isset($icon['title'])?$icon['title']:''}}
                    </div>
                </div>
            @endforeach
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb27-1"></div>
@endif
{{-- @foreach($data->mockups as $c=>$mockup)
<div id="page28-{{$c}}">
    @php
    $page_number++;
    @endphp
    <div class="page-number @if($c % 2==1) right @endif">{{$page_number}}</div>
    <div class="mockup">
        @if(!empty($mockup->title))
        @if($c % 2 == 1)
        <div class="image-full-left" style="background-image: url({{$mockup->image}})"></div>
        @else
        <div class="mockup-title-left">
            {{$mockup->title}}
        </div>
        <div class="part-image-left" style="background-image: url({{$mockup->image}})"></div>
        @endif
        @else
        <div class="image-full-left" style="background-image: url({{$mockup->image}})"></div>
        @endif
    </div>
</div>
<div class="page-break pb28-{{$c}}"></div>
<div id="page28-{{$c}}-2">
    @php
    $page_number++;
    @endphp
    <div class="page-number @if($c % 2==1) right @endif">{{$page_number}}</div>
    <div class="mockup">
        @if(!empty($mockup->title))
        @if($c % 2 == 1)
        <div class="part-image-right" style="background-image: url({{$mockup->image}})"></div>
        <div class="mockup-title-left">
            {{$mockup->title}}
        </div>

        @else
        <div class="image-full-right" style="background-image: url({{$mockup->image}})"></div>
        @endif
        @else
        <div class="image-full-right" style="background-image: url({{$mockup->image}})"></div>
        @endif
    </div>
</div>
<div class="page-break pb28-{{$c}}"></div>
@endforeach --}}
<div id="page26" style="padding-top: 440px">
    @php
        $page_number++;
    @endphp
    <div class="page-number" id="Color Palette">{{$page_number}}</div>
    <h1 class="title" contenteditable="true" @blur="title_changed()"
        data-title-field="pallette_title">{!! !empty($data->pallette_title) ? $data->pallette_title :
trans('themes.our_color_palette') !!}</h1>
    <div class="text" data-field="pallette_text" style="">
        @if(!empty($data->pallette_text))
            {!!$data->pallette_text!!}
        @else
            {!! trans('themes.the_colors_selected', ['brand' => $data->brand]) !!}
        @endif
    </div>
    <div class="color-line" style="margin-top: -150px;">
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
                <svg width="323" height="57" viewBox="0 0 323 57" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M323 0.5H56.5L1 56" stroke="#C7C7C7"/>
                </svg>
                {{trans('themes.primary_color')}}
                <div class="color-code">
                    @if(isset($data->colors_list[0]))
                        {{$data->colors_list[0]->id}}
                    @endif
                </div>
            </div>
            <div class="textual-block second">
                <svg width="196" height="33" viewBox="0 0 196 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M196 0.5H33L1 32.5" stroke="#C7C7C7"/>
                </svg>
                {{trans('themes.secondary_color')}}
                <div class="color-code">
                    @if(isset($data->colors_list[1]))
                        {{$data->colors_list[1]->id}}
                    @endif
                </div>
            </div>
            <div class="textual-block third">
                <svg width="62" height="15" viewBox="0 0 62 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M62 0.5H14L0.5 14" stroke="#C7C7C7"/>
                </svg>
                {{trans('themes.tertiary_color')}}
                <div class="color-code">
                    @if(isset($data->colors_list[2]))
                        {{$data->colors_list[2]->id}}
                    @endif
                </div>
            </div>

        </div>
    </div>
    {{-- <div class="text-small">
        Instead of the colors referred to on this page, you may use the PANTONE&reg; colors listed above, the standards for which can be found in the current edition of the PANTONE COLOR FORMULA GUIDE. The colors shown on this page and throughout this guideline have not been evaluated by PANTONE, Inc. for accuracy and may not match the PANTONE color standards. PANTONE&reg; is a registered trademark of PANTONE, Inc.
    </div> --}}
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb26"></div>
<div id="page27-27" style="position: relative;">
    @php
        $page_number++;
    @endphp
    <div class="page-number right" id="Color Palette">{{$page_number}}</div>
    <div class="svg-block" style="position: absolute;top: 0;
		right: 0;">
        <svg width="849" height="638" viewBox="0 0 849 638" fill="none" xmlns="http://www.w3.org/2000/svg">
            @if(isset($data->colors_list[1]))
                <path
                    d="M1023.04 -45.6976C1229.5 -61.843 1405.55 138.588 1324.47 267.179C1248.15 377.538 1033 226.759 974.436 273.346C880.411 348.146 679.707 451.621 630.001 291.076C582.694 138.278 855.12 -32.5659 1023.04 -45.6976Z"
                    fill="{{$data->colors_list[1]->id}}"/>@endif
            @if(isset($data->colors_list[0]))
                <path
                    d="M194.643 162.667C179.869 401.943 418.049 531.187 566.979 394.534C694.657 269.629 513.827 78.7963 567.198 -3.74124C652.892 -136.264 770.024 -399.526 581.069 -399.717C401.231 -399.899 206.659 -31.9488 194.643 162.667Z"
                    fill="{{$data->colors_list[0]->id}}"/>@endif
            @if(isset($data->colors_list[2]))
                <path
                    d="M264.838 307.705C289.947 338.245 298.128 399.204 267.261 424.582C236.393 449.96 197.396 454.838 165.421 434.014C119.198 403.911 129.707 333.357 160.575 307.979C191.442 282.601 222.921 256.721 264.838 307.705Z"
                    fill="{{$data->colors_list[2]->id}}"/>@endif
        </svg>
        <span class="cp1"
              style="position: absolute;display: block;top: 280px;left: 350px;text-transform: uppercase;font-size: 32px;color: #fff;">{{$data->colors_list[0]->id}}</span>
        <span class="cp2"
              style="position: absolute;display: block;top: 240px;left: 680px;text-transform: uppercase;font-size: 24px;color: #fff;">{{$data->colors_list[1]->id}}</span>
        <span class="cp3"
              style="position: absolute;display: block;top: 360px;left: 160px;text-transform: uppercase;font-size: 20px;color: #fff;">{{$data->colors_list[2]->id}}</span>

    </div>
    <div class="text-small">
        {!! trans('themes.instead_of_the_colors') !!}
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb27-27"></div>
<div id="page26-26" class="@if(count($data->colors_list)<5) colors-4 @endif"
     style="position: relative;padding-top: 480px;">
    @php
        $page_number++;
    @endphp
    <div class="page-number" id="Color Palette">{{$page_number}}</div>
    <h1 class="title" contenteditable="true" @blur="title_changed()"
        data-title-field="pallette_title">{!! !empty($data->pallette_title) ? $data->pallette_title : trans('themes.our_color_palette') !!}</h1>
    <div class="text-small">
        {!! trans('themes.instead_of_the_colors') !!}
    </div>
    @if(count($data->colors_list)>4)
        @php
            $cloffset = 0;
            $cllimit = 4;
        @endphp
    @else
        @php
            $cloffset = 0;
            $cllimit = 2;
        @endphp
    @endif
    <div class="color-blocks"
         style="height: 410px;width: 580px;position: absolute;left: 90px;top:90px;align-items: center;display: flex;flex-wrap: nowrap;flex-shrink: 0; flex-grow: 0;justify-content: space-between;">
        @foreach($data->colors_list as $c=>$color)
            @if($c<$cllimit && $c>=$cloffset)
                @if(isset($color->color))
                    <div class="color-block"
                         style="margin-bottom: 20px;flex-basis: 137px; @if(count($data->colors_list)<=4 && $c==1) margin-right: 45px; @endif" {{--style="@if($c<2) margin-top:42px; @endif"--}}>
                        <div class="color-block-color" style="border: 1.30097px solid #C5C3C3;
box-sizing: border-box;
box-shadow: 5.20389px 5.20389px 19.5146px rgba(0, 0, 0, 0.25);padding: 9px;">
                            @if($color->show_shades)
                                <div class="darker-color"
                                     style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}};border-bottom: 2px solid #fff;height: 30px;display: flex;font-size: 10px;align-items: center;align-content: center;justify-content: center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30))}};margin-bottom: 2px;">
                                    {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}}
                                </div>
                            @endif
                            <div class="main-color"
                                 style="background: {{$color->color->hex->value}};border-bottom: 2px solid #fff;height: 120px;display: flex;align-items: center;align-content: center;justify-content: center;font-size: 14px;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($color->color->hex->value)}};margin-bottom: 2px;@if(!$color->show_shades) height: 216px; margin-bottom: 40px; @endif">
                                {{$color->color->hex->value}}
                            </div>
                            @if($color->show_shades)
                                <div class="ligher-color"
                                     style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}};border-bottom: 2px solid #fff;height: 30px;display: flex;font-size: 10px;align-items: center;align-content: center;justify-content: center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30))}};margin-bottom: 2px;">
                                    {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}}
                                </div>
                            @endif
                            @if($color->show_shades)
                                <div class="lightest-color"
                                     style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}};border-bottom: 2px solid #fff;height: 30px;display: flex;font-size: 10px;align-items: center;align-content: center;justify-content: center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40))}};margin-bottom: 40px;">
                                    {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}}
                                </div>
                            @endif
                        </div>
                        <div class="title"
                             style="color: #000; font-size: 13px;margin-top: 6px;margin-bottom: 6px;">{{$color->color->name->value}}</div>
                        <div class="color-block-info" style="">
                            <div class="key-value" style="display: flex;white-space: nowrap;">
                                <div class="key" style="color: #999999; font-size: 13px;">Hex</div>
                                <div class="value"
                                     style="color: #000; font-size: 13px;">{{$color->color->hex->value}}</div>
                            </div>
                            <div class="key-value" style="flex-basis: 100%;white-space: nowrap;display: flex;">
                                <div class="key" style="color: #999999; font-size: 13px;">RGB</div>
                                <div class="value"
                                     style="color: #000; font-size: 13px;">{{$color->color->rgb->r}} {{$color->color->rgb->g}} {{$color->color->rgb->b}}</div>
                            </div>
                            <div class="key-value" style="flex-basis: 100%;white-space: nowrap;display: flex;">
                                <div class="key" style="color: #999999; font-size: 13px;">CMYK</div>
                                <div class="value"
                                     style="color: #000; font-size: 13px;">{{$color->color->cmyk->c}} {{$color->color->cmyk->m}} {{$color->color->cmyk->y}} {{$color->color->cmyk->k}}</div>
                            </div>
                            @if($color->pantone!=null)
                                <div class="key-value" style="flex-basis: 100%;white-space: nowrap;display: flex;">
                                    <div class="key" style="color: #999999; font-size: 13px;">Pantone</div>
                                    <div class="value"
                                         style="color: #000; font-size: 13px;">{{$color->pantone->getName()}}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb26-26"></div>
<div id="page27" class="@if(count($data->colors_list)<5) colors-4 @endif" style="position: relative;">
    @php
        $page_number++;
    @endphp

    <div class="page-number right">{{$page_number}}</div>
    @if(count($data->colors_list)>4)
        @php
            $cloffset = 4;
            $cllimit = 8;
        @endphp
    @else
        @php
            $cloffset = 2;
            $cllimit = 4;
        @endphp
    @endif
    <div class="color-blocks"
         style="height: 410px;width: 580px;position: absolute;left: 90px;top:90px;align-items: center;display: flex;flex-wrap: nowrap;flex-shrink: 0; flex-grow: 0;justify-content: space-between;">
        @foreach($data->colors_list as $c=>$color)
            @if($c<$cllimit && $c>=$cloffset)
                @if(isset($color->color))
                    <div class="color-block"
                         style="margin-bottom: 20px;flex-basis: 137px; @if(count($data->colors_list)<=4 && $c==2) margin-left: 45px; @endif" {{--style="@if($c<2) margin-top:42px; @endif"--}}>
                        <div class="color-block-color" style="border: 1.30097px solid #C5C3C3;
box-sizing: border-box;
box-shadow: 5.20389px 5.20389px 19.5146px rgba(0, 0, 0, 0.25);padding: 9px;">
                            @if($color->show_shades)
                                <div class="darker-color"
                                     style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}};border-bottom: 2px solid #fff;height: 30px;display: flex;font-size: 10px;align-items: center;align-content: center;justify-content: center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30))}};margin-bottom: 2px;">
                                    {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}}
                                </div>
                            @endif
                            <div class="main-color"
                                 style="background: {{$color->color->hex->value}};border-bottom: 2px solid #fff;height: 120px;display: flex;align-items: center;align-content: center;justify-content: center;font-size: 14px;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($color->color->hex->value)}};margin-bottom: 2px;@if(!$color->show_shades) height: 216px; margin-bottom: 40px; @endif">
                                {{$color->color->hex->value}}
                            </div>
                            @if($color->show_shades)
                                <div class="ligher-color"
                                     style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}};border-bottom: 2px solid #fff;height: 30px;display: flex;font-size: 10px;align-items: center;align-content: center;justify-content: center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30))}};margin-bottom: 2px;">
                                    {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}}
                                </div>
                            @endif
                            @if($color->show_shades)
                                <div class="lightest-color"
                                     style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}};border-bottom: 2px solid #fff;height: 30px;display: flex;font-size: 10px;align-items: center;align-content: center;justify-content: center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40))}};margin-bottom: 40px;">
                                    {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}}
                                </div>
                            @endif
                        </div>
                        <div class="title"
                             style="color: #000; font-size: 13px;margin-top: 6px;margin-bottom: 6px;">{{$color->color->name->value}}</div>
                        <div class="color-block-info" style="">
                            <div class="key-value" style="display: flex;white-space: nowrap;">
                                <div class="key" style="color: #999999; font-size: 13px;">Hex</div>
                                <div class="value"
                                     style="color: #000; font-size: 13px;">{{$color->color->hex->value}}</div>
                            </div>
                            <div class="key-value" style="flex-basis: 100%;white-space: nowrap;display: flex;">
                                <div class="key" style="color: #999999; font-size: 13px;">RGB</div>
                                <div class="value"
                                     style="color: #000; font-size: 13px;">{{$color->color->rgb->r}} {{$color->color->rgb->g}} {{$color->color->rgb->b}}</div>
                            </div>
                            <div class="key-value" style="flex-basis: 100%;white-space: nowrap;display: flex;">
                                <div class="key" style="color: #999999; font-size: 13px;">CMYK</div>
                                <div class="value"
                                     style="color: #000; font-size: 13px;">{{$color->color->cmyk->c}} {{$color->color->cmyk->m}} {{$color->color->cmyk->y}} {{$color->color->cmyk->k}}</div>
                            </div>
                            @if($color->pantone!=null)
                                <div class="key-value" style="flex-basis: 100%;white-space: nowrap;display: flex;">
                                    <div class="key" style="color: #999999; font-size: 13px;">Pantone</div>
                                    <div class="value"
                                         style="color: #000; font-size: 13px;">{{$color->pantone->getName()}}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb27"></div>
<div id="page28" style="">
    @php
        $page_number++;
    @endphp
    <div class="page-number" id="Our Fonts">{{$page_number}}</div>
    @if(isset($data->fonts_main[1]))
        <div class="huge-text text-one" style="border: none">
            <div
                style="overflow: hidden;height: 200px;width: 1072px;position: absolute;color: #D4D4D4;left: -104px;top: -95px;font-size: 200px;font-weight: 900;line-height: 200px;white-space: nowrap;">
                <div
                    style="position: absolute;right: 0; bottom: 0;font-family: 'main1';l">{{$data->fonts_main[1]['font_face']}}</div>
            </div>
            @if(isset($data->colors_list[0]) && isset($data->colors_list[0]->id))
                <div class="color"
                     style="position: absolute;color: #EAEAEA;top: 90px;left: 145px;font-weight: 800;text-transform: uppercase;font-size: 50px;">
                    {{$data->colors_list[0]->id}}
                </div>
            @endif
            <small class="color-subtext"
                   style="color: ##D4D4D4;color: #D4D4D4;position: absolute;left: 210px;top: 160px;width: 420px;     white-space: unset;display: block;">
                <svg width="155" height="99" viewBox="0 0 155 99" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M153.001 96.6665H96.3169L1.54883 1.89844" stroke="#D4D4D4" stroke-width="3"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                {{$data->fonts_main[1]['font_face']}} {{$data->fonts_main[1]['weight']}} 70 Pt
            </small>
        </div>
    @endif
    @if(isset($data->fonts_main[2]))
        <div class="huge-text text-one" style="border: none">
            <div
                style="overflow: hidden;height: 200px;width: 750px;position: absolute;color: #EAEAEA;left: -104px;top: 255px;font-size: 120px;font-weight: bold;line-height: 200px;font-family: 'main2'">
                <div
                    style="position: absolute;right: 0; font-family: 'main2';white-space: nowrap;">{{$data->fonts_main[2]['font_face']}}</div>
            </div>
            <small class="color-subtext"
                   style="color: #EAEAEA;color: #EAEAEA;position: absolute;left: 380px;top: 420px;width: 420px;     white-space: unset;display: block;">
                <svg width="155" height="99" viewBox="0 0 155 99" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M153.001 96.6665H96.3169L1.54883 1.89844" stroke="#EAEAEA" stroke-width="3"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                {{$data->fonts_main[2]['font_face']}} {{$data->fonts_main[2]['weight']}} 120 Pt
            </small>
        </div>
    @endif
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb28"></div>
<div id="page29" style=" padding-top: 350px;">
    @php
        $page_number++;
    @endphp
    <div class="page-number right">{{$page_number}}</div>
    @if(isset($data->fonts_main[1]))
        <div class="huge-text text-one" style="border: none">
            <div style="overflow: hidden;height: 200px;width: 1072px;position: absolute;color: #d4d4d4;left: -581px;top: -110px;font-size: 200px;font-weight: 900;line-height: 200px;font-family: 'main1';left: -818px;white-space: nowrap;
    top: -50px;">
                <div
                    style="position: absolute;right: 0; bottom: 0;font-family: 'main1';l">{{$data->fonts_main[1]['font_face']}}</div>
            </div>
            <small class="color-subtext"
                   style="color: #d4d4d4;position: absolute;left: 280px;top: 70px;width: 460px;     white-space: unset;display: block;">
                <svg width="170" height="4" viewBox="0 0 170 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.572266" y="0.945312" width="168.449" height="3" fill="#d4d4d4"/>
                </svg>
                {{$data->fonts_main[1]['font_face']}} {{$data->fonts_main[1]['weight']}} 200 Pt
            </small>
        </div>
    @endif
    <h1 class="title">{{trans('themes.our_fonts')}}</h1>
    <div class="text">
        @if(isset($data->fonts_main) && isset($data->fonts_main[1]))
            {{trans('themes.the_primary_font_is')}}
            {{$data->fonts_main[1]['font_face']}}
            {{trans('themes.and_it_has')}}
            {{count($data->fonts_main)}}
            {{ trans('themes.' . Str::plural('weight', count($data->fonts_secondary)))}}:
            @if(count($data->fonts_main)==4)
                {{$data->fonts_main[2]['weight']}}, {{$data->fonts_main[1]['weight']}}
                {{trans('themes.&')}} {{$data->fonts_main[3]['weight']}}
            @elseif(count($data->fonts_main)==3)
                {{$data->fonts_main[1]['weight']}} {{trans('themes.&')}} {{$data->fonts_main[2]['weight']}}
            @else
                {{$data->fonts_main[1]['weight']}}
            @endif.
        @endif
        @if(isset($data->fonts_secondary) && isset($data->fonts_secondary[1]))
            {{trans('themes.our_secondary_font_is')}} {{$data->fonts_secondary[1]['font_face']}} {{trans('themes.and_it_has')}}
            {{count($data->fonts_secondary)}} {{ trans('themes.' . Str::plural('weight', count($data->fonts_secondary)))}}
            :
            @if(count($data->fonts_secondary)==3)
                {{$data->fonts_secondary[2]['weight']}},
                {{$data->fonts_secondary[1]['weight']}} {{trans('themes.&')}} {{$data->fonts_secondary[3]['weight']}}
            @elseif(count($data->fonts_secondary)==2)
                {{$data->fonts_secondary[1]['weight']}}
                @if(isset($data->fonts_secondary[2])) {{trans('themes.&')}} {{$data->fonts_secondary[2]['weight']}}
                @endif
            @else
                {{$data->fonts_secondary[1]['weight']}}
            @endif.
        @endif
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb29"></div>
<div id="page30">
    @php
        $page_number++;
    @endphp
    <div class="page-number">{{$page_number}}</div>
    <div class="fonts2-title" style="padding-left: 171px;">{{trans('themes.primary_font')}}</div>
    {{-- <div class="gradient-line"></div> --}}
    @if(isset($data->fonts_main) && isset($data->fonts_main[1]))
        <div class="fonts2-fontname"
             style="font-weight: normal;font-size: 36px;padding-left: 171px;">{{$data->fonts_main[1]['font_face']}}</div>
    @endif
    @foreach($data->fonts_main as $fm)
        @if(isset($fm['index']))
            <div style="display: flex; flex-wrap: nowrap; margin-bottom: 20px; align-items: center;">
                <div
                    style="border-right: 1px solid #000000;font-family: 'main{{$fm['index']}}';padding: 12px; margin-right: 40px;width: 131px; box-sizing: border-box;height: auto;text-align: center;">
                    {{-- <div style="font-size: 10px;font-family: 'main{{$fm['index']}}';">{{$data->fonts_main[1]['font_face']}} @if(isset($fm['weight'])){{$fm['weight']}}@endif</div> --}}
                    <div style="font-size: 34px;font-family: 'main{{$fm['index']}}'; margin-top: 0;">Aa</div>
                    <div style="font-size: 12px;font-family: 'main{{$fm['index']}}';">{{$data->brand}}</div>
                </div>
                <div class="fonts2-weight font-{{$fm['index']}}">
                    @if(isset($fm['weight']))<em style="color: #000">{{$fm['weight']}}</em>@endif
                    <p>{{trans('themes.alphabet_big')}}</p>
                    <p>{{trans('themes.alphabet_sm')}}</p>
                    <p>{{trans('themes.numbers')}}</p>
                </div>
            </div>
        @endif
    @endforeach
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb30"></div>
<div id="page31">
    @php
        $page_number++;
    @endphp
    <div class="page-number right">{{$page_number}}</div>
    @if(isset($data->fonts_secondary) && isset($data->fonts_secondary[1]))
        <div class="fonts2-title" style="padding-left: 171px;">{{trans('themes.secondary_font')}}</div>
    @endif
    @if(isset($data->fonts_secondary) && isset($data->fonts_secondary[1]))
        <div class="fonts2-fontname" style="padding-left: 171px;">{{$data->fonts_secondary[1]['font_face']}}</div>
    @endif
    @foreach($data->fonts_secondary as $fs)
        @if(isset($fs['index']))
            <div style="display: flex; flex-wrap: nowrap; margin-bottom: 20px; align-items: center;">
                <div
                    style="border-right: 1px solid #000000;font-family: 'second{{$fs['index']}}';padding: 12px; margin-right: 40px;width: 131px; box-sizing: border-box;height: auti;text-align: center;">
                    {{-- <div style="font-size: 10px;font-family: 'second{{$fs['index']}}';">{{$data->fonts_main[1]['font_face']}} @if(isset($fs['weight'])){{$fs['weight']}}@endif</div> --}}
                    <div style="font-size: 34px;font-family: 'second{{$fs['index']}}'; margin-top: 0;">Aa</div>
                    <div style="font-size: 12px;font-family: 'second{{$fs['index']}}';">{{$data->brand}}</div>
                </div>
                <div class="fonts2-weight font-{{$fs['index']}}">
                    <em style="color: #000">{{$fs['weight']}}</em>
                    <p>{{trans('themes.alphabet_big')}}</p>
                    <p>{{trans('themes.alphabet_sm')}}</p>
                    <p>{{trans('themes.numbers')}}</p>
                </div>
            </div>
        @endif
    @endforeach
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb31"></div>
@if(isset($data->mockups[3]))
    @if(!empty($data->mockups[3]->title))
        <div id="page-mockup-4-0">
            @php
                $page_number++;
            @endphp
            <div class="page-number">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-photo mockup-photo-left-full-right-half"
                     style="background-image: url({{$data->mockups[3]->image}})"></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div id="page-mockup-4-1">
            @php
                $page_number++;
            @endphp
            <div class="page-number right">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-photo mockup-photo-right-half"
                     style="background-image: url({{$data->mockups[3]->image}})"></div>
                <div class="mockup-title right">
                    {{$data->mockups[3]->title}}
                </div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @else
        <div id="page-mockup-4-0">
            @php
                $page_number++;
            @endphp
            <div class="page-number">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-photo mockup-photo-left-full"
                     style="background-image: url({{$data->mockups[3]->image}})"></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div id="page-mockup-4-1">
            @php
                $page_number++;
            @endphp
            <div class="page-number right">{{$page_number}}</div>
            <div class="mockup-wrapper">
                <div class="mockup-photo mockup-photo-right-full"
                     style="background-image: url({{$data->mockups[3]->image}})"></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endif
@endif
<div id="page32">
    @php
        $page_number++;
    @endphp
    <div class="page-number " id="Brandbook designer">{{$page_number}}</div>
    {{-- <div class="svg-block" style="position: absolute;left: 427px;top: 0;"><svg width="696" height="356" viewBox="0 0 696 356" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="223.001" y="317.461" width="314.988" height="314.988" transform="rotate(-135 223.001 317.461)" fill="@if(isset($data->colors_list[1]) && isset($data->colors_list[1]->id)){{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($data->colors_list[1]->id, -40)}}@endif"/><rect width="211.072" height="211.072" transform="matrix(-0.70829 -0.705921 0.70829 -0.705922 546 356)" fill="@if(isset($data->colors_list[1]) && isset($data->colors_list[1]->id)){{$data->colors_list[1]->id}}@endif"/></svg></div> --}}
    <div class="user-info">
        <div class="image">
            <img src="{{$data->user->avatar}}" alt="">
        </div>
        <div class="name" style="color: #000">{{$data->user->name}}</div>
        <div class="position" style="color: #000">{{$data->user->position}}</div>
    </div>
    <h1 class="title " style="white-space: nowrap;">{{trans('themes.brand_book_designer')}}</h1>
    <div class="text ">
        {{$data->user->description}}
    </div>

    <div class="company">
        <div class="company-logo">
            <img src="{{$data->user->company_logo_full}}" alt="" style="max-width: 150px;">
        </div>
        <div class="web">
            <p style="color: #000">{{$data->user->company_web}}</p>
            @if(!empty($data->user->company_dribble))
                <p style="color: #000"><i class="fa fa-dribbble"
                                          style="margin-right: 5px; display: inline-block;"></i>{{$data->user->company_dribble}}
                </p>
            @endif
            @if(!empty($data->user->company_behance))
                <p style="color: #000"><i class="fa fa-behance"
                                          style="margin-right: 5px; display: inline-block;"></i>{{$data->user->company_behance}}
                </p>
            @endif
        </div>
        <div class="contact">
            <p style="color: #000">{{trans('themes.contact')}}</p>
            @if(!empty($data->user->company_phone))
                <p style="color: #000"><i class="fa fa-mobile"
                                          style="margin-right: 5px; display: inline-block;"></i>{{$data->user->company_phone}}
                </p>
            @endif
            @if(!empty($data->user->email))
                <p style="color: #000"><i class="fa fa-envelope"
                                          style="margin-right: 5px; display: inline-block;"></i>{{$data->user->email}}
                </p>
            @endif
        </div>
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb32"></div>
<div id="page33">
    @php
        $page_number++;
    @endphp
    <div class="page-number right">{{$page_number}}</div>
    {{-- <div class="svg-block" style="position: absolute;left: -333px;top: 0;"><svg width="696" height="356" viewBox="0 0 696 356" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="223.001" y="317.461" width="314.988" height="314.988" transform="rotate(-135 223.001 317.461)" fill="@if(isset($data->colors_list[1]) && isset($data->colors_list[1]->id)){{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($data->colors_list[1]->id, -40)}}@endif"/><rect width="211.072" height="211.072" transform="matrix(-0.70829 -0.705921 0.70829 -0.705922 546 356)" fill="@if(isset($data->colors_list[1]) && isset($data->colors_list[1]->id)){{$data->colors_list[1]->id}}@endif"/></svg></div> --}}
    {{-- <div class="gradient"></div> --}}
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb33"></div>
<div id="page34">
    @php
        $page_number++;
    @endphp
    <div class="page-number">{{$page_number}}</div>
    <div class="text-center">
        <p>{{trans('themes.designed_by')}}</p>
        @if(isset($data->user->company_logo_full) && !empty($data->user->company_logo_full) && $data->user->company_logo_full!==null)
            <div class="company-logo">
                <img src="{{$data->user->company_logo_full}}" alt="">
            </div>
        @else
            <div style="font-weight: bold; text-align: center;">{{$data->user->name}}</div>
        @endif
        <div class="logo-gingersauce">
            <svg width="14" height="14" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"/>
            </svg>
            {{trans('themes.powered_by') }} gingersauce
        </div>
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb34"></div>
<div id="page35" style="">
    @php
        $page_number++;
    @endphp
    <div class="page-number right">{{$page_number}}</div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
<div class="page-break pb35"></div>
<div id="page36">
    {{-- <div class="gradient"></div> --}}
    <div class="company-logo"
         style="width: 100%;height: 760px;display: flex;align-items: center;justify-content: center;">
        <img src="{{$white_bg_logo}}" alt="" style="width: 380px;height: auto;">
    </div>
    <div class="small-title" style="color: #000;">
        {{$data->brand}} {{trans('themes.brand_book')}}
    </div>
    <div class="logo-gingersauce" style="color: #000; display: none;">
        <svg width="14" height="14" viewBox="0 0 6 6" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"
                fill="#000"/>
        </svg>
        {{trans('themes.powered_by')}} gingersauce
    </div>
    @if($data->watermark)
        <img class="watermark-draft" src="{{$watermark}}">
    @endif
</div>
</div>
</body>
</html>
