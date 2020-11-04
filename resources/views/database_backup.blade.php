@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/fixedHeader.dataTables.min.css') }}" />
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Mysql </h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
            <li><a>Backup</a></li>
            <li class="active"><strong>Mysql </strong></li>
        </ol>
    </div>
    <div class="col-sm-2">
        <div class="title-action">
            <a href="{{url('BackupDB')}}" class="btn btn-success">Backup DB</a>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Backup<small> Tables</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <input type="hidden" id='table_edit_id' name="">
                        <table class="table table-bordered table-hover table-striped" id='dataTable' width="100%">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Size</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.jqueryui.min.js')}}"></script>
<script src="{{ asset('public/js/buttons.jqueryui.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.responsive.js')}}"></script>
<script type="text/javascript">
    var dataTable = $('#dataTable').dataTable({
        "processing": true,
        "serverSide": true,
        "fixedHeader": true,
        "lengthMenu": [[50, 100, 200, 1000], [50, 100, 200, 1000, ] ],
        "ajax": {
            "url": "<?= url('BackupTable') ?>",
            "dataType": "json",
            "type": "POST",
            data: function(d) {
                d._token = "<?= csrf_token() ?>";
            },
        },
        "columns": [
        {"data": "name", 'width': '70%'},
        {"data": "size", 'width': '10%'},
        {"data": "action", 'visible': true },
        ],
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.delete', function() {
        if (!confirm("Are you sure?")) {return false; }
        var table_id = $(this).attr('table_id');
        $.ajax({
            url: 'Brand/delete/' + table_id,
            type: 'get',
            data: {
                _token: "<?= csrf_token() ?>",
                id: table_id
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.result != 'success') {alert(response.result); return false; }
                dataTable.fnDraw();
            }
        });
    });
</script>
@endsection