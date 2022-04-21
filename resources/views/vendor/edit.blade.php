@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Vendor</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Vendor</li>
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
          <form action="{{ route('vendor.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" value="{{ $data->id }}">
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('vendor.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage vendors
                </a>
                
              </div>
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="vendor_name">Vendor Name</label>
                      <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Enter vendor Name.." value="{{ $data->vendor_name }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="ref_code">Ref Code</label>
                      <input type="text" class="form-control" id="ref_code" name="ref_code" placeholder="Enter Ref Code.." value="{{ $data->ref_code }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="cr_number">Ref Code</label>
                      <input type="text" class="form-control" id="cr_number" name="cr_number" placeholder="Enter CR Number.." value="{{ $data->cr_number }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="category_id">Category</label>
                      <select class="form-select" id="category_id" name="category_id">
                        <option selected>select category</option>
                        @foreach($categorys as $category)
                        @php
                            $selected = '';
                            if($category->id == $data->category_id)
                            $selected = 'selected'
                          @endphp
                        <option value="{{ $category->id }}" {{ $selected }}>{{ $category->vendor_category_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="tax_number">Tax Number</label>
                      <input type="text" class="form-control" id="tax_number" name="tax_number" placeholder="Enter Tax Number.." value="{{ $data->tax_number }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="address1">Address 1</label>
                      <input type="text" class="form-control" id="address1" name="address1" placeholder="Enter a Address 1.." value="{{ $data->address1 }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="address2">Address 2</label>
                      <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter a Address 2.." value="{{ $data->address2 }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="city">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="Enter a City.." value="{{ $data->city }}" >
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="country">Country</label>
                      <select class="form-select" id="country" name="country">
                        <option selected>select country</option>
                        @foreach($countries as $country)
                        @php
                            $selected = '';
                            if($country->id == $data->country)
                            $selected = 'selected'
                          @endphp
                        <option value="{{ $country->id }}" {{ $selected }}>{{ $country->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="contact_person">Contact Person</label>
                      <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter a Contact Person.." value="{{ $data->contact_person }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="mobile">Contact Mobile</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter a Mobile.." value="{{ $data->mobile }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter a Email.." value="{{ $data->email }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="debtor_in_charge">Debtor In Charge</label>
                      <input type="text" class="form-control" id="debtor_in_charge" name="debtor_in_charge" placeholder="Enter a Debtor In Charge.." value="{{ $data->debtor_in_charge }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="currency">Currency</label>
                      <input type="text" class="form-control" id="currency" name="currency" placeholder="Enter Currency.." value="{{ $data->currency }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="credit_amount">Credit Amount</label>
                      <input type="text" class="form-control" id="credit_amount" name="credit_amount" placeholder="Enter Credit Amount.." value="{{ $data->credit_amount }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="credit_days">Credit Days</label>
                      <input type="text" class="form-control" id="credit_days" name="credit_days" placeholder="Enter Credit Days.." value="{{ $data->credit_days }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="opening_balance">Opening Balance</label>
                      <input type="text" class="form-control" id="opening_balance" name="opening_balance" placeholder="Enter Opening Balance.." value="{{ $data->opening_balance }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="payment_type_id">Payment Type</label>
                      <select class="form-select" id="payment_type_id" name="payment_type_id">
                        <option selected>select Payment Type</option>
                        @foreach($payment_types as $payment_type)
                        @php
                            $selected = '';
                            if($payment_type->id == $data->payment_type_id)
                            $selected = 'selected'
                          @endphp
                        <option value="{{ $payment_type->id }}" {{ $selected }}>{{ $payment_type->payment_type_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="remarks">Remarks</label>
                      <textarea class="form-control" id="remarks" name="remarks" rows="4" placeholder="Remarks..">{{ $data->remarks }}</textarea>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column1">Column 1</label>
                      <input type="text" class="form-control" id="column1" name="column1" placeholder="Enter a value.." value="{{ $data->column1 }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column2">Column 2</label>
                      <input type="text" class="form-control" id="column2" name="column2" placeholder="Enter a value.." value="{{ $data->column2 }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column3">Column 3</label>
                      <input type="text" class="form-control" id="column3" name="column3" placeholder="Enter a value.." value="{{ $data->column3 }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column4">Column 4</label>
                      <input type="text" class="form-control" id="column4" name="column4" placeholder="Enter a value.." value="{{ $data->column4 }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="column5">Column 5</label>
                      <input type="text" class="form-control" id="column5" name="column5" placeholder="Enter a value.." value="{{ $data->column5 }}">
                    </div>                    
                  </div>
                </div>
              </div>
              <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-fw fa-check opacity-50 me-1"></i> Save
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