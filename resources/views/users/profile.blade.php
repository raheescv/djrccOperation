@extends('layouts.app')
@section('style')
<style type="text/css">
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
#img-upload{
    width: 100%;
}
#logo-upload{
    width: 100%;
}
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
            <li><a>Company</a></li>
            <li class="active"><strong>Profile</strong></li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Remarks<small> Tables</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {!! Form::open(array('url' => '/profile_update','files'=>'true','id'=>'profile-form','class'=>'form-sample','method'=>'post','enctype'=>'multipart/form-data')); !!}
                    <div class="form-group row">
                        <div class="col-md-4">
                            {{Form::label('company','Company')}}
                            {{Form::text('company',$Profile->company,['class'=>'form-control','placeholder'=>'Enter Company Name'])}}
                        </div>
                        <div class="col-md-4">
                            {{Form::label('header','Header')}}
                            {{Form::text('header',$Profile->header,['class'=>'form-control','placeholder'=>'Enter Header Name'])}}
                        </div>
                        <div class="col-md-4">
                            {{Form::label('footer','Footer')}}
                            {{Form::text('footer',$Profile->footer,['class'=>'form-control','placeholder'=>'Enter Footer Name'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4" >
                            {{Form::label('address_line_1','Address line 1')}}
                            {{Form::text('address_line_1',$Profile->address_line_1,['class'=>'form-control','placeholder'=>'Enter Address line 1 Name'])}}
                        </div>
                        <div class="col-md-4" >
                            {{Form::label('address_line_2','Address line 2')}}
                            {{Form::text('address_line_2',$Profile->address_line_2,['class'=>'form-control','placeholder'=>'Enter Address line 2 Name'])}}
                        </div>
                        <div class="col-md-4" >
                            {{Form::label('address_line_3','Address line 3')}}
                            {{Form::text('address_line_3',$Profile->address_line_3,['class'=>'form-control','placeholder'=>'Enter Address line 3 Name'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6" >
                            {{Form::label('email','Email')}}
                            {{Form::text('email',$Profile->email,['class'=>'form-control','placeholder'=>'Enter Email Adderess'])}}
                        </div>
                        <div class="col-md-6" >
                            {{Form::label('mobile','Mobile')}}
                            {{Form::text('mobile',$Profile->mobile,['class'=>'form-control','placeholder'=>'Enter Mobile No'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… {{Form::file('image_upload',['id'=>'imgInp'])}}
                                        </span>
                                    </span>
                                    {{Form::text('image',$Profile->image,['class'=>'form-control','readonly'])}}
                                </div>
                                <img id='img-upload' src="{{ url('public/profile').'/'.$Profile->image}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… {{Form::file('logo_upload',['id'=>'logoInp'])}}
                                        </span>
                                    </span>
                                    {{Form::text('logo',$Profile->logo,['class'=>'form-control','readonly'])}}
                                </div>
                                <img id='logo-upload' src="{{ url('public/profile').'/'.$Profile->logo }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-offset-5 col-md-8">
                            <button name="submit" type="submit" id='submit_button' class="btn btn-primary">Update My Profile</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
            log = label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
        function readImageURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readLogoURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#logo-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgInp").change(function(){
            readImageURL(this);
        });
        $("#logoInp").change(function(){
            readLogoURL(this);
        });
    });
    $('#submit_button').click(function(){
        var company=$('#company').val();
        if(!company)
        {
            $('#company').focus();
            return false;
        }
        var data=$('#profile-form').serialize();
        var url_address="<?= url('profile_ajax') ?>";
        $.post( url_address,data, function( response ) {
            if(response.result!='success')
            {
                alert(response.result);
                return false;
            }
        }, "json");
    });
</script>
@endsection
