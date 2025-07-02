<footer class="app-footer">
    <div class="site-footer-right">
        <?php echo __('voyager::theme.footer_copyright'); ?> <a href="https://dodel.co?utm_source=gingersauce.system" target="_blank">dodel</a>
        <?php $version = Voyager::getVersion(); ?>
        <?php if(!empty($version)): ?>
            - <?php echo e($version); ?>

        <?php endif; ?>
    </div>
</footer>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/vendor/voyager/partials/app-footer.blade.php ENDPATH**/ ?>