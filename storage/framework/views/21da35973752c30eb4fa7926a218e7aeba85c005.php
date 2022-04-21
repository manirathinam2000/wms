<?php if($errors->any()): ?>
    <div class="alert alert-danger m-4 pb-1">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/shared/errors.blade.php ENDPATH**/ ?>