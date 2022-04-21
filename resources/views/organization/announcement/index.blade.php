@extends('layout.main')
@section('content')



    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid mb-3">
            @can('store-announcement')
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> {{__('Add Announcement')}}</button>
            @endcan
            @can('delete-announcement')
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> {{__('Bulk delete')}}</button>
            @endcan
        </div>


        <div class="table-responsive">
            <table id="announcement-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Title')}}</th>
                    <th>{{__('Published For')}}</th>
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('End Date')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Announcement')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">

                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Title')}} *</label>
                                <input type="text" name="title" id="title" required class="form-control"
                                       placeholder="should be unique">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Summary')}}</label>
                                <input type="text" name="summary" id="summary" required class="form-control"
                                       placeholder="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Start Date')}}</label>
                                <input type="text" name="start_date" id="start_date" class="form-control date" value=""
                                       required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('End Date')}}</label>
                                <input type="text" name="end_date" id="end_date" class="form-control date" value=""
                                       required>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Description')}}</label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="3"></textarea>
                                </div>
                            </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Department')}}</label>
                                    <select name="department_id" id="department_id" class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="begins"
                                            title='{{__('Selecting',['key'=>trans('file.Department')])}}...'>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_notify"
                                               id="is_notify_edit" value="1" checked>
                                        <label class="custom-control-label"
                                               for="is_notify_edit">{{trans('file.Notify')}}</label>
                                    </div>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value="{{trans('file.Add')}}" />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="announcement_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('Announcement Info')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <span id="logo_id"></span>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table  table-bordered">
                                    <tr>
                                        <th>{{trans('file.Title')}}</th>
                                        <td id="title_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Summary')}}</th>
                                        <td id="summary_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Description')}}</th>
                                        <td id="description_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Published For')}}</th>
                                        <td id="department_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Added By')}}</th>
                                        <td id="added_by_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Start Date')}}</th>
                                        <td id="start_date_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('End Date')}}</th>
                                        <td id="end_date_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Notification')}}</th>
                                        <td id="notify_id"></td>
                                    </tr>


                                </table>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.Close')}}</button>
            </div>
        </div>
    </div>








    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">{{trans('file.OK')}}'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        (function($) {  
            "use strict";
            $(document).ready(function () {

                var date = $('.date');
                date.datepicker({
                    format: '{{ env('Date_Format_JS')}}',
                    autoclose: true,
                    todayHighlight: true
                });


                $('#announcement-table').DataTable({
                    initComplete: function () {
                        this.api().columns([2, 4]).every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                                $('select').selectpicker('refresh');
                            });
                        });
                    },
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    serverSide: true,
                    ajax: {
                        url: "{{ route('announcements.index') }}",
                    },


                    columns: [

                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title',

                        },
                        {
                            data: 'department',
                            name: 'department',
                        },
                        {
                            data: 'start_date',
                            name: 'start_date',
                        },
                        {
                            data: 'end_date',
                            name: 'end_date',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ],


                    "order": [],
                    'language': {
                        'lengthMenu': '_MENU_ {{__("records per page")}}',
                        "info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                        "search": '{{trans("file.Search")}}',
                        'paginate': {
                            'previous': '{{trans("file.Previous")}}',
                            'next': '{{trans("file.Next")}}'
                        }
                    },
                    'columnDefs': [
                        {
                            "orderable": false,
                            'targets': [0, 5]
                        },
                        {
                            'render': function (data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                            },
                            'targets': [0]
                        }
                    ],


                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    dom: '<"row"lfB>rtip',
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            });


            $('#create_record').on('click', function () {

                $('.modal-title').text('{{__('Add Announcement')}}');
                $('#action_button').val('{{trans("file.Add")}}');
                $('#action').val('{{trans("file.Add")}}');
                $('#formModal').modal('show');


            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == '{{trans('file.Add')}}') {

                    $.ajax({
                        url: "{{ route('announcements.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            console.log(data);

                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('select').selectpicker('refresh');
                                $('.date').datepicker('update');
                                $('#announcement-table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    })
                }

                if ($('#action').val() == '{{trans('file.Edit')}}') {
                    $.ajax({
                        url: "{{ route('announcements.update') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                setTimeout(function () {
                                    $('#formModal').modal('hide');
                                    $('.date').datepicker('update');
                                    $('#announcement-table').DataTable().ajax.reload();
                                    $('#sample_form')[0].reset();


                                }, 2000);

                            }
                            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    });
                }
            });


            $(document).on('click', '.show_new', function () {

                var id = $(this).attr('id');
                $('#form_result').html('');

                var target = '{{route('announcements.index')}}/' + id;

                $.ajax({
                    url: target,
                    dataType: "json",
                    success: function (result) {

                        $('#title_id').html(result.data.title);
                        $('#summary_id').html(result.data.summary);
                        $('#description_id').html(result.data.description);
                        $('#company_id_show').html(result.company_name);
                        if (result.department_name=='') {
                            // $('#department_id_show').html('All Department');
                            $('#department_id_show').html('{{trans('file.All_Department')}}');
                        }else{
                            $('#department_id_show').html(result.department_name);
                        }
                        $('#added_by_id').html(result.data.added_by);
                        $('#start_date_id').html(result.data.start_date);
                        $('#end_date_id').html(result.data.end_date);
                        if (result.data.is_notify == 1)
                            $('#notify_id').html('Yes');
                        else {
                            $('#notify_id').html('No');
                        }


                        $('#announcement_modal').modal('show');
                        $('.modal-title').text("{{__('Announcement Info')}}");
                    }
                });
            });


            $(document).on('click', '.edit', function () {


                var id = $(this).attr('id');
                $('#form_result').html('');

                $('.date').datepicker('update');


                var target = "{{ route('announcements.index') }}/" + id + '/edit';


                $.ajax({
                    url: target,
                    dataType: "json",
                    success: function (html) {
                        $('#title').val(html.data.title);
                        $('#start_date').val(html.data.start_date);
                        $('#end_date').val(html.data.end_date);
                        $('#summary').val(html.data.summary);
                        $('#description').val(html.data.description);
                        $('#company_id').selectpicker('val', html.data.company_id);

                        let all_departments = '<option value="0">All Department</option>';
                        $.each(html.departments, function (index, value) {
                            all_departments += '<option value=' + value['id'] + '>' + value['department_name'] + '</option>';
                        });
                        $('#department_id').empty().append(all_departments);
                        $('#department_id').selectpicker('refresh');
                        if (html.data.department_id==null) {
                            $('#department_id').selectpicker('val', '0');   
                        }
                        else{
                            $('#department_id').selectpicker('val', html.data.department_id);
                        }
                        
                        $('#department_id').selectpicker('refresh');

                        if (html.data.is_notify == 1) {
                            $('#is_notify_edit').prop('checked', true);
                        } else {
                            $('#is_notify_edit').prop('checked', false);
                        }


                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text('{{trans('file.Edit')}}');
                        $('#action_button').val('{{trans('file.Edit')}}');
                        $('#action').val('{{trans('file.Edit')}}');
                        $('#formModal').modal('show');
                    }
                })
            });


            let delete_id;

            $(document).on('click', '.delete', function () {
                delete_id = $(this).attr('id');
                $('#confirmModal').modal('show');
                $('.modal-title').text('{{__('DELETE Record')}}');
                $('#ok_button').text('{{trans('file.OK')}}');

            });


            $(document).on('click', '#bulk_delete', function () {

                var id = [];
                let table = $('#announcement-table').DataTable();
                id = table.rows({selected: true}).ids().toArray();
                if (id.length > 0) {
                    if (confirm('{{__('Delete Selection',['key'=>trans('file.Announcement')])}}')) {
                        $.ajax({
                            url: '{{route('mass_delete_announcements')}}',
                            method: 'POST',
                            data: {
                                announcementIdArray: id
                            },
                            success: function (data) {
                                let html = '';
                                if (data.success) {
                                    html = '<div class="alert alert-success">' + data.success + '</div>';
                                }
                                if (data.error) {
                                    html = '<div class="alert alert-danger">' + data.error + '</div>';
                                }
                                table.ajax.reload();
                                table.rows('.selected').deselect();
                                if (data.errors) {
                                    html = '<div class="alert alert-danger">' + data.error + '</div>';
                                }
                                $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                            }

                        });
                    }
                } else {
                    alert('{{__('Please select atleast one checkbox')}}');
                }
            });


            $('#close').on('click', function () {
                $('#sample_form')[0].reset();
                $('#announcement-table').DataTable().ajax.reload();
                $('select').selectpicker('refresh');
                $('.date').datepicker('update');
            });

            $('#ok_button').on('click', function () {
                let target = "{{ route('announcements.index') }}/" + delete_id + '/delete';
                $.ajax({
                    url: target,
                    beforeSend: function () {
                        $('#ok_button').text('{{trans('file.Deleting...')}}');
                    },
                    success: function (data) {
                        let html = '';
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                        }
                        if (data.error) {
                            html = '<div class="alert alert-danger">' + data.error + '</div>';
                        }
                        setTimeout(function () {
                            $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                            $('#confirmModal').modal('hide');
                            $('#announcement-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });

            $('.dynamic').change(function () {
                if ($(this).val() !== '') {
                    let value = $(this).val();
                    let dependent = $(this).data('dependent');
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('dynamic_department') }}",
                        method: "POST",
                        data: {value: value, _token: _token, dependent: dependent},
                        success: function (result) {
                            result = '<option value="0">All Department</option>' + result;
                            $('select').selectpicker("destroy");
                            $('#department_id').html(result);
                            $('select').selectpicker();

                        }
                    });
                }
            });

        })(jQuery); 
    </script>

@endsection