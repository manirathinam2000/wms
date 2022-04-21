<?php $__env->startSection('content'); ?>
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Parts</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Parts</li>
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
          <form action="<?php echo e(route('part.store')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="<?php echo e(route('part.index')); ?>">
                  <i class="fa fa-arrow-left me-1"></i> Manage Parts
                </a>
                
              </div>
              <?php echo $__env->make('shared.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="part_name">Part Name</label>
                      <input type="text" class="form-control" id="part_name" name="part_name" placeholder="Enter Part Name.." value="<?php echo e(old('part_name')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="article_number">Article Number</label>
                      <input type="text" class="form-control" id="article_number" name="article_number" placeholder="Enter Article Number.." value="<?php echo e(old('article_number')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="oem_part_number">OEM Part Number</label>
                      <input type="text" class="form-control" id="oem_part_number" name="oem_part_number" placeholder="Enter a OEM Part Number.." value="<?php echo e(old('oem_part_number')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="part_description">Description</label>
                      <textarea class="form-control" id="part_description" name="part_description" rows="4" placeholder="Enter Description.."><?php echo e(old('part_description')); ?></textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="make">Make</label>
                      <input type="text" class="form-control" id="make" name="make" placeholder="Enter a Make.." value="<?php echo e(old('make')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="model">Model</label>
                      <input type="text" class="form-control" id="model" name="model" placeholder="Enter a model.." value="<?php echo e(old('model')); ?>" >
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="type_id">type</label>
                      <select class="form-select" id="type_id" name="type_id">
                        <option selected>select type</option>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->part_type_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="category_id">Category</label>
                      <select class="form-select" id="category_id" name="category_id">
                        <option selected>select category</option>
                        <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->part_category_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="uom_id">UOM</label>
                      <select class="form-select" id="uom_id" name="uom_id">
                        <option selected>select uom</option>
                        <?php $__currentLoopData = $uoms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($uom->id); ?>"><?php echo e($uom->uom); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="purchase_price">Purchase Price</label>
                      <input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="Enter Purchase Price.." value="<?php echo e(old('purchase_price')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="selling_price">Selling Price</label>
                      <input type="text" class="form-control" id="selling_price" name="selling_price" placeholder="Enter a Selling Price.." value="<?php echo e(old('selling_price')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="max_discount">Max Discount</label>
                      <input type="text" class="form-control" id="max_discount" name="max_discount" placeholder="Enter Max Discount.." value="<?php echo e(old('max_discount')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="reorder_level">Reorder Level</label>
                      <input type="text" class="form-control" id="reorder_level" name="reorder_level" placeholder="Enter Reorder Level.." value="<?php echo e(old('reorder_level')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="location_id">Location</label>
                      <select class="form-select" id="location_id" name="location_id">
                        <option selected>select location</option>
                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($location->id); ?>"><?php echo e($location->location_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>                    
                    <div class="mb-4">
                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                    <label class="form-check-label" for="dm-post-add-active">Set active</label>
                    </div>                    
                    <div class="mb-4">
                      <label class="form-label" for="column1">Column 1</label>
                      <input type="text" class="form-control" id="column1" name="column1" placeholder="Enter a value.." value="<?php echo e(old('column1')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column2">Column 2</label>
                      <input type="text" class="form-control" id="column2" name="column2" placeholder="Enter a value.." value="<?php echo e(old('column2')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column3">Column 3</label>
                      <input type="text" class="form-control" id="column3" name="column3" placeholder="Enter a value.." value="<?php echo e(old('column3')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column4">Column 4</label>
                      <input type="text" class="form-control" id="column4" name="column4" placeholder="Enter a value.." value="<?php echo e(old('column4')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column5">Column 5</label>
                      <input type="text" class="form-control" id="column5" name="column5" placeholder="Enter a value.." value="<?php echo e(old('column5')); ?>">
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/part/create.blade.php ENDPATH**/ ?>