@extends('layouts.admin')

@section('title')
<title>{{ trans('message.promotions.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.promotions.create'), 'collection' => [
    [
      'name' => trans('message.promotions.breadcrumb'),
      'route' => route('promotions.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.promotions.breadcrumb_create'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <form action="{{ route('promotions.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title">{{ trans('message.promotions.title_name') }}</label>
              <span style="color: red">*</span>
              <input type="title" class="form-control" id="title" name="title" placeholder="Title" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="type">{{ trans('message.promotions.type') }}</label>
              <select id="type" class="form-control" required name="type">
                @foreach ($collection as $item)
                  <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="value">{{ trans('message.promotions.value') }}</label>
              <input type="number" class="form-control" id="value" name="value" min=0 max=99 value=0>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.promotions.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="date_begin">{{ trans('message.promotions.date_begin')}}</label>
              <span style="color: red">*</span>
              <input type="text" class="date form-control" id="datepicker" name="date_begin" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="date_end">{{ trans('message.promotions.date_end')}}</label>
              <span style="color: red">*</span>
              <input type="text" class="date form-control" id="datepicker" name="date_end" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.promotions.photo')}}</label>
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