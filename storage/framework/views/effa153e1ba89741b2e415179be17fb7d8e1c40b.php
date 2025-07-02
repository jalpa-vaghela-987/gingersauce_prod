<?php if(isset($packages)): ?>
    <div class="modal" id="modal-buy-plan" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1000px">
            <div class="modal-content rounded-2" style="padding: 50px; text-align: center">
                <h1 style="font-weight:700;font-size:32px;">
                    <?php echo e(trans('general.buy_plan')); ?>

                </h1>
                <button type="button" class="close" id="close-packages-modal"  data-dismiss="modal" aria-label="Close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 0;padding: 30px;top: 0;">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="switch-block my-3 d-flex justify-content-center">
                    <p><?php echo e(trans('general.modal_buy_plan_message')); ?></p>
                </div>
                <modal-packages action="<?php echo e(route('invoice.create')); ?>" :has_package="<?php echo e(json_encode($user->package !== null)); ?>"></modal-packages>
                <div class="modal-footer justify-content-center" style="border-top: none;">
                    <button type="button"
                            class="btn btn-outline-secondary feedback-modal"
                            data-dismiss="modal" aria-label="Close"
                            style="padding: 10px 50px;"><?php echo e(trans('general.not_yet')); ?></button>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/billing/buy_plan.blade.php ENDPATH**/ ?>