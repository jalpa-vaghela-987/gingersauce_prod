<div id="profile-sidebar">
    <div class="my-acc-header">{{trans('profile.my_profile')}}</div>
    <div class="sidebar-menu">
        <a href="{{route('profile.my')}}"><i class="fa fa-user" aria-hidden="true"></i>@lang('profile.my_profile')</a>
        <a href="{{route('profile.plans')}}"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('profile.my_plans')</a>
        <a href="{{route('billing.index')}}"><i class="fa fa-credit-card" aria-hidden="true"></i>@lang('profile.billing')</a>
        <a href="{{route('invoice.index')}}"><i class="fa fa-history" aria-hidden="true"></i>@lang('profile.purchase_history')</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out-alt" aria-hidden="true"></i>
            @lang('profile.logout')
        </a>
    </div>
</div>
