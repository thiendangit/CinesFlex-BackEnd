@extends('layouts.admin')

@section('title')
<title>{{ trans('message.regions.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.regions.update'), 'collection' => [
    [
      'name' => trans('message.regions.breadcrumb'),
      'route' => route('regions.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.regions.breadcrumb_update'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <form action="{{ route('regions.update', ['region' => $model]) }}" method="post">
          @csrf
          @method('PUT')

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">{{ trans('message.regions.name') }}</label>
              <span style="color: red">*</span>
              <input type="name" class="form-control" id="name" name="name" value="{{ $model->name }}" placeholder="Name" required>
            </div>

            <div class="form-group col-md-6">
              <label for="inputDescription">{{ trans('message.regions.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" value="{{ $model->description }}" placeholder="Description">
            </div>
          </div>
          <button type="submit" class="btn btn-success float-right">{{ trans('message.home.submit_update_btn') }}</button>
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