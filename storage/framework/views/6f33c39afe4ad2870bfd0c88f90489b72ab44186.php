<div class="modal" id="modal-confirm-download">
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header">
                    <a href="#" data-dismiss="modal" style="z-index:10">
                        <svg id="closeIcon" width="49" height="49" viewBox="0 0 49 49" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.1837 12.2347L36.9573 37.2595M36.2768 12.8601L13.1837 36.6341" stroke="black"
                                  stroke-width="3"/>
                        </svg>
                    </a>
                    <h1>
                        <?php echo e(trans('general.remove_watermark')); ?>

                    </h1>
                </div>
                <div class="modal-body">
                    <?php echo e(trans('general.remove_wm_message')); ?>

                </div>
                <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-danger btn-confirm btn-block" id="confirm-download">
                        <?php echo e(trans('general.yes')); ?>

                    </a>
                    <button type="button"
                            class="btn btn-outline-secondary btn-block feedback-modal not-remove-watermark"><?php echo e(trans('general.not_yet')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/brandbook/modal/confirmRemoveWatermarkModal.blade.php ENDPATH**/ ?>