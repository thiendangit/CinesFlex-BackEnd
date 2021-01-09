@extends('layouts.admin')

@section('title')
<title>{{ trans('message.gifts.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.gifts.update'), 'collection' => [
    [
      'name' => trans('message.gifts.breadcrumb'),
      'route' => route('gifts.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.gifts.breadcrumb_update'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('gifts.update', ['gift' => $model]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          @if($model->images && isset($model->images[0]))
            <div class="gift-photo" style="margin-bottom: 10px; padding:0px">
              <img alt="{{ $model->title }}" src="{{ asset($model->images[0]->url) }}" width="100"/>
            </div>
          @endif

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title">{{ trans('message.gifts.title_name') }}</label>
              <span style="color: red">*</span>
              <input type="title" class="form-control" id="title" name="title" value="{{ $model->title }}" placeholder="Title" required>
            </div>
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.gifts.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" value="{{ $model->description }}" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="coin">{{ trans('message.gifts.coin')}}</label>
              <span style="color: red">*</span>
              <input type="number" class="form-control" id="coin" name="coin" value="{{ $model->coin }}"required>
            </div>
            <div class="form-group col-md-6">
              <label for="discount">{{ trans('message.gifts.discount')}}</label>
              <span style="color: red">*</span>
              <input type="number" class="form-control" id="discount" name="discount" value="{{ $model->discount }}" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.gifts.photo')}}</label>
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