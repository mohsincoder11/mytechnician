@extends('layout')
@section('content')
<section id="main-content">

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card-title">
                            <h4>Add Resell Product</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form id="form" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="hidden" id="edit_id" name="edit_id">
                                    <input type="hidden" id="exist_image" name="exist_image">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Appliance Category</label>
                                                <select class="form-control selectpicker" name="appliance_id" id="appliance_id">
                                                    @foreach ($appliance as $a)
                                                    <option value="{{$a->id}}">{{$a->appliance_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Brand Name</label>
                                                <input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="Brand name" required>
                                                <p class="text-danger m-t-10" id="accessory_error">This field is required</p>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product name" required>
                                                <p class="text-danger m-t-10" id="accessory_error">This field is required</p>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="number" name="price" id="price" class="form-control" placeholder="Price" required>
                                                <p class="text-danger m-t-10" id="accessory_error">This field is required</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Warranty (In Month)</label>
                                                <input type="number" value="0" name="warranty" id="warranty" class="form-control" placeholder="Warranty" required>
                                                <p class="text-danger m-t-10" id="accessory_error">This field is required</p>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description of product" required></textarea>
                                                <p class="text-danger m-t-10" id="accessory_error">This field is required</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="file-upload">
                                                    <label for="upload" class="file-upload__label"><i class="fa fa-upload"></i>
                                                        &nbsp;Select Images</label>
                                                    <input id="upload" class="file-upload__input" type="file" name="images[]" multiple>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10" id="image_upload">


                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary "><span id="btn_text">Add</span></button>

                                                <button type="button" class="btn btn-danger reload"><span id="btn_text2">Clear</span></button>
                                            </div>
                                        </div>


                                    </div>



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
                                            <th>Product </th>
                                            <th>Price </th>
                                            <th>Warranty </th>
                                            <th>Description </th>
                                            <th>Images </th>
                                            <th>Status </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="accessory_table_body">

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

<script src="{{asset('public/assets/js/lib/toastr/toastr.min.js')}}"></script>
<script src="{{asset('public/assets/js/lib/toastr/toastr.init.js')}}"></script>

<script>
    $(document).ready(function() {
        get_resell_data();
        var edit_id = null;
        $(".text-danger").hide();

        $('#form').on('submit', (function(e) {
            console.log(1);
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{url('insert_resell_master')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    success_toaster();
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(data) {
                    alert('server error');
                }
            });
        }));

        function get_resell_data() {
            $.ajax({
                type: "get",
                url: "{{url('get_resell_data')}}",
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(a, b) {
                        let images = (b.images).replace(/["]+/g, '');
                        images = images.split(",");
                        var html = "";
                        $.each(images, function(a, b) {
                            html += '<img class="resell_image" src="{{asset("public/assets/images/resell_product")}}/' + b + '">';
                        })
                        let status;
                        b.status==1 ? status='<button class="btn btn-secondary btn-sm">On Sale</button>' : '';
                        b.status==2 ? status='<button class="btn btn-primary btn-sm">Order Received</button>' : '';
                        b.status==3 ? status='<button class="btn btn-success btn-sm">Sold</button>' : '';
                        $("#accessory_table_body").append(
                            '<tr> <td>' + b.id + '</td><td>' + b.appliance_name + '</td><td><b>' + b.brand_name + '</b> - ' + b.product_name + '</td><td>' + b.price + '</td> <td>' + b.warranty + ' M</td> <td><p id="class'+b.id+'" class="review_length">'+b.description+'</p></td><td id="image' + b.id + '">' + html + ' </td><td>'+status+'</td> <td><button class="btn btn-warning edit_btn btn-sm" id="' + b.id + '"><i class="fa fa-edit "></i></button> <button class="btn btn-danger delete_btn btn-sm" id="' + b.id + '"><i class="fa fa-trash "></i></button></td></tr>'
                        );

                    });

                    createtable();
                }
            });
        }

        $('#accessory_table tbody').on('click', '.review_length', function() {
            id=$(this).attr('id');
            $("#"+id).toggleClass('review_length_max');
        })

        $("#upload").on('change', function() {
            $("#image_upload").empty();
            if (this.files) {
                [].forEach.call(this.files, readAndPreview);
            }

        })

        function readAndPreview(file) {
            var preview = document.querySelector('#image_upload');
            var reader = new FileReader();
            reader.addEventListener("load", function() {
                var image = new Image();
                image.height = 100;
                image.width = 100;
                image.title = file.name;
                image.src = this.result;
                preview.appendChild(image);
            });
            reader.readAsDataURL(file);
        }



        $(".reload").on('click', function() {
            location.reload();
        })


        $('#accessory_table tbody').on('click', '.delete_btn', function() {
            $.ajax({
                type: "get",
                url: "{{url('delete_resell')}}",
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


        $('#accessory_table tbody').on('click', '.edit_btn', function() {
            $.ajax({
                type: "get",
                url: "{{url('edit_resell_item')}}",
                dataType: 'json',
                data: {
                    id: $(this).attr('id')
                },
                success: function(data) {
                    $("#image_upload").empty();
                    $("#exist_image").val(data.images);
                    $("#appliance_id").val(data.appliance_id);
                    $("#edit_id").val(data.id);
                    $("#btn_text").text('Update');
                    $("#brand_name").val(data.brand_name);
                    $("#product_name").val(data.product_name);
                    $("#price").val(data.price);
                    $("#warranty").val(data.warranty);
                    $("#description").val(data.description);
                    let images = (data.images).replace(/["]+/g, '');
                    images = images.split(",");
                    var html = "";
                    $.each(images, function(a, b) {
                        html += '<img class="resell_image2" src="{{asset("public/assets/images/resell_product")}}/' + b + '">';

                    })
                    $("#image_upload").append(html);
                }
            });
        })

        function createtable() {
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
        }


    })
</script>

@stop