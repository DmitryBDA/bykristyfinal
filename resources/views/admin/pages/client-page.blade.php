@extends('admin.layouts.main')

@section('custom_css')

@endsection

@section('title', 'Главная')

@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          @if (Session::has('success'))
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-success">
                    {{Session::get('success')}}
                  </div>
                </div>
              </div>
            </div>
          @endif
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
              </div>
              <form method="post" action="{{ route('admin.client.update',$obUser->id ) }}">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Введите имя" value="{{ $obUser->name }}" required>
                  </div>
                  <div class="form-group">
                    <label for="surname">Фамилия</label>
                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Введите фамилию" value="{{ $obUser->surname }}" required>
                  </div>
                  <div class="form-group">
                    <label>Телефон</label>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" name="phone" value="{{ $obUser->phone }}" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask required>
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Сохранить</button>
                  <a href="{{ route('admin.client.index') }}" type="submit" class="btn btn-primary">Назад к списку</a>
                </div>
                <div class="card-footer">
                  <a href="{{ route('admin.client.sendnotification', $obUser->id) }}" type="submit" class="btn btn-primary">Отправить уведомление о записи</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
