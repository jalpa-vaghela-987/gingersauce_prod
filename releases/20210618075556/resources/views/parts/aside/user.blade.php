<div id="aside" class="col-3 py-5 pr-0" style="padding-left: 50px;padding-top: 123px !important;position: relative;">
	<div class="add-new-block brandbook-block mx-0 p-3 bg-danger d-none" style="right: 0;position: absolute;">
		@if(Auth::user()->credits()>0)
		<a href="{{route('brandbook.my')}}/new">
			<div class="content border-0 py-5">
				<div class="plus text-white">+</div>
				<div class="text text-white">
					{{__('Create New Brandbook')}}
				</div>
			</div>
		</a>
		@else
            <a href="{{route('brandbook.my')}}/new">
			<div class="content py-5 border-0">
				<div class="plus text-white">+</div>
				<div class="text text-white">
					{{__('Create New Brandbook')}}
				</div>
			</div>
		</a>
		@endif
	</div>
	<div class="mt-3 text-center d-none" style="position: absolute; right: 0;">
		<div><i>@lang('general.need_help')</i></div>
		<a class="btn btn-outline-danger" href="https://gingersauce.co/how-to-use-gingersauce-create-a-brand-book-online/">{{trans('general.ginger_guide')}}</a>
		<div class="mt-2"><small>
                {{trans('general.or_talk')}}
		</small></div>
	</div>
</div>
