@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Task Add</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Job Management</li>
                  <li class="breadcrumb-item active" aria-current="page">Inspection</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content content-full content-boxed">
          <!-- New Post -->
          <form action="{{ route('inspection.task.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" value="{{ $data->id }}"><input type="hidden" class="form-control" id="hidden_job_id" name="hidden_job_id" value="{{ $data->job_id }}">
            <div class="block">
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="task_type_id">Task Type</label>
                      <select class="form-select" id="task_type_id" name="task_type_id">
                        <option value="" selected>Select type</option>
                        @foreach($task_types as $type)
                        <option value="{{ $type->id }}">{{ $type->task_type_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="task_description">Description</label>
                      <textarea class="form-control" id="task_description" name="task_description" rows="4" placeholder="Task Description..">{{ old('task_description') }}</textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="standard_time">Estimate</label>
                      <input type="text" class="form-control" id="standard_time" name="standard_time" placeholder="Enter Estimate.." value="{{ old('standard_time') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="part_id">Part</label>
                      <select class="form-select" id="part_id" name="part_id">
                        <option value="" selected>Select Item</option>
                        @foreach($parts as $part)
                        <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="quantity">Part Used Quantity</label>
                      <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Part Used Quantity.." value="{{ old('quantity') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="actual_cost">Actual Cost</label>
                      <input type="text" class="form-control" id="actual_cost" name="actual_cost" placeholder="Enter Actual Cost.." value="{{ old('actual_cost') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-fw fa-long-arrow-alt-right opacity-50 me-1"></i> Add Task
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