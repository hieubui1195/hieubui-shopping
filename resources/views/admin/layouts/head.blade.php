<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>@lang('custom.common.title')</title>

<!-- Bootstrap -->
{{ Html::style('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}
<!-- Font Awesome -->
{{ Html::style('assets/Font-Awesome/web-fonts-with-css/css/fontawesome-all.min.css') }}
<!-- Ionicons -->
{{ Html::style('assets/Ionicons/css/ionicons.min.css') }}
<!-- Select2 -->
{{ Html::style('assets/select2/dist/css/select2.min.css') }}
<!-- Datatables -->
{!! Html::style('assets/datatables.net-dt/css/jquery.dataTables.min.css') !!}
<!-- Bootstrap Daterangepicker -->
{!! Html::style('assets/bootstrap-daterangepicker/daterangepicker.css') !!}
{!! Html::style('assets/sweetalert2/dist/sweetalert2.min.css') !!}
<!-- Theme style -->
{{ Html::style('dist/css/AdminLTE.min.css') }}
<!-- AdminLTE Skins -->
{{ Html::style('dist/css/skins/_all-skins.min.css') }}
<!-- Main css -->
{{ Html::style('css/admin/main.css') }}
<!-- Google Font -->
{{ Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic') }}
