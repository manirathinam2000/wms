<?php $__env->startSection('content'); ?>
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Purchase Order Booking</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Purchase Order Booking</li>
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
          <form action="<?php echo e(route('purchase_order_booking.store')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="<?php echo e(route('purchase_order_booking.index')); ?>">
                  <i class="fa fa-arrow-left me-1"></i> Manage Purchase Order Booking
                </a>
                
              </div>
              <?php echo $__env->make('shared.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="vendor_invoice_number">Vendor Invoice Number</label>
                      <input type="text" class="form-control" id="vendor_invoice_number" name="vendor_invoice_number" placeholder="Enter Vendor Invoice Number.." value="<?php echo e(old('vendorinvoice_number')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="invoice_date">Invoice Date</label>
                      <input type="text" class="form-control" id="invoice_date" name="invoice_date" placeholder="Enter Invoice Date.." value="<?php echo e(old('invoice_date')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="invoice_amount">Invoice Amount</label>
                      <input type="text" class="form-control" id="invoice_amount" name="invoice_amount" placeholder="Enter Invoice Amount.." value="<?php echo e(old('invoice_amount')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="submitted_date">Submitted Date</label>
                      <input type="text" class="form-control" id="submitted_date" name="submitted_date" placeholder="Enter a Submitted Date.." value="<?php echo e(old('submitted_date')); ?>">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="goods_receipt">Good Receipt</label>
                      <input type="text" class="form-control" id="goods_receipt" name="goods_receipt" placeholder="Enter Good Receipt.." value="<?php echo e(old('goods_receipt')); ?>" >
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="payment_status_id">Payment Status</label>
                      <select class="form-select" id="payment_status_id" name="payment_status_id">
                        <option selected>select Payment Status<</option>
                        <?php $__currentLoopData = $payment_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status->id); ?>"><?php echo e($status->payment_status_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="payment_date">Payment Date</label>
                      <input type="text" class="form-control" id="payment_date" name="payment_date" placeholder="Enter a Payment Date.." value="<?php echo e(old('payment_date')); ?>">
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vegkuxyk/kalaashcharya.in/demo/wms/resources/views/purchase_order_booking/create.blade.php ENDPATH**/ ?>