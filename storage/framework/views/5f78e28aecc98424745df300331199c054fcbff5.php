<?php $__env->startSection('content'); ?>
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Vehicle</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Vehicle</li>
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
          <form action="<?php echo e(route('vehicle.store')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="<?php echo e(route('vehicle.index')); ?>">
                  <i class="fa fa-arrow-left me-1"></i> Manage Vehicles
                </a>
                
              </div>
              <?php echo $__env->make('shared.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="vehicle_registration_number">Vehicle Registration Number</label>
                      <input type="text" class="form-control" id="vehicle_registration_number" name="vehicle_registration_number" placeholder="Enter Vehicle Registration Number.." value="<?php echo e(old('vehicle_registration_number')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="sufix">Sufix</label>
                      <input type="text" class="form-control" id="sufix" name="sufix" placeholder="Enter Sufix.." value="<?php echo e(old('sufix')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="4" placeholder="Description.."><?php echo e(old('description')); ?></textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="model_id">Model</label>
                      <select class="form-select" id="model_id" name="model_id">
                        <option selected>select model</option>
                        <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($model->id); ?>"><?php echo e($model->vehicle_model_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="vin">VIN</label>
                      <input type="text" class="form-control" id="vin" name="vin" placeholder="Enter a VIN.." value="<?php echo e(old('vin')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="engine_no">Engine Number</label>
                      <input type="text" class="form-control" id="engine_no" name="engine_no" placeholder="Enter a Engine Number.." value="<?php echo e(old('engine_no')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="engine">Engine</label>
                      <input type="text" class="form-control" id="engine" name="engine" placeholder="Enter a Engine.." value="<?php echo e(old('engine')); ?>" >
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="color">Color</label>
                      <input type="text" class="form-control" id="color" name="color" placeholder="Enter a Color.." value="<?php echo e(old('color')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="trims">Trim</label>
                      <input type="text" class="form-control" id="trims" name="trims" placeholder="Enter a Trim.." value="<?php echo e(old('trims')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="std_fitment">STD Fitment</label>
                      <input type="text" class="form-control" id="std_fitment" name="std_fitment" placeholder="Enter STD Fitment.." value="<?php echo e(old('std_fitment')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="reg_type">Reg Type</label>
                      <input type="text" class="form-control" id="reg_type" name="reg_type" placeholder="Enter Reg Type.." value="<?php echo e(old('reg_type')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="category_type_id">Category</label>
                      <select class="form-select" id="category_type_id" name="category_type_id">
                        <option selected>select Category</option>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->vehicle_type_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="category_id">Category</label>
                      <select class="form-select" id="category_id" name="category_id">
                        <option selected>select Category</option>
                        <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->vehicle_category_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="key_no">Key Number</label>
                      <input type="text" class="form-control" id="key_no" name="key_no" placeholder="Enter Key Number.." value="<?php echo e(old('key_no')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="customer_name">Customer Name</label>
                      <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Customer Name.." value="<?php echo e(old('customer_name')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="owner_name">Owner Name</label>
                      <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Enter Owner Name.." value="<?php echo e(old('owner_name')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="remarks">Remarks</label>
                      <textarea class="form-control" id="remarks" name="remarks" rows="4" placeholder="Remarks.."><?php echo e(old('remarks')); ?></textarea>
                    </div>
                    <div class="mb-4">
                    <input class="form-check-input" type="checkbox" value="1" id="active_status" name="active_status">
                    <label class="form-check-label" for="dm-post-add-active">Active Status</label>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="amc_status">AMC Status</label>
                      <input type="text" class="form-control" id="amc_status" name="amc_status" placeholder="Enter AMC Status.." value="<?php echo e(old('amc_status')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="registration_expiry">Registration Expiry</label>
                      <input type="text" class="form-control" id="registration_expiry" name="registration_expiry" placeholder="Enter Registration Expiry.." value="<?php echo e(old('registration_expiry')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="insurance_policy_number">Insurance Policy Number</label>
                      <input type="text" class="form-control" id="insurance_policy_number" name="insurance_policy_number" placeholder="Enter Insurance Policy Number.." value="<?php echo e(old('insurance_policy_number')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="premium_amount">Premium Amount</label>
                      <input type="text" class="form-control" id="premium_amount" name="premium_amount" placeholder="Enter Premium Amount.." value="<?php echo e(old('premium_amount')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="insurance_expiry">Insurance Expiry</label>
                      <input type="text" class="form-control" id="insurance_expiry" name="insurance_expiry" placeholder="Enter Insurance Expiry.." value="<?php echo e(old('insurance_expiry')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="purchase_date">Purchase Date</label>
                      <input type="text" class="form-control" id="purchase_date" name="purchase_date" placeholder="Enter Purchase Date.." value="<?php echo e(old('purchase_date')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="purchase_cost">Purchase Cost</label>
                      <input type="text" class="form-control" id="purchase_cost" name="purchase_cost" placeholder="Enter Purchase Cost.." value="<?php echo e(old('purchase_cost')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="asset_structure">Asset Structure</label>
                      <input type="text" class="form-control" id="asset_structure" name="asset_structure" placeholder="Enter Asset Structure.." value="<?php echo e(old('asset_structure')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="fuel_card_number_id">Fuel Card</label>
                      <select class="form-select" id="fuel_card_number_id" name="fuel_card_number_id">
                        <option selected>select Fuel Card</option>
                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($card->id); ?>"><?php echo e($card->fuel_card_number); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
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
                    <div class="mb-4">
                      <label class="form-label" for="file_1">Attachment 1</label>
                    <input type="file" id="file_1"
                                        class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="file_1" placeholder="Upload a file">
                                        </div>
                                        <div class="mb-4">
                      <label class="form-label" for="file_2">Attachment 2</label>
                    <input type="file" id="file_2"
                                        class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="file_2" placeholder="Upload a file">
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/vehicle/create.blade.php ENDPATH**/ ?>