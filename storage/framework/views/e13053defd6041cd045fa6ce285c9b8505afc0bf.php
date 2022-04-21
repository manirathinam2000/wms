<?php $__env->startSection('content'); ?>
<!-- Hero -->
<div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Vehicle</h1>
              <a href="<?php echo e(route('vehicle.create')); ?>">
                <button type="button" class="btn btn-alt-primary my-2">
                    <i class="fa fa-fw fa-plus me-1"></i> New 
                </button>
              </a>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
<div class="block block-rounded">
            <div class="block-content block-content-full">
              <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
              <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                <thead>
                <tr>
                    <th>Registration Number</th>
                    <th>VIN</th>
                    <th>Engine No</th>
                    <th>Customer Name</th>
                    <th>Action</th>
                </tr>
                
                </thead>
                <tbody>
                  
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($rows->vehicle_registration_number); ?></td>
                        <td><?php echo e($rows->vin); ?></td>
                        <td><?php echo e($rows->engine_no); ?></td>
                        <td><?php echo e($rows->customer_name); ?></td>
                        <td>
                          <a type="button" name="edit" href="<?php echo e(route('vehicle.edit', ['id' => $rows->id])); ?>" class="edit btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
          </div>
</div>
          <script src="<?php echo e(asset('assets/js/dashmix.app.min.js')); ?>"></script>

          <script src="<?php echo e(asset('assets/js/lib/jquery.min.js')); ?>"></script>

          <script src="<?php echo e(asset('assets/js/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/be_tables_datatables.min.js')); ?>"></script>

    

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/vehicle/index.blade.php ENDPATH**/ ?>