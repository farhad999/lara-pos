<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{config('app.name')}}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/vendor/bootstrap-4/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/swal/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/toast/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/data-table/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{asset('/vendor/adminLTE/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css"
          integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{asset('app.css')}}">
    @yield('styles')

</head>
<body>
<div>
    <div>
        @include('pertials.sidebar')
        @include('pertials.header')
    </div>

    <div class="content-wrapper px-2">
        @yield('main')
    </div>
</div>
<script src="{{asset('/vendor/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('vendor/popper.min.js')}}"></script>
<script src="{{asset('/vendor/bootstrap-4/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/vendor/select2/js/select2.full.js')}}"></script>
<script src="{{asset('/vendor/toast/toastr.js')}}"></script>
<script src="{{asset('/vendor/swal/sweetalert2.min.js')}}"></script>
<script src="{{asset('/vendor/data-table/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/vendor/adminLTE/js/adminlte.min.js')}}"></script>
<script src="{{asset('/vendor/jquery.validate.min.js')}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('ul').Treeview();

</script>

@yield('scripts')
</body>
</html>
