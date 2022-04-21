@extends('layout.main')
@section('content')
<!-- Hero -->
<div class="bg-body-light">
          <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
              <h1 class="flex-grow-1 fs-3 fw-semibold my-2">Location</h1>
              <a href="{{ route('locations.create') }}">
                <button type="button" class="btn btn-alt-primary my-2">
                    <i class="fa fa-fw fa-plus me-1"></i> New 
                </button>
              </a>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
          <div class="block block-rounded">
            <div class="block-content block-content-full">
              <table class="table table-bordered table-striped table-vcenter js-dataTable-simple" id="location-table">
                <thead>
                <tr>
                    <th>Location Name</th>
                    <th>City</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                
                </thead>
                <tbody>
                  
                @foreach($data as $rows)
                    <tr>
                        <td>{{ $rows->location_name }}</td>
                        <td>{{ $rows->city }}</td>
                        <td>{{ $rows->contact_person}}</td>
                        <td>{{ $rows->email}}</td>
                        <td>
                          <a type="button" name="edit" href="{{ route('locations.edit', ['id' => $rows->id]) }}" class="edit btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
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