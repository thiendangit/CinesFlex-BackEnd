@extends('layouts.admin')

@section('title')
<title>{{ trans('message.cinemas.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.cinemas.create'), 'collection' => [
    [
      'name' => trans('message.cinemas.breadcrumb'),
      'route' => route('cinemas.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.cinemas.breadcrumb_create'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <form action="{{ route('cinemas.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">{{ trans('message.cinemas.name') }}</label>
              <span style="color: red">*</span>
              <input type="name" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.cinemas.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="region_id">{{ trans('message.cinemas.region') }}</label>
              <select id="region_id" class="form-control" required name="region_id">
                @foreach ($collection as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.cinemas.photo')}}</label>
              <span style="color: red">*</span>
              <input type="file" class="form-control-file" name="file">
            </div>
          </div>
          <button type="submit" class="btn btn-success">{{ trans('message.home.submit_create_btn') }}</button>
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