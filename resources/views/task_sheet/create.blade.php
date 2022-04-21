@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Inspection</h1>
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
          <form action="{{ route('inspection.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="block">
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-12 d-flex mb-3">
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="id">Inspection No.</label>
                      <input type="text" class="form-control" id="id" name="id" placeholder="Inspection No. will be auto generated" value="{{ old('id') }}" disabled>
                    </div>
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="ref_no">Reference No.</label>
                      <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Enter Reference No.." value="{{ old('ref_no') }}">
                    </div>
                  </div>
                  <div class="col-md-12 d-flex mb-3">
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="date_time">Date &amp; Time</label>
                      <input type="text" class="form-control" id="date_time" name="date_time" placeholder="Enter Date &amp; Time.." value="{{ old('date_time') }}">
                    </div>
                    <div class="col-md-5 ms-5">
                    <label class="form-label" for="service_category_id">Service Type</label>
                      <select class="form-select" id="service_category_id" name="service_category_id">
                        <option value="" selected>select type</option>
                        @foreach($service_categories as $category)
                        <option value="{{ $category->id }}">{{ $category->service_category_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12 d-flex mb-3">
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="customer_id">Customer</label>
                      <select class="form-select" id="customer_id" name="customer_id">
                        <option value="" selected>select type</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="vehicle_registration_number">Customer Reg No</label>
                      <input type="text" class="form-control" id="vehicle_registration_number" name="vehicle_registration_number" placeholder="Customer Reg No" value="{{ old('id') }}" disabled>
                    </div>                    
                  </div>
                  <div class="col-md-12 d-flex mb-3">
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('id') }}" disabled>
                    </div> 
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="vin">VIN</label>
                      <input type="text" class="form-control" id="vin" name="vin" placeholder="VIN" value="{{ old('id') }}" disabled>
                    </div>                    
                  </div>
                  <div class="col-md-12 d-flex mb-3">
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="phone">Phone</label>
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{ old('id') }}" disabled>
                    </div>      
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="Make">Make</label>
                      <input type="text" class="form-control" id="Make" name="Make" placeholder="Make" value="{{ old('id') }}" disabled>
                    </div>               
                  </div>
                  <div class="col-md-12 d-flex mb-3">
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="mileage">Mileage</label>
                      <input type="text" class="form-control" id="mileage" name="mileage" placeholder="Enter Mileage" value="{{ old('id') }}">
                    </div>      
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="model">Model</label>
                      <input type="text" class="form-control" id="model" name="model" placeholder="Model" value="{{ old('id') }}" disabled>
                    </div>               
                  </div>
                  <div class="col-md-12 d-flex mb-3">
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="odometer">Odometer</label>
                      <input type="text" class="form-control" id="odometer" name="odometer" placeholder="Enter Odometer" value="{{ old('id') }}">
                    </div>      
                    <div class="col-md-5 ms-5">
                      <label class="form-label" for="fuel">Fuel</label>
                      <input type="text" class="form-control" id="fuel" name="fuel" placeholder="Enter Fuel" value="{{ old('id') }}">
                    </div>               
                  </div>
                  <div class="checklist-options justify-content-center">
                  <h4 class="ms-5">Items</h4>
                  <div class="col-md-10 d-flex checklist mb-3 ms-5">
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="service_book">Service Book</label>
                      <select class="form-select" id="service_book" name="service_book">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>   
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="radio">Radio</label>
                      <select class="form-select" id="radio" name="radio">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="wipers">Wipers</label>
                      <select class="form-select" id="wipers" name="wipers">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="air_conditioner">A/C</label>
                      <select class="form-select" id="air_conditioner" name="air_conditioner">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>         
                  </div>
                  <div class="col-md-10 d-flex checklist mb-3 ms-5">
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="spare_wheel">Spare Wheel</label>
                      <select class="form-select" id="spare_wheel" name="spare_wheel">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>   
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="cassette">Cassette</label>
                      <select class="form-select" id="cassette" name="cassette">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="cig_lighter">Cig. Lighter</label>
                      <select class="form-select" id="cig_lighter" name="cig_lighter">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="head_rest">Head Rest</label>
                      <select class="form-select" id="head_rest" name="head_rest">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>        
                  </div>
                  <div class="col-md-10 d-flex checklist mb-3 ms-5">
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="jack">Jack</label>
                      <select class="form-select" id="jack" name="jack">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                        
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="antenna">Antenna</label>
                      <select class="form-select" id="antenna" name="antenna">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="wheel_cap">Wheel Cap</label>
                      <select class="form-select" id="wheel_cap" name="wheel_cap">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>    
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="tools">Tools</label>
                      <select class="form-select" id="tools" name="tools">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>       
                  </div>
                  <h4 class="ms-5">Window Glass</h4>
                  <div class="col-md-10 d-flex checklist mb-3 ms-5">
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="front_left">Front Left</label>
                      <select class="form-select" id="front_left" name="front_left">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                        
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="front_right">Front Right</label>
                      <select class="form-select" id="front_right" name="front_right">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="rear_left">Rear Left</label>
                      <select class="form-select" id="rear_left" name="rear_left">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>    
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="rear_right">Rear Right</label> 
                      <select class="form-select" id="rear_right" name="rear_right">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>       
                  </div>
                  <h4 class="ms-5">Lights</h4>
                  <div class="col-md-10 d-flex checklist mb-3 ms-5">
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="head_light">Head Light</label>
                      <select class="form-select" id="head_light" name="head_light">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                        
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="front_park_light">Front park Light</label>
                      <select class="form-select" id="front_park_light" name="front_park_light">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="rear_red_light">Rear Red Light</label>
                      <select class="form-select" id="rear_red_light" name="rear_red_light">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>    
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="turn_signals">Turn Signals</label>
                      <select class="form-select" id="turn_signals" name="turn_signals">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>       
                  </div>
                  <h4 class="ms-5">Mirror</h4>
                  <div class="col-md-10 d-flex checklist mb-3 ms-5">
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="fire_extinguisher">Fire Extinguisher</label>
                      <select class="form-select" id="fire_extinguisher" name="fire_extinguisher">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="inside_mirror">Inside Mirror</label>
                      <select class="form-select" id="inside_mirror" name="inside_mirror">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div> 
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="mirror_lh">Mirror LH</label>
                      <select class="form-select" id="mirror_lh" name="mirror_lh">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>  
                       
                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                      <label class="form-label pe-3" for="mirror_rh">Mirror RH</label>
                      <select class="form-select" id="mirror_rh" name="mirror_rh">
                        <option selected></option>
                        <option value="X">X</option>
                        <option value="N">N</option>
                        <option value="D">D</option>
                      </select>
                    </div>       
                  </div>
                  </div>
                </div>
              </div>
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-fw fa-long-arrow-alt-right opacity-50 me-1"></i> Add Task
                    </button>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center push">
                <div class="products-table col-md-10">
                  <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                    <thead>
                    <tr>
                        <th>Task Type</th>
                        <th>Description</th>
                        <th>Estimate</th>
                        <th>Part Name</th>
                        <th>Quantity Used</th>
                        <th>Actual Cost</th>
                        <th>Action</th>
                    </tr>
                    
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7">
                              No Task Assigned.
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