@extends('layout')
@section('content')
<section id="main-content">

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card-title">
                            <h4>Add Appliance</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form>
                                    <div class="form-group">
                                        <label>Appliance Name</label>
                                        <input type="text" id="appliance_name" name="appliance_name" class="form-control" placeholder="applicance name">
                                        <p class="text-danger m-t-10" id="appliance_error">This field is required</p>
                                    </div>
                                    <button type="button" id="add_appliance" class="btn btn-primary "><span id="btn_text">Add</span></button>
                                    <button type="button" class="btn btn-danger reload"><span id="btn_text">Clear</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="appliance_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appliance_data as $a)
                                        <tr>
                                            <td>{{$a->id}}</td>
                                            <td>{{$a->appliance_name}}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit_btn" id="{{$a->id}}">
                                                    <i class="ti-pencil-alt"> </i>
                                                </button>
                                                <button class="btn btn-danger btn-sm  delete_btn" id="{{$a->id}}">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card-title">
                            <h4>Add Accessory</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form>
                                    <div class="form-group">
                                        <label>Select Appliance</label>
                                        <select class="form-control selectpicker" name="appliance_id" id="appliance_id">
                                            @foreach ($appliance_data as $a)
                                            <option value="{{$a->id}}">{{$a->appliance_name}}</option>

                                            @endforeach

                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label>Accessory Name</label>
                                        <input type="text" name="accessory_name" id="accessory_name" class="form-control" placeholder="accessory name">
                                        <p class="text-danger m-t-10" id="accessory_error">This field is required</p>

                                    </div>
                                    <button type="button" id="add_accessory" class="btn btn-primary "><span id="btn_text2">Add</span></button>
                                    <button type="button" class="btn btn-danger reload"><span id="btn_text">Clear</span></button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="accessory_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Appliance</th>
                                            <th>Accessory </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="accessory_table_row">
                                        @foreach ($accessory_data as $acc)

                                        <tr>
                                            <td>{{$acc->id}}</td>
                                            <td>{{$acc->appliance_name}}</td>
                                            <td>{{$acc->accessory_name}}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit_btn2" id="{{$acc->id}}">
                                                    <i class="ti-pencil-alt"> </i>
                                                </button>
                                                <button class="btn btn-danger btn-sm  delete_btn2" id="{{$acc->id}}">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="footer">
                <p>{{date('Y')}} © Easy Solution</a></p>
            </div>
        </div>
    </div>
</section>

@stop

@section('script')
@if(count($accessory_data)>0)
<script>
    $("#accessory_table").dataTable({
        "info": true,
        "autoWidth": false,
        "order": [
            [0, "desc"]
        ],
        "columnDefs": [{
            "targets": [0],
            "visible": false,
        }],
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        }
    });
</script>
@endif

@if(count($appliance_data)>0)
<script>
    $("#appliance_table").dataTable({
        "info": true,
        "autoWidth": false,
        "order": [
            [0, "desc"]
        ],
        "columnDefs": [{
            "targets": [0],
            "visible": false,
        }],
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        }
    });
</script>
@endif
<script src="{{asset('public/assets/js/lib/toastr/toastr.min.js')}}"></script>
<script src="{{asset('public/assets/js/lib/toastr/toastr.init.js')}}"></script>

<script>
    $(document).ready(function() {
        var edit_id = null;
        var accessory_edit_id = null;
        $(".text-danger").hide();

        $("#add_appliance").on('click', function() {
            if ($("#appliance_name").val()) {
                $("#appliance_error").hide();
                $.ajax({
                    type: "get",
                    url: "{{url('add_appliance')}}",
                    dataType: 'json',
                    data: {
                        appliance_name: $("#appliance_name").val(),
                        edit_id: edit_id
                    },
                    success: function(data) {
                        if (data > 0)
                            success_toaster();
                        else
                            Update_toaster();

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                });
            } else
                $("#appliance_error").show();

        })

        $("#add_accessory").on('click', function() {

            if ($("#accessory_name").val()) {
                $("#accessory_error").hide();
                $.ajax({
                    type: "get",
                    url: "{{url('add_accessory')}}",
                    dataType: 'json',
                    data: {
                        accessory_name: $("#accessory_name").val(),
                        appliance_id: $("#appliance_id").val(),
                        accessory_edit_id: accessory_edit_id
                    },
                    success: function(data) {
                        if (data > 0)
                            success_toaster();
                        else
                            Update_toaster();

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                });
            } else
                $("#accessory_error").show();

        })

        $(".reload").on('click', function() {
            location.reload();
        })


        $("#appliance_table").on('click', '.delete_btn', function() {
            $.ajax({
                type: "get",
                url: "{{url('delete_appliance')}}",
                dataType: 'json',
                data: {
                    id: $(this).attr('id')
                },
                success: function(data) {
                    delete_toaster();

                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            });
        })

        $("#accessory_table").on('click', '.delete_btn2', function() {
            $.ajax({
                type: "get",
                url: "{{url('delete_accessory')}}",
                dataType: 'json',
                data: {
                    id: $(this).attr('id')
                },
                success: function(data) {
                    delete_toaster();

                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            });
        })

        $("#appliance_table").on('click', '.edit_btn', function() {
            $.ajax({
                type: "get",
                url: "{{url('edit_appliance')}}",
                dataType: 'json',
                data: {
                    id: $(this).attr('id')
                },
                success: function(data) {
                    $("#appliance_name").val(data.appliance_name);
                    edit_id = data.id;
                    $("#btn_text").text('Update');
                }
            });
        })

        $("#accessory_table").on('click', '.edit_btn2', function() {
            $.ajax({
                type: "get",
                url: "{{url('edit_accessory')}}",
                dataType: 'json',
                data: {
                    id: $(this).attr('id')
                },
                success: function(data) {
                    console.log(data.appliance_id);
                    $("#accessory_name").val(data.accessory_name);
                    $("#appliance_id").val(data.appliance_id);
                    accessory_edit_id = data.id;
                    $("#btn_text2").text('Update');
                }
            });
        })

    })
</script>

@stop