@extends('layouts.admin')

@section('title')
<title>{{ trans('message.categories.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.categories.update'), 'collection' => [
    [
      'name' => trans('message.categories.breadcrumb'),
      'route' => route('categories.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.categories.breadcrumb_update'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('categories.update', ['category' => $model]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title">{{ trans('message.categories.title_name') }}</label>
              <span style="color: red">*</span>
              <input type="title" class="form-control" id="title" name="title" value="{{ $model->title }}" placeholder="Title" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.categories.description')}}</label>
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