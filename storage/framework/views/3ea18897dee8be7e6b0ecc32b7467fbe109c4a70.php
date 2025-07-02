<div class="modal" id="modal-feedback">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0"><?php echo e(trans('general.provide_your_feedback')); ?></div>
            <div class="subheader"><?php echo e(trans('general.feedback_subheader')); ?></div>
            <form method="POST" action="<?php echo e(route('store_feedback')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <textarea class="form-control" rows="10" name="feedback" required="required"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><?php echo e(trans('general.submit')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/brandbook/modal/modal_feedback.blade.php ENDPATH**/ ?>