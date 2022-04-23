@extends('layouts.main')

@section('css')

@endsection

@section('content')
<div class="row">
   <div class="col-md-6">
       <div class="card card-danger">
               <div class="card-header">
                   <h3 class="card-title">Product Sales Diagram</h3>
                       <div class="card-tools">
                           <button type="button" class="btn btn-tool" data-card-widget="collapse">
                               <i class="fas fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-tool" data-card-widget="remove">
                               <i class="fas fa-times"></i>
                           </button>
                       </div>
               </div>
           <div class="card-body">
               <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
           </div>
       </div>
   </div>

   <div class="col-md-6">
   <div class="card card-success">
           <div class="card-header">
               <h3 class="card-title">Best Customer Chart</h3>
                   <div class="card-tools">
                       <button type="button" class="btn btn-tool" data-card-widget="collapse">
                           <i class="fas fa-minus"></i>
                       </button>
                       <button type="button" class="btn btn-tool" data-card-widget="remove">
                           <i class="fas fa-times"></i>
                       </button>
               </div>
           </div>
           <div class="card-body">
               <div class="chart">
                   <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection

@section('js')
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/plugins/chart.js/Chart.min.js') }}"></script>

<script type="text/javascript">

   var label_donut = '{!! json_encode($label_donut) !!}';
    var data_donut = '{!! json_encode($data_donut) !!}';

    var label_bar = '{!! json_encode($label_bar) !!}';
    var data_bar = '{!! json_encode($data_bar) !!}';


    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    var donutData = {
      labels: JSON.parse(label_donut),
      datasets: [
        {
          data: JSON.parse(data_donut),
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#56f0ef', '#FF69B4', '#FF00FF', '#7FFF00', '#FF8C00', '#f39j82'],
        }
      ]
    };

    var donutOptions = {
      maintainAspectRatio : false,
      responsive : true,
    }
        //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#donutChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
     //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });

    var areaChartData = {
      labels  : JSON.parse(label_bar),
      datasets: JSON.parse(data_bar)
    };
     //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
   //  barChartData.datasets[0] = temp1
   //  barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    };

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

</script>


@endsection