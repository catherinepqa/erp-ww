@extends('template')

@section('title', 'Invoices')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">

    <style>
        .fa-file-excel-o {
            color : #28a745;
        }
        .fa-file-pdf-o {
            color : #dc3545;
        }
        .fa-print {
            color : #007bff;
        }

        .previous > a {
            width: 100px;
            text-align: center;
        }

        .next > a {
            width: 100px;
            text-align: center;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Invoices</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Sales</li>
                <li class="breadcrumb-item active" aria-current="page">Invoices</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-6 col-sm-12 text-right hidden-xs">
        <a class="btn btn-sm btn-primary" title="New Invoice" href="{{ url('sales/invoices/new') }}" style="width: 150px !important;" >New Invoice</a>
    </div>
@endsection

@section('content')
   <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-lg-12">
                            <ul class="accordion2">
                                <li class="accordion-item">
                                    <h3 class="accordion-thumb"><span>Filter</span></h3>
                                    <div class="accordion-panel" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control">
                                                        <option>Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <select class="form-control">
                                                        <option>Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Style</label>
                                                    <select class="form-control">
                                                        <option>Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" style="margin-bottom: 15px;">
                                                <button class="btn btn-info pull-right" type="button">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="dt" class="table table-striped table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>Sales Order No.</th>
                                            <th>Sales Order Date</th>
                                            <th>Customer</th>
                                            <th style="width: 4%;"</th>
                                           
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
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        $(function() {
            $(".accordion-thumb").click(function() {
                $(this).closest( "li" ).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
            });

           
            $('#dt').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend:    'copyHtml5',
                        text:      '<i class="fa fa-files-o"></i>',
                        titleAttr: 'Copy'
                    },
                    {
                        extend:    'csvHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF'
                    },
                    {
                        extend:    'print',
                        text:      '<i class="fa fa-print"></i>',
                        titleAttr: 'Print'
                    }
                ]
            });
        });
    </script>
@endsection
