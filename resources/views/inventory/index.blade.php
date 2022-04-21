@extends('layout.main')
@section('content')
<!-- Hero -->
<div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Stock</h1>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
<div class="block block-rounded">
            <div class="block-content block-content-full">
              <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
              <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Location</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                
                </thead>
                <tbody>
                  
                @foreach($data as $rows)
                    <tr>
                        <td>{{ $rows->part_name }}</td>
                        <td>{{ $rows->location_name}}</td>
                        <td>{{ $rows->stock }}</td>
                        <td>
                          <a type="button" name="edit" href="#" class="edit btn btn-primary btn-sm">Rates</i></a>
                          <a type="button" name="edit" href="#" class="edit btn btn-primary btn-sm">Returns</i></a>
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