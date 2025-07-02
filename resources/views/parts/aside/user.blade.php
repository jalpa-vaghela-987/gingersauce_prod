<div id="aside" class="col-2 py-5 pr-0" style="padding-left: 0px;padding-top: 123px !important;position: relative;">
	<div class="add-new-block brandbook-block mx-0 p-3 bg-danger d-none rounded-16" style="right: 0;position: absolute;">
		@if(Auth::user()->credits()>0)
		<a href="{{route('brandbook.my')}}/new" id="createNew" onclick="checkFirst(this)">
			<div class="content border-0 py-5">
				<div class="plus text-white">+</div>
				<div class="text text-white text-center">
					{{__('Create New Brandbook')}}
				</div>
			</div>
		</a>
		@else
    <a href="{{route('brandbook.my')}}/new" id="createNew" onclick="checkFirst(this)">
			<div class="content py-5 border-0">
				<div class="plus text-white">+</div>
				<div class="text text-white text-center">
					{{__('Create New Brandbook')}}
				</div>
			</div>
		</a>
		@endif
	</div>
	<div class="mt-0 text-center d-none" style="position: absolute; right: 0px; width: 293.625px; top: 420.625px; left: 24.703px;">
		<div class="p-3 d-block">
			<i class="need-help-text">@lang('general.need_help')</i>
			<a class="btn btn-outline-danger w-100 mt-2" target="_blank" href="https://gingersauce.co/how-to-use-gingersauce-create-a-brand-book-online/">{{trans('general.ginger_guide')}}</a>
		</div>
		<?php /*<div class="mt-2"><small>
                {{trans('general.or_talk')}}
		</small></div>*/ ?>
	</div>
</div>

@section('scripts')
<script>
	window.onload = () => {
		if("{{$limit_reached}}" == true && "{{$new_page}}" == true){
			showBuyPopup();
		}
	}
	function checkFirst(el){
		let e	=	window.event;
		if("{{$limit_reached}}" == true){
            e.preventDefault();
			showBuyPopup();
		}
	}
	function showBuyPopup() {
		const modalElem = document.getElementById('modal-buy-plan');
			const modal = new window.bootstrap.Modal(modalElem, {
				backdrop: 'static',
				keyboard: false
			});
			modalElem.addEventListener('shown.bs.modal', () => {
					modalElem.focus();
			});
			modal.show();
	}
</script>
@endsection
