@extends('layouts.admin')

@section('title')
<title>{{ trans('message.cinemas.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.cinemas.update'), 'collection' => [
    [
      'name' => trans('message.cinemas.breadcrumb'),
      'route' => route('cinemas.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.cinemas.breadcrumb_update'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('cinemas.update', ['cinema' => $model]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          @if($model->images && isset($model->images[0]))
            <div class="cinema-photo" style="margin-bottom: 10px; padding:0px">
              <img alt="{{ $model->name }}" src="{{ asset($model->images[0]->url) }}" width="100"/>
            </div>
          @endif

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">{{ trans('message.cinemas.name') }}</label>
              <span style="color: red">*</span>
              <input type="name" class="form-control" id="name" name="name" value="{{ $model->name }}" placeholder="Name" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.cinemas.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" value="{{ $model->description }}" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="region_id">{{ trans('message.cinemas.region')}}</label>
              <select id="region_id" class="form-control" name="region_id">
                @foreach ($collection as $item)
                  @if ($item->id === $model->region_id)
                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                  @else    
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.cinemas.photo')}}</label>
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