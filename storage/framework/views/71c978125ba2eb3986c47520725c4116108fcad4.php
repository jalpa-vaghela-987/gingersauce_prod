<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('auth.modal-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        function renderCaptcha() {
            console.log("loading login..")
            if (typeof grecaptcha !== 'undefined') {
                try {
                    grecaptcha.render('recaptcha-signin', {
                        'sitekey': '<?php echo e(config('services.captcha.sitekey')); ?>' // Ensure you use your site key here
                    });
                }catch (error) {
                    console.log(error);
                    grecaptcha.reset();
                }
            } else {
                console.warn("grecaptcha not available, retrying...");

                // If grecaptcha is not yet loaded, check again after some time
                setTimeout(renderCaptcha, 1000); // Check every 500 milliseconds
            }
        }
        window.onload = function () {
            renderCaptcha();
        };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.signupin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/auth/login.blade.php ENDPATH**/ ?>