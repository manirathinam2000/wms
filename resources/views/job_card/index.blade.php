@extends('layout.main')
@section('content')
<!-- Hero -->
<div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Job Card</h1>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
<div class="block block-rounded">
            <div class="block-content block-content-full long-list">
              <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
              <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                <thead>
                <tr>
                    <th>Vehicle No.</th>
                    <th>Vehicle Model</th>
                    <th>Job Car No.</th>
                    <th>Service Type</th>
                    <th>Customer</th>
                    <th>Customer Reg no.</th>
                    <th>In time</th>
                    <th>Out time</th>
                    <th>Odometer</th>
                    <th>Mileage</th>
                    <th>Estimated Amount</th>
                    <th>Estimated Release Date</th>
                    <th>Actual Amount</th>
                    <th>Branch Name</th>
                    <th>Created By &amp; On</th>
                    <th>Action</th>
                </tr>
                
                </thead>
                <tbody>
                  
                @foreach($data as $rows)
                    <tr>
                        <td>{{ $rows->id }}</td>
                        <td>{{ $rows->ref_no }}</td>
                        <td>{{ $rows->date_time }}</td>
                        <td>{{ $rows->location_id}}</td>
                        <td>
                          <a type="button" name="edit" href="{{ route('inspection.edit', ['id' => $rows->id]) }}" class="edit btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
</div>
          <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>

          <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>

          <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>

    

@endsection