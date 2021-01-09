@extends('layouts.admin')

@section('title')
<title>{{ trans('message.gifts.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.gifts.create'), 'collection' => [
    [
      'name' => trans('message.gifts.breadcrumb'),
      'route' => route('gifts.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.gifts.breadcrumb_create'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('gifts.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title">{{ trans('message.gifts.title_name') }}</label>
              <span style="color: red">*</span>
              <input type="title" class="form-control" id="title" name="title" placeholder="Title" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.gifts.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="coin">{{ trans('message.gifts.coin')}}</label>
              <span style="color: red">*</span>
              <input type="number" class="form-control" id="coin" name="coin" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="discount">{{ trans('message.gifts.discount')}}</label>
              <span style="color: red">*</span>
              <input type="number" class="form-control" id="discount" name="discount" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.gifts.photo')}}</label>
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

@section('js')
<script type="text/javascript">

$('.date').datepicker({  
       format: 'dd-mm-yyyy'
     }); 

</script> 

@endsection