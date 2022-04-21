@extends('layout.main')

@section('content')


    <span id="form_result"></span>

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{__('General Setting')}}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic"></p>
                            <form method="POST"  id="general_settings_form" action="{{route('general_settings.update',1)}}" enctype="multipart/form-data">
                                @csrf


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{__('Project Description(APP)')}} *</strong></label>
                                            <textarea class="form-control" id="project_desc"
                                              name="project_desc" rows="5">{{$general_settings_data->project_desc ?? ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="submit" id="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        (function($) {
            "use strict";

            $("ul#setting").siblings('a').attr('aria-expanded','true');
            $("ul#setting").addClass("show");
            $("ul#setting #general-setting-menu").addClass("active");

            $('select[name=date_format]').val(($('#date_format_hidden')).val());

            if($("input[name='timezone_hidden']").val()){
                $('select[name=timezone]').val($("input[name='timezone_hidden']").val());
                $('.selectpicker').selectpicker('refresh');
            }

            $('.selectpicker').selectpicker({
                style: 'btn-link',
            });
        })(jQuery);
    </script>

@endsection
