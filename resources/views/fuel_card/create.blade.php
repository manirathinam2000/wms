@extends('layout.main')
@section('content')
<!-- Hero -->
        <div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Fuel Card</h1>
              <nav class="flex-shrink-0 my-2 my-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Fuel Card</li>
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
          <form action="{{ route('fuel_card.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="block">
              <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{ route('fuel_card.index') }}">
                  <i class="fa fa-arrow-left me-1"></i> Manage Bay
                </a>
                
              </div>
              @include('shared.errors')
              <div class="block-content">
                <div class="row justify-content-center push">
                  <div class="col-md-10">
                    <div class="mb-4">
                      <label class="form-label" for="fuel_card_number">Fuel Card Number</label>
                      <input type="text" class="form-control" id="fuel_card_number" name="fuel_card_number" placeholder="Enter the Fuel Card Number.." value="{{ old('fuel_card_number') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="fuel_card_company">Fuel Card Company</label>
                      <input type="text" class="form-control" id="fuel_card_company" name="fuel_card_company" placeholder="Enter the Fuel Card Company.." value="{{ old('fuel_card_company') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="limits">Limit</label>
                      <input type="text" class="form-control" id="limits" name="limits" placeholder="Enter the limit.." value="{{ old('limits') }}">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="expiry">Expiry</label>
                      <input type="text" class="form-control" id="expiry" name="expiry" placeholder="Enter the Expiry.." value="{{ old('expiry') }}">
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