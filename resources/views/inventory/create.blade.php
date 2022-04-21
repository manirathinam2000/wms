@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Inventory</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Inventory</li>
                  <li class="breadcrumb-item active" aria-current="page">Goods Inward</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content content-full content-boxed">
          <!-- New Post -->
          <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="block">
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="branch">Branch</label>
                      <select class="form-select" id="branch" name="branch">
                        <option value="" selected>Select Branch</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="requisition_no">Requisition No</label>
                      <select class="form-select" id="requisition_no" name="requisition_no">
                        <option value="" selected>Select requisition no</option>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="type">Item type</label>
                      <select class="form-select" id="type" name="type">
                        <option value="" selected>Select Item type</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->part_type_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="po_no">PO no</label>
                      <select class="form-select" id="po_no" name="po_no">
                        <option value="" selected>	Select PO no</option>
                        @foreach($orders as $order)
                        <option value="{{ $order->id }}">{{ $order->id }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-fw fa-long-arrow-alt-right opacity-50 me-1"></i> Go
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <!-- END New Post -->
        </div>
        <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
@endsection