<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Technicians Admin Dashboard</title>
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <!-- Retina iPad Touch Icon-->
    <!-- Styles -->
    <link href="{{asset('public/assets/css/lib/calendar2/pignose.calendar.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/chartist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/lib/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/lib/weather-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/lib/menubar/sidebar.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/helper.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/admin/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/admin/datetime.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/toastr/toastr.min.css')}}" rel="stylesheet">
    <style>
        .price{
            font-weight: bold;
            color: #000000;
        }
        .review_length {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 150px;
            cursor: pointer;

        }

        .review_length_max {
            overflow: visible;
            white-space: initial;
            max-width: 100%;
        }

        .resell_image2 {
            height: 8vh;
            width: 8vh;
            margin-right: 2vh;
            border-radius: 5px;
        }

        .resell_image {
            height: 4vh;
            width: 4vh;
            margin-right: 2vh;
            border-radius: 5px;
            transition: 0.5s ease-in-out;

        }

        .resell_image:hover {
            transform: scale(4);
            transition: 0.8s ease-in-out;
        }

        .logo span {
            color: #ffffff;
        }

        .fa {
            color: #fff;
        }

        .file-upload {
            position: relative;
            display: inline-block;
        }

        .file-upload__label {
            display: block;
            padding: 0.5em 1em;
            color: #fff;
            background: #12b525;
            border-radius: .4em;
            transition: background .3s;


        }

        .file-upload__input {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            font-size: 1;
            width: 0;
            height: 100%;
            opacity: 0;
        }
    </style>
</head>

<body>

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <div class="logo"><a href="index.html">
                            <span>My Technicians Panel</span>
                        </a></div>

                    <li><a href="{{url('/')}}"><i class="ti-home"></i> Dashboard </a></li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-plus"></i> Master <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{url('master')}}">Appliance & Accessory</a></li>

                            <li><a href="{{url('resell_master')}}">Resell Products</a></li>


                        </ul>
                    </li>
                    
                    <li><a href="{{url('resell_order')}}"><i class="ti-back-right"></i> Resell Order </a></li>
                    <li><a href="{{url('service_request')}}"><i class="ti-headphone-alt"></i> Service Request </a></li>
                    <li><a href="{{url('installation_request')}}"><i class="ti-settings"></i> Installation Request </a></li>
                    <li><a href="{{url('accessory_req')}}"><i class="ti-plug"></i> Accessory Order </a></li>
                    <li><a href="{{url('extend_warrenty')}}"><i class="ti-medall-alt"></i> Extend Warrenty </a></li>
                    <li><a href="{{url('app_user')}}"><i class="ti-user"></i> App User</a></li>

                    <li><a href="{{url('feedback')}}"><i class="ti-write"></i> App Feedback </a></li>
                    <li><a href="{{url('log_out')}}"><i class="ti-power-off "></i> Log Out </a></li>


                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->

    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <div class="hamburger sidebar-toggle">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                    <div class="float-right">

                        <div class="dropdown dib">
                            <div class="header-icon">
                                <span class="user-avatar">
                                    <B>{{ ucfirst(Session::get('userdata'))}}</B>&nbsp;&nbsp;<a class="btn btn-danger btn-sm btn-rounded"href="{{url('log_out')}}"><i class="ti-power-off "></i>  </a>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Hello, <span>Welcome Here</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->

                @yield('content')








            </div>
        </div>
    </div>

    <!-- jquery vendor -->
    <script src="{{asset('public/assets/js/lib/jquery.min.js')}}"></script>
    <script src="{{asset('public/assets/js/lib/jquery.nanoscroller.min.js')}}"></script>
    <!-- nano scroller -->
    <script src="{{asset('public/assets/js/lib/menubar/sidebar.js')}}"></script>
    <script src="{{asset('public/assets/js/lib/preloader/pace.min.js')}}"></script>
    <!-- sidebar -->

    <script src="{{asset('public/assets/js/lib/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/assets/js/scripts.js')}}"></script>
    <!-- bootstrap -->

    <script src="{{asset('public/assets/js/lib/calendar-2/moment.latest.min.js')}}"></script>


    <script src="{{asset('public/assets/js/lib/data-table/jquery.dataTables.min2.js')}}"></script>
    <script src="{{asset('public/assets/js/momentjs.js')}}"></script>
    <script src="{{asset('public/assets/js/datetime.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <!-- scripit init-->
    <script src="{{asset('public/assets/js/dashboard2.js')}}"></script>
    <script>
        $(document).ready(function() {

            //$(".pace-done").addClass('sidebar-hide');
        })

        function delete_toaster() {
            toastr.error('Record deleted successfully.', 'Delete', {
                timeOut: 1500,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            })
        }

        function success_toaster() {
            toastr.success('Record added successfully.', 'Success', {
                timeOut: 1500,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            })
        }

        function Update_toaster() {
            toastr.success('Record updated successfully.', 'Success', {
                timeOut: 1500,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            })
        }

        function user_status_toaster() {
            toastr.success('User status changed successfully.', 'Success', {
                timeOut: 1500,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            })
        }

        var minDate, maxDate;

// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date(data[2]);

        if (
            (min == null && max == null) ||
            (min == null && date <= max) ||
            (min <= date && max == null) ||
            (min <= date && date <= max)
        ) {
            return true;
        }
        return false;
    }
);

minDate = new DateTime($('#min'), {
    format: 'YYYY-MM-DD'
});
maxDate = new DateTime($('#max'), {
    format: 'YYYY-MM-DD'
});
    </script>
    @yield('script')
</body>

</html>