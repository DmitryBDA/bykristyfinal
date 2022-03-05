@extends('admin.layouts.main')

@section('custom_css')
  <style>
    .dt-buttons{
      display: none;
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
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Список клиентов</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($obUserList as $obUser)
                  <tr>
                    <td><a href="{{route('admin.client.show', $obUser->id)}}">{{$obUser->surname}}</a></td>
                    <td><a href="{{route('admin.client.show', $obUser->id)}}">{{$obUser->name}}</a></td>
                    <td>{{$obUser->phone}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
