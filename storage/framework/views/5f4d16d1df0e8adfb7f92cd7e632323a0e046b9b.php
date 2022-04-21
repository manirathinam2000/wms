<?php $__env->startSection('content'); ?>
<!-- Hero -->
<div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Job Card</h1>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
          <div class="block block-rounded">
            <form action="#" method="GET" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
              <div class="d-flex col-md-6 py-5 px-3 align-items-center no-wrap-space">
                <label class="form-label pe-3" for="job_id">Select Job</label>
                <select class="form-select me-3" id="job_id" name="job_id">
                  <option value="" selected>select job</option>
                  <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($job->id); ?>"><?php echo e($job->id); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-fw fa-search opacity-50 me-1"></i> Go
                    </button>
            </div>
            </form>
            <div class="block-content block-content-full long-list">
              <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
              <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                <thead>
                <tr>
                    <th>Vehicle No.</th>
                    <th>Vehicle Model</th>
                    <th>Job Car No.</th>
                    <th>Service Type</th>
                    <th>Customer</th>
                    <th>Task Type</th>
                    <th>Task Status</th>
                    <th>Resource</th>
                    <th>Part Name</th>
                    <th>Part Category &amp; Number</th>
                    <th>Part Quantity Used</th>
                    <th>Bay No.</th>
                    <th>Planned Hours</th>
                    <th>Hours Spent</th>
                    <th>Update Status</th>
                    <th>Created By &amp; On</th>
                    <th>Updated By &amp; On</th>
                    <th>Action</th>
                </tr>
                
                </thead>
                <tbody>
                  
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($rows->id); ?></td>
                        <td><?php echo e($rows->ref_no); ?></td>
                        <td><?php echo e($rows->date_time); ?></td>
                        <td><?php echo e($rows->location_id); ?></td>
                        <td>
                          <a type="button" name="edit" href="<?php echo e(route('inspection.edit', ['id' => $rows->id])); ?>" class="edit btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
            <div class="row justify-content-start push mx-2 my-5 no-wrap-space">
                <div class="products-table col-md-6">
                  <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                    <thead>
                    <tr>
                        <th>Resource Name</th>
                        <th>Planned Hours</th>
                        <th>Hours Spent</th>
                    </tr>
                    
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">
                              N/A
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/task_sheet/index.blade.php ENDPATH**/ ?>