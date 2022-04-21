@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Bay</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Bay</li>
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
          <form action="{{ route('bay.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" value="{{ $data->id }}">
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('bay.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage Bay
                </a>
                
              </div>
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="bay_name">Bay Name</label>
                      <input type="text" class="form-control" id="bay_name" name="bay_name" placeholder="Enter a bay name.." value="{{ $data->bay_name }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="location_id">Location</label>
                      <select class="form-select" id="location_id" name="location_id">
                        <option selected>select location</option>
                        @foreach($locations as $location)
                        @php
                            $selected = '';
                            if($location->id == $data->location_id)
                            $selected = 'selected'
                          @endphp
                        <option value="{{ $location->id }}" {{ $selected }}>{{ $location->location_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="task_type_id">Task Type</label>
                      <select class="form-select" id="task_type_id" name="task_type_id">
                        <option selected>select task type</option>
                        @foreach($task_types as $task_type)
                        @php
                            $selected = '';
                            if($task_type->id == $data->task_type_id)
                            $selected = 'selected'
                          @endphp
                        <option value="{{ $task_type->id }}" {{ $selected }}>{{ $task_type->task_type_name }}</option>
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