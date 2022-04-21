@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Service Category</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Service Category</li>
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
          <form action="{{ route('service_category.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" value="{{ $data->id }}">
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('service_category.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage Service Category
                </a>
                
              </div>
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="service_category_name">Service Category</label>
                      <input type="text" class="form-control" id="service_category_name" name="service_category_name" placeholder="Enter a Service Category.." value="{{ $data->service_category_name }}">
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
        <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
@endsection