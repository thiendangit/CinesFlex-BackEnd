@extends('layouts.admin')

@section('title')
<title>{{ trans('message.promotions.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.promotions.update'), 'collection' => [
    [
      'name' => trans('message.promotions.breadcrumb'),
      'route' => route('promotions.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.promotions.breadcrumb_update'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('promotions.update', ['promotion' => $model]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          @if($model->images && isset($model->images[0]))
            <div class="promotion-photo" style="margin-bottom: 10px; padding:0px">
              <img alt="{{ $model->title }}" src="{{ asset($model->images[0]->url) }}" width="100"/>
            </div>
          @endif

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title">{{ trans('message.promotions.title_name') }}</label>
              <span style="color: red">*</span>
              <input type="title" class="form-control" id="title" name="title" value="{{ $model->title }}" placeholder="Title" required>
            </div>
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.promotions.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" value="{{ $model->description }}" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="type">{{ trans('message.promotions.type') }}</label>
              <select id="type" class="form-control" name="type" disabled>
                @foreach ($collection as $item)
                  @if ($item['id'] === $model->type)
                    <option selected value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                  @else
                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            @if($model->vouchers && isset($model->vouchers[0]))
              <div class="form-group col-md-6">
                <label for="name">{{ trans('message.promotions.value') }}</label>
                <span style="color: red">*</span>
                <input type="number" class="form-control" id="value" name="value" value="{{ $model->vouchers[0]->value }}" placeholder="value" required>
              </div>
            @endif
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="date_begin">{{ trans('message.promotions.date_begin')}}</label>
              <span style="color: red">*</span>
              <input type="text" class="date form-control" id="datepicker" name="date_begin" value="{{ $model->date_begin->format('d-m-Y') }}"required>
            </div>
            <div class="form-group col-md-6">
              <label for="date_end">{{ trans('message.promotions.date_end')}}</label>
              <span style="color: red">*</span>
              <input type="text" class="date form-control" id="datepicker" name="date_end" value="{{ $model->date_end->format('d-m-Y') }}" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.promotions.photo')}}</label>
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

@section('js')
<script type="text/javascript">

$('.date').datepicker({  
       format: 'dd-mm-yyyy'
     }); 

</script> 

@endsection