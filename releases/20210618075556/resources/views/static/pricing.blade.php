@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="font-weight-bold">{{__('Pricing')}}</h2>
                <div class="font-weight-bold">{{__('Choose your Favorite Sauce with simple pay-as-you-go pricing')}}</div>
            </div>
        </div>
        <div class="row mt-4 card-deck mb-5 pricing">
            <div class="card text-center">
                <div class="card-header" style="background: #DADADA">
                    <div class="font-weight-bold h3">Starter</div>
                    <div class="font-weight-bold">On the house</div>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center">
                    {{-- <div class="w-100" style="color: #DADADA">Starter</div> --}}
                    {{-- <div class="display-4 font-weight-bold w-100">On the house</div> --}}
                    <div class="w-100 display-4">
                        Free
                    </div>
                    <div class="pricing_small w-100">
                        <strong>Unlimited</strong> Brand Books For A Personal View
                    </div>
                    <div class="mb-4">
                        <ul class="text-left">
                            <li class="font-weight-bold">Unlimited brand books for personal view only</li>
                            <li class="font-weight-bold">Editable by the owner only</li>
                            <li class="font-weight-bold">Available for 14 Days</li>
                            <li class="font-weight-bold">Brand books come with a watermark</li>
                        </ul>
                    </div>
                    {{--@if($package->title=='Free')
                        <button class="btn btn-outline-secondary align-self-end" data-toggle="modal" data-target="#signupModal">{{__('Try for Free')}}</button>
                    @else
                        <button class="btn align-self-end" style="background-color: {{$package->color}}; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Buy Now')}}</button>
                    @endif--}}
                </div>
            </div>
            <div class="card text-center">
                <div class="card-header" style="background: #29B473">
                    <div class="font-weight-bold h3">Professional</div>
                    <div class="font-weight-bold">Spicy Wasabi</div>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center">
                    <div class="display-4 font-weight-bold w-100">$9/month</div>
                    <div class="w-100 font-weight-bold">
                        Billed Annually
                    </div>
                    <div class="pricing_small w-100">
                        <strong>5</strong> Brand Books A Month (60 A Year)
                    </div>
                    <div class="mb-4">
                        <ul class="text-left">
                            <li class="font-weight-bold">5 Free Brand books a month</li>
                            <li class="font-weight-bold">Available for 6 Month (Renewable)</li>
                            <li class="font-weight-bold">Share with multiple external editors</li>
                            <li class="font-weight-bold">Share with unlimited free viewers</li>
                            <li class="font-weight-bold">Download a PDF version</li>
                            <li class="font-weight-bold">Download brand assets</li>
                            <li class="font-weight-bold">Email support</li>
                        </ul>
                    </div>
                    <button class="btn align-self-end" style="background-color: #29B473; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Get Started')}}</button>
                    {{--@if($package->title=='Free')
                        <button class="btn btn-outline-secondary align-self-end" data-toggle="modal" data-target="#signupModal">{{__('Try for Free')}}</button>
                    @else
                        <button class="btn align-self-end" style="background-color: {{$package->color}}; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Buy Now')}}</button>
                    @endif--}}
                </div>
            </div>
            <div class="card text-center">
                <div class="card-header" style="background: #EE6636">
                    <div class="font-weight-bold h3">Agency</div>
                    <div class="font-weight-bold">Hot Chilli</div>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center">
                    <div class="display-4 font-weight-bold w-100">$29/month</div>
                    <div class="w-100 font-weight-bold">
                        Billed Annually
                    </div>
                    <div class="pricing_small w-100">
                        <strong>30</strong> Brand Books A Month (360 A Year)
                    </div>
                    <div class="mb-4">
                        <ul class="text-left">
                            <li class="font-weight-bold">30 Free Brand books a month</li>
                            <li class="font-weight-bold">Available for 12 Month (Renewable)</li>
                            <li class="font-weight-bold">Share with multiple external editors</li>
                            <li class="font-weight-bold">Share with unlimited free viewers</li>
                            <li class="font-weight-bold">Download a PDF version</li>
                            <li class="font-weight-bold">Download brand assets</li>
                            <li class="font-weight-bold">Email support</li>
                        </ul>
                    </div>
                    <button class="btn align-self-end" style="background-color: #EE6636; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Get Started')}}</button>
                    {{--@if($package->title=='Free')
                        <button class="btn btn-outline-secondary align-self-end" data-toggle="modal" data-target="#signupModal">{{__('Try for Free')}}</button>
                    @else
                        <button class="btn align-self-end" style="background-color: {{$package->color}}; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Buy Now')}}</button>
                    @endif--}}
                </div>
            </div>
            <div class="card text-center">
                <div class="card-header" style="background: #FFD459">
                    <div class="font-weight-bold h3">Brand Manager</div>
                    <div class="font-weight-bold">Sweet Soy</div>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center">
                    <div class="display-4 font-weight-bold w-100">$129</div>
                    <div class="w-100 font-weight-bold">
                        (one time purchase)
                    </div>
                    <div class="pricing_small w-100">
                        <strong>1</strong> Brand Book
                    </div>
                    <div class="mb-4">
                        <ul class="text-left">
                            <li class="font-weight-bold">1 official Brand book</li>
                            <li class="font-weight-bold">Available for 1 year (Renewable)</li>
                            <li class="font-weight-bold">Share with multiple external editors</li>
                            <li class="font-weight-bold">Share with unlimited free viewers</li>
                            <li class="font-weight-bold">Download a PDF version</li>
                            <li class="font-weight-bold">Download brand assets</li>
                            <li class="font-weight-bold">Personal assistance</li>
                        </ul>
                    </div>
                    <button class="btn align-self-end" style="background-color: #FFD459; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Get Started')}}</button>
                    {{--@if($package->title=='Free')
                        <button class="btn btn-outline-secondary align-self-end" data-toggle="modal" data-target="#signupModal">{{__('Try for Free')}}</button>
                    @else
                        <button class="btn align-self-end" style="background-color: {{$package->color}}; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Buy Now')}}</button>
                    @endif--}}
                </div>
            </div>
            <div class="card text-center">
                <div class="card-header" style="background: #fff">
                    <div class="font-weight-bold h3">Our Specials</div>
                    {{-- <div class="font-weight-bold">Sweet Soy</div> --}}
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center">
                    <div class="display-4 font-weight-bold w-100">Add your ingredients</div>
                    <div class="w-100 font-weight-bold">
                        Need A Specific Plan Tailored To Your Needs?
                    </div>
                    <div class="pricing_small w-100">
                        <p>Contact Us, And Directly Describe Your Requirements To The Team.</p>

                        <p>Large Agency? Let’s Add More Creatable Brand Books.</p>

                        <p>Medium-Sized Company? We’ll Figure Out Something In Between.</p>

                        <p class="font-weight-bold">We Will Be Happy To Create One That Suits You Best. </p>
                    </div>
                    <div class="mb-4 d-none">
                        <ul class="text-left">
                            <li class="font-weight-bold">1 official Brand book</li>
                            <li class="font-weight-bold">Available for 1 year (Renewable)</li>
                            <li class="font-weight-bold">Share with multiple external editors</li>
                            <li class="font-weight-bold">Share with unlimited free viewers</li>
                            <li class="font-weight-bold">Download a PDF version</li>
                            <li class="font-weight-bold">Download brand assets</li>
                            <li class="font-weight-bold">Personal assistance</li>
                        </ul>
                    </div>
                    <button class="btn align-self-end" style="background-color: #000; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Contact Us')}}</button>
                    {{--@if($package->title=='Free')
                        <button class="btn btn-outline-secondary align-self-end" data-toggle="modal" data-target="#signupModal">{{__('Try for Free')}}</button>
                    @else
                        <button class="btn align-self-end" style="background-color: {{$package->color}}; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Buy Now')}}</button>
                    @endif--}}
                </div>
            </div>
            {{-- <div class="col-3 "> --}}
            {{--@foreach($packages as $package)
                <div class="card text-center">
                    <div class="card-header" style="background: {{$package->color}}">
                        <div class="font-weight-bold">{{$package->name}}</div>
                    </div>
                    <div class="card-body d-flex flex-wrap justify-content-center">
                        <div class="w-100" style="color: {{$package->color}}">{{$package->upper_title}}</div>
                        <div class="display-4 font-weight-bold w-100">{{$package->title}}</div>
                        <div class="w-100">
                            @if($package->title=='Free')
                                {{__('Try')}} <strong>{{$package->credits}}</strong> {{__('Brand Book for Free')}}
                            @else
                                <strong>{{$package->credits}}</strong> {{__('Brand')}} {{Str::plural('Book', $package->credits)}}
                            @endif
                        </div>
                        <div class="pricing_small">
                            {{$package->lower_title}}
                        </div>
                        <div class="mb-4">
                            <ul class="text-left">
                                {!!$package->description!!}
                            </ul>
                        </div>
                        @if($package->title=='Free')
                            <button class="btn btn-outline-secondary align-self-end" data-toggle="modal" data-target="#signupModal">{{__('Try for Free')}}</button>
                        @else
                            <button class="btn align-self-end" style="background-color: {{$package->color}}; color: #fff;" data-toggle="modal" data-target="#signupModal">{{__('Buy Now')}}</button>
                        @endif
                    </div>
                </div>
            @endforeach--}}
        </div>
        <div class="text-center mb-4">
            <a href="{{route('features')}}" class="text-danger h4">{{__('See All Features')}}</a>
        </div>
        <div class="text-center mb-5">
            <div class="lobster">{{__('Spice Up Your Brand')}}</div>
        </div>
    </div>
@endsection