@extends('layouts.app')
@section('title')
    Vote Analytical View
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chartContainer"
                                 style="height: 400px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            showMap();
          function showMap(){
              setTimeout(function(){
                  var chart = new CanvasJS.Chart("chartContainer", {
                      title: {
                          text: ""
                      },
                      axisY: [{
                          title: "Matched",
                          lineColor: "#C24642",
                          tickColor: "#C24642",
                          labelFontColor: "#C24642",
                          titleFontColor: "#C24642",
                          suffix: "k"
                      },
                          {
                              title: "Mismatched",
                              lineColor: "#369EAD",
                              tickColor: "#369EAD",
                              labelFontColor: "#369EAD",
                              titleFontColor: "#369EAD",
                              suffix: "k"
                          }],
                      axisY2: {
                          title: "Total",
                          lineColor: "#7F6084",
                          tickColor: "#7F6084",
                          labelFontColor: "#7F6084",
                          titleFontColor: "#7F6084",
                          prefix: "$",
                          suffix: "k"
                      },
                      toolTip: {
                          shared: true
                      },
                      legend: {
                          cursor: "pointer",
                          itemclick: toggleDataSeries
                      },
                      data: [{
                          type: "line",
                          name: "Mismatched",
                          color: "#369EAD",
                          showInLegend: true,
                          axisYIndex: 1,
                          dataPoints: [
                              <?php
                                  foreach ($mismatched as $row){
                                  ?>
                              {x: new Date(<?php echo $row['year']?>, <?php echo $row['month']?>, <?php echo $row['day']?>), y: <?php echo $row['vote']?>},
                            <?php }?>
                          ]
                      },
                          {
                              type: "line",
                              name: "Matched",
                              color: "#C24642",
                              axisYIndex: 0,
                              showInLegend: true,
                              dataPoints: [
                                      <?php
                                      foreach ($matched as $row){
                                      ?>
                                  {x: new Date(<?php echo $row['year']?>, <?php echo $row['month']?>, <?php echo $row['day']?>), y: <?php echo $row['vote']?>},
                                  <?php }?>
                              ]
                          },
                          {
                              type: "line",
                              name: "Total",
                              color: "#7F6084",
                              axisYType: "secondary",
                              showInLegend: true,
                              dataPoints: [
                                      <?php
                                      foreach ($total as $row){
                                      ?>
                                  {x: new Date(<?php echo $row['year']?>, <?php echo $row['month']?>, <?php echo $row['day']?>), y: <?php echo $row['vote']?>},
                                  <?php }?>
                              ]
                          }
                      ]
                  });
                  chart.render();
                  function toggleDataSeries(e) {
                      if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                          e.dataSeries.visible = false;
                      } else {
                          e.dataSeries.visible = true;
                      }
                      e.chart.render();
                  }
              },200)
            }
        }

    </script>
@endsection

