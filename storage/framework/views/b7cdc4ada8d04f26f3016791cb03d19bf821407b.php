<?php $__env->startSection('content'); ?>
    <?php
        $user = Auth::user();
    ?>
    <div class="container-fluid" style="height: calc(100vh - 50px);overflow: auto;">
        <div class="row" id="my-brandbooks">
            <?php echo $__env->make('parts.aside.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-9 px-5 margined">
                <div class="row pt-5 pb-2">
                    <div class="col-4"><h1><?php echo e(__('My Brandbooks')); ?></h1></div>
                    <div class="col-4 col-md-5 col-lh-6 d-none d-md-block">
                        <a href="<?php echo e(route('brandbook.my')); ?>"
                        class="btn <?php echo e('btn-'); ?><?php if(!empty($draft_filter)): ?><?php echo e('outline-'); ?><?php endif; ?><?php echo e('secondary'); ?> font-weight-bold py-0 px-4"
                        style="border-radius: 30px;border-width: 2px;">
                            <?php echo e(__('All')); ?></a>
                        <a href="<?php echo e(route('brandbook.my')); ?>?draft_filter=draft"
                        class="btn <?php echo e('btn-'); ?><?php if(empty($draft_filter) || $draft_filter!='draft'): ?><?php echo e('outline-'); ?><?php endif; ?><?php echo e('secondary'); ?> font-weight-bold  py-0 px-4"
                        style="border-radius: 30px; border-width: 2px;">
                            <?php echo e(__('Draft')); ?>

                        </a>
                        <a href="<?php echo e(route('brandbook.my')); ?>?draft_filter=official"
                        class="btn <?php echo e('btn-'); ?><?php if(empty($draft_filter) || $draft_filter!='official'): ?><?php echo e('outline-'); ?><?php endif; ?><?php echo e('secondary'); ?> font-weight-bold  py-0 px-4"
                        style="border-radius: 30px; border-width: 2px;">
                            <?php echo e(__('Official')); ?></a>
                    </div>
                    <div class="col-4 col-md-3 col-lg-2 d-flex justify-content-end">
                        <div class="dropdown mr-3 d-none">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if(isset($filter)): ?>
                                    <?php echo e(__('Filter by')); ?>:
                                    <?php switch($filter):
                                        case ('open'): ?>
                                        <?php echo e(__('Open project')); ?>

                                        <?php break; ?>
                                        <?php case ('finished'): ?>
                                        <?php echo e(__('Finished')); ?>

                                        <?php break; ?>
                                        <?php case ('private'): ?>
                                        <?php echo e(__('Private')); ?>

                                        <?php break; ?>
                                        <?php case ('public'): ?>
                                        <?php echo e(__('Public')); ?>

                                        <?php break; ?>
                                        <?php case ('company'): ?>
                                        <?php echo e(__('Company')); ?>

                                        <?php break; ?>
                                        <?php case ('product'): ?>
                                        <?php echo e(__('Product')); ?>

                                        <?php break; ?>
                                        <?php case ('new'): ?>
                                        <?php echo e(__('New Brand')); ?>

                                        <?php break; ?>
                                        <?php case ('rebrand'): ?>
                                        <?php echo e(__('Rebrand')); ?>

                                        <?php break; ?>
                                    <?php endswitch; ?>
                                <?php else: ?>
                                    <?php echo e(__('Filter by')); ?>

                                <?php endif; ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right bg-danger-"
                                aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'open'])); ?>"><?php echo e(__('Open project')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'finished'])); ?>"><?php echo e(__('Finished')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'private'])); ?>"><?php echo e(__('Private')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'public'])); ?>"><?php echo e(__('Public')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'company'])); ?>"><?php echo e(__('Company')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'product'])); ?>"><?php echo e(__('Product')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'new'])); ?>"><?php echo e(__('New Brand')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['filter'=>'rebrand'])); ?>"><?php echo e(__('Rebrand')); ?></a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if(isset($sort)): ?>
                                    <?php switch($sort):
                                        case ('name'): ?>
                                        <?php echo e(__('Name')); ?>

                                        <?php break; ?>
                                        <?php case ('updated'): ?>
                                        <?php echo e(__('Last updated')); ?>

                                        <?php break; ?>
                                        
                                        
                                        
                                    <?php endswitch; ?>
                                <?php else: ?>
                                    <?php echo e(__('Last updated')); ?>

                                <?php endif; ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right bg-danger-"
                                aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['sort'=>'name'])); ?>"><?php echo e(__('Name')); ?></a>
                                <a class="dropdown-item text-white-"
                                href="<?php echo e(request()->fullUrlWithQuery(['sort'=>'updated'])); ?>"><?php echo e(__('Last updated')); ?></a>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php $__currentLoopData = $brandbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('parts.brandbookitem', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="d-flex justify-content-center">
                    <div id="bb-pagnation-container" class="pagination">
                        <?php echo e($brandbooks->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-confirm-wizard">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0"><?php echo e(trans('general.are_you_sure')); ?></div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal"><?php echo e(trans('general.cancel')); ?></button>
                    <a type="button" class="btn btn-danger btn-confirm"><?php echo e(trans('general.yes_edit')); ?></a>
                </div>
            </div>
        </div>
    </div>

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
                            class="btn btn-outline-secondary btn-block feedback-modal"><?php echo e(trans('general.not_yet')); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-confirm-share">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="#" data-dismiss="modal" style="z-index:10">
                        <svg class="closeIcon" width="49" height="49" viewBox="0 0 49 49" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.1837 12.2347L36.9573 37.2595M36.2768 12.8601L13.1837 36.6341" stroke="black"
                                stroke-width="3"/>
                        </svg>
                    </a>
                    <h1><?php echo e(trans('general.share_header')); ?></h1>
                </div>
                <div class="modal-body"><?php echo e(trans('general.promoting_this_will_cost')); ?></div>
                <input type="hidden" id="id"/>
                <div class="modal-footer border-top-0">
                    <a type="button" class="btn btn-danger" id="confirm-share"><?php echo e(trans('general.yes')); ?></a>
                    <button type="button" class="btn btn-outline-secondary feedback-modal"><?php echo e(trans('general.not_yet')); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('brandbook.modal.modal_feedback', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('brandbook.modal.share_book', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('billing.buy_plan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('billing.choose_plan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>





<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/detect-mobile-browser@5.0.0/detect-browser.min.js"></script>
    <script>
        window.onload = () => {
            if ( SmartPhone.isAny() ) {
                document.querySelectorAll( '.brandbook-block a' ).forEach( item => {
                    item.addEventListener( 'click', ( e ) => {
                        e.preventDefault();
                        window.location = item.dataset[ 'href' ];
                    } );
                } );
            }
            <?php if(Session::has('message')): ?>
            new Noty( {
                          type   : 'success',
                          text   : '<?php echo e(Session::get('message')); ?>',
                          timeout: 5000,
                      } ).show();
            <?php endif; ?>
        };
    </script>
    <link rel="stylesheet" href="<?php echo e(url("/js/chromoselector/src/chromoselector.css")); ?>">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/brandbook/my.blade.php ENDPATH**/ ?>