@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Move Goods</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Inventory</li>
                  <li class="breadcrumb-item active" aria-current="page">Move Goods</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content content-full content-boxed">
          <!-- New Post -->
          <form action="{{ route('inventory.transfer.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="block">
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="branch_id">From Branch</label>
                      <select class="form-select" id="branch_id" name="branch_id">
                        <option value="" selected>Select Branch</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="to_branch_id">To Branch</label>
                      <select class="form-select" id="to_branch_id" name="to_branch_id">
                        <option value="" selected>Select Branch</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
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
                      <i class="fa fa-fw fa-long-arrow-alt-right opacity-50 me-1"></i> Add Products
                    </button>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center push">
                <div class="products-table col-md-10">
                  <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                    
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">
                              No Products Added.
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </form>
          <!-- END New Post -->
        </div>
        <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
@endsection