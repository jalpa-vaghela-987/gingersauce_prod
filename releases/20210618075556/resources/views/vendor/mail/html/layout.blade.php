<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
	<tr>
		<td class="header-"></td>
	</tr>
<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
	{{-- $header ?? '' --}}
<!-- Body content -->
<tr>
<td class="content-cell">
	<img src="{{asset('images/ginger02.png')}}" alt="Gingersauce" style="display: block; margin: 10px auto;" />
	<div style="text-align: center;margin-bottom: 40px;color: #666666">Gingersauce</div>

{{ Illuminate\Mail\Markdown::parse($slot) }}

{{ $subcopy ?? '' }}

<hr>
<div class="small-text-footer">
	Gingersauce is the first professional brand book maker built by designers for designers. Our goal is to empower designers by saving time and helping them focus only on the creative aspects of the design process.
</div>
<div class="small-text-spice">
	<img src="{{asset('images/suyb.png')}}" alt="Spice Up Your Brand" />
</div>
</td>
</tr>
</table>
</td>
</tr>

{{ $footer ?? '' }}
</table>
</td>
</tr>
</table>
</body>
</html>
