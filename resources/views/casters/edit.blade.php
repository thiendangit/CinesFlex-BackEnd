@extends('layouts.admin')

@section('title')
<title>{{ trans('message.casters.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.casters.update'), 'collection' => [
    [
      'name' => trans('message.casters.breadcrumb'),
      'route' => route('casters.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.casters.breadcrumb_update'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('casters.update', ['caster' => $model]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          @if($model->images && isset($model->images[0]))
            <div class="caster-photo" style="margin-bottom: 10px; padding:0px">
              <img alt="{{ $model->name }}" src="{{ asset($model->images[0]->url) }}" width="100"/>
            </div>
          @endif

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">{{ trans('message.casters.name') }}</label>
              <span style="color: red">*</span>
              <input type="name" class="form-control" id="name" name="name" value="{{ $model->name }}" placeholder="Name" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.casters.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" value="{{ $model->description }}" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.casters.photo')}}</label>
              <input type="file" class="form-control-file" name="file">
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