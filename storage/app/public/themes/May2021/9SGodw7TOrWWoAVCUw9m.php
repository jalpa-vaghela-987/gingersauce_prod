@php

    $approved_primary_color = false;
    $approved_secondary_color = false;
    $main_color = !empty($data->colors_list[0]->id) ? $data->colors_list[0]->id : '#fff';
    $secondary_color = !empty($data->colors_list[1]->id) ? $data->colors_list[1]->id : '#fff';
    $tertiary_color = !empty($data->colors_list[2]->id) ? $data->colors_list[2]->id : '#fff';
    $color_class = 'light';

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

            if($data->logo_w==0)
            $data->logo_w = 200;
            if($data->logo_h==0)
            $data->logo_h = 100;

            $ratio = floatval($data->logo_w / ($data->logo_h==0?1:$data->logo_h));


@endphp
<html>
<head>

    @if(!empty($data->custom['body_family']))
        <link href="https://fonts.googleapis.com/css?family={{$data->custom['body_family']}}&display=swap"
              rel="stylesheet">
    @endif

    @if(!empty($data->custom['title_family']))
        <link href="https://fonts.googleapis.com/css?family={{$data->custom['title_family']}}&display=swap"
              rel="stylesheet">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <style>

        @font-face {
            font-family: 'Sentinel Bold';
            src: url('{{ url('fonts/Sentinel/Sentinel-Bold.eot') }}');
            src: url(' {{ url('fonts/Sentinel/Sentinel-Bold.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */ url(' {{ url('fonts/Sentinel/Sentinel-Bold.woff') }}') format('woff'), /* Pretty Modern Browsers */ url(' {{ url('fonts/Sentinel/Sentinel-Bold.ttf') }}') format('truetype'), /* Safari, Android, iOS */ url(' {{ url('fonts/Sentinel/Sentinel-Bold.svg#svgFontName') }}') format('svg'); /* Legacy iOS */
        }

        html, body {
            margin: 0;
            padding: 0;
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
            font-family: 'Sentinel Bold';
            margin: 0;
            padding: 0;
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Sentinel Bold';
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
            position: relative;
        }

        #page12 > svg {
            fill: #35a358;
            position: absolute;
            left: 23%;
            top: 35%;
        }

        .bottom-right {
            position: absolute !important;
            top: 78%;
            right: 50px;
        }

        #page12 > svg > svg {
            opacity: 40%;
        }

        #page12 > svg line, #page12 > svg rect {
            stroke: white;
        }

        #page13 .text.bottom-left {
            position: absolute;
            color: black;
            top: 80%;
            max-width: 363px;
            text-align: left;
        }

        .logo-var-page-wrapper .logo-var-background {
            height: 50%;
            width: 50%;
            display: block;
            float: left;
            padding: 20px;
            text-align: center;
        }

        .logo-var-page-wrapper {
            margin-top: 40px;
            height: 720px;
        }

        .logo-var-page-wrapper .logo-variation {
            height: 60%;
            width: 50%;
            max-height: 65%;
            margin: auto;
            margin-top: 20%;
        }

        #page13 .text.bottom-left p {
            text-align: left;
            padding-left: 20px;
        }


        .page-heading-line {
            position: absolute;
            height: 1px;
            background: white;
            padding-left: 0px;
            top: 40px;
            width: 760px;
        }

        .page-heading-with-title {
            height: 1px;
            background: white;
            position: absolute;
            width: 100%;
            left: 0;
            top: 40px;
        }

        .page-heading-title {
            position: absolute;
            right: 0;
            font-size: 16px;
            padding-left: 15px;
            padding-right: 10px;
            border-bottom-left-radius: 25px;
            bottom: -40px;
            font-family: 'Sentinel Bold';
            font-weight: bold;
            padding-bottom: 20px;

        }

        #page3 .page-heading-title {
            padding-right: 90px;
        }

        .page-heading-title .page-num {
            margin-left: 15px;
        }

        .page-num {
            font-size: 70px;
            top: 19px;
            position: relative;
            font-family: 'Sentinel Bold';
            font-weight: bold;
        }


        .opacity-background {
            width: 100%;
            height: 100%;
            position: absolute;
            background: white;
            opacity: 0.4;
            top: 0;
            left: 0;
            padding: 1px;
        }

        .opacity-background.dark {
            background: black;
        }


        .page-item {
            padding: 50px 50px 0px 40px;
        }

        .page-wrapper {
            /* padding: 50px 50px 30px 40px; */
            height: 100%;
            width: 100%;
            border-left: 1px solid;
            border-top: 1px solid;
            position: relative;
            padding-top: 30px;
        }

        .light .page-wrapper {
            border-color: white;
        }

        .light. .logo-row {
            border-color: white;
        }

        .light {
            color: white;
        }

        .page-title {
            position: absolute;
            background: {{ $main_color }};
            top: -22px;
            right: 0;
            padding-left: 10px;
        }

        .main-color-background {
            background: {{ $main_color }};
        }

        .secondary-color-background {
            background: {{ $secondary_color }};
        }

        .tertiary-color-background {
            background: {{ $tertiary_color }};
        }

        .tertiary-color {
            color: {{$tertiary_color}}
        }

        .favicons.size-2 .image {
            max-height: 70%;
        }

        .secondary-color {
            color: {{$secondary_color}}
        }

        .white-background {
            background: white;
        }

        .black-background {
            background: black;
        }

        .grey-background {
            background: #DDDDDD;
        }

        go-var-page-wrapper {
            padding-top: 40px;
        }

        /**
        LOGO page
         */


        .logo-row {
            border-bottom: 1px solid;
            position: relative;
            background-size: contain;
            background-repeat: no-repeat;
        }

        .logo-text {
            position: absolute;
            bottom: 10px;
            right: 0;
        }

        .page-heading-black {
            color: black;
        }

        .page-num-main-color {
            color: {{$main_color}}











        }

        .page-heading-main-color {
            background: {{$main_color}};
        }

        .main-color, .color-primary {
            color: {{$main_color}};
        }


        .page-heading-main-color .page-heading-title {
            background: white;
        }

        .logo-wrapper-in-content {
            height: 680px;
            top: 80px;
            position: relative;
            left: 40px;
            border-bottom: 1px solid #999999;
        }

        .color-black {
            color: black;
        }

        .introduction-wrapper {
            border-top: 1px solid #999999;
            border-bottom: 1px solid #999999;
            height: 680px;
            top: 80px;
            position: relative;
            padding-top: 100px;
            padding-left: 40px;
            padding-right: 100px;
        }

        .logo-wrapper-in-content svg {
            opacity: 1;
        }

        .logo-wrapper-in-content .logo-row {
            border-top: 1px solid #999999;
        }

        img.logo-grid {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        img.embed-logo {
            width: 100%;
            padding: 10px;
            opacity: 0.4;
            max-height: 100%;
            @if($ratio < 1)
                   height: 100%;
            min-height: 290px;
        @endif





        }

        .page-heading-left span.page-num {
            position: absolute;
            top: -40px;
            padding-left: 20px;
            padding-right: 20px;
            border-bottom-right-radius: 25px;
        }

        .icon-background {
            position: absolute;
            overflow: hidden;
            width: 1500px;
            height: 1500px;
            left: -100px;
            top: -100px;
            background-size: 100%;
            background-repeat: no-repeat;
        }

        .icon-background-right {
            left: -860px;
        }

        .icon-wrapper svg {
            height: 87%;
            width: auto;
            margin: auto;
            left: 6%;
            position: relative;
            top: 6%;
            opacity: 40%;
        }


        .icon-background svg {
            height: auto;
            width: 1400px;
            opacity: 10%;
            fill: black;
        }

        h1.title.center-title {
            position: absolute;
            top: 50%;
            right: 10%;
        }

        .color-reversed {
            color: white;
        }


        .logo-size-1 {
            height: 10%;
        }

        .logo-size-2 {
            height: 15%;
        }

        .logo-size-3 {
            height: 20%;
        }

        .logo-size-4 {
            height: 25%;
        }

        .logo-size-5 {
            height: 30%;
        }

        .svg-embed-block {
            position: absolute;
            width: 40%;
            max-height: 40%;
            top: 30%;
            left: 200px;
        }

        .icon-wrapper {
            height: 40%;
            width: 40%;
            position: absolute;
            left: 27%;
            top: 20%;
        }

        .bottom-left {
            position: absolute;
            bottom: 40px;
            width: 550px;
            left: 40px;
        }

        .background-transparent {
            background: #fff;
            opacity: 0.2;
        }

        .logo-wrapper {
            width: 100%;
            text-align: center;
            margin-top: 40px;
            height: 360px;
        }

        .logo-wrapper svg {
            height: 45%;
            width: auto;
            margin-top: 98px;
        }

        .icon-brand-name {
            color: black;
            margin-top: 20px;
            font-weight: normal;
        }

        .logo-variations-block {
            height: 380px;
        }

        .icon-preview {
            width: 33%;
            height: 50%;
            float: left;
            text-align: center;
        }

        .icon-preview .icon {
            height: 100px;
            width: 100px;
            margin: auto;
        }

        .icon-preview svg {
            height: 60%;
            width: 60%;
            margin-top: 20%;
        }

        .icon-text.color-black {
            padding: 10px;
        }

        .logo-image-prop {
            position: absolute;
            top: 50%;
            left: 50%;
            border: 1px solid;
        }

        .logo-image-prop svg {
            height: 100%;
            width: 100%;
        }

        .description.logo-description div, .description.icon-description div {
            width: 490px;
            padding-left: 120px;
            padding-right: 20px;
        }

        .logo-1:after, .icon-1:after {
            content: "";
            height: 1px;
            width: 100%;
            position: absolute;
            background: #000;
            left: 0;
            bottom: 10px;
        }

        .lgo.logo-1 svg.logosp_arr_2, .icn.icon-1 .logosp_arr_2 {
            position: absolute;
            right: -2px;
            bottom: 6px;
        }

        .lgo.logo-1 svg.logosp_arr_2 path, .icn.icon-1 .logosp_arr_2 path, .lgo.logo-1 .logosp_arr_1 path, .icn.icon-1 .logosp_arr_1 path {
            fill: black;
        }

        .lgo.logo-1 .logosp_arr_1, .icn.icon-1 .logosp_arr_1 {
            position: absolute;
            left: -2px;
            bottom: 6px;
            transform: rotate(-180deg);
        }

        .icn.icon-1 {
            border-left: 1px dashed black;
            border-right: 1px dashed black;
        }

        .icon-1 {
            padding-bottom: 20px;
        }

        .icn, .lgo {
            float: left;
            position: relative;
            margin-right: 60px;
        }

        .icon-long-wrapper, .logo-long-wrapper {
            width: 200%;
            position: absolute;
            display: flex;
            align-items: center;
            height: 400px;
        }

        .icon-long-wrapper {
            top: 300px;
        }


        .lgo.logo-1 {
            padding-top: 26px;
        }

        .logo-long-wrapper {
            height: 300px;
            top: 50px;
        }

        .logo-long-wrapper.single {
            top: 25%;
        }

        .clear {
            clear: both;
        }

        #page23 .logo-long-wrapper, #page23 .icon-long-wrapper {
            left: -100%;
            margin-top: 10px;
        }

        #page24 .title {
            text-align: right;
            padding-right: 40px;
            padding-top: 40px;
        }

        .misuses-wrapper {
            height: 610px;
            position: absolute;
            top: 185px;
        }

        .misuses-wrapper .rejected_item {
            height: 50%;
            width: 50%;
            float: left;
            position: relative;
            border: 1px solid black;
            border: 1px solid black;
            margin-right: -1px;
            margin-top: -1px;
        }

        .rejected_item .logo-image {
            width: 50% !important;
            height: 65% !important;
            margin: auto;
            margin-top: 5%;
        }

        .tertiary-color-box {
            width: 166px;
            height: 166px;
            position: absolute;
            right: 0;
            bottom: 200px;
            text-align: center;
        }

        .adjust-color-line {
            height: 1px;
            background: white;
            position: absolute;
            top: 0px;
            width: 560px;
            right: 0;
        }


        .secondary-color-box {
            width: 200px;
            height: 200px;
            position: absolute;
            bottom: 0;
            text-align: center;
        }

        .main-color-box {
            width: 560px;
            height: 560px;
            top: 0;
            position: absolute;
            right: 0;
            text-align: center;
        }

        .main-color-box p.color-name {
            margin-top: 30%;
            font-size: 32px;
        }

        .main-color-box p.color-hex {
            font-size: 38px;
        }


        p.color-hex {
            margin-top: 5px;
            font-size: 24px;
            text-transform: uppercase;
            font-style: italic;
        }

        p.color-name {
            padding-top: 40px;
            font-size: 20px;
            margin-bottom: 0;
        }

        .rejected_item:last-child {
            border-top: 0;
        }

        .misuses-text {
            text-align: center;
            margin-top: 5%;
        }

        .favicons.size-1 .favicon {
            width: 33%;
            height: 240px;
        }

        .favicons.size-2 .favicon {
            width: 50%;
            height: 240px;
        }

        .favicons.size-3 .favicon {
            width: 100%;
            height: 480px;
        }

        .favicons .image {
            width: 100%;
            height: 90%;
        }

        .favicon {
            float: left;
            text-align: center;
        }

        .favicon .image {
            margin: auto;
        }

        .favicons {
            margin-top: 80px;
        }

        .color-size-2 .detail-color-box {
            width: 50%;
            height: 50%;
            float: left;
        }

        .color-size-2 .left-block {
            width: 60%;
            height: 100%;
            float: left;
            padding-left: 40px;
        }

        .color-size-2 .right-block {
            width: 40%;
            height: 100%;
            float: left;
            padding-top: 30%;
        }

        .right-block div {
            height: 50px;
            text-transform: uppercase;
        }

        .color-size-2 .text-color-type {
            margin-top: 50%;
        }

        .color-size-2 .color-description {
            margin-top: 100px;
        }

        .detail-color-box .name {
            width: 40%;
            float: left;
        }

        .color-description {
            font-size: 16px;
        }

        .favicons.size-3 .image {
            width: 50%;
            max-height: 50%;
            margin-top: 25%;
        }

        .color-size-1 .detail-color-box {
            width: 50%;
            height: 100%;
            float: left;
        }

        .color-size-1 .left-block {
            width: 60%;
            height: 50%;
            padding-top: 30%;
            padding-left: 40px;
        }

        .color-size-1 .color-description {
            padding-top: 470px;
        }

        .right-block {
            width: 60%;
            padding-left: 40px;
            padding-right: 10px;
        }

        .huge-text {
            font-size: 550px;
            margin-top: -106px;
        }

        .font-family-names {
            border-bottom: 1px solid{{$main_color}};
            line-height: 1;
            width: 630px;
        }

        .font-family-names.font-size-1 {
            font-size: 32px;
            margin-top: -90px;
        }

        .font-family-names.font-size-2 {
            font-size: 38px;
        }

        .font-family-names.font-size-3 {
            font-size: 48px;
        }

        .font-family-names.font-size-4 {
            font-size: 60px;
        }

        .font-family-names.font-size-5 {
            font-size: 72px;
        }

        .font-family-names.font-size-6 {
            font-size: 90px;
        }

        .font-family-names.font-size-7 {
            font-size: 100px;
        }

        .heading-font {
            margin-top: 80px;
            padding-left: 40px;
        }

        .fonts-title {
            font-size: 24px;
        }

        .font-name {
            font-size: 60px;
            font-weight: 900;
        }

        .font-preview {
            border-top: 1px solid{{$secondary_color}};
            padding-top: 30px;
            width: 680px;
            padding-bottom: 20px
        }

        .font-titlw-left {
            width: 300px;
            float: left;
            padding-left: 40px;
            font-size: 32px;
        }

        .block-1 {
            font-size: 48px;
        }

        .block-2 {
            font-size: 32px;
        }

        .block-3 {
            font-size: 16px;
        }

        .block-4 {
            font-size: 20px;
        }

        .font-title-right {
            width: 600px;
            margin-left: 436px;
        }

        .logo-background {
            position: absolute;
            top: 0;
            left: 70%;
            width: 5000px;
        }

        .last-page-wrapper {
            border-bottom: 1px solid black;
            height: 680px;
            width: 650px;
            margin-left: 40px;
            border-left: 1px solid black;
        }

        .last-page-logo-wrapper {
            height: 200px;
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            position: relative;
            top: 40px;
        }

        .last-page-logo-wrapper svg {
            height: 100%;
            width: auto;
            opacity: 40%;
        }

        .last-page-brand {
            position: absolute;
            right: 40px;
            font-size: 32px;
            font-weight: bold;
            bottom: 46px;
            padding: 20px;
            line-height: 46px;
        }

        .last-page-logo-gingersauce {
            position: absolute;
            bottom: 40px;
            right: 60px;
            font-size: 12px;
        }

        #page1 .logo, #page4 .logo {
            background-image: url({{$white_bg_logo}});
            background-size: contain;
            background-position: left;
            background-repeat: no-repeat;
            height: 100%;
            width: 200%;
        }

        @if(!empty($data->all_logo_variations['0_White Negative on Primary']['logo_b64']))
            #page1 .logo {
            background-image: url({{$data->all_logo_variations['0_White Negative on Primary']['logo_b64']}});
        }

        @endif

        #page1 .logo {
            opacity: 0.4;
        }

        .logo-cell img {
            opacity: 0.2;
        }

        .logo-cell {
            float: left;
        }

        #page7 .text {
            padding: 0 65px;
            position: absolute;
            top: 50%;
        }


        #page8 .text {
            position: absolute;
            padding-right: 50px;
        }

        span.logo-name {
            width: 100%;
            left: 0;
            display: block;
            margin-top: 42px;
        }

        .proportions_text_ratio {
            position: absolute;
            text-align: center;
            width: 100%;
        }

        .proportions_text_text {
            position: absolute;
            top: 60px;
            width: 100%;
        }


        /**
        end LOGO
         */

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
            text-align: center;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 34px;
            font-size: 12px;
            line-height: 18px;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #page2 svg {
            width: 800px;
            height: 800px;
            position: relative;
            left: -200px;
            bottom: -200px;
        }

        #page3, #page9 {
            padding: 170px 90px 0;
            position: relative;
            height: 221mm;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        #page10 > .title {
            padding-left: 100px;
            padding-top: 30px;
        }

        #page11 > .text {
            padding-top: 150px;
            padding-left: 100px;
        }

        #page10 > .text {
            padding-left: 100px;
        }

        .page-padding-wrapper {
            padding: 90px;
        }


        #page16-1, #page17-1 {
            padding: 90px;
        }

        #page10 {
            padding-top: 30px;
        }


        #page29 {
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
            text-decoration: none;
        }

        #page3 .contents .content-item .dots {
            flex-basis: 221mm;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            border-bottom: 2px dotted white;
            margin-top: -5px;
            margin-left: 5px;
            margin-right: 5px;
        }

        h1.title, .title-font {
            @if(!empty($data->custom['title_family']))
                          font-family: {{ $data->custom['title_family'] }},{{ $data->custom['title_category'] }};
            font-style: {{ $data->custom['title_weight'] }};
            @else
                          font-family: 'Sentinel Bold';
        @endif











        }

        h1.title {
            font-size: 52px;
            line-height: 46px;
            margin-bottom: 27px;
            position: relative;
        }

        .page-title, .logo-text {
            @if(!empty($data->custom['title_family']))
                          font-family: {{ $data->custom['title_family'] }},{{ $data->custom['title_category'] }};
            font-style: {{ $data->custom['title_weight'] }};
            @else
                          font-family: 'Sentinel Bold';
            font-size: 32px;
            font-weight: 900;
            @endif
                    letter-spacing: 0em;
            line-height: 1;
        }

        .logo-text {
            font-size: 12px;
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
        #page6, #page18 {
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

        #page11 .core-values, #page10 .core-values {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            height: 308px;
            bottom: 90px;
            position: absolute;
            padding-left: 75px;
        }

        #page11 .core-values .core-value, #page10 .core-values .core-value {
            display: flex;
            flex-wrap: nowrap;
            height: 64px;
            margin-bottom: 40px;
            flex-basis: 100%;
            align-items: center;
        }

        #page11 .core-values .core-value .img, #page10 .core-values .core-value .img {
            display: block;
            margin-right: 18px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            height: 70px;
            width: 70px;
            max-width: 70px;
        }

        #page11 .core-values .core-value .title, #page10 .core-values .core-value .title {
            font-weight: 300;
            font-size: 24px;
            line-height: 24px;
            margin-right: 40px;
        }

        #page11 .core-values .core-value div, #page10 .core-values .core-value div {
            font-weight: normal;
            font-size: 12px;
            line-height: 20px;
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

        #page13 .text-block {
            width: 100%;
            text-align: center;
            position: absolute;
            left: 0;
            bottom: -40px;
        }

        #page14 .logo-versions {
            margin-top: 100px;
        }

        .logo-versions .logo-version {
            width: 50%;
            float: left;
        }

        .logo-versions .logo-version .logo-img {
            height: 100%;
            width: 70%;
            background-size: contain;
            background-repeat: no-repeat;
            display: inline-block;
            background-position: top center;
            height: 100px;
            margin-bottom: 20px;
        }

        .logo-versions .logo-version .logo-title {
            text-align: center;
            font-size: 12px;
            line-height: 25px;
            width: 70%;
            padding-top: 40px;
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


        #page21 {
            padding-top: 90px;
        }

        #page19 .logo, #page19 .icon {
            border: 1px solid #DADADA;
        }

        #page20 .logo, #page21 .icon {
            border: 1px solid{{$main_color}};
        }

        #page21 .logogsspace {
            border-color: {{$main_color}};
        }

        #page19 .logo, #page20 .logo {
            width: 300px;
            height: 200px;
            position: absolute;
            left: 30%;
            top: 120px;
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
        }

        #page20 .logo {
            width: {{$data->logo_w}}px;
            height: {{$data->logo_h}}px;
            left: 50%;
            margin-left: -{{$data->logo_w/2}}px;
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
        }

        #page19 .icon, #page21 .icon, #page20 .icon {
            width: 70px;
            height: 70px;
            position: absolute;
            left: 50%;
            margin-left: -35px;
            top: 35%;
        }

        #page18 .logo {
            position: absolute;
            top: 35%;
            left: 50%;
        }

        #page24 .logo-image, #page25 .logo-image, #page19 .icon .icon-image, #page21 .icon .logo-image, #page20 .icon .logo-image, #page20 .logo .logo-image, #page23 .logo .logo-image, #page23 .icon .logo-imag {
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
        }

        #page25 .rejected_item .line, #page24 .rejected_item .line {
            border: 1px solid #FF0000;
            position: absolute;
            z-index: 3;
            left: 50%;
            top: 35%;
            width: 172px;
            margin-left: -86px;
            -webkit-transform: rotate(144.65deg);
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

        #page20 .logo-pre {
            position: absolute;
            left: -30px;
            right: -30px;
            top: -30px;
            border-top: 1px solid #dadada;
        }

        #page20 .logo-post {
            position: absolute;
            left: -30px;
            bottom: -30px;
            right: -30px;
            border-bottom: 1px solid #dadada;
        }

        #page20 .logo-pre .left, #page20 .logo-post .left {
            float: left;
            filter: grayscale(1);
        }

        #page20 .logo-post .left {
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

        #page20 {
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

        #page21 .icon-post .right, #page21 .icon-pre .right, #page20 .icon-post .right, #page20 .icon-pre .right {
            height: 30px;
            width: 30px;
            border: 1px solid #dadada;
            color: #dadada;
            font-size: 14px;
            text-align: center;
            line-height: 30px;
            float: right;
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


        #page25 .text {
            padding-top: 40px;
            margin-top: 40px;
            padding-left: 40px;
            padding-right: 60px;
            font-size: 16px;
        }


        @foreach($data->fonts_main as $font_m)
            @font-face {
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
            @if(isset($font_m['index']))
                          font-family: "second{{$font_m['index']}}";
            @else
                           font-family: "second1";
            @endif
                           src: url("{{$font_m['font']}}");
        }

        @endforeach

        .fonts2-title {
            font-style: normal;
            font-weight: normal;
            font-size: 12px;
            line-height: 14px;
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

        .contact-info-wrapper {
            padding-left: 110px;
            padding-top: 80px;
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
            width: 300px;
        }

        #page32 .company {
            margin-top: 20px;
        }

        #page32 .company .company-logo {
            margin-right: 50px;
            margin-top: 50px;
        }

        #page32 .company p {
            margin-bottom: 0;
            margin-top: 0;
            font-size: 11px;
            color: #fff;
        }

        #page32 .company .web {
            margin-right: 50px;
        }

        #page34 {
            padding-top: 300px;
        }

        .powered-by {
            width: 70%;
        }

        #page34 .text-center {
            text-align: center;
        }

        #page34 p {
            font-size: 14px;
            line-height: 14px;
            color: #000000;
        }

        #page34 .logo-gingersauce {
            font-size: 14px;
            color: #797979;
            margin-top: 20px;
            position: absolute;
            bottom: 60px;
            left: 25%;
        }

        #page34 .company-logo {
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


        #page14 .logo-versions {
            margin-top: 100px;
            display: flex;
        }

        .logo-versions .logo-version {
            flex-basis: 50%;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-versions .logo-version .logo-img {
            width: 100%;
            background-size: contain;
            background-repeat: no-repeat;
            display: inline-block;
            background-position: center;
            height: 100px;
        }

        .logo-versions .logo-version .logo-title {
            text-align: center;
            font-size: 12px;
            line-height: 25px;
            width: 100%;
            padding-top: 40px;
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

        #page15 {
            overflow: hidden;
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

        #page17 .favicons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            height: 570px;
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
        }

        #page17 .favicon .logo-img {
            padding: 15px;
            display: block;
            margin: 0 auto;
        }

        #page17, #page27-1 {
            position: relative;
        }

        #page17 .favicon .logo-img .image {
            width: 40px;
            height: 40px;
        }

        #page16 .favicon .logo-title, #page17 .favicon .logo-title, #page27-1 .favicon .logo-title {
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
    </style>
    <meta charset="utf-8">
</head>
<body>
<div class="template4 {{$color_class}}">
    <div id="page1" class="page-item main-color-background"
         @if($data->custom_logo)
         style="background-image: url({{public_path( config('app.images_path') . $data->user_id . '/' . $data->id . '/' . $data->custom_logo)}});
             background-repeat: no-repeat;
             background-size: cover;"
        @endif
    >
        @if(empty($data->custom_logo))

            <div class="page-wrapper">
                <div class="page-title title-font">
                    {{$data->brand}} {{trans('themes.brand_book')}}
                </div>
                <div class="logo-row logo-size-1">
                    <div class="logo"></div>
                    <div class="logo-text title-font">{{trans('themes.brand_strategy_and_values')}}</div>
                </div>
                <div class="logo-row logo-size-2">
                    <div class="logo"></div>
                    <div class="logo-text title-font">{{trans('themes.logo_specifications')}}</div>
                </div>
                <div class="logo-row logo-size-3">
                    <div class="logo"></div>
                    <div class="logo-text title-font">{{trans('themes.color_palette')}}</div>
                </div>
                <div class="logo-row logo-size-4">
                    <div class="logo"></div>
                    <div class="logo-text title-font">{{trans('themes.font_family_and_weight')}}</div>
                </div>
                <div class="logo-row logo-size-5">
                    <div class="logo"></div>
                    <div class="logo-text title-font"></div>
                </div>
            </div>
        @endif
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
    </div>
    <div class="page-break pb1"></div>
    <div id="page2" class="main-color-background">
        <div class="page-heading-line"></div>
        @if(isset($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
            @if(!empty($data->all_icon_variations)) {!! $data->all_icon_variations['White Negative on Secondary in Square']['icon'] !!} @else {!!$data->icon!!} @endif
        @endif
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb2"></div>
    <div id="page3" class="main-color-background">
        <div class="page-heading-with-title">
            <div class="page-heading-title main-color-background">{{$data->brand}} {{trans('themes.brand_book')}} <span
                    class="page-num">03</span></div>
        </div>
        <h1 class="title">{{trans('themes.contents')}}</h1>
        <div class="contents">
            <div class="content-item">
                <div><a -href="#Introduction">{{ trans('themes.introduction')}}</a></div>
                <div class="dots"></div>
                <div class="page">05</div>
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
                    <div class="page">{{$page_number_sm < 10 ? 0 . $page_number_sm : $page_number_sm }}</div>
                </div>
            @endif
            @if(isset($data->mission) || isset($data->mission_text))
                @php
                    $page_number_sm += 1;
                @endphp
                <div class="content-item">
                    <div><a -href="#Mission">{{trans('themes.mission')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm < 10 ? 0 . $page_number_sm : $page_number_sm}}</div>
                </div>
            @endif
            @if(count($data->core_values)>0)
                @php
                    $page_number_sm += 2;
                @endphp
                <div class="content-item">
                    <div><a -href="#Core Values">{{trans('themes.core_values')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm < 10 ? 0 . $page_number_sm : $page_number_sm}}</div>
                </div>
            @endif
            @php
                $page_number_sm += 2;
            @endphp
            <div class="content-item">
                <div><a -href="#Our Logo">{{trans('themes.our_logo')}}</a></div>
                <div class="dots"></div>
                <div class="page">{{$page_number_sm < 10 ? 0 . $page_number_sm : $page_number_sm }}</div>
            </div>
            @if(count($data->approved))
                @php
                    $page_number_sm += 2;
                @endphp
                <div class="content-item">
                    <div><a -href="#Logo Versions">{{trans('themes.logo_versions')}}</a></div>
                    <div class="dots"></div>
                    <div class="page">{{$page_number_sm < 10 ? 0 . $page_number_sm : $page_number_sm }}</div>
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
                <div><a -href="#Clear Space">{{trans('themes.clear_space')}}</a></div>
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
    <div id="page4" class="white-background">
        <div class="page-heading-line page-heading-left tertiary-color-background"><span
                class="page-num tertiary-color white-background">04</span></div>
        <div class="logo-wrapper-in-content">
            <div class="logo-row logo-size-1">
                <div class="logo"></div>
            </div>
            <div class="logo-row logo-size-2">
                <div class="logo"></div>
            </div>
            <div class="logo-row logo-size-3">
                <div class="logo"></div>
            </div>
            <div class="logo-row logo-size-4">
                <div class="logo"></div>
            </div>
            <div class="logo-row logo-size-5">
                <div class="logo"></div>
            </div>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb4"></div>
    <div id="page5" class="white-background">
        <div class="page-heading-with-title tertiary-color-background">
            <div class="page-heading-title color-black white-background">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num tertiary-color">05</span></div>
        </div>
        <div class="introduction-wrapper">
            <h1 class="title main-color" contenteditable="true" data-title-field="introduction_title"
                style="position: relative;z-index: 2">{!! !empty($data->introduction_title) ? $data->introduction_title : trans('themes.introduction') !!}</h1>
            <div class="text color-black" id="edit-1" data-field="introduction_text"
                 style="position: relative;z-index: 2">
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
            <div id="page-mockup-1-0" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-1-1" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-1-0" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-1-1" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
        <div id="page6" class="secondary-color-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-line page-heading-left tertiary-color-background"><span
                    class="page-num tertiary-color secondary-color-background">{{$page_number}}</span></div>
            @if(isset($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
                <div class="icon-background"
                     style="opacity:0.4; background-image:
                     @if(!empty($data->all_icon_variations['White Negative on Primary in Square']['icon_b64']))
                         url({{$data->all_icon_variations['White Negative on Primary in Square']['icon_b64']}})
                     @endif
                         ">
                </div>
            @endif

            <h1 class="title tertiary-color center-title" contenteditable="true" @blur="title_changed()"
                data-title-field="vision_title">
                {!! !empty($data->vision_title) ? $data->vision_title : trans('themes.vision') !!}
            </h1>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb6"></div>
        <div id="page7" class="secondary-color-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp

            <div class="page-heading-with-title tertiary-color-background">
                <div class="page-heading-title color-reversed secondary-color-background">{{$data->brand}} Brand
                    Book
                    <span class="page-num tertiary-color">{{$page_number}}</span></div>
            </div>
            @if(isset($data->icon) && $data->icon!='skipped' && $data->icon!='[]' && !empty($data->all_icon_variations))

                <div class="icon-background icon-background-right"
                     style="opacity: 0.4; background-image: url({{$data->all_icon_variations['White Negative on Primary in Square']['icon_b64']}})">
                </div>
            @endif
            <div class="text" data-field="vision_text" data-length="{{strlen($data->vision)}}"
                 style="color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($secondary_color)}};
                     font-size: {{\App\BrandBookCreator\BrandBookHelper::getFontSize($data->vision,'vision', 'template4')}}px">

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
        <div id="page8" class="main-color-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div
                class="opacity-background {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($main_color, true)}}"></div>
            <div class="page-heading-line page-heading-left main-color-background"><span
                    class="page-num main-color main-color-background">
                        <div
                            class="opacity-background {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($main_color, true)}}"
                            style="border-bottom-right-radius: 25px;"></div>
                        <span style="position: relative">{{$page_number}}</span></span></div>
            <div class="page-padding-wrapper" style="padding-top: 300px;">
                <h1 class="title secondary-color" contenteditable="true" @blur="title_changed()"
                    data-title-field="mission_title">{!! !empty($data->mission_title) ? $data->mission_title : trans('themes.mission') !!}</h1>
                <div class="text main-color" data-field="mission_text"
                     style="font-size: {{\App\BrandBookCreator\BrandBookHelper::getFontSize($data->mission,'mission', 'template4')}}px">
                    @if(!empty($data->mission_text))
                        {!!$data->mission_text!!}
                    @else
                        <p>
                            {!!nl2br($data->mission)!!}
                        </p>
                    @endif
                </div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb8"></div>

        <div id="page9" class="main-color-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div
                class="opacity-background {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($main_color, true)}}"></div>
            <div class="page-heading-with-title main-color-background">
                <div class="page-heading-title main-color main-color-background">
                    <div
                        class="opacity-background {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($main_color, true)}}"
                        style="border-bottom-left-radius: 25px">
                    </div>
                    <span style="position: relative"> {{$data->brand}} {{trans('themes.brand_book')}} </span>
                    <span class="page-num main-color">{{$page_number}}</span></div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb9"></div>
    @endif

    @if(count($data->core_values)>0)
        <div id="page10" class="white-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-line page-heading-left black-background"><span
                    class="page-num white-background main-color">{{$page_number}}</span></div>
            <h1 class="title main-color" contenteditable="true" @blur="title_changed()"
                data-title-field="core_title">{!! !empty($data->core_title) ? $data->core_title : trans('themes.core_values') !!}</h1>
            <div class="text color-black" data-field="core_text">
                @if(!empty($data->core_text))
                    @php
                        $core_text_1 = substr($data->core_text, 0, 350);
                    @endphp
                    {!!$core_text_1!!}
                @else
                    <p>
                        {{trans('themes.company_values_matter')}}
                    </p>
                @endif
            </div>
            <div class="core-values">
                @foreach($data->core_values as  $c=>$core_value)
                    @if($c<count($data->core_values)/2)
                        <div class="core-value">
                            <div class="img" style="background-image: url({{$core_value['image']}})"></div>
                            <div class="core-value-wrapper">
                                <div class="title main-color">{{$core_value['title']}}</div>
                                <div class="text color-black">{{$core_value['description']}}</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb10"></div>
        <div id="page11" class="color-black white-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-with-title black-background">
                <div class="page-heading-title white-background color-black">{{$data->brand}} Brand
                    Book
                    <span class="page-num main-color">{{$page_number}}</span></div>
            </div>
            <div class="text" data-field="core_text">
                @if(!empty($data->core_text))
                    @php
                        $core_text_2 = substr($data->core_text, 351);
                    @endphp
                    {!! $core_text_2 !!}
                @else
                    <p>
                        {{trans('themes.integrated_into_company_mission')}}
                    </p>
                @endif
            </div>
            <div class="core-values">
                @foreach($data->core_values as  $c=>$core_value)
                    @if($c>=count($data->core_values)/2)
                        <div class="core-value">
                            <div class="img" style="background-image: url({{$core_value['image']}})"></div>
                            <div class="core-value-wrapper">
                                <div class="title main-color">{{$core_value['title']}}</div>
                                <div class="text">{{$core_value['description']}}</div>
                            </div>
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
    <div id="page12" class="secondary-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-line page-heading-left black-background"><span
                class="page-num color-black secondary-color-background">{{$page_number}}</span></div>
        <div class="svg-embed-block">

            <img class="logo-grid"
                 src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzcxIiBoZWlnaHQ9IjIyMiIgdmlld0JveD0iMCAwIDM3MSAyMjIiIGZpbGw9Im5vbmUiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHg9IjYuOTkyMTkiIHk9IjExLjUiIHdpZHRoPSIzNTcuMDE1IiBoZWlnaHQ9IjE5OSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8cmVjdCB4PSIwLjUiIHk9IjAuNSIgd2lkdGg9IjM3MCIgaGVpZ2h0PSIyMjEiIHJ4PSIzMy41IiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSIzNi44MjcxIiB5MT0iMTEiIHgyPSIzNi44MjcxIiB5Mj0iMjExIiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSI2Ni42NjExIiB5MT0iMTEiIHgyPSI2Ni42NjExIiB5Mj0iMjExIiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSI5Ni40OTYxIiB5MT0iMTEiIHgyPSI5Ni40OTYxIiB5Mj0iMjExIiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSIxMjYuMzMiIHkxPSIxMSIgeDI9IjEyNi4zMyIgeTI9IjIxMSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8bGluZSB4MT0iMTU2LjE2NSIgeTE9IjExIiB4Mj0iMTU2LjE2NSIgeTI9IjIxMSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8bGluZSB4MT0iMTg2IiB5MT0iMTEiIHgyPSIxODYiIHkyPSIyMTEiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjIxNS44MzUiIHkxPSIxMSIgeDI9IjIxNS44MzUiIHkyPSIyMTEiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjI0NS42NjkiIHkxPSIxMSIgeDI9IjI0NS42NjkiIHkyPSIyMTEiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjI3NS41MDQiIHkxPSIxMSIgeDI9IjI3NS41MDQiIHkyPSIyMTEiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjMwNS4zMzgiIHkxPSIxMSIgeDI9IjMwNS4zMzgiIHkyPSIyMTEiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjMzNS4xNzMiIHkxPSIxMSIgeDI9IjMzNS4xNzMiIHkyPSIyMTEiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjYuNDkyMTkiIHkxPSIxNzcuNSIgeDI9IjM2NC41MDciIHkyPSIxNzcuNSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8bGluZSB4MT0iNi40OTIxOSIgeTE9IjE0My41IiB4Mj0iMzY0LjUwNyIgeTI9IjE0My41IiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSI2LjQ5MjE5IiB5MT0iMTEwLjUiIHgyPSIzNjQuNTA3IiB5Mj0iMTEwLjUiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjYuNDkyMTkiIHkxPSI3Ny41IiB4Mj0iMzY0LjUwNyIgeTI9Ijc3LjUiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjYuNDkyMTkiIHkxPSI0My41IiB4Mj0iMzY0LjUwNyIgeTI9IjQzLjUiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeTE9Ii0wLjUiIHgyPSI0MTAuMDkxIiB5Mj0iLTAuNSIgdHJhbnNmb3JtPSJtYXRyaXgoMC44NzMwMTMgMC40ODc2OTYgLTAuMDQ5NjYyOSAwLjk5ODc2NiA2LjQ5MjE5IDExKSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8bGluZSB5MT0iLTAuNSIgeDI9IjQxMC4wOTEiIHkyPSItMC41IiB0cmFuc2Zvcm09Im1hdHJpeCgtMC44NzMwMTMgMC40ODc2OTYgLTAuMDQ5NjYyOSAtMC45OTg3NjYgMzY0LjUwOCAxMSkiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeTE9Ii0wLjUiIHgyPSIyMzIuODk4IiB5Mj0iLTAuNSIgdHJhbnNmb3JtPSJtYXRyaXgoMC41MTI0MDUgMC44NTg3NDQgLTAuMTQ3NTQgMC45ODkwNTYgMTI1LjgzIDExKSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8bGluZSB5MT0iLTAuNSIgeDI9IjMxMS4zOTUiIHkyPSItMC41IiB0cmFuc2Zvcm09Im1hdHJpeCgwLjc2NjQ3NyAwLjY0MjI3MiAtMC4wNzQzNzk5IDAuOTk3MjMgNi40OTIxOSAxMSkiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeTE9Ii0wLjUiIHgyPSIzMTEuMzk1IiB5Mj0iLTAuNSIgdHJhbnNmb3JtPSJtYXRyaXgoMC43NjY0NzcgMC42NDIyNzIgLTAuMDc0Mzc5OSAwLjk5NzIzIDEyNS44MyAxMSkiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeTE9Ii0wLjUiIHgyPSIyMzIuODk4IiB5Mj0iLTAuNSIgdHJhbnNmb3JtPSJtYXRyaXgoLTAuNTEyNDA1IDAuODU4NzQ0IC0wLjE0NzU0IC0wLjk4OTA1NiAyNDUuMTcgMTEpIiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHkxPSItMC41IiB4Mj0iMzExLjM5NSIgeTI9Ii0wLjUiIHRyYW5zZm9ybT0ibWF0cml4KC0wLjc2NjQ3NyAwLjY0MjI3MiAtMC4wNzQzNzk5IC0wLjk5NzIzIDM2NC41MDggMTEpIiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHkxPSItMC41IiB4Mj0iMzExLjM5NSIgeTI9Ii0wLjUiIHRyYW5zZm9ybT0ibWF0cml4KC0wLjc2NjQ3NyAwLjY0MjI3MiAtMC4wNzQzNzk5IC0wLjk5NzIzIDI0NS4xNyAxMSkiIHN0cm9rZT0id2hpdGUiLz4KPC9zdmc+Cgo="/>
            @if(!empty($data->all_logo_variations))
                <img class="embed-logo"
                     src="{{$data->all_logo_variations['0_White Negative on Secondary']['logo_b64']}}"/>
            @endif
        </div>
        <h1 class="title bottom-right" contenteditable="true" @blur="title_changed()"
            data-title-field="logo_title">{!! !empty($data->logo_title) ? $data->logo_title : trans('themes.our_logo') !!}</h1>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb12"></div>
    <div id="page13" class="white-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-with-title main-color-background">
            <div class="page-heading-title white-background color-black">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num main-color">{{$page_number}}</span></div>
        </div>
        <div class="svg-embed-block">
            <img class="embed-logo" style="opacity: 1" src="{{$white_bg_logo}}"/>
            <div class="text color-black" style="text-align: center; width: 100%">
                {{trans('themes.master_and_slogan')}}
            </div>
        </div>
        <div class="text-block">

        </div>
        <div class="text bottom-left" data-field="logo_text">
            @if(!empty($data->logo_text))
                {!!$data->logo_text!!}
            @else
                <p class="color-black">
                    {{trans('themes.we_are_proud_logo')}}
                </p>
            @endif
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb13"></div>
    @if(count($data->approved)>0 || count($data->logo_versions) > 1)
        <div id="page14" class="main-color-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-line page-heading-left white-background"><span
                    class="page-num main-color-background">{{$page_number}}</span></div>
            <div class="page-padding-wrapper" style="padding-top: 200px;">
                <h1 class="title" contenteditable="true" @blur="title_changed()"
                    data-title-field="versions_title">{!!
!empty($data->versions_title) ?
$data->versions_title :
trans('themes.logo_versions') !!}</h1>
                <div class="text" data-field="versions_text">
                    @if(!empty($data->versions_text))
                        {!!$data->versions_text!!}
                    @else
                        <p>
                            @php
                                $color1 = isset($data->colors_list[0]) ? $data->colors_list[0]->color->name->value : '';
                                $color2 = isset($data->colors_list[1]) ? $data->colors_list[1]->color->name->value : '';
                            @endphp
                            {{trans('themes.logo_colors', ['brand' => $data->brand, 'color1' => $color1, 'color2' => $color2])}}
                        </p>
                    @endif
                </div>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb14"></div>
        @foreach(\App\BrandBookCreator\BrandBookHelper::orderLogoVariations($data->approved, $data->logo_versions) as $chunk_index => $chunk)
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div id="page15"
                 class="{{ \App\BrandBookCreator\BrandBookHelper::getLogoVariationsPageBgColor($chunk_index) }}">
                @if($chunk_index % 2 == 0)
                    <div class="page-heading-with-title white-background">
                        <div
                            class="page-heading-title color-white {{\App\BrandBookCreator\BrandBookHelper::getLogoVariationsPageBgColor($chunk_index)}}">{{$data->brand}}
                            {{trans('themes.brand_book')}}
                            <span class="page-num">{{$page_number}}</span>
                        </div>
                    </div>
                @else
                    <div class="page-heading-line page-heading-left white-background"><span
                            class="page-num {{ \App\BrandBookCreator\BrandBookHelper::getLogoVariationsPageBgColor($chunk_index) }}">{{$page_number}}</span>
                    </div>
                @endif

                <div class="logo-var-page-wrapper">
                    @foreach($chunk as $logo)
                        <div class="logo-var-background"
                             style="background: {{$logo->background == 'transparent' ? \App\BrandBookCreator\BrandBookHelper::LOGO_BACKGROUND[$logo->id] : $logo->background}}">
                            <div class="logo-variation" style="background-image: url({{$logo->logo_b64}});background-repeat: no-repeat;background-position: center;background-size: contain"></div>
                            <span
                                class="logo-name color-{{!empty(\App\BrandBookCreator\BrandBookHelper::LOGO_NAME_COLOR[$logo->id]) ? \App\BrandBookCreator\BrandBookHelper::LOGO_NAME_COLOR[$logo->id] : ''}}">
                                        {{ $logo->title }}
                                    </span>
                        </div>

                    @endforeach
                </div>
                    @if($data->watermark)
                        <img class="watermark-draft" src="{{$watermark}}">
                    @endif
            </div>
            <div class="page-break pb15"></div>
            @if($loop->last && $chunk_index % 2 != 0)
                <div id="page15"
                     class="{{ \App\BrandBookCreator\BrandBookHelper::getLogoVariationsPageBgColor($chunk_index+1) }}">
                    <div class="page-heading-with-title white-background">
                        <div
                            class="page-heading-title color-white {{\App\BrandBookCreator\BrandBookHelper::getLogoVariationsPageBgColor($chunk_index + 1)}}">{{$data->brand}}
                            {{trans('themes.brand_book')}}
                            <span class="page-num">{{++$page_number}}</span>
                        </div>
                    </div>
                    <div class="logo-var-page-wrapper">
                    </div>
                    @if($data->watermark)
                        <img class="watermark-draft" src="{{$watermark}}">
                    @endif
                </div>
                <div class="page-break pb15"></div>
            @endif
        @endforeach
    @endif

    @if(isset($data->mockups[1]))
        @if(!empty($data->mockups[1]->title))
            <div id="page-mockup-1-0" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
                @endphp
                <div class="page-number">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-title">
                        {{$data->mockups[1]->title}}
                    </div>
                    <div class="mockup-photo mockup-photo-left-half"
                         style="background-image: url({{$data->mockups[1]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
            <div id="page-mockup-1-1" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
                @endphp
                <div class="page-number right">{{$page_number}}</div>
                <div class="mockup-wrapper">
                    <div class="mockup-photo mockup-photo-right-full-left-half"
                         style="background-image: url({{$data->mockups[1]->image}})"></div>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @else
            <div id="page-mockup-1-0" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-1-1" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
        <div id="page16" class="secondary-color-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-line page-heading-left tertiary-color-background">
                <span class="page-num tertiary-color secondary-color-background">{{$page_number}}</span>
            </div>

            <div class="icon-wrapper">
                <img class="logo-grid"
                     src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzE0IiBoZWlnaHQ9IjMxNSIgdmlld0JveD0iMCAwIDMxNCAzMTUiIGZpbGw9Im5vbmUiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHg9IjE5LjUiIHk9IjE5LjUiIHdpZHRoPSIyNzUiIGhlaWdodD0iMjc1IiBzdHJva2U9IndoaXRlIi8+CjxyZWN0IHg9IjE5LjUiIHk9IjE5LjUiIHdpZHRoPSIyNzUiIGhlaWdodD0iMjc1IiByeD0iMTM3LjUiIHN0cm9rZT0id2hpdGUiLz4KPHJlY3QgeD0iNzQuNSIgeT0iNzQuNSIgd2lkdGg9IjE2NSIgaGVpZ2h0PSIxNjUiIHJ4PSI4Mi41IiBzdHJva2U9IndoaXRlIi8+CjxyZWN0IHg9Ijk5LjUiIHk9Ijk5LjUiIHdpZHRoPSIxMTUiIGhlaWdodD0iMTE1IiByeD0iNTcuNSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8cmVjdCB4PSIwLjUiIHk9IjAuNSIgd2lkdGg9IjMxMyIgaGVpZ2h0PSIzMTMiIHJ4PSI2NC41IiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSI0LjM3MTE0ZS0wOCIgeTE9Ijk5LjUiIHgyPSIzMTQiIHkyPSI5OS41IiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSI0LjM3MTE0ZS0wOCIgeTE9IjE1Ny41IiB4Mj0iMzE0IiB5Mj0iMTU3LjUiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjQuMzcxMTRlLTA4IiB5MT0iMjE1LjUiIHgyPSIzMTQiIHkyPSIyMTUuNSIgc3Ryb2tlPSJ3aGl0ZSIvPgo8bGluZSB4MT0iMjE1LjUiIHkxPSIxIiB4Mj0iMjE1LjUiIHkyPSIzMTUiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjE1Ny41IiB5MT0iMSIgeDI9IjE1Ny41IiB5Mj0iMzE1IiBzdHJva2U9IndoaXRlIi8+CjxsaW5lIHgxPSI5OS41IiB5MT0iMSIgeDI9Ijk5LjUiIHkyPSIzMTUiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjIwLjM1MzYiIHkxPSIyMC42NDY0IiB4Mj0iMjk0LjM1NCIgeTI9IjI5NC42NDYiIHN0cm9rZT0id2hpdGUiLz4KPGxpbmUgeDE9IjI5NC4zNTQiIHkxPSIyMS4zNTM2IiB4Mj0iMjAuMzUzNSIgeTI9IjI5NS4zNTQiIHN0cm9rZT0id2hpdGUiLz4KPC9zdmc+CgoK"/>
                @if(!empty($data->all_icon_variations))
                    @if(!empty($data->all_icon_variations['White Negative on Primary in Square']))
                        <img class="embed-logo" style="padding: 25px"
                             src="{{$data->all_icon_variations['White Negative on Primary in Square']['icon_b64']}}"/>
                    @endif
                @endif
            </div>


            <div class="text-block bottom-left">
                <h1 class="title" contenteditable="true" @blur="title_changed()" data-title-field="icon_title"
                    style="margin-bottom: 30px;position: relative;z-index: 2">{!! !empty($data->icon_title) ? $data->icon_title : trans('themes.our_icon_and_favicon') !!}</h1>
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
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>

        <div class="page-break pb16"></div>
        <div id="page17" class="white-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-with-title tertiary-color-background">
                <div
                    class="page-heading-title color-black white-background">{{$data->brand}} {{trans('themes.brand_book')}}
                    <span class="page-num tertiary-color">{{$page_number}}</span>
                </div>
            </div>
            <div class="logo-wrapper">
                {!! $data->icon !!}
                <div
                    class="icon-brand-name color-black">{{trans('themes.the_brand_book_icon', ['brand' => $data->brand])}}</div>
            </div>
            <div class="logo-variations-block">
                @if(!empty($data->approved_icon))
                    @foreach($data->approved_icon as $icon_id => $icon_variation)
                        <div class="icon-preview">
                            <div class="icon" style="
                                background: {{$icon_variation['background']}};
                            @if(\App\BrandBookCreator\BrandBookHelper::borderRadius($icon_variation['title']))
                                border-radius : 100%;
                            @endif
                                ">
                                {!! $icon_variation['icon'] !!}
                            </div>
                            <div class="icon-text color-black">{{$icon_variation['title']}}</div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb17"></div>
    @endif
    @php

        $proportions_x = 'x';
        $proportions_y = 'x';
        $proportions_text = '';

        $logo_prop_text = '';
        $logo_prop_ratio = '';

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
        $proportions_text = $logo_prop_ratio = '1:1 ' . trans('themes.square_ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.= "<br>" . trans('themes.prop_linked_to_fib_seq');
        $logo_prop_text = trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=1;
        }else if($ratio>=2.9 && $ratio<=3.1){
        $proportions_text = $logo_prop_ratio = '1:3 ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $logo_prop_text = "<br>" . trans('themes.prop_linked_to_fib_seq');
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
        $proportions_text = $logo_prop_ratio = '1:'.$xval.' ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $logo_prop_text = trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=5;
        }else if($ratio>=7.8 && $ratio<=8.2){
        $proportions_text = $logo_prop_ratio = '1:8 ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $logo_prop_text = trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=8;
        }else if($ratio>=1.4 && $ratio<=1.58){
        $proportions_text = $logo_prop_ratio = '2:3 ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $logo_prop_text = trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=2;
        $proportions_fibo_active[]=3;
        }else if($ratio>=1.641 && $ratio<=1.7){
        $proportions_text = $logo_prop_ratio = '3:5 ' . trans('themes.ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $logo_prop_text = trans('themes.prop_linked_to_fib_seq');
        $proportions_fibo_active[]=3;
        $proportions_fibo_active[]=5;
        }else if($ratio>=1.581 && $ratio<=1.64){
        $proportions_text = $logo_prop_ratio = '1:1.681 ' . trans('themes.golden_ratio');
        $proportions_text_small = $proportions_text;
        if($data->proportions == 'fibonacci')
        $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
        $logo_prop_text = trans('themes.prop_linked_to_fib_seq');
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
    <div id="page18" class="main-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            $logo_height = $ratio < 1 ? 290 : 290/$ratio;
            if($logo_height > 200){
                $top = '25';
                $percent_in_pix = 190;
                $fibonachi_top = $percent_in_pix + $logo_height + 50;
            } else {
                $top = '35';
                $percent_in_pix = 266;
                $fibonachi_top = $percent_in_pix + $logo_height + 50;
            }
        @endphp
        <div class="page-heading-line page-heading-left secondary-color-background">
            <span class="page-num secondary-color main-color-background">{{$page_number}}</span>
        </div>
        <div class="background-transparent" style="
        @if($ratio<1)
            width: {{290*$ratio}}px;
            height: {{$top}}%; position: absolute; top: 0; left: 50%;
            margin-left: -{{290*$ratio/2}}px;
        @else
            width: 290px;
            height: {{$top}}%;
            position: absolute;
            top: 0; left: 50%;
            margin-left: -145px;
        @endif"></div>
        <div class="background-transparent" style="
        @if($ratio<1)
            width: 50%;
            height: 290px;
            position: absolute;
            top: {{$top}}%;
            margin-left: -{{290*$ratio/2}}px;
        @else
            width: 50%;
            height: {{290/$ratio}}px;
            position: absolute;
            top: {{$top}}%;
            margin-left: -145px;
        @endif"></div>

        <div class="logo" data-x="{{$proportions_x}}" data-y="{{$proportions_y}}"
             data-h="{{$data->logo_h}}px" data-w="{{$data->logo_w}}px" style="top: {{$top}}%">

            <div class="prop_x"
                 style="@if($ratio<1)
                     width: {{290*$ratio}}px;
                     height: 30px;
                     position: absolute;
                     top: 50%; left: 50%;
                     margin-left: -{{290*$ratio/2}}px;
                     margin-top: -36px;
                     border-left: 1px solid white; border-right: 1px solid white;
                 @else width: 290px;
                     height: 30px; position: absolute; top: 50%; left: 50%;
                     margin-left: -145px;
                     border-left: 1px solid white;
                     border-right: 1px solid white;
                     margin-top: -36px;
                 @endif">
                <svg width="15" height="8" class="x_first" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="white"/>
                </svg>
                <span style="color: white">{!!$proportions_x!!}</span>
                <svg width="15" height="8" class="x_last" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="white"/>
                </svg>
            </div>
            <div class="prop_y"
                 style="@if($ratio<1) width: 30px; height: 290px; position: absolute; top: 50%; left: 50%;
                     margin-left: -{{290*$ratio/2 + 40}}px;
                     border-top: 1px solid white; border-bottom: 1px solid white;
                 @else width: 30px; height: {{290/$ratio}}px; position: absolute; top: 50%; left: 50%;
                     margin-left: -185px; border-top: 1px solid white; border-bottom: 1px solid white @endif">

                <svg width="15" class="y_first" height="8" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="white"/>
                </svg>
                <span>{!!$proportions_y!!}</span>
                <svg width="15" height="8" class="y_last" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z" fill="white"/>
                </svg>
            </div>

            <div class="logo-image-prop"
                 style="@if($ratio<1) width: {{290*$ratio}}px; height: 290px;margin-left: -{{290*$ratio/2}}px;
                 @else width: 290px; height: {{290/$ratio}}px;margin-left: -145px;
                 @endif">
                @if(!empty($data->all_logo_variations['0_White Negative on Primary']['logo']))
                    {!! $data->all_logo_variations['0_White Negative on Primary']['logo'] !!}
                @else
                    <div class="logo-image"
                         style="background-image: url({{$data->logo_b64}}); width: 100%;height: 100%; background-size: cover;"></div>
                @endif
            </div>
        </div>
        @if($proportions_fibo_active_active)
            <div class="propositions_fibonacci_container" style="top: {{$fibonachi_top}}px">
                <div class="proportions_text_ratio">{!!$logo_prop_ratio!!}</div>
                <div class="proportions_fibonacci @if($proportions_fibo_active_golden) golden @endif">
                    @foreach([1, 1, 2, 3, 5, 8, 13, 21, 34, 55] as $ndx=>$i)
                        <span
                            class="@if(in_array($i, $proportions_fibo_active))
                            @if($ndx==0&&$i==1) @else active @endif @endif">{{$i}}</span>
                    @endforeach
                </div>
                <div class="proportions_text_text">{!!$logo_prop_text!!}</div>
            </div>
        @endif

        <h1 class="title bottom-right" contenteditable="true" @blur="title_changed()"
            data-title-field="proportions_title"
            style="font-size: 52px; text-align: right">{!! !empty($data->proportions_title) ? $data->proportions_title : trans('themes.logo_and_icon_proportions') !!}
        </h1>

        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb18"></div>
    <div id="page19" class="main-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            $icon_height = $ratio_icon < 1 ? 70 :  70 / $ratio_icon;
            $margin = $logo_height < $icon_height ? $logo_height - $icon_height : $logo_height - $icon_height;
        @endphp
        <div class="page-heading-with-title secondary-color-background">
            <div
                class="page-heading-title main-color-background secondary-color">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num secondary-color">{{$page_number}}</span>
            </div>
        </div>
        @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
            <div class="background-transparent"
                 style="position:absolute;left: 50%;height: {{$percent_in_pix + $margin}}px;
                 @if($ratio_icon<1)
                     width: {{70*$ratio_icon}}px;
                     margin-left: -35px;
                 @else
                     width: 70px;
                     margin-left: -35px;
                 @endif"></div>
            <div class="background-transparent"
                 style="position:absolute;width: 50%;left: 50%; margin-top: {{$percent_in_pix + $margin}}px;
                 @if($ratio_icon<1)
                     height: 70px;
                     margin-left: 35px;
                 @else
                     height: {{70/$ratio_icon}}px;
                     margin-left: 35px;
                 @endif"></div>
            <div class="icon"
                 style="
                 @if($ratio_icon<1) width: {{70*$ratio_icon}}px; height: 70px;
                 @else width: 70px; height: {{70/$ratio_icon}}px; @endif
                     margin-top: {{$percent_in_pix + $margin}}px; top: 0">
                <div class="prop_x"
                     style="width: 100%; height: 30px; position: absolute; top: -30px; left: 0;
border-left: 1px solid white; border-right: 1px solid white">
                    <svg width="15" height="8" class="x_first" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="white"/>
                    </svg>
                    <span style="color:white">{!!$proportions_x_icon!!}</span>
                    <svg width="15" height="8" class="x_last" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="white"/>
                    </svg>
                </div>
                <div class="prop_y"
                     style="width: 30px; height: 100%; position: absolute; top: 0; right: -30px;
border-top: 1px solid white; border-bottom: 1px solid white;">
                    <svg width="15" class="y_first" height="8" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="white"/>
                    </svg>
                    <span style="margin-left: 25px; color: white">{!!$proportions_y_icon!!}</span>
                    <svg width="15" height="8" class="y_last" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="white"/>
                    </svg>
                </div>
                @if(isset($data->icon[0]) && !empty($data->all_icon_variations))
                    <div class="icon-image"
                         style="background-image: url({{$data->all_icon_variations['White Negative on Primary in Square']['icon_b64']}})"></div>
                @endif
            </div>
        @endif
        <div class="text-block bottom-left">
            <div class="text" data-field="proportions_text">
                @if(!empty($data->proportions_text))
                    {!!$data->proportions_text!!}
                @else
                    {{trans('themes.prop_text', ['brand' => $data->brand,'prop_text_small' => $proportions_text_small, 'prop_text' => $proportions_text_small_icon])}}
                @endif
            </div>
        </div>
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
            background: white;
        }

        .prop_y {
            display: flex;
            align-items: center;
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
            background: white;
        }

        .prop_y span {
            margin-left: -10px;
        }

        .propositions_fibonacci_container {
            position: absolute;
            width: 100%;
            height: 30px;
            white-space: nowrap;
            text-align: center;
        }

        .proportions_text {
            text-align: center;
            opacity: 1 !important;
            position: absolute;
            width: 100%;
            color: white;
            /*bottom: 70px;*/
        }

        .proportions_fibonacci {
            padding: 3px 8px;
            border: 1px solid white;
            border-radius: 15px;
            position: absolute;
            top: 25px;
            text-align: center;
            margin: 0 auto;
            left: 50%;
            margin-left: -103px;
            background: {{$main_color}};
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
            background: white;
            padding: 3px 4px;
            margin: 0;
            border-radius: 3px;
            color: {{$main_color}};
        }
    </style>
    <div class="page-break pb19"></div>
    <div id="page20" class="secondary-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            $logo_space = \App\BrandBookCreator\BrandBookHelper::logoFreeSpace($data);
            $top = ($data->logo_h>0?$data->logo_h/2+$logo_space['free_space_y_h']:1)+120;
        @endphp
        <div class="page-heading-line page-heading-left white-background">
            <span class="page-num secondary-color-background">{{$page_number}}</span>
        </div>

        <div class="view-block space-{{$data->space}}"
             style="position: relative;top:{{$top}}px; height: 70px;
             @if($data->logo_w/$data->logo_h<1 && $data->logo_h>=100)transform:scale(.8)@endif">
            <div class="logogsspace space_x"
                 style="background-image: @if($logo_space['show_clear_icon']) url({{$data->logo_b64}}) @else none @endif;
                     background-size: contain; background-position: center; background-repeat: no-repeat;
                     width: {{$logo_space['free_space_x_w'] }}px;
                     height: {{$logo_space['free_space_y_h']}}px; position: absolute; top: 50%; left: 50%;
                     margin-left: -{{($data->logo_w/2+$logo_space['free_space_x_w'])}}px; margin-top: -{{($data->logo_h>0?$data->logo_h/2+$logo_space['free_space_y_h']:1)}}px;
                     border: 1px solid {{$main_color}}; --sx: {{$logo_space['free_space_x_w']}}px; --sy: {{$logo_space['free_space_y_h']}}px">
                <div class="first">
                    <span>{!!$logo_space['free_space_y']!!}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                </div>
                <div class="seond"><span>{!!$logo_space['free_space_x']!!}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                </div>
            </div>
            <div class="logogsspace space_x2"
                 style="background-image: @if($logo_space['show_clear_icon']) url({{$data->logo_b64}}) @else none @endif;
                     background-size: contain;
                     background-position: center;
                     background-repeat: no-repeat;
                     width: {{$logo_space['free_space_x_w']}}px;
                     height: {{$logo_space['free_space_y_h']}}px;
                     position: absolute;
                     top: 50%; left: 50%;
                     margin-left: {{$data->logo_w/2}}px;
                     margin-top: {{($data->logo_h>0?$data->logo_h/2:1)}}px;
                     border: 1px solid {{$main_color}};">
            </div>
            <div class="logogsspace space_x3"
                 style="background-image: @if($logo_space['show_clear_icon']) url({{$data->logo_b64}}) @else none @endif; background-size: contain;
                     background-position: center; background-repeat: no-repeat;
                     width: {{$logo_space['free_space_x_w']}}px; height: {{$logo_space['free_space_y_h']}}px; position: absolute; top: 50%; left: 50%;
                     margin-left: -{{($data->logo_w/2+$logo_space['free_space_x_w'])}}px; margin-top: {{($data->logo_h>0?$data->logo_h/2:1)}}px; border: 1px solid {{$main_color}};">
            </div>
            <div class="logogsspace space_x4"
                 style="background-image: @if($logo_space['show_clear_icon']) url({{$data->logo_b64}}) @else none @endif;
                     width: {{$logo_space['free_space_x_w']}}px;
                     height: {{$logo_space['free_space_y_h']}}px; position: absolute; top: 50%;background-size: contain; background-position: center; background-repeat: no-repeat;
                     left: 50%; margin-left: {{$data->logo_w/2}}px; margin-top: -{{($data->logo_h>0?$data->logo_h/2+$logo_space['free_space_y_h']:1)}}px; border: 1px solid {{$main_color}};">
            </div>
            <div class="logo-sponge-space_x" style="--width: {{$data->logo_w}}px; --height: {{$data->logo_h}}px">
                <span>{{$logo_space['free_sp_x_text']}}</span>
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
                <span>{{$logo_space['free_sp_y_text']}}</span>
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
                <div class="logo-sponge-space_c">
                    <span>{{ $logo_space['free_sp_c_text']}}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                </div>
            @endif

            <div class="logo" style="    position: absolute;
                left: 50%;
                top: 50%;
                margin-left: -{{$data->logo_w/2}}px;
                width: {{$data->logo_w}}px;
                height: {{$data->logo_h}}px;
                margin-top: -{{$data->logo_h/2}}px;
                ">
                @if(isset($data->logo_b64))
                    <div class="proportions_logo logo-image"
                         style="width: {{$data->logo_w}}px;height: {{$data->logo_h}}px;
                             background-image: url({{count($data->all_logo_variations) ? $data->all_logo_variations['0_Primary Color Positive']['logo_b64'] : $data->logo_b64}}); background-size: cover;"></div>
                @endif
                @if($logo_space['clear_space_text']!=='')
                    <div class="proportions_text" style="bottom: -{{($data->logo_h/2+60)}}px;">
                        {!!$logo_space['clear_space_text']!!}
                    </div>
                @endif
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
                        background: {{$main_color}};
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
                        background: {{$main_color}};
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
                        border-top: 1px solid{{$main_color}};
                        border-bottom: 1px solid{{$main_color}};
                        height: {{$data->logo_h + 2*$logo_space['free_space_y_h']-2}}px;
                        position: absolute;
                        top: -{{$logo_space['free_space_y_h'] + 1}}px;
                        left: -1px;
                        width: 101%;
                    }

                    #page21 .logo:after {
                        content: "";
                        display: block;
                        border-left: 1px solid white;
                        border-right: 1px solid white;
                        width: {{$data->logo_w + 2* $logo_space['free_space_x_w']-2}}px;
                        position: absolute;
                        left: -{{ $logo_space['free_space_x_w']+1}}px;
                        top: -1px;
                        height: 108%;
                    }

                    .space_x .first, .space_x2 .first {
                        font-size: 30px;
                        text-align: center;
                        padding-left: 15px;
                        position: absolute;
                        top: -1px;
                        height: {{$logo_space['free_space_y_h']}}px;
                        display: flex;
                        align-items: center;
                        color: {{$main_color}};
                        border-top: 1px solid{{$main_color}};
                        border-bottom: 1px solid{{$main_color}};
                        background-repeat: no-repeat;
                        background-size: contain;
                        width: 60px;
                        left: -60px;
                    }

                    .space_x .seond, .space_x2 .seond {
                        font-size: 30px;
                        position: absolute;
                        left: -1px;
                        width: {{$logo_space['free_space_x_w']}}px;
                        text-align: center;
                        color: {{$main_color}};
                        border-left: 1px solid{{$main_color}};
                        border-right: 1px solid{{$main_color}};
                        background-repeat: no-repeat;
                        background-size: contain;
                        height: 60px;
                        top: -60px;
                    }


                    .icon .space_x .first, .space_x2 .first {
                        height: {{$logo_space['free_space_y_h']-1}}px;
                    }

                    .icon .space_x .seond, .space_x2 .seond {
                        width: {{$logo_space['free_space_x_w']-1}}px;
                    }


                    .logo-sponge-space_x {
                        position: absolute;
                        left: 50%;
                        width: var(--width);
                        margin-left: -{{$data->logo_w/2}}px;
                        margin-bottom: {{$data->logo_h/2}}px;
                        bottom: 50%;
                        height: {{$logo_space['free_space_y_h']}}px;
                        border-top: 1px solid{{ $main_color }};

                    }

                    .logo-sponge-space_x:after {
                        content: "";
                        height: 1px;
                        width: 100%;
                        position: absolute;
                        background: {{$main_color}};
                        left: 0;
                        top: {{$logo_space['free_space_y_h']/2 + 3}}px;
                    }

                    .logo-sponge-space_x .logosp_arr_1 {
                        transform: rotate(-180deg);
                        position: absolute;
                        top: {{$logo_space['free_space_y_h'] / 2}}px;
                        left: 0;
                    }

                    .logo-sponge-space_x .logosp_arr_2 {
                        position: absolute;
                        top: {{$logo_space['free_space_y_h'] / 2}}px;
                        right: 0;
                    }

                    logosp_arr_1 path, .logosp_arr_2 path {
                        fill: {{$main_color}};
                    }

                    .logo-sponge-space_x span {
                        width: 100%;
                        text-align: center;
                        display: block;
                        font-size: 14px;
                        position: absolute;
                        top: 0px;
                        color: {{$main_color}};
                    }

                    .logo-sponge-space_y {
                        height: {{$data->logo_h}}px;
                        position: absolute;
                        top: 50%;
                        margin-top: -{{$data->logo_h/2}}px;
                        margin-right: {{$data->logo_w/2}}px;
                        right: 50%;
                        left: unset;
                        width: {{ceil($logo_space['free_space_x_w'])}}px;
                        border-left: 1px solid{{ $main_color }};
                    }

                    .logo-sponge-space_y:after {
                        content: "";
                        height: 100%;
                        width: 1px;
                        position: absolute;
                        background: {{$main_color}};
                        left: {{ceil($logo_space['free_space_x_w']/2)-1}}px;
                        top: 0px;
                    }

                    .logo-sponge-space_y .logosp_arr_1 {
                        transform: rotate(-90deg);
                        position: absolute;
                        top: 2px;
                        left: {{ceil($logo_space['free_space_x_w']/2)-8}}px;
                    }

                    .logo-sponge-space_y .logosp_arr_2 {
                        position: absolute;
                        bottom: 2px;
                        left: {{ceil($logo_space['free_space_x_w']/2)-8}}px;
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
                        color: {{$main_color}};
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
                        background: {{$main_color}};
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
                        color: {{$main_color}};
                        text-shadow: 0 0 3px rgba(255, 255, 255, 0.7);
                    }

                    .logogsspace.space_x2:before {
                        display: block;
                        content: '';
                        width: {{$data->logo_w}}px;
                        height: 1px;
                        background: {{$main_color}};
                        position: absolute;
                        bottom: -1px;
                        left: -{{$data->logo_w}}px;
                    }

                    .logogsspace.space_x2:after {
                        display: block;
                        content: '';
                        height: {{$data->logo_h}}px;
                        background: {{$main_color}};
                        width: 1px;
                        position: absolute;
                        right: -1px;
                        top: -{{$data->logo_h}}px;
                    }

                    .logosp_arr_1 path {
                        fill: {{$main_color}};
                    }
                </style>
            </div>
        </div>
        <div class="bottom-left">
            <h1 class="title" contenteditable="true"
                data-title-field="space_title">{!! !empty($data->space_title) ? $data->space_title : trans('themes.clear_space') !!}
            </h1>
            <div class="text" data-field="space_text" style="position: relative;z-index: 2">
                @if(!empty($data->space_text))
                    {!!$data->space_text!!}
                @else
                    <p>{{trans('themes.clear_space_text')}}
                        @endif</p>
            </div>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb20"></div>
    <div id="page21" class="secondary-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            list($show_clear_icon,$free_space_x_w,$free_space_y_h, $free_sp_x_text, $free_sp_y_text, $free_space_y, $free_space_x, $free_sp_c_text )
            = \App\BrandBookCreator\BrandBookHelper::freeSpaceIcon($icon_w, $icon_h, $data);

        @endphp
        <div class="page-heading-with-title">
            <div class="page-heading-title secondary-color-background">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num tertiary-color">{{$page_number}}</span>
            </div>
        </div>
        @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
            <div class="icon iconster space-{{$data->space}}"
                 style="width: {{$data->icon_w}}px; height: {{$data->icon_h}}px;margin-left: -{{$data->icon_w/2}}px; top : {{$top}}px">
                <div class="logogsspace space_x icon"
                     style="background-image: @if($show_clear_icon) url({{$data->icon_b64}}) @else none @endif;
                         background-size: contain; background-position: center;
                         background-repeat: no-repeat;
                         width: {{$free_space_x_w}}px;
                         height: {{$free_space_y_h}}px;
                         position: absolute; top: 50%; left: 50%;
                         margin-left: -{{($data->icon_w/2+$free_space_x_w)}}px;
                         margin-top: -{{($data->icon_h>0?$data->icon_h/2+$free_space_y_h:1)}}px;
                         border: 1px solid {{$main_color}};
                         --sx: {{$free_space_x_w}}px;
                         --sy: {{$free_space_y_h}}px"
                >
                    <div class="first">
                        <span>{!!$free_space_y!!}</span>
                        <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                                  fill="black"/>
                        </svg>
                        <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                                  fill="black"/>
                        </svg>
                    </div>
                    <div class="seond" style="width: {{$free_space_x_w}}px"><span>{!!$free_space_x!!}</span>
                        <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                                  fill="black"/>
                        </svg>
                        <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                                  fill="black"/>
                        </svg>
                    </div>
                </div>
                <div class="logogsspace space_x2"
                     style="background-image:
                     @if($show_clear_icon)
                         url({{$data->icon_b64}})
                     @else
                         none
                     @endif;
                         background-size: contain;
                         background-position: center;
                         background-repeat: no-repeat;
                         width: {{$free_space_x_w}}px;
                         height: {{$free_space_y_h}}px;
                         position: absolute; top: 50%; left: 50%;
                         margin-left: {{$data->icon_w/2}}px;
                         margin-top: {{($data->icon_h>0?$data->icon_h/2:1)}}px;
                         border: 1px solid {{$main_color}};
                         --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
                    <!--<div class="first" v-html=free_space_x></div>-->
                    <!--<div class="seond" v-html=free_space_y></div>-->
                </div>
                <div class="logogsspace space_x3"
                     style="background-image:
                     @if($show_clear_icon)
                         url({{$data->icon_b64}})
                     @else
                         none
                     @endif;
                         background-size: contain;
                         background-position: center;
                         background-repeat: no-repeat;
                         width: {{$free_space_x_w}}px;
                         height: {{$free_space_y_h}}px;
                         position: absolute; top: 50%; left: 50%;
                         margin-left: -{{($data->icon_w/2+$free_space_x_w)}}px;
                         margin-top: {{($data->icon_h>0?$data->icon_h/2:1)}}px;
                         border: 1px solid {{$main_color}}; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
                </div>
                <div class="logogsspace space_x4"
                     style="background-image:
                     @if($show_clear_icon)
                         url({{$data->icon_b64}})
                     @else
                         none
                     @endif;background-size: contain;
                         background-position: center;
                         background-repeat: no-repeat;
                         width: {{$free_space_x_w}}px;
                         height: {{$free_space_y_h}}px;
                         position: absolute; top: 50%; left: 50%;
                         margin-left: {{$data->icon_w/2}}px;
                         margin-top: -{{($data->icon_h>0?$data->icon_h/2+$free_space_y_h:1)}}px;
                         border: 1px solid {{$main_color}}; --sx: {{$free_space_x_w}}px; --sy: {{$free_space_y_h}}px">
                </div>
                <div class="logo-sponge-space_x iconed"
                     style="width: {{$data->icon_w}}px; height: {{$free_space_y_h}}px;">
                    <span style="margin-top: 13px;">{{$free_sp_x_text}}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                </div>
                <div class="logo-sponge-space_y iconed"
                     style="height: {{$data->icon_h}}px; width: {{$free_space_x_w}}px;">
                    <span>{{$free_sp_y_text}}</span>
                    <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                    <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                              fill="black"/>
                    </svg>
                </div>
                @if($data->space=='pithagoras')
                    <div class="logo-sponge-space_c iconed"
                         style="--pyw: {{sqrt($data->logo_w*$data->icon_w + $data->icon_h*$data->icon_h)}}px; --width: {{$data->icon_w}}px; --height: {{$data->icon_h}}px; --degree: {{(asin($data->icon_h/sqrt($data->icon_w*$data->icon_w + $data->icon_h*$data->icon_h))*180/pi())}}deg">
                        <span>{{$free_sp_c_text}}</span>
                        <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                                  fill="black"/>
                        </svg>
                        <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                                  fill="black"/>
                        </svg>
                    </div>
                @endif
                @if(isset($data->icon_b64) && !empty($data->all_icon_variations))
                    <div class="logo-image"
                         style="width: {{$data->icon_w}}px; height: {{$data->icon_h}}px;background-image:
                             url({{$data->all_icon_variations[\App\BrandBookCreator\BrandBookHelper::PRIMARY_ICON_VARIATION]['icon_b64']}})"></div>
                @endif
                <style>
                    .logo-sponge-space_x.iconed {
                        margin-left: -{{$data->icon_w/2}}px;
                        margin-bottom: {{$data->icon_h/2}}px;
                    }

                    .logo-sponge-space_y.iconed {
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

                    #page21 .logo-sponge-space_y .logosp_arr_1, #page21 .logo-sponge-space_y .logosp_arr_2 {
                        left: {{$free_space_x_w / 2}}px;
                    }

                    #page21 .logo-sponge-space_y:after {
                        left: {{$free_space_x_w / 2 + 7}}px;
                    }

                    #page21 .logogsspace.space_x2:before {
                        width: {{$data->icon_w}}px;
                        left: -{{$data->icon_w}}px;
                    }

                    #page21 .logogsspace.space_x2:after {
                        height: {{$data->icon_h}}px;
                        top: -{{$data->icon_h}}px;
                    }

                    .icon.iconster .space_x .first, .icon.iconster .space_x2 .first {
                        height: {{$free_space_y_h}}px;
                    }
                </style>
            </div>
        @endif
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb21"></div>
    <div id="page22" class="secondary-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-line page-heading-left">
            <span class="page-num secondary-color-background">{{$page_number}}</span>
        </div>

        <div class="opacity-background"></div>


        <div
            class="logo-long-wrapper  @if( empty($data->icon) || $data->icon =='skipped' || $data->icon=='[]') single @endif">
            <div class="description logo-description secondary-color">
                <div>
                    {{trans('themes.not_smaller_in_digital_logo', ['brand' => $data->brand])}}
                    @if($data->size=='quark') 71px @endif
                    @if($data->size=='neutron') 100px @endif
                    @if($data->size=='atom') 160px @endif
                    @if($data->size=='molecule') 214px @endif
                    {{trans('themes.in_digital_or')}}
                    @if($data->size=='quark') 20mm @endif
                    @if($data->size=='neutron') 28mm @endif
                    @if($data->size=='atom') 45mm @endif
                    @if($data->size=='molecule') 60mm @endif {{trans('themes.in_print')}}
                </div>
            </div>
            <div class="lgo logo-1"
                 style="text-align: center;border-left: 1px dashed black;border-right: 1px dashed black;padding-bottom: 20px; margin-top: 20px">
                <div class="logo"
                     style="height: auto; margin: 0 auto;
                         width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size]}}px;">
                    @if(isset($data->logo_b64))
                        <img class="logo-image" src="{{$data->logo_b64}}" style="
                            width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size]}}px;
                            display: block;margin: 0 auto; height: auto;
                            ">
                    @endif
                </div>
                <div class="logo_after color-black" style="
                    width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size]}}px;
                    ">
                    <div class="text" style="margin: auto;
                        width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size] - 20}}px;
                    @if($data->size=='quark' || $data->size=='neutron')
                        line-height: 1em;padding-top: 10px;
                    @endif">
                        @if($data->size=='quark') 71px / 20mm @endif
                        @if($data->size=='neutron') 100px / 28mm @endif
                        @if($data->size=='atom') 160px / 45mm @endif
                        @if($data->size=='molecule') 214px /60mm @endif
                    </div>
                </div>
                <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                          fill="black"></path>
                </svg>
                <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                          fill="black"></path>
                </svg>
            </div>
            @php
                $size = \App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size];
            @endphp
            @for($i=1; $i<10; $i+=0.8)
                <div class="lgo">

                    <div class="logo"
                         style="height: auto; margin: 0 auto;
                             width: {{ $size * $i }}px;">
                        @if(isset($data->logo_b64))
                            <img class="logo-image" src="{{$data->logo_b64}}" style="
                                width: {{ $size * $i }}px;
                                display: block;margin: 0 auto; height: auto;
                                ">
                        @endif
                    </div>
                </div>
            @endfor

            <div class="clear"></div>
        </div>
        @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')

            <div class="icon-long-wrapper">
                <div class="description icon-description secondary-color">
                    <div>
                        {{trans('themes.not_smaller_in_digital', ['brand' => $data->brand])}} @if($data->size=='quark')
                            10px @endif @if($data->size=='neutron') 14px @endif @if($data->size=='atom')
                            22px @endif @if($data->size=='molecule') 30px @endif {{trans('themes.in_digital_or')}} @if($data->size=='quark')
                            2.8mm @endif @if($data->size=='neutron') 3.9mm @endif @if($data->size=='atom')
                            6.3mm @endif @if($data->size=='molecule') 8.4mm @endif {{trans('themes.in_print')}}
                    </div>
                </div>
                <div class="icn icon-1" style="text-align: center;">
                    <div class="icon"
                         style="margin-top:20px; height: auto; width: {{\App\BrandBookCreator\BrandBookHelper::ICON_SIZES[$data->size]}}px;">
                        <img class="logo-image" src="{{$data->icon_b64}}" style="
                            width: {{ \App\BrandBookCreator\BrandBookHelper::ICON_SIZES[$data->size] }}px;
                            display: block;margin: 0 auto; height: auto;
                            ">
                    </div>
                    <svg width="9" class="logosp_arr_1" height="6" viewBox="0 0 9 6" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M-1.05922e-07 3L9 5.59808L9 0.401924L-1.05922e-07 3Z" fill="black"/>
                    </svg>
                    <svg width="9" class="logosp_arr_2" height="6" viewBox="0 0 9 6" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M-1.05922e-07 3L9 5.59808L9 0.401924L-1.05922e-07 3Z" fill="black"/>
                    </svg>
                </div>
                @php
                    $size = \App\BrandBookCreator\BrandBookHelper::ICON_SIZES[$data->size];
                @endphp
                @for($i=1; $i<20; $i+=1)
                    <div class="icn">
                        <div class="icon" style="margin: 0 auto;height: auto;width:{{$size * $i}}px;">
                            <img class="logo-image" src="{{$white_bg_logo}}" style="width: {{$size * $i}}px;
                                display: block;margin: 0 auto; height: auto;">
                        </div>
                    </div>
                @endfor
                <div class="clear"></div>
            </div>
        @endif
        <div class="bottom-left">
            <h1 class="title secondary-color" contenteditable="true" @blur="title_changed()"
                data-title-field="size_title"
                style="position: relative;z-index: 2">{!! !empty($data->size_title) ? $data->size_title :trans('themes.minimum_size') !!}
            </h1>
            <div class="text secondary-color" data-field="size_text" style="position: relative;z-index: 2">
                @if(!empty($data->size_text))
                    {!!$data->size_text!!}
                @else
                    <p>{{trans('themes.establishing')}}</p>
                @endif
            </div>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb22"></div>
    <div id="page23" class="secondary-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="opacity-background"></div>

        <div class="page-heading-with-title">
            <div class="page-heading-title secondary-color-background">
                <div class="opacity-background" style="border-bottom-left-radius: 25px"></div>

                {{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num secondary-color">{{$page_number}}</span>
            </div>
        </div>
        <div
            class="logo-long-wrapper @if(empty($data->icon) || $data->icon=='skipped' || $data->icon=='[]') single @endif">
            <div class="description icon-description secondary-color">
                <div>
                </div>
            </div>
            <div class="lgo logo-1"
                 style="text-align: center;border-left: 1px dashed black;border-right: 1px dashed black;padding-bottom: 20px; margin-top: 20px">
                <div class="logo"
                     style="height: auto; margin: 0 auto;
                         width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size]}}px;">
                    @if(isset($data->logo_b64))
                        <img class="logo-image" src="{{$data->logo_b64}}" style="
                            width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size]}}px;
                            display: block;margin: 0 auto; height: auto;
                            ">
                    @endif
                </div>
                <div class="logo_after color-black" style="
                    width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size]}}px;
                    ">
                    <div class="text" style="margin: auto;
                        width: {{\App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size] - 20}}px;
                    @if($data->size=='quark' || $data->size=='neutron')
                        line-height: 1em;padding-top: 10px;
                    @endif">
                        @if($data->size=='quark') 71px / 20mm @endif
                        @if($data->size=='neutron') 100px / 28mm @endif
                        @if($data->size=='atom') 160px / 45mm @endif
                        @if($data->size=='molecule') 214px /60mm @endif
                    </div>
                </div>
                <svg width="15" height="8" class="logosp_arr_1" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                          fill="black"></path>
                </svg>
                <svg width="15" height="8" class="logosp_arr_2" viewBox="0 0 15 8" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3008 4.13812L0.800781 7.96942L0.800781 0.306815L14.3008 4.13812Z"
                          fill="black"></path>
                </svg>
            </div>
            @php
                $size = \App\BrandBookCreator\BrandBookHelper::LOGO_SIZES[$data->size];
            @endphp
            @for($i=1; $i<10; $i+=0.8)
                <div class="lgo">

                    <div class="logo"
                         style="height: auto; margin: 0 auto;
                             width: {{ $size * $i }}px;">
                        @if(isset($data->logo_b64))
                            <img class="logo-image" src="{{$data->logo_b64}}" style="
                                width: {{ $size * $i }}px;
                                display: block;margin: 0 auto; height: auto;
                                ">
                        @endif
                    </div>
                </div>
            @endfor

            <div class="clear"></div>
        </div>

        @if(!empty($data->icon) && $data->icon!='skipped' && $data->icon!='[]')
            <div class="icon-long-wrapper">
                <div class="description icon-description secondary-color">
                    <div>
                    </div>
                </div>
                <div class="icn icon-1" style="text-align: center;">
                    <div class="icon"
                         style="margin-top:20px; height: auto; width: {{\App\BrandBookCreator\BrandBookHelper::ICON_SIZES[$data->size]}}px;">
                        <img class="logo-image" src="{{$data->icon_b64}}" style="
                            width: {{ \App\BrandBookCreator\BrandBookHelper::ICON_SIZES[$data->size] }}px;
                            display: block;margin: 0 auto; height: auto;
                            ">
                    </div>
                    <svg width="9" class="logosp_arr_1" height="6" viewBox="0 0 9 6" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M-1.05922e-07 3L9 5.59808L9 0.401924L-1.05922e-07 3Z" fill="black"/>
                    </svg>
                    <svg width="9" class="logosp_arr_2" height="6" viewBox="0 0 9 6" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M-1.05922e-07 3L9 5.59808L9 0.401924L-1.05922e-07 3Z" fill="black"/>
                    </svg>
                </div>
                @php
                    $size = \App\BrandBookCreator\BrandBookHelper::ICON_SIZES[$data->size];
                @endphp
                @for($i=1; $i<20; $i+=1)
                    <div class="icn">
                        <div class="icon" style="margin: 0 auto;height: auto;width:{{$size * $i}}px;">
                            <img class="logo-image" src="{{$data->icon_b64}}" style="width: {{$size * $i}}px;
                                display: block;margin: 0 auto; height: auto;">
                        </div>
                    </div>
                @endfor
                <div class="clear"></div>
            </div>
        @endif
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb23"></div>
    @if(isset($data->mockups[2]))
        @if(!empty($data->mockups[2]->title))
            <div id="page-mockup-3-0" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-3-1" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
        <div id="page24" class="white-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-line page-heading-left black-background">
                <span class="page-num main-color white-background">{{$page_number}}</span>
            </div>
            <h1 class="title color-black" contenteditable="true" @blur="title_changed()" data-title-field="misuse_title"
                style="position: relative;z-index: 2">{!! !empty($data->misuse_title) ? $data->misuse_title : trans('themes.logo_misuse') !!}</h1>
            <div class="misuses-wrapper">
                @foreach($data->missuses as $missuse)
                    <div class="rejected_item">
                        <div class="logo-image"
                             style="@foreach($missuse->style as $key=>$value) {{\App\BrandBookCreator\BrandBookHelper::fromCamelCase($key)}}: @if($value=='rotate(45deg)') rotate(20deg) @else{{$value}}@endif;@endforeach background-image: url({{$missuse->logo_b64}})"></div>
                        <div class="misuses-text color-black">{{$missuse->title}}</div>
                        <div class="line"></div>
                    </div>
                    @break($loop->iteration == 4)
                @endforeach
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb24"></div>
        <div id="page25" class="white-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-with-title black-background">
                <div
                    class="page-heading-title color-black white-background">{{$data->brand}} {{trans('themes.brand_book')}}
                    <span class="page-num main-color">{{$page_number}}</span>
                </div>
            </div>
            <div class="text main-color" data-field="misuse_text" style="position: relative;z-index: 2">
                @if(!empty($data->misuse_text))
                    {!!$data->misuse_text!!}
                @else
                    <p>{{trans('themes.it_is_important_that_appearance')}}</p>
                @endif
            </div>

            <div class="misuses-wrapper">
                @foreach($data->missuses as $missuse)
                    @continue($loop->iteration < 4)
                    <div class="rejected_item">
                        <div class="logo-image"
                             style="@foreach($missuse->style as $key=>$value) {{\App\BrandBookCreator\BrandBookHelper::fromCamelCase($key)}}: @if($value=='rotate(45deg)') rotate(20deg) @else{{$value}}@endif;@endforeach background-image: url({{$missuse->logo_b64}})"></div>
                        <div class="misuses-text color-black">{{$missuse->title}}</div>
                        <div class="line"></div>
                    </div>
                @endforeach
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb25"></div>
    @endif
    @if(count($data->icon_family)>0)
        <div id="page26-1" class="white-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-line page-heading-left black-background">
                <span class="page-num secondary-color white-background">{{$page_number}}</span>
            </div>
            <h1 class="title main-color bottom-right"
                style="position: relative;z-index: 2">{{trans('themes.feature_icons')}}</h1>
            <div
                class="favicons {{ \App\BrandBookCreator\BrandBookHelper::getIconWrapperSize(count($data->icon_family)) }}">
                @foreach($data->icon_family as $ind=>$icon)
                    @break($loop->iteration == \App\BrandBookCreator\BrandBookHelper::getIconBreakCount($loop->count))
                    <div class="favicon icon-{{$ind}}">
                        <div class="image"
                             style="background-image: url({{isset($icon['b64'])?$icon['b64']:''}});
                                 background-repeat: no-repeat;
                                 background-position: center;
                                 background-size: contain;"></div>
                        <div class="logo-title color-black" style="margin-top: 0">
                            {{isset($icon['title'])?$icon['title']:''}}
                        </div>
                    </div>

                @endforeach
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        <div class="page-break pb26-1"></div>
        <div id="page27-1" class="white-background">
            @php
                \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            @endphp
            <div class="page-heading-with-title black-background">
                <div
                    class="page-heading-title color-black white-background">{{$data->brand}} {{trans('themes.brand_book')}}
                    <span class="page-num secondary-color">{{$page_number}}</span>
                </div>
            </div>
            <div class="text secondary-color bottom-left">
                <p>{{trans('themes.icons_are_the_visual')}}</p>
            </div>
            <div
                class="favicons {{ \App\BrandBookCreator\BrandBookHelper::getIconWrapperSize(count($data->icon_family)) }}">
                @foreach($data->icon_family as $ind=>$icon)
                    @continue($loop->iteration < \App\BrandBookCreator\BrandBookHelper::getIconBreakCount($loop->count))
                    <div class="favicon">
                        <div class="image"
                             style="background-image: url({{isset($icon['b64'])?$icon['b64']:''}});
                                 background-repeat: no-repeat;
                                 background-position: center;
                                 background-size: contain;"></div>
                        <div class="logo-title color-black" style="margin-top: 0">
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
    <div id="page26" class="white-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-line page-heading-left main-color-background">
            <span class="page-num main-color white-background">{{$page_number}}</span>
        </div>
        <div class="page-padding-wrapper">
            <h1 class="title color-black" contenteditable="true" @blur="title_changed()"
                data-title-field="pallette_title">{!! !empty($data->pallette_title) ? $data->pallette_title : trans('themes.our_color_palette') !!}</h1>
            <div class="text color-black" data-field="pallette_text" style="">
                @if(!empty($data->pallette_text))
                    {!!$data->pallette_text!!}
                @else
                    <p>{{trans('themes.the_colors_selected', ['brand' => $data->brand])}}</p>
                @endif
            </div>
            <div class="tertiary-color-box tertiary-color-background">
                <p class="color-name">{{trans('themes.tertiary_color')}}</p>
                <p class="color-hex">{{$tertiary_color}}</p>
            </div>
            <div class="text color-black bottom-right" style="padding-left: 80px; font-size: 12px">
                <p>
                    {{trans('themes.instead_of_the_colors')}}
                </p>
            </div>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb26"></div>
    <div id="page27-27" style="position: relative;" class="white-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-with-title main-color-background" style="z-index: 2">
            <div class="adjust-color-line"></div>
            <div class="page-heading-title main-color-background">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num">{{$page_number}}</span>
            </div>
        </div>
        <div class="secondary-color-box secondary-color-background">
            <p class="color-name">{{trans('themes.secondary_color')}}</p>
            <p class="color-hex">{{$secondary_color}}</p>
        </div>

        <div class="main-color-box main-color-background">
            <p class="color-name">{{trans('themes.primary_color')}}</p>
            <p class="color-hex">{{$main_color}}</p>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb27-27"></div>
    <div id="page26-26"
         class="@if(count($data->colors_list)<5) color-size-1 @else color-size-2 @endif grey-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
            $color_names = \App\BrandBookCreator\BrandBookHelper::nameColors(count($data->colors_list));
            $paginate_colors = \App\BrandBookCreator\BrandBookHelper::paginateColors($data->colors_list);
            $break_continue = count($data->colors_list) < 5 ? 2 : 4;
        @endphp
        <div class="page-heading-line page-heading-left">
            <span class="page-num" style="background: {{$paginate_colors[0]}}">{{$page_number}}</span>
        </div>
        @foreach($data->colors_list as $index => $color)
            @break($loop->iteration > $break_continue)
            <div class="detail-color-box" style="background: {{$color->color->hex->value}};">
                <div class="left-block">
                    <div class="text-color-type">{{$color_names[$index]}}</div>
                    <div class="text-color-name">{{$color->color->name->value}}</div>
                    <div class="color-description">
                        <div class="name">Hex</div>
                        <div class="value">{{$color->color->hex->value}}</div>
                        <div class="name">RGB</div>
                        <div
                            class="value">{{$color->color->rgb->r}} {{$color->color->rgb->g}} {{$color->color->rgb->b}}</div>
                        <div class="name">CMYK</div>
                        <div
                            class="value">{{$color->color->cmyk->c}} {{$color->color->cmyk->m}} {{$color->color->cmyk->y}} {{$color->color->cmyk->k}}</div>
                        @if(property_exists($color, 'pantone') && $color->pantone!=null)
                            <div class="name">{{trans('themes.pantone')}}</div>
                            <div class="value">{{$color->pantone->getName()}}</div>
                        @endif
                    </div>
                </div>
                <div class="right-block">
                    @if($color->show_shades)
                        <div style="background:
                        {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}};
                            display: flex;align-items: center;align-content: center;justify-content: center;color:
                        {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30))}};margin-bottom: 2px;">
                            {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}}
                        </div>
                        <div class="main-color"
                             style="background: {{$color->color->hex->value}};
                                 display: flex;align-items: center;align-content: center;justify-content:
                                 center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($color->color->hex->value)}};
                                 margin-bottom: 2px;@if(!$color->show_shades) height: 210px; margin-bottom: 40px; @endif">
                            {{$color->color->hex->value}}
                        </div>
                        <div class="ligher-color"
                             style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}};
                                 display: flex;align-items: center;align-content: center;justify-content: center;
                                 color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30))}};margin-bottom: 2px;">
                            {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}}
                        </div>
                        <div class="lightest-color"
                             style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}};
                                 display: flex;align-items: center;align-content: center;justify-content:
                                 center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40))}};margin-bottom: 40px;">
                            {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb26-26"></div>
    <div id="page27"
         class="@if(count($data->colors_list)<5) color-size-1 @else color-size-2 @endif grey-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-with-title white-background">
            <div class="page-heading-title"
                 style="background: {{$paginate_colors[1]}}">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num">{{$page_number}}</span>
            </div>
        </div>
        @foreach($data->colors_list as $index => $color)
            @continue($loop->iteration <= $break_continue)
            <div class="detail-color-box" style="background: {{$color->color->hex->value}};">
                <div class="left-block">
                    <div class="text-color-type">{{$color_names[$index]}}</div>
                    <div class="text-color-name">{{$color->color->name->value}}</div>
                    <div class="color-description">
                        <div class="name">Hex</div>
                        <div class="value">{{$color->color->hex->value}}</div>
                        <div class="name">RGB</div>
                        <div
                            class="value">{{$color->color->rgb->r}} {{$color->color->rgb->g}} {{$color->color->rgb->b}}</div>
                        <div class="name">CMYK</div>
                        <div
                            class="value">{{$color->color->cmyk->c}} {{$color->color->cmyk->m}} {{$color->color->cmyk->y}} {{$color->color->cmyk->k}}</div>
                        @if(property_exists($color, 'pantone') && $color->pantone!=null)
                            <div class="name">{{trans('themes.pantone')}}</div>
                            <div class="value">{{$color->pantone->getName()}}</div>
                        @endif
                    </div>
                </div>
                <div class="right-block">
                    @if(isset($color->show_shades))
                        <div style="background:
                        {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}};
                            display: flex;align-items: center;align-content: center;justify-content: center;color:
                        {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30))}};margin-bottom: 2px;">
                            {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, -30)}}
                        </div>
                        <div class="main-color"
                             style="background: {{$color->color->hex->value}};
                                 display: flex;align-items: center;align-content: center;justify-content:
                                 center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor($color->color->hex->value)}};
                                 margin-bottom: 2px;@if(!$color->show_shades) height: 210px; margin-bottom: 40px; @endif">
                            {{$color->color->hex->value}}
                        </div>
                        <div class="ligher-color"
                             style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}};
                                 display: flex;align-items: center;align-content: center;justify-content: center;
                                 color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30))}};margin-bottom: 2px;">
                            {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 30)}}
                        </div>
                        <div class="lightest-color"
                             style="background: {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}};
                                 display: flex;align-items: center;align-content: center;justify-content:
                                 center;color: {{\App\BrandBookCreator\BrandBookHelper::getContrastColor(\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40))}};margin-bottom: 40px;">
                            {{\App\BrandBookCreator\BrandBookHelper::adjustBrightness($color->color->hex->value, 40)}}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb27"></div>
    <div id="page28" class="secondary-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-line page-heading-left" style="z-index: 1">
            <span class="page-num secondary-color-background">{{$page_number}}</span>
        </div>
        @if(isset($data->fonts_main[1]))
            <div class="huge-text main-color" style="font-family:'main1'; z-index: 0">
                Aa
            </div>
        @endif
        <div class="font-family-names font-size-1 main-color"
             style="font-family: 'main1'">{{$data->fonts_main[1]['font_face']}}</div>
        <div class="font-family-names font-size-2 main-color"
             style="font-family: 'main1'">{{$data->fonts_main[1]['font_face']}}</div>
        <div class="font-family-names font-size-3 main-color"
             style="font-family: 'main1'">{{$data->fonts_main[1]['font_face']}}</div>
        <div class="font-family-names font-size-4 main-color"
             style="font-family: 'main1'">{{$data->fonts_main[1]['font_face']}}</div>
        <div class="font-family-names font-size-5 main-color"
             style="font-family: 'main1'">{{$data->fonts_main[1]['font_face']}}</div>
        <div class="font-family-names font-size-6 main-color"
             style="font-family: 'main1'">{{$data->fonts_main[1]['font_face']}}</div>
        <div class="font-family-names font-size-7 main-color"
             style="font-family: 'main1'">{{$data->fonts_main[1]['font_face']}}</div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb28"></div>
    <div id="page29" class="secondary-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-with-title">
            <div class="page-heading-title secondary-color-background">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num">{{$page_number}}</span>
            </div>
        </div>
        <div class="bottom-left">
            <h1 class="title">{{trans('themes.our_fonts')}}</h1>
            <div class="text">
                @php
                    $fonts_count = !empty($data->fonts_main) && !empty($data->fonts_secondary) ? 2 : 1;
                @endphp
                {{trans_choice('themes.we_use_count_fonts', $fonts_count)}}
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
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb29"></div>
    <div id="page30" class="white-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-line page-heading-left black-background">
            <span class="page-num main-color white-background">{{$page_number}}</span>
        </div>
        <div class="heading-font">
            <div class="fonts-title color-black">{{trans('primary')}}</div>
            @if(isset($data->fonts_main) && isset($data->fonts_main[1]))
                <div class="font-name color-black"
                     style="font-family: 'main1';">{{$data->fonts_main[1]['font_face']}}</div>
            @endif
        </div>
        @foreach($data->fonts_main as $fm)
            @if(isset($fm['index']))
                <div class="font-preview color-black">
                    <div class="font-titlw-left"
                         style="font-family: 'main{{$fm['index']}}';">{{$data->fonts_main[1]['font_face']}} @if(isset($fm['weight'])){{$fm['weight']}}@endif</div>
                    <div class="font-title-right">
                        <div class="block-1" style="font-family: 'main{{$fm['index']}}';">ABCDEFGH</div>
                        <div class="block-2" style="font-family: 'main{{$fm['index']}}';">{{$data->brand}}</div>
                        <div class="block-3" style="font-family: 'main{{$fm['index']}}';">
                            {{trans('themes.alphabet_big')}}
                        </div>
                        <div class="block-4"
                             style="font-family: 'main{{$fm['index']}}';">{{trans('themes.numbers_and_symbols')}}</div>
                    </div>
                    <div class="clear"></div>
                </div>
            @endif
        @endforeach
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb30"></div>
    <div id="page31" class="white-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-with-title black-background">
            <div class="page-heading-title white-background color-black">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num main-color">{{$page_number}}</span>
            </div>
        </div>
        <div class="heading-font">
            <div class="fonts-title color-black">{{trans('themes.secondary_font')}}</div>
            @if(isset($data->fonts_secondary) && isset($data->fonts_secondary[1]))
                <div class="font-name color-black"
                     style="font-family: 'second1'">{{$data->fonts_secondary[1]['font_face']}}</div>
            @endif
        </div>
        @foreach($data->fonts_secondary as $fm)
            @if(isset($fm['index']))
                <div class="font-preview color-black">
                    <div class="font-titlw-left"
                         style="font-family: 'second{{$fm['index']}}';">{{$data->fonts_secondary[1]['font_face']}} @if(isset($fm['weight'])){{$fm['weight']}}@endif</div>
                    <div class="font-title-right">
                        <div class="block-1" style="font-family: 'second{{$fm['index']}}';">ABCDEFGH</div>
                        <div class="block-2" style="font-family: 'second{{$fm['index']}}';">{{$data->brand}}</div>
                        <div class="block-3" style="font-family: 'second{{$fm['index']}}';">
                            {{trans('themes.alphabet_big')}}
                        </div>
                        <div class="block-4"
                             style="font-family: 'second{{$fm['index']}}';">{{trans('themes.numbers_and_symbols')}}</div>
                    </div>
                    <div class="clear"></div>
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
            <div id="page-mockup-4-0" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-4-1" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-4-0" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
            <div id="page-mockup-4-1" class="white-background">
                @php
                    \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
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
    <div id="page32" class="main-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="opacity-background"></div>
        <div class="page-heading-line page-heading-left black-background">
            <div class="opacity-background"></div>
            <span class="page-num main-color-background">
                    <div class="opacity-background" style="border-bottom-right-radius: 25px;"></div>
                    {{$page_number}}</span>
        </div>
        <div class="contact-info-wrapper">
            <div class="user-info">
                <div class="image">
                    <img src="{{$data->user->avatar}}" alt="">
                </div>
                <div class="name" style="color: #000">{{$data->user->name}} {{$data->user->position}}</div>
            </div>
            <h1 class="title " style="white-space: nowrap;">{{trans('themes.brand_book_designer')}}</h1>
            <div class="text ">
                {{$data->user->description}}
            </div>

            <div class="company">
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
                <div class="company-logo">
                    <img src="{{$data->user->company_logo_full}}" alt="" style="max-width: 150px;">
                </div>
            </div>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb32"></div>
    <div id="page33" class="main-color-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="opacity-background"></div>

        <div class="page-heading-with-title">
            <div class="page-heading-title main-color-background">
                <div class="opacity-background" style="border-bottom-left-radius: 25px;"></div>
                {{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num">{{$page_number}}</span>
            </div>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb33"></div>
    <div id="page34" class="white-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-line page-heading-left black-background">
            <span class="page-num color-black white-background">{{$page_number}}</span>
        </div>
        <div class="text-center powered-by">
            <p>{{trans('themes.designed_by')}}</p>
            @if(isset($data->user->company_logo_full) && !empty($data->user->company_logo_full) && $data->user->company_logo_full!==null)
                <div class="company-logo">
                    <img src="{{$data->user->company_logo_full}}" alt="">
                </div>
            @else
                <div style="font-weight: bold; text-align: center;" class="color-black">{{$data->user->name}}</div>
            @endif
            <div class="logo-gingersauce">
                <svg width="14" height="14" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"/>
                </svg>
                {{trans('themes.powered_by')}} gingersauce
            </div>
        </div>
        <div class="logo-background">
            @for($i = 0, $index = 0; $i< 760; $i+=$data->logo_h, $index++)
                <div class="logo-row-matrix" @if($index % 2 == 0) style="margin-left: 100px;" @endif>
                    @for($j = 0; $j < 1860; $j+=$data->logo_w)
                        <div class="logo-cell"
                             style="max-width: 200px; height: {{$data->logo_h}}px; width: {{$data->logo_w}}px;">
                            @if(!empty($data->all_logo_variations))
                                <img style="height:100%"
                                     src="{{$data->all_logo_variations['0_White & Black']['logo_b64']}}"/>
                            @endif
                        </div>
                    @endfor
                    <div class="clear"></div>
                </div>
            @endfor
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb34"></div>
    <div id="page35" class="white-background">
        @php
            \App\BrandBookCreator\BrandBookHelper::pageNumber($page_number);
        @endphp
        <div class="page-heading-with-title black-background">
            <div class="page-heading-title color-black white-background">{{$data->brand}} {{trans('themes.brand_book')}}
                <span class="page-num white-background color-black">{{$page_number}}</span>
            </div>
        </div>
        <div class="logo-background" style="left: -30%">
            @for($i = 0, $index=0, $showed = false; $i< 760; $i+=$data->logo_h, $index++)
                <div class="logo-row-matrix" @if($index % 2 == 0) style="margin-left: 100px;" @endif>
                    @for($j = 0; $j < 1860; $j+=$data->logo_w)
                        <div class="logo-cell"
                             style="max-width: 200px; height: {{$data->logo_h}}; width: {{$data->logo_w}}px;">
                            @if(\App\BrandBookCreator\BrandBookHelper::lastPageFullLogo($i,$j, $data->logo_h, $data->logo_w, $showed) || empty($data->all_logo_variations))
                                <img style="opacity:1;height:100%" src="{{$white_bg_logo}}"/>
                            @else
                                <img style="height:100%"
                                     src="{{$data->all_logo_variations['0_White & Black']['logo_b64']}}"/>
                            @endif
                        </div>
                    @endfor
                    <div class="clear"></div>
                </div>
            @endfor
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
    <div class="page-break pb35"></div>
    <div id="page36" class="main-color-background">
        <div class="last-page-wrapper">
            <div class="last-page-logo-wrapper">
                @if(!empty($data->all_logo_variations))
                    <img style="height:100%; opacity:0.4;"
                         src="{{$data->all_logo_variations['0_White & Black']['logo_b64']}}"/>
                @endif
            </div>
        </div>
        <div class="last-page-brand main-color-background">{{ $data->brand }} {{trans('themes.brand_book')}}</div>
        <div class="last-page-logo-gingersauce">
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
