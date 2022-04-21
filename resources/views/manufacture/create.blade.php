@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Manufacture</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Manufacture</li>
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
          <form action="{{ route('manufacture.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('manufacture.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage Manufactures
                </a>
                
              </div>
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="manufacture_name">Manufacture Name</label>
                      <input type="text" class="form-control" id="manufacture_name" name="manufacture_name" placeholder="Enter Manufacture Name.." value="{{ old('manufacture_name') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="sap_ref_code">SAP Ref Code</label>
                      <input type="text" class="form-control" id="sap_ref_code" name="sap_ref_code" placeholder="Enter SAP Ref Code.." value="{{ old('sap_ref_code') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="address1">Address 1</label>
                      <input type="text" class="form-control" id="address1" name="address1" placeholder="Enter a Address 1.." value="{{ old('address1') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="address2">Address 2</label>
                      <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter a Address 2.." value="{{ old('address2') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="city">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="Enter a City.." value="{{ old('city') }}" >
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="country">Country</label>
                      <select class="form-select" id="country" name="country">
                        <option selected>select country</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="contact_person">Contact</label>
                      <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter a Contact Person.." value="{{ old('contact_person') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="mobile">Mobile</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter a Mobile.." value="{{ old('mobile') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter a Email.." value="{{ old('email') }}">
                    </div>
                    <div class="mb-4">
                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                    <label class="form-check-label" for="dm-post-add-active">Set active</label>
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