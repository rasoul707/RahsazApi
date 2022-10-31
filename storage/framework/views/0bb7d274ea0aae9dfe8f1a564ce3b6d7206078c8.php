<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('coupon.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('coupon::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/zl50/rahsaz/Modules/Coupon/Resources/views/index.blade.php ENDPATH**/ ?>