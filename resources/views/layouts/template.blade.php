<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="description" content="{{ config('app.name') }}">
  <meta name="author" content="DallingtonCompanies">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title><?= isset($companyData) ? $companyData['company_name']:  env('APP_NAME') ?></title>

  <script>window.Laravel = { csrfToken: 'csrf_token()' }</script>
  <script src="{{ asset('vendors/js/jquery-3.3.1.js') }}"></script>
  <script src="{{ asset('vendors/jquery-modal/jquery.modal.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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
  <script src="{{ asset('vendors/js/customJs.js') }}"></script>
  <script src="{{ asset('vendors/jquery-confirm/jquery-confirm.min.js') }}"></script>
  <script src="{{ asset('vendors/calendar/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('vendors/calendar/moment.min.js') }}"></script>
  <script src="{{ asset('vendors/calendar/fullcalendar.min.js') }}"></script>
  <script src="{{ asset('vendors/js/bootstrap3-typeahead.min.js') }}"></script>
  <script src="{{ asset('js/Chart.min.js') }}"></script>

  <script src="{{ asset('vendors/js/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('vendors/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>
  <script src="{{ asset('vendors/wickedpicker/src/wickedpicker.js') }}"></script>
  <script src="{{ asset('vendors/laravel-ckeditor-master/ckeditor.js') }}"></script>
  <script src="{{ asset('vendors/jquery-tabledit/jquery.tabledit.min.js') }}"></script>
  <script src="{{ asset('vendors/js/jquery.flot.js') }}"></script>
  <script src="{{ asset('vendors/js/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('vendors/js/Chart.bundle.min.js') }}"></script>
  <script src="{{ asset('vendors/js/chart.flot.sampledata.js') }}"></script>
  <script src="{{ asset('vendors/js/azia.js') }}"></script>
  <script src="{{ asset('js/external.min.js') }}"></script>
  <script src="{{ asset('vendors/custom/custom-datatables.js') }}"></script>

  <link rel="stylesheet" href="{{ asset('vendors/fonts/montserrat/css.css') }}">
  <link href="{{ asset('vendors/calendar/fullcalendar.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/nunito.css') }}" rel="stylesheet">
  <!-- <link href="{{ asset('css/hotel.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('vendors/css/azia.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  <link href="{{ asset('css/css.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/notification.css') }}" rel="stylesheet">
  
  <link href="{{ asset('vendors/datatables/dtables/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/datatables/dtables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet"/>

  <link href="{{ asset('vendors/js/dataTables.jqueryui.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/js/jquery-ui.css') }}" rel="stylesheet">
  <!-- <link href="{{ asset('vendors/fontawesome/css/font-awesome-4.7.min.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('vendors/fontawesome/css/all.min.css') }}" rel="stylesheet">
 
  <link href="{{ asset('vendors/ionicons/docs/css/ionicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/themify-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/typicons.font/typicons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/morris.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/flag-icon.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/jqvmap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/wickedpicker/stylesheets/wickedpicker.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">
  <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
  <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">

  <link href="{{ asset('vendors/jquery-modal/jquery.modal.min.css') }}" rel="stylesheet">


  <style>
   html, body {
      max-width: 100%;
      overflow: scroll;
      overflow-x: hidden;
    }

  ::-webkit-scrollbar {
    width: 0;
    /* background: transparent; */
  }

/* ::-webkit-scrollbar-thumb {
    background: #FF0000;
} */

.table-responsive{
  overflow: auto !important;
}

.az-header-center > div {
  text-align: center;
  display: block;
  }

  .az-header-center > div > i {
     font-weight: 'bold'
  }

  .icon-img{
    width:40px !important;
    height:40px !important;
  }

  .icon-img-1{
    width:45px !important;
    height:45px !important;
  }

  .icon-img-2{
    width:30px !important;
    height:30px !important;
  }

  .header-caption{
    font-size: 12px !important
  }

  .az-header-center > div > a > h6 {
    color: #009688 !important;
    font-size: 13px !important;
    font-weight:'bold' !important;
  }

  .fa-home{
    font-size: 16px !important;
  }

  </style>
</head>


@auth
<body>
  <div class="az-body az-body-sidebar az-light">
    @include('layouts.sidebar')
  </div>

</body>
@endauth </html>