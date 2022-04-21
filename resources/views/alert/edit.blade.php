@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Alert List</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Alert List</li>
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
          <form action="{{ route('alert.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" value="{{ $data->id }}">
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('alert.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage Alert Lists
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
                        @php
                            $selected = '';
                            if($item->id == $data->alert_list_id)
                            $selected = 'selected'
                          @endphp
                        <option value="{{ $item->id }}" {{ $selected }}>{{ $item->alert_list_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    
                    <div class="mb-4">
                      <label class="form-label" for="alert_schedule">Period</label>
                      <select class="form-select" id="alert_schedule" name="alert_schedule">
                        <option value="" selected>Select period</option>
                        <option value="Once" <?php echo $data->alert_schedule == "Once"? 'selected' : '' ?>>Once</option>
                        <option value="Daily" <?php echo $data->alert_schedule == "Daily"? 'selected' : '' ?>>Daily</option>
                        <option value="Weekly" <?php echo $data->alert_schedule == "Weekly"? 'selected' : '' ?>>Weekly</option>
                        <option value="Monthly" <?php echo $data->alert_schedule == "Monthly"? 'selected' : '' ?>>Monthly</option>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="alert_start_date">Start Date</label>
                      <input type="text" class="form-control" id="alert_start_date" name="alert_start_date" placeholder="Enter Start date.." value="{{ $data->alert_start_date }}">
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