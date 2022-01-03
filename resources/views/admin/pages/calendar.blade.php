@extends('admin.layouts.main')

@section('custom_css')
    <link rel="stylesheet" href="/plugins/fullcalendar/main.css">
    <style>
        .timeline>div>.timeline-item{
            margin-left: 0!important;
            margin-right: 0!important;
        }
        .timeline>div>.timeline-item>.time{
            float: left;
        }
        .list-group-item{
            padding: 3px 8px;
        }
    </style>
@endsection

@section('title', 'Главная')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Calendar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Calendar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <calendar-component></calendar-component>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <list-active-record></list-active-record>
    </div>
    <!-- /.content-wrapper -->
@endsection
