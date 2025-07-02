@extends('layouts.app')

@section('content')
	@php
		$user = Auth::user();
	@endphp
	<div class="container-fluid">
		<div class="row" id="my-brandbooks" style="height: calc(100vh - 50px); overflow: auto;">
			@include('profile.sidebar')

			<div class="col-9">
				<h1 class="my-5">{{__('Invoices')}}</h1>
				<div class="invoices table">
					<table class="table table-condensed table-bordered">
						<thead>
							<tr>
								<th>{{__('Date')}}</th>
								<th class="text-left">{{__('Description')}}</th>
								<th>{{__('ID')}}</th>
								<th>{{__('Price')}}</th>
								<th>{{__('Invoice')}}</th>
							</tr>
						</thead>
						@foreach($invoices as $invoice)
							<tr>
								<td>
									{{\Carbon\Carbon::parse($invoice->created_at)->toFormattedDateString()}}
								</td>
								<td>
									{{$invoice->description}} ({{$invoice->credits}})
								</td>
								<td class="text-center">
									Ger-{{str_pad($invoice->id,6,'0',STR_PAD_LEFT)}}
								</td>
								<td class="text-center">
									${{$invoice->paidAmount()}}
								</td>
								<td class="text-center">
									@if(!empty($invoice->file))
										<a href="{{$invoice->file}}" target=_blank class="text-dark"><i class="far fa-file-alt"></i></a>
									@else
										<small>{{trans('general.not_payed')}}</small>
									@endif
								</td>
							</tr>
						@endforeach
					</table>
					<div class="pagination text-dark dark">
						{{$invoices->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
