<div class="brandbook-block col-3 p-3">
    <div class="contents p-3">
        <div data-book-id="<?php echo e($brandbook->id); ?>" class="public-mark" style="position: absolute; z-index: 1; top: 16px;right: 36px; <?php echo e($brandbook->status!='public' ? 'display:none' : ''); ?>">
            <svg width="21" height="27" viewBox="0 0 21 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0.75 -2.25H20.2368V15.5066C20.2368 20.7039 15.8363 24.1976 10.5114 26.1939C4.68146 23.7217 0.75 20.71 0.75 15.5066V-2.25Z"
                    fill="white" stroke="black" stroke-width="1.5"/>
                <path
                    d="M9.94067 6.88454L8.68318 9.44975L5.8697 9.86243C5.36516 9.93605 5.16296 10.5619 5.52885 10.9203L7.56433 12.9159L7.0829 15.7349C6.99625 16.2444 7.52967 16.6261 7.97644 16.3878L10.4934 15.0568L13.0103 16.3878C13.457 16.6242 13.9905 16.2444 13.9038 15.7349L13.4224 12.9159L15.4579 10.9203C15.8238 10.5619 15.6216 9.93605 15.117 9.86243L12.3035 9.44975L11.046 6.88454C10.8207 6.4273 10.1679 6.42149 9.94067 6.88454Z"
                    fill="#EE6636"/>
            </svg>
        </div>
        <a class="image" data-href="<?php echo e((\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id); ?>"
           href="<?php echo e(($brandbook->completed>=20) ? (\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id : route('brandbook.my').'/resume/'.$brandbook->id); ?>"
           style="position: relative;background-image: url(<?php if($brandbook->finished()): ?><?php echo e((\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('pdf_preview', $brandbook) : $brandbook->logo_b64); ?><?php else: ?><?php echo e($brandbook->logo_b64); ?><?php endif; ?>);
           <?php if($brandbook->finished() && \App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)): ?>padding-top: calc(100% + 1rem); margin: -1rem !important; margin-bottom: 0rem !important;background-size: cover;<?php endif; ?>">
            <?php if($brandbook->completed<20): ?>
            <span class="splash" style="    position: absolute;top: 0%;width: 100%;text-align: center;text-decoration: none;font-size: 24px;color: black;display: flex;justify-content: center;
    align-items: center;height: 100%;background: rgba(255, 255, 255, 0.75);
}
}">
                <?php echo e(__('In progress, Click to complete')); ?>

            </span>
            <?php endif; ?>
        </a>
        <div class="icons text-muted">
            <?php if(isset($brandbook->industry_level_1)): ?>
                <i data-toggle="tooltip" data-placement="top" title="<?php echo e($brandbook->industry_1->title); ?>"
                   class="fas fa-<?php echo e($brandbook->industry_1->icon); ?>"></i>
            <?php endif; ?>
            <?php if(isset($brandbook->industry_level_2)): ?>
                <i data-toggle="tooltip" data-placement="top" title="<?php echo e($brandbook->industry_2->title); ?>"
                   class="fas fa-<?php echo e($brandbook->industry_2->icon); ?>"></i>
            <?php endif; ?>
        </div>
        <div class="bottom-content d-flex justify-content-between">
            <div class="texts">
                <div class="title font-weight-boldic mt-2 <?php if($brandbook->user_id!=Auth::user()->id): ?> text-muted <?php endif; ?>">
                    <a data-href="<?php echo e((\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id); ?>"
                       href="<?php echo e(($brandbook->completed>=20) ? (\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id : route('brandbook.my').'/resume/'.$brandbook->id); ?>"><?php echo e($brandbook->brand ?: 'New Brandbook'); ?></a>
                </div>
                <?php if($brandbook->user_id == Auth::user()->id): ?>
                    <div class="last-updated small text-muted">
                        <a data-href="<?php echo e((\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id); ?>"
                           href="<?php echo e(($brandbook->completed>=20) ? (\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id : route('brandbook.my').'/resume/'.$brandbook->id); ?>"><?php echo e(__('Last updated')); ?> <?php echo e($brandbook->human_date()); ?></a>
                    </div>
                <?php else: ?>
                    <div class="last-updated small ">
                        <a data-href="<?php echo e((\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id); ?>"
                           href="<?php echo e(($brandbook->completed>=20) ? (\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)) ? route('brandbook.my').'/view/'.$brandbook->id : route('brandbook.my').'/view-new/'.$brandbook->id : route('brandbook.my').'/resume/'.$brandbook->id); ?>"><?php echo e(__('Handed ')); ?> <?php echo e($brandbook->human_date()); ?></a>
                    </div>
                <?php endif; ?>
                <?php if(!empty($brandbook->expires_at)): ?>
                    <div class="last-updated expires-at small d-flex align-items-center">
                        <svg width="16" height="18" class="mr-2" viewBox="0 0 16 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.1321 13.173L10.525 13.7707C10.3571 13.9359 10.0857 13.9359 9.91786 13.7707L8 11.8793L6.08214 13.7672C5.91429 13.9324 5.64286 13.9324 5.475 13.7672L4.86786 13.1695C4.7 13.0043 4.7 12.7371 4.86786 12.5719L6.78571 10.684L4.86786 8.79609C4.7 8.63086 4.7 8.36367 4.86786 8.19844L5.475 7.60078C5.64286 7.43555 5.91429 7.43555 6.08214 7.60078L8 9.48867L9.91786 7.60078C10.0857 7.43555 10.3571 7.43555 10.525 7.60078L11.1321 8.19844C11.3 8.36367 11.3 8.63086 11.1321 8.79609L9.21071 10.6875L11.1286 12.5754C11.3 12.7406 11.3 13.0078 11.1321 13.173ZM16 3.9375V16.3125C16 17.2441 15.2321 18 14.2857 18H1.71429C0.767857 18 0 17.2441 0 16.3125V3.9375C0 3.00586 0.767857 2.25 1.71429 2.25H3.42857V0.421875C3.42857 0.189844 3.62143 0 3.85714 0H5.28571C5.52143 0 5.71429 0.189844 5.71429 0.421875V2.25H10.2857V0.421875C10.2857 0.189844 10.4786 0 10.7143 0H12.1429C12.3786 0 12.5714 0.189844 12.5714 0.421875V2.25H14.2857C15.2321 2.25 16 3.00586 16 3.9375ZM14.2857 16.1016V5.625H1.71429V16.1016C1.71429 16.2176 1.81071 16.3125 1.92857 16.3125H14.0714C14.1893 16.3125 14.2857 16.2176 14.2857 16.1016Z"
                                fill="#A0A0A0"/>
                        </svg>
                        <strong <?php if(strtotime($brandbook->expires_at)-time()<60*60*24*7): ?><?php echo e('class=text-danger'); ?><?php endif; ?>>
                            <?php echo e(__('Expires:')); ?> <?php echo e($brandbook->expires_at->format('d.m.Y')); ?>

                        </strong>
                    </div>
                <?php endif; ?>
            </div>
            <?php if($brandbook->user_id != Auth::user()->id): ?>
                <img src="<?php echo e(url($brandbook->user->avatar)); ?>" class="mt-2 img-fluid rounded-circle"
                     style="width: 30px; height: 30px;border: 2px solid rgba(199, 199, 199, 0.85);opacity: .5" alt="">
            <?php endif; ?>
            <div class="dropup">
                <button class="btn btn-default pr-0 bg-transparent" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">



                    <?php if(Auth::user()->can_do('edit', $brandbook)): ?>
                        <?php if($brandbook->completed>=20): ?>
                            
                            <a class="dropdown-item edit-wizard" href="<?php echo e(route('brandbook.my')); ?>/wizard/<?php echo e($brandbook->id); ?>/">
                                <i class="fas fa-pencil-alt"></i> <?php echo e(__('Edit wizard')); ?></a>
                        <?php else: ?>
                            <a class="dropdown-item" href="<?php echo e(route('brandbook.my')); ?>/resume/<?php echo e($brandbook->id); ?>/"><i
                                    class="fas fa-pencil-alt"></i> <?php echo e(__('Edit wizard')); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($brandbook->completed>=20): ?>
                        <?php if(\App\BrandBookCreator\BrandBookHelper::isOldBrandBook($brandbook)): ?>
                            <a class="dropdown-item" href="<?php echo e(route('brandbook.my')); ?>/view/<?php echo e($brandbook->id); ?>/"><i
                                class="far fa-eye"></i> <?php echo e(__('View')); ?></a>
                        <?php else: ?>
                            <a class="dropdown-item" href="<?php echo e(route('brandbook.my')); ?>/view-new/<?php echo e($brandbook->id); ?>/"><i
                                    class="far fa-eye"></i> <?php echo e(__('View')); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(Auth::user()->can_do('duplicate', $brandbook)): ?>
                        <form action="<?php echo e(route('brandbook.duplicate', $brandbook->id)); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field('PUT')); ?>

                            <button class="dropdown-item" href="<?php echo e(route('brandbook.my')); ?>/duplicate/<?php echo e($brandbook->id); ?>">
                                <i class="far fa-copy"></i> <?php echo e(__('Duplicate')); ?></button>
                        </form>
                    <?php endif; ?>
                    <?php if(Auth::user()->can_do('delete', $brandbook)): ?>
                        <form action="<?php echo e(route('brandbook.delete', $brandbook->id)); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field('DELETE')); ?>

                            <button class="dropdown-item"><i class="far fa-trash-alt"></i> <?php echo e(__('Delete')); ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>
</div>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/parts/brandbookitem.blade.php ENDPATH**/ ?>