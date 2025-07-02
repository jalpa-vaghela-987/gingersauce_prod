<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="google-fonts-key" content="<?php echo e(config('services.google_fonts.key')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="preload" href="/img/ginger_icon_color_loader.svg" as="image">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <?php echo $__env->make('parts.google_tag_head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        let endpoints = {
            create_payment_method: "<?php echo e(route('billing.create')); ?>",
            form                 : {
                book_extend: "<?php echo e(route('invoice.create')); ?>",
            },
            ajax                 : {
                get : {
                    industries        : '<?php echo e(route('ajax.get.industries')); ?>',
                    industries_related: '<?php echo e(route('ajax.get.industries.related')); ?>',

                    themes: '<?php echo e(route('ajax.get.themes')); ?>',
                    theme : '<?php echo e(route('ajax.get.theme')); ?>',

                    extends         : '<?php echo e(route('profile.get_extends')); ?>',
                    upgrade_packages: '<?php echo e(route('upgrade_packages_get')); ?>',
                    tabs : '<?php echo e(url('my/tabs')); ?>',
                    new_view_page : '<?php echo e(url('my/new-view-page')); ?>',
                    header : {
                        'plans_pricing' : '<?php echo e(route('profile.plans-pricing')); ?>',
                        'profile' : '<?php echo e(route('profile.my')); ?>',
                        'plans' : '<?php echo e(route('profile.plans')); ?>',
                        'billing' : '<?php echo e(route('billing.index')); ?>',
                        'purchase_history' : '<?php echo e(route('invoice.index')); ?>',
                        'logout': '<?php echo e(route('logout')); ?>'
                    }
                },
                put: {
                    'edit_custom_field' : '<?php echo e(url('ajax/brandbook/edit-custom-field')); ?>'
                },
                post: {
                    upload_logo       : '<?php echo e(route('ajax.post.upload_logo')); ?>',
                    old_upload_logo   : '<?php echo e(route('ajax.post.old_upload_logo')); ?>',
                    upload_icon       : '<?php echo e(route('ajax.post.upload_icon')); ?>',
                    upload_font       : '<?php echo e(route('ajax.post.upload_font')); ?>',
                    upload_icon_adv   : '<?php echo e(route('ajax.post.upload_icon_adv')); ?>',
                    upload_mockup     : '<?php echo e(route('ajax.post.upload_mockup')); ?>',
                    upload_icon_family: '<?php echo e(route('ajax.post.upload_icon_family')); ?>',
                    upload_misuse     : '<?php echo e(route('ajax.post.upload_misuse')); ?>',
                    remove_watermark  : '<?php echo e(route('ajax.post.remove_watermark')); ?>',

                    referafriend       : '<?php echo e(route('ajax.post.referafriend')); ?>',
                    coupon             : '<?php echo e(route('ajax.post.coupon')); ?>',
                    load_user          : '<?php echo e(route('ajax.post.load_user')); ?>',
                    update_billing_info: '<?php echo e(route('billing.info_update')); ?>',
                    cc_card_save       : '<?php echo e(route('billing.store')); ?>',
                    toggle_reccuring   : "<?php echo e(route('profile.toggle_reccuting')); ?>",

                    colormind: '<?php echo e(route('ajax.post.colormind')); ?>',

                    brandbook: {
                        create       : '<?php echo e(route('ajax.post.brandbook.create')); ?>',
                        save         : '<?php echo e(route('ajax.post.brandbook.save')); ?>',
                        save_custom  : '<?php echo e(route('save_custom')); ?>',
                        saveSeparate : '<?php echo e(route('ajax.post.brandbook.saveSeparate')); ?>',
                        generate     : '<?php echo e(route('ajax.post.brandbook.generate_pdf')); ?>',
                        load         : '<?php echo e(route('ajax.post.brandbook.load')); ?>',
                        resume       : '<?php echo e(route('ajax.post.brandbook.resume')); ?>',
                        edit         : '<?php echo e(route('ajax.post.brandbook.edit')); ?>',
                        save_field   : '<?php echo e(route('ajax.post.brandbook.save_field')); ?>',
                        shares       : '<?php echo e(route('ajax.post.brandbook.shares')); ?>',
                        shares_add   : '<?php echo e(route('ajax.post.brandbook.shares_add')); ?>',
                        shares_edit  : '<?php echo e(route('ajax.post.brandbook.shares_edit')); ?>',
                        shares_delete: '<?php echo e(route('ajax.post.brandbook.shares_delete')); ?>',
                        shares_link  : '<?php echo e(route('ajax.post.brandbook.shares_link')); ?>',
                        shares_code  : '<?php echo e(route('ajax.post.brandbook.shares_code')); ?>',

                        list_item: '<?php echo e(route('ajax.post.brandbook.list_item')); ?>',
                        save_customize:"<?php echo e(route('ajax.post.brandbook.save_customize')); ?>",
                    },
                },
            },
        };
        let translations = {
            en: <?php echo File::get(base_path() . '/resources/lang/en.json'); ?>,
            ja: <?php echo File::get(base_path() . '/resources/lang/ja.json'); ?>

        };
    </script>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>?version=<?php echo e(config('app.release_hash')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Lobster|Montserrat:300,300i,400,400i,700,700i,900,900i&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>?version=<?php echo e(config('app.release_hash')); ?>" rel="stylesheet">

    <style type="text/css">
        .submenu:hover + .dropdown-menu {
            display: block;
        }
    </style>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</head>
<body class="<?php if(Auth::check()): ?> authed <?php endif; ?>">
<?php echo $__env->make('parts.google_tag_body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div id="app" style="height: 100%">
        <?php if(Auth::check()): ?>
            <?php echo $__env->make('parts.headers.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(!((\Request::segment(2) ===  "view-new" )&& (int)\Request::segment(3))): ?>
            <?php echo $__env->make('parts.headers.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <main style="height: 100%">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php echo $__env->yieldContent('modals'); ?>
    <already-have-subscription-modal></already-have-subscription-modal>

</div>


<div class="modal" tabindex="-1" role="dialog" id="loginModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <img src="<?php echo e(url('/images/ginger02.png')); ?>" class="logo">
            <div class="modal-body">
                <?php echo $__env->make('auth.modal-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="signupModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <img src="<?php echo e(url('/images/ginger02.png')); ?>" class="logo">
            <div class="modal-body">
                <?php echo $__env->make('auth.modal-signup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>


<?php echo $__env->yieldContent('scripts'); ?>
<style>
    .loading-main {
        background: url('/img/ginger_icon_color_loader.svg');
    }

    @media  screen and (max-width: 768px) {
        #username {
            max-width: 85px;
            border-left: 0;
        }
    }
</style>
<?php if(\Request::route()->getName() != 'profile.start'): ?>
    <div class="mobile-overlay">
        <p class="overlay-title">My Brandbooks</p>
        <div>
            <img src="/images/laptop-2-1.svg" alt="">
            <p class="mb7 overlay-bold-title">Aw Shucks!</p>
            <p class="mb7">Our mobile version<br> isn’t ready yet. </p>
            <p class="mb7">Please access gingersauce<br> with a desktop.</p>
        </div>
    </div>
<?php endif; ?>

<?php echo $__env->make('parts.tawkto_chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/layouts/vueApp.blade.php ENDPATH**/ ?>