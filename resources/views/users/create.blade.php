@extends('layouts.admin')

@section('title')
<title>{{ trans('message.users.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.users.create'), 'collection' => [
    [
      'name' => trans('message.users.breadcrumb'),
      'route' => route('users.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.users.breadcrumb_create'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">{{ trans('message.users.name') }}</label>
              <span style="color: red">*</span>
              <input type="name" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="phone">{{ trans('message.users.phone') }}</label>
              <span style="color: red">*</span>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="email">{{ trans('message.users.email') }}</label>
              <span style="color: red">*</span>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="password">{{ trans('message.users.password') }}</label>
              <span style="color: red">*</span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
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