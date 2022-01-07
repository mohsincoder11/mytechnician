<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Focus Admin: Widget</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->

    <!-- Styles -->
    <link href="{{asset('public/assets/css/lib/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/lib/helper.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('public/assets/css/admin/snackalert.css')}}" />

    <title>Login | My Technician</title>
    <style>
        .box_shadow{
            box-shadow: rgb(208 208 208) 0px 8px 24px;  
              }
    </style>

</head>

<body class="bg-primary">

    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div class="login-content box_shadow">
                        <!-- <div class="login-logo">
                            <a href="index.html"><span>Focus</span></a>
                        </div> -->
                        <div class="login-form">
                            <h4>My Technicians</h4>
                            <form id="login_form" >
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                </div>

                                <button type="button" id="login_btn" class="btn btn-primary btn-flat m-b-30 m-t-10">Sign in</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="snackbar">Incorrect Username Or Password</div>

    <script src="{{asset('public/assets/js/lib/jquery.min.js')}}"></script>

    <script>
        $(document).ready(function() {
          
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $('#login_btn').on('click',function() {
                console.log(1);
                    $.ajax({
                    type: "get",
                    url: "{{url('check_login')}}",
                    data: {_token: CSRF_TOKEN,username:$("#username").val(),password:$("#password").val()},
                    dataType: 'json',
                     success: function(data) {
                        if (data == 1) {
                            window.location.href = "{{Route('dashboard')}}";
                        } else {
                            var x = document.getElementById("snackbar");
                            x.className = "show";
                            setTimeout(function() {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        }
                  
                    }
                });
            })
        })
    </script>
</body>

</html>