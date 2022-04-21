<?php $__env->startSection('content'); ?>
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Employee</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Employee</li>
                  <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content content-full content-boxed">
          <!-- New Post -->
          <form action="<?php echo e(route('employee.store')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="<?php echo e(route('employee.index')); ?>">
                  <i class="fa fa-arrow-left me-1"></i> Manage employees
                </a>
                
              </div>
              <?php echo $__env->make('shared.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="employee_id">Employee ID</label>
                      <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Enter employee ID.." value="<?php echo e(old('employee_id')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="employee_name">Employee Name</label>
                      <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Enter employee Name.." value="<?php echo e(old('employee_name')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="category_id">category</label>
                      <select class="form-select" id="category_id" name="category_id">
                        <option selected>select category</option>
                        <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->employee_category_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="shift_start_time">Shift Start Time</label>
                      <input type="text" class="form-control" id="shift_start_time" name="shift_start_time" placeholder="Enter a shift start time.." value="<?php echo e(old('shift_start_time')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="shift_end_time">Shift End Time</label>
                      <input type="text" class="form-control" id="shift_end_time" name="shift_end_time" placeholder="Enter a shift end time.." value="<?php echo e(old('shift_end_time')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="nationality">Nationality</label>
                      <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Enter a nationality.." value="<?php echo e(old('nationality')); ?>" >
                    </div>
                    
                    <div class="mb-4">
                      <label class="form-label" for="doj">Date of Joining</label>
                      <input type="text" class="form-control" id="doj" name="doj" placeholder="Enter date of joining.." value="<?php echo e(old('doj')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="basic">Basic</label>
                      <input type="text" class="form-control" id="basic" name="basic" placeholder="Enter a basic.." value="<?php echo e(old('basic')); ?>">
                    </div>
                    <div class="mb-4">
                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                    <label class="form-check-label" for="dm-post-add-active">Set active</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-fw fa-check opacity-50 me-1"></i> Create
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/employee/create.blade.php ENDPATH**/ ?>