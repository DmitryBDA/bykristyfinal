@extends('admin.layouts.main')

@section('title', 'Финансы')

<style>
  .price_doxod {
    position: absolute;
    top: 59%;
    left: 41%;
    font-size: 27px;
  }
</style>

@section('custom_js')
  <script>
    $(function () {
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData = {
        labels: {!! json_encode($dataOnTekDay['arNameServices']) !!},
        datasets: [
          {
            data: {!! json_encode($dataOnTekDay['arPriceService']) !!},
            backgroundColor: ['#00a65a', '#f56954', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }
      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })


      var donutChartCanvas = $('#donutChartTwo').get(0).getContext('2d')
      var donutData = {
        labels: {!! json_encode($dataOnMonth['arNameServices']) !!},
        datasets: [
          {
            data: {!! json_encode($dataOnMonth['arPriceService']) !!},
            backgroundColor: ['#00a65a', '#f56954', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }
      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })
    })
  </script>

  <script>
    let arNameMonth = []
    let arCountClients = []
    let arCountNewUserts = []
    $.ajax({
      url: '/admin/records/total/all',
      success: function (response) {

        arNameMonth = response.nameMonth
        arCountClients = response.countClients
        arCountNewUserts = response.countNewUsers

        $(function () {
          'use strict'

          var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
          }


          var mode = 'index'
          var intersect = true

          var $salesChart = $('#sales-chart')
          // eslint-disable-next-line no-unused-vars
          var salesChart = new Chart($salesChart, {
            type: 'bar',
            data: {
              labels: arNameMonth,
              datasets: [
                {
                  backgroundColor: '#007bff',
                  borderColor: '#007bff',
                  data: arCountClients
                },
                {
                  backgroundColor: '#ced4da',
                  borderColor: '#ced4da',
                  data: arCountNewUserts
                }

              ],
            },
            options: {
              "hover": {
                "animationDuration": 0
              },
              "animation": {
                "duration": 1,
                "onComplete": function() {
                  var chartInstance = this.chart,
                    ctx = chartInstance.ctx;

                  ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                  ctx.textAlign = 'center';
                  ctx.textBaseline = 'bottom';

                  this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                      var data = dataset.data[index];
                      ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                  });
                }
              },
              legend: {
                "display": false
              },
              tooltips: {
                "enabled": false
              },

              scales: {
                yAxes: [{
                  display: false,
                  gridLines: {
                    display: false
                  },
                  ticks: {
                    max: 70,
                    display: false,
                    beginAtZero: true
                  }
                }],
                xAxes: [{
                  gridLines: {
                    display: false
                  },
                  ticks: {
                    beginAtZero: true
                  }
                }]
              }
            }
          })


        })
      },
    });


  </script>
@endsection

@section('content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Доходы</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/">Главная</a></li>
              <li class="breadcrumb-item active">Доходы</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">


            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Цена на сегодняшний день</h3>

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
                <canvas id="donutChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <div class="price_doxod">
                {{$dataOnTekDay['arSum']}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Цена за текущий месяц</h3>

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
                <canvas id="donutChartTwo"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <div class="price_doxod">
                {{$dataOnMonth['arSum']}}
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Статистика по клиентам</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">

                <div class="position-relative mb-4">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                      <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                      <div class=""></div>
                    </div>
                  </div>
                  <canvas id="sales-chart" height="200"
                          class="chartjs-render-monitor"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Всего клиентов
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Новых
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
