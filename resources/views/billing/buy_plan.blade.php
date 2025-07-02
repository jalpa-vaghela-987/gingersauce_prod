@isset($packages)
    <div class="modal" id="modal-buy-plan" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1000px">
            <div class="modal-content rounded-2" style="padding: 26px; text-align: center">
                <h1 style="font-weight:700;font-size:32px;">
                    {{trans('general.upgrade_to_paid_plan')}}
                </h1>
                <button type="button" class="close" id="close-packages-modal"  data-dismiss="modal" aria-label="Close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 0;padding: 30px;top: 0;">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="d-flex flex-row">
                    <div class="col-2"></div>
                    <div class="col-8 switch-block my-3 d-flex justify-content-center px-5">
                        <p>{{trans('general.upgrade_plan_description')}}</p>
                    </div>
                    <div class="col-2"></div>
                </div>
                <modal-packages action="{{route('invoice.create')}}" :has_package="{{json_encode($user->package !== null)}}" :package="{{json_encode($user->package?$user->package->id:0)}}"></modal-packages>
                <div class="modal-footer justify-content-center" style="border-top: none;">
                    <button type="button"
                            class="btn btn-outline-secondary feedback-modal"
                            data-dismiss="modal" aria-label="Close"
                            style="padding: 10px 50px;">{{trans('general.not_yet')}}</button>
                </div>

            </div>
        </div>
    </div>
@endisset