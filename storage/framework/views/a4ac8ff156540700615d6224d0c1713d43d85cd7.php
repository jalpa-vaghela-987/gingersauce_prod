<?php $__env->startSection('content'); ?>
<?php
    $user = Auth::user();
?>
<router-view></router-view>
<?php if($user): ?>
    <?php echo $__env->make('billing.buy_plan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('billing.choose_plan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('brandbook.modal.confirmRemoveWatermarkModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('brandbook.modal.modal_feedback', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('brandbook.modal.share_book', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<script>
    window.user = <?php echo json_encode(base64_encode($user), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.vueApp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/brandbook/myVue.blade.php ENDPATH**/ ?>