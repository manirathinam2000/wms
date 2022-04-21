<?php $__env->startSection('content'); ?>
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Location</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Location</li>
                  <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content content-full content-boxed">
          <!-- New Post -->
          <form action="<?php echo e(route('locations.update')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="<?php echo e(route('locations.index')); ?>">
                  <i class="fa fa-arrow-left me-1"></i> Manage Locations
                </a>
                
              </div>
              <?php echo $__env->make('shared.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder="Enter a Location Name.." value="<?php echo e($data->id); ?>">
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="location_name">Location Name</label>
                      <input type="text" class="form-control" id="location_name" name="location_name" placeholder="Enter a Location Name.." value="<?php echo e($data->location_name); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="address1">Address 1</label>
                      <input type="text" class="form-control" id="address1" name="address1" placeholder="Enter a Address 1.." value="<?php echo e($data->address1); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="address2">Address 2</label>
                      <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter a Address 2.." value="<?php echo e($data->address2); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="city">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="Enter a City.." value="<?php echo e($data->city); ?>" >
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="country">Country</label>
                      <select class="form-select" id="country" name="country">
                        <option>select country</option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php
                            $selected = '';
                            if($country->id == $data->country)
                            $selected = 'selected'
                          ?>
                          <option value="<?php echo e($country->id); ?>" <?php echo e($selected); ?>><?php echo e($country->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="contact_person">Contact Person</label>
                      <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter a Contact Person.." value="<?php echo e($data->contact_person); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="mobile">Mobile</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter a Mobile.." value="<?php echo e($data->mobile); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter a Email.." value="<?php echo e($data->email); ?>">
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/location/edit.blade.php ENDPATH**/ ?>