@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Alert</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Alert</li>
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
          <form action="{{ route('alert.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('alert.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage Alerts
                </a>
                
              </div>
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    
                  <div class="mb-4">
                      <label class="form-label" for="alert_list_id">Item</label>
                      <select class="form-select" id="alert_list_id" name="alert_list_id">
                        <option selected>Select item</option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->alert_list_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    
                    <div class="mb-4">
                      <label class="form-label" for="alert_schedule">Period</label>
                      <select class="form-select" id="alert_schedule" name="alert_schedule">
                        <option value="" selected>Select period</option>
                        <option value="Once">Once</option>
                        <option value="Daily">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="alert_start_date">Start Date</label>
                      <input type="text" class="form-control" id="alert_start_date" name="alert_start_date" placeholder="Enter Start date.." value="{{ old('alert_start_date') }}">
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
        <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
@endsection