@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Task</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Task</li>
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
          <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('task.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage Tasks
                </a>
                
              </div>
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                  <div class="mb-4">
                      <label class="form-label" for="task_category_id">Category</label>
                      <select class="form-select" id="task_category_id" name="task_category_id">
                        <option selected>select Category</option>
                        @foreach($categorys as $category)
                        <option value="{{ $category->id }}">{{ $category->task_category_name }}</option>
                        @endforeach
                      </select>
                    </div>                    
                    <div class="mb-4">
                      <label class="form-label" for="task_type_id">Type</label>
                      <select class="form-select" id="task_type_id" name="task_type_id">
                        <option selected>select Type</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->task_type_name }}</option>
                        @endforeach
                      </select>
                    </div>
                                       
                    <div class="mb-4">
                      <label class="form-label" for="task_list_id">Task</label>
                      <select class="form-select" id="task_list_id" name="task_list_id">
                        <option selected>select Task</option>
                        @foreach($lists as $list)
                        <option value="{{ $list->id }}">{{ $list->task_list_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="day_of_service">Day of Service</label>
                      <input type="text" class="form-control" id="day_of_service" name="day_of_service" placeholder="Enter Day of Service.." value="{{ old('day_of_service') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="km_of_service">KM of Service</label>
                      <input type="text" class="form-control" id="km_of_service" name="km_of_service" placeholder="Enter KM of Service.." value="{{ old('km_of_service') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="task_status_id">Status</label>
                      <select class="form-select" id="task_status_id" name="task_status_id">
                        <option selected>select Task</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->task_status_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <input class="form-check-input" type="checkbox" value="1" id="auto_update" name="auto_update">
                      <label class="form-check-label" for="dm-post-add-active">Auto Update</label>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="standard_time">Standard Time</label>
                      <input type="text" class="form-control" id="standard_time" name="standard_time" placeholder="Enter a Standard Time.." value="{{ old('standard_time') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="rate_per_hour">Rate Per Hour</label>
                      <input type="text" class="form-control" id="rate_per_hour" name="rate_per_hour" placeholder="Enter a Rate Per Hour.." value="{{ old('rate_per_hour') }}">
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_01">Sub Task - 01</label>
                        <input type="text" class="form-control" id="sub_task_01" name="sub_task_01" placeholder="Enter a Sub Task.." value="{{ old('sub_task_01') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_01">Part</label>
                        <select class="form-select" id="spare_part_01" name="spare_part_01">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_02">Sub Task - 02</label>
                        <input type="text" class="form-control" id="sub_task_02" name="sub_task_02" placeholder="Enter a Sub Task.." value="{{ old('sub_task_02') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_02">Part</label>
                        <select class="form-select" id="spare_part_02" name="spare_part_02">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_03">Sub Task - 03</label>
                        <input type="text" class="form-control" id="sub_task_03" name="sub_task_03" placeholder="Enter a Sub Task.." value="{{ old('sub_task_03') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_03">Part</label>
                        <select class="form-select" id="spare_part_03" name="spare_part_03">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_04">Sub Task - 04</label>
                        <input type="text" class="form-control" id="sub_task_04" name="sub_task_04" placeholder="Enter a Sub Task.." value="{{ old('sub_task_04') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_04">Part</label>
                        <select class="form-select" id="spare_part_04" name="spare_part_04">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_05">Sub Task - 05</label>
                        <input type="text" class="form-control" id="sub_task_05" name="sub_task_05" placeholder="Enter a Sub Task.." value="{{ old('sub_task_05') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_05">Part</label>
                        <select class="form-select" id="spare_part_05" name="spare_part_05">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_06">Sub Task - 06</label>
                        <input type="text" class="form-control" id="sub_task_06" name="sub_task_06" placeholder="Enter a Sub Task.." value="{{ old('sub_task_06') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_06">Part</label>
                        <select class="form-select" id="spare_part_06" name="spare_part_06">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_07">Sub Task - 07</label>
                        <input type="text" class="form-control" id="sub_task_07" name="sub_task_07" placeholder="Enter a Sub Task.." value="{{ old('sub_task_07') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_07">Part</label>
                        <select class="form-select" id="spare_part_07" name="spare_part_07">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_08">Sub Task - 08</label>
                        <input type="text" class="form-control" id="sub_task_08" name="sub_task_08" placeholder="Enter a Sub Task.." value="{{ old('sub_task_08') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_08">Part</label>
                        <select class="form-select" id="spare_part_08" name="spare_part_08">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_09">Sub Task - 09</label>
                        <input type="text" class="form-control" id="sub_task_09" name="sub_task_09" placeholder="Enter a Sub Task.." value="{{ old('sub_task_09') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_09">Part</label>
                        <select class="form-select" id="spare_part_09" name="spare_part_09">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                      <div class="col-md-6">
                        <label class="form-label" for="sub_task_10">Sub Task - 10</label>
                        <input type="text" class="form-control" id="sub_task_10" name="sub_task_10" placeholder="Enter a Sub Task.." value="{{ old('sub_task_10') }}" >
                      </div>
                      <div class="col-md-5">
                        <label class="form-label" for="spare_part_10">Part</label>
                        <select class="form-select" id="spare_part_10" name="spare_part_10">
                          <option selected>select Part</option>
                          @foreach($parts as $part)
                          <option value="{{ $part->id }}">{{ $part->part_name }}</option>
                          @endforeach
                        </select>
                      </div>
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