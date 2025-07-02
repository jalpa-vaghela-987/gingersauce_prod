<div class="d-block tabule">
    <div class="modal-subtitle text-center mb-4">
        <div><?php echo e(__('Create an account. its free.')); ?></div>
        <div><?php echo e(__('Built by designers, For Designers.')); ?></div>

    </div>
<!--    <div class="text-center mb-4">
        <a class="btn btn-outline-secondary d-flex align-items-center" onClick="window.open(
                '<?php echo e(route('social.redirect', 'facebook')); ?>',
                'fb-window',
                'menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=600,height=600,left='+((window.innerWidth/2)-400)
            );"
           href="#">
            <img src="<?php echo e(url('/images/facebook-icon.png')); ?>" alt="Facebook" style="justify-self: start">
            <span style="text-align: center; display: block; flex-basis: 100%;"><?php echo e(__('Sign up with')); ?> Facebook</span>
        </a>
    </div>-->
    <div class="text-center mb-4">
        <a class="btn btn-outline-secondary d-flex align-items-center" onClick="window.open(
                '<?php echo e(route('social.redirect', 'google')); ?>',
                'fb-window',
                'menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=600,height=600,left='+((window.innerWidth/2)-400)
            );"
           href="#">
            <img src="<?php echo e(url('/images/google-icon.png')); ?>" alt="Google"  style="justify-self: start">
            <span style="text-align: center; display: block; flex-basis: 100%;"><?php echo e(__('Sign up with')); ?> Google</span>
        </a>
    </div>
    <div class="separator">
        <span><?php echo e(__('or')); ?></span>
    </div>
    <button class="btn btn-danger d-flex justify-content-center align-content-center w-100 login-signup-switch-button"><?php echo e(__('Sign up with email')); ?></button>
    <div class="footer-form text-center mt-3">
        <?php echo e(__('By signing up, you agree to Gingersauce’s Terms of use and Privacy Policy')); ?>

    </div>
    <div class="text-center mt-2">
        Already a user? <a href="<?php echo e(route('login')); ?>">Log in here.</a>
    </div>
</div>
<div class="d-none tabule">
    <h3 class="back-arrow"><?php echo e(__('Create your account')); ?></h3>
    <div class="subtext">
        <?php echo e(__('It will just take a sec')); ?>

    </div>
    <div class="login-form">
        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group mb-2">
                <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus placeholder="<?php echo e(__('Name')); ?>">

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group mb-2">
                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus placeholder="<?php echo e(__('E-Mail')); ?>">

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group mb-2">
                <input id="su_password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password" placeholder="<?php echo e(__('Password')); ?>">

                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group mb-2">
            	<progress id="password_progress" value="0" max="100"></progress>
            	<div>
            		<?php echo e(__('Use 8 or more chacters with a mix of letters, numbers & symbols.')); ?>

            	</div>
            </div>
            <input type="hidden" name="remember" value="1">

            <div class="form-group">
                <div class="recaptcha-container">
                    <div id="recaptcha-signup"></div>
                </div>
                <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert" style="display:block">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-danger w-100 d-block">
                    <?php echo e(__('Get started, it’s free!')); ?>

                </button>
            </div>
            <div class="footer-form text-center small">
            	By signing up, you agree to Gingersauce’s <a href="<?php echo e(route('terms-of-use')); ?>" class="text-danger" target="_blank">Terms of use</a> and <a href="<?php echo e(route('privacy-policy')); ?>" target="_blank" class="text-danger">Privacy Policy</a>.
				<br>Already signed up? <a href="<?php echo e(route('login')); ?>" class="text-danger">Log in</a>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/auth/modal-signup.blade.php ENDPATH**/ ?>