@extends('layout')
@section('content')

<section id="main-content">
    <div class="row">
       
    
    <div class="col-lg-3  go_to" link="service_request">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-back-right color-dark border-dark"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Resell Order Request</div>
                        <div class="stat-digit">{{$resell_product_request}}</div>
                    </div>
                </div>
            </div>
        </div> 
        
        <div class="col-lg-3  go_to" link="service_request">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-headphone-alt color-info border-info"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Service Request</div>
                        <div class="stat-digit">{{$service_requests}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 go_to" link="installation_request">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-settings color-success border-success"></i>
                    </div>
                    <div class="stat-content dib">

                        <div class="stat-text">Installation Request</div>
                        <div class="stat-digit">{{$installation_requests}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3  go_to" link="accessory_req">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-plug color-pink border-pink"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Accessory Order</div>
                        <div class="stat-digit">{{$accessory_order}}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3  go_to" link="extend_warrenty">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-medall-alt color-muted border-muted"></i></div>
                    <div class="stat-content dib">
                        <div class="stat-text">Extend Warrenty </div>
                        <div class="stat-digit">{{$extend_warranties}}</div>
                    </div>
                </div>
            </div>
        </div>       


        <div class="col-lg-3  go_to" link="app_user">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total App User</div>
                        <div class="stat-digit">{{$total_user}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3  go_to" link="feedback">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-write color-danger border-danger"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Feedback Received</div>
                        <div class="stat-digit">{{$feedback}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3  go_to" link="feedback">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-star color-warning border-warning"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Avg Service Rating</div>
                        <div class="stat-digit">{{number_format((float)$avg_rating, 1, '.', '')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
      

        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                <div id="totalorderchart">

</div>                </div>
            </div>
        </div>
    </div>
   
  
   

    <div class="row">
        <div class="col-lg-12">
            <div class="footer">
                <p>2018 © Admin Board. - <a href="#">example.com</a></p>
            </div>
        </div>
    </div>
</section>

@stop

@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    $(document).ready(function() {
        
          // Load google charts
     google.charts.load('current', {
       'packages': ['corechart']
     });

     // Draw the chart and set the chart values
     function drawChart1() {
       var data = google.visualization.arrayToDataTable([
         ['Type', 'Total'],
         ['Installation Request',  parseInt('{{$installation_requests}}')],
         ['Service Request',  parseInt('{{$service_requests}}')],
         ['Accessory Order',  parseInt('{{$accessory_order}}')],
         ['Extend Warrenty Request',  parseInt('{{$extend_warranties}}')],
         ['Resell order',  parseInt('{{$resell_product_request}}')],
         
       ]);

       // Optional; add a title and set the width and height of the chart
       var options = {
         'title': 'Total App Request',
         
         'height': 500
       };

       // Display the chart inside the <div> element with id="piechart"
       var chart = new google.visualization.PieChart(document.getElementById('totalorderchart'));
       chart.draw(data, options);
     }
     google.charts.setOnLoadCallback(drawChart1);
    })

    $(".go_to").on("click",function(){
        var url=$(this).attr('link');
        window.location.href =""+url+"";
    })
</script>

@stop