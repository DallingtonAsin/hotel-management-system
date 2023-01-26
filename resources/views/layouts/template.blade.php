<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="DallingtonCompanies">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title><?= isset($companyData) ? $companyData['company_name'] : env('APP_NAME') ?></title>

    <script>
        window.Laravel = { csrfToken: 'csrf_token()' }
    </script>

    <script src="{{ asset('vendors/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/routes/index.js') }}"></script>
    <script src="{{ asset('vendors/jquery-modal/jquery.modal.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/dtables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/dataTables.select.min.js') }}"></script>


    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
    <script src="{{ asset('vendors/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('vendors/js/bootstrap3-typeahead.min.js') }}"></script>

    <script src="{{ asset('js/custom/ajax.js') }}"></script>
    <script src="{{ asset('vendors/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendors/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('vendors/wickedpicker/src/wickedpicker.js') }}"></script>
    <script src="{{ asset('vendors/jquery-tabledit/jquery.tabledit.min.js') }}"></script>
    <script src="{{ asset('vendors/js/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendors/js/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('vendors/js/sidebar-dropdown.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle-5.0.2.min.js') }}"></script>


    <script src="{{ asset('vendors/js/azia.js') }}"></script>
    <script src="{{ asset('js/custom/datatables.js') }}"></script>
    <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('vendors/custom/echarts.js') }}"></script>
    <script src="{{ asset('js/custom/common.js') }}"></script>

    <link href="{{ asset('css/nunito.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/azia.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap-5.2.min.css') }}">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/notification.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables/dtables/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables/dtables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/js/dataTables.jqueryui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/js/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendors/toastr/css/toastr.min.css') }}">
    <script src="{{ asset('vendors/toastr/js/toastr.min.js') }}"></script>

    <link href="{{ asset('vendors/ionicons/docs/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/wickedpicker/stylesheets/wickedpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/must-load.css') }}" rel="stylesheet" media="all">

    <script>
        var permissions = {!! json_encode(config('permissions')) !!};
    </script>
</head>


@auth
    <body>
        <div class="az-body az-body-sidebar az-light">
            @include('layouts.sidebar')
        </div>

    </body>
@endauth

</html>
