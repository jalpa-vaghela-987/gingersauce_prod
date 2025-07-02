<div class="modal" id="modal-feedback">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">{{trans('general.provide_your_feedback')}}</div>
            <div class="subheader">{{trans('general.feedback_subheader')}}</div>
            <form method="POST" action="{{route('store_feedback')}}">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" rows="10" name="feedback" required="required"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{trans('general.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>