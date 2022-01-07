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
                                    <td><input type="text"  id="min" name="min"></td>
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
                                    <th>Service Code</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Brand Name</th>
                                    <th>Appliance </th>
                                    <th>Accessory</th>
                                    <th>Date Of Purchase</th>
                                    <th>Specifique Requirements</th>
                                    <th>User Rating</th>

                                    <th width="10%">Action</th>
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
            url: "{{url('get_installation_request')}}",
            dataType: 'json',
            success: function(data) {
                console.log(data);

                $('#feedback_table').DataTable().clear().destroy();
                $.each(data, function(a, b) {
                    let status = 'Processing';
                    b.status == 2 ? status = '<span class=" font-weight-bold text-primary">Aceepted</span>' : '';
                    b.status == 3 ? status = '<span class=" font-weight-bold text-success">Completed</span>' : '';
                    b.status == 0 ? status = '<span class=" font-weight-bold text-danger">Canceled</span>' : '';
                    let rating;
                 b.rating ? rating='<i class="ti-star color-warning border-warning"></i> ' +b.rating :rating='Not rated';

                    $("#feedback_row").append(
                        '<tr><td>' + b.id + '</td><td>' + b.service_code + '</td><td>' + b.created_at.substring(0, 10) + '</td><td>' + b.full_name + '</td><td>' + b.mobile + '</td><td>' + b.address + ' ' + b.pincode + '</td><td>' + b.brand_name + '</td><td>' + b.appliance_name + '</td><td>' + b.accessory_name + '</td><td>' + b.date_of_purchase + '</td><td>' + b.specific_requirement + '</td><td>' + rating + '<p id="class'+b.id+'" class="review_length">'+b.review+'</p></td><td><a title="Cancel Request"  class="btn btn-danger btn-xs rounded-circle change_status" value="0" id=' + b.id + '><i class="fa fa-times"></i></a> &nbsp;<a title="Accept Request"  class="btn btn-primary btn-xs rounded-circle change_status" value="2" id=' + b.id + ' ><i class="fa fa-check"></i></a>&nbsp;<a  title="Complete Request" class="btn btn-success btn-xs rounded-circle change_status" value="3" id=' + b.id + ' ><i class="fa fa-check-square-o"></i></a><br>' + status + '</td></tr>'
                    );
                    //alert(data[j].fullname);
                });
                createtable();
            }
        });

        $("#feedback_table").on('click', '.review_length', function() {
            id=$(this).attr('id');
            $("#"+id).toggleClass('review_length_max');
        })

        $("#feedback_table").on('click', '.change_status', function() {

            $.ajax({
                type: "get",
                url: "{{url('change_status')}}",
                dataType: 'json',
                data: {
                    id: $(this).attr('id'),
                    value: $(this).attr('value'),
                    type: 'installation_request'
                },
                success: function(data) {
                    location.reload();

                }
            });
        })

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
    })
</script>
@stop