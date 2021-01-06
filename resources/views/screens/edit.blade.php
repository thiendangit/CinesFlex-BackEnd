@extends('layouts.admin')

@section('title')
<title>{{ trans('message.screens.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.screens.update'), 'collection' => [
    [
      'name' => trans('message.screens.breadcrumb'),
      'route' => route('screens.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.screens.breadcrumb_update'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('screens.update', ['screen' => $model]) }}" method="post">
          @csrf
          @method('PUT')
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">{{ trans('message.screens.name') }}</label>
              <span style="color: red">*</span>
              <input type="name" class="form-control" id="name" name="name" value="{{ $model->name }}" placeholder="Name" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.screens.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" value="{{ $model->description }}" placeholder="Description">
            </div>
          </div>
          <button type="submit" class="btn btn-success">{{ trans('message.home.submit_update_btn') }}</button>
        </form>
      </div>
     </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->    
@endsection