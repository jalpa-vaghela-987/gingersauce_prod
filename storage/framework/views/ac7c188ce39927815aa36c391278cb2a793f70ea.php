<div id="aside" class="col-3 py-5 pr-0" style="padding-left: 50px;padding-top: 123px !important;position: relative;">
	<div class="add-new-block brandbook-block mx-0 p-3 bg-danger d-none" style="right: 0;position: absolute;">
		<?php if(Auth::user()->credits()>0): ?>
		<a href="<?php echo e(route('brandbook.my')); ?>/new">
			<div class="content border-0 py-5">
				<div class="plus text-white">+</div>
				<div class="text text-white">
					<?php echo e(__('Create New Brandbook')); ?>

				</div>
			</div>
		</a>
		<?php else: ?>
            <a href="<?php echo e(route('brandbook.my')); ?>/new">
			<div class="content py-5 border-0">
				<div class="plus text-white">+</div>
				<div class="text text-white">
					<?php echo e(__('Create New Brandbook')); ?>

				</div>
			</div>
		</a>
		<?php endif; ?>
	</div>
	<div class="mt-3 text-center d-none" style="position: absolute; right: 0;">
		<div><i><?php echo app('translator')->get('general.need_help'); ?></i></div>
		<a class="btn btn-outline-danger" href="https://gingersauce.co/how-to-use-gingersauce-create-a-brand-book-online/"><?php echo e(trans('general.ginger_guide')); ?></a>
		<div class="mt-2"><small>
                <?php echo e(trans('general.or_talk')); ?>

		</small></div>
	</div>
</div>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/parts/aside/user.blade.php ENDPATH**/ ?>