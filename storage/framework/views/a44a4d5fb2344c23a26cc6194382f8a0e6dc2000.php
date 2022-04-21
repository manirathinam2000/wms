<?php $__env->startSection('content'); ?>
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Service</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Service</li>
                  <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content content-full content-boxed">
          <!-- New Post -->
          <form action="<?php echo e(route('service.update')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
            <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" value="<?php echo e($data->id); ?>">
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="<?php echo e(route('service.index')); ?>">
                  <i class="fa fa-arrow-left me-1"></i> Manage Service
                </a>
                
              </div>
              <?php echo $__env->make('shared.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="service_name">Service Name</label>
                      <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Enter a Service name.." value="<?php echo e($data->service_name); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="service_category_id">Category</label>
                      <select class="form-select" id="service_category_id" name="service_category_id">
                        <option>select category</option>
                        <?php $__currentLoopData = $service_categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $selected = '';
                            if($category->id == $data->service_category_id)
                            $selected = 'selected'
                          ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e($selected); ?>><?php echo e($category->service_category_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                    <?php
                            $checked = '';
                            if($data->is_active == 1)
                              $checked = 'checked'
                          ?>
                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" <?php echo e($checked); ?>>
                    <label class="form-check-label" for="dm-post-add-active">Set active</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-fw fa-check opacity-50 me-1"></i> Edit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <!-- END New Post -->
        </div>
        <script src="<?php echo e(asset('assets/js/dashmix.app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/service/edit.blade.php ENDPATH**/ ?>