@extends('layout')
@section('content')
<section id="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="bootstrap-data-table-panel">
                    <div class="table-responsive">
                    <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                    <td>Start date:</td>
                                    <td><input type="text" id="min" name="min"></td>
                                </tr>
                                <tr>
                                    <td>End date:</td>
                                    <td><input type="text"  id="max" name="max"></td>
                                </tr>
                            </tbody>
                        </table>
                        
                    <table id="feedback_table" style="width: 100%" class="table table-striped table-bordered display nowrap">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Registered Date</th> 
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="feedback_row">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /# card -->
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="footer">
                <p>{{date('Y')}} © Easy Solution.</p>
            </div>
        </div>
    </div>
</section>
@stop

@section('script')
<script>
    $(document).ready(function() {
        $('#min, #max').on('change', function() {
            $("#feedback_table").DataTable().draw();
        });

        $.ajax({
            type: "get",
            url: "{{url('get_app_user')}}",
            dataType: 'json',
            success: function(data) {

                $('#feedback_table').DataTable().clear().destroy();
                $.each(data, function(a, b) {
                    let status_button = 'Disabled <button value="1" class="btn btn-danger btn-sm disable_user" id="' + b.id + '"><i class="ti-na"> </i></button>';
                    if (b.status == 1) {
                        status_button = 'Active <button value="0" class="btn btn-success btn-sm disable_user" id="' + b.id + '"><i class="ti-check"> </i></button>';
                    }
                    $("#feedback_row").append(
                        '<tr><td>' + b.id + '</td><td>' + b.full_name + '</td><td>' + b.created_at.substring(0, 10) + '</td><td>' + b.email + '</td><td>' + b.mobile + '</td><td>' + b.address + '  ' + b.pincode + '</td><td>' + status_button + '</td></tr>'
                    );
                    //alert(data[j].fullname);
                });
                createtable();
            }
        });


        function createtable() {
            $("#feedback_table").dataTable({
                dom: 'Bfrtip',
                buttons: [
                     'excel', 'pdf'
                ],
                "info": true,
                "autoWidth": false,
                scrollX: true,

                responsive: true,
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                }],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
        }

        $("#feedback_table").on('click', '.disable_user', function() {
            $.ajax({
                type: "get",
                url: "{{url('disable_user')}}",
                dataType: 'json',
                data: {
                    id: $(this).attr('id'),
                    value: $(this).attr('value')
                },
                success: function(data) {
                    location.reload();
                    
                }
            });
        })


    })
</script>
@stop