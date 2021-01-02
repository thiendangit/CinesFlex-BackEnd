@extends('layouts.admin')

@section('title')
<title>{{ trans('message.regions.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.regions.regions'), 'collection' => [
    [
      'name' => trans('message.home.home'),
      'route' => url('/home'),
      'active' => false,
    ],
    [
      'name' => trans('message.regions.breadcrumb'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="text-align: center">
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
      </div>
       <div class="col-md-12">
        <a href="{{ route('regions.create') }}" class="btn btn-success float-right m-2">{{ trans('message.home.create_btn') }}</a>
       </div>
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">{{ trans('message.regions.name') }}</th>
              <th scope="col">{{ trans('message.regions.description') }}</th>
              <th scope="col">{{ trans('message.home.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($collection as $item)
            <tr>
              <td>{{ $item->name }}</td>
              <td>{{ $item->description }}</td>
              <td>
                <a href="{{ route('regions.edit', ['region' => $item]) }}" class="btn btn-primary">{{ trans('message.home.edit_btn') }}</a>
                <a href="{{ route('regions.destroy', ['region' => $item]) }}" class="btn btn-danger">{{ trans('message.home.delete_btn') }}</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="col-md-12">
        {{ $collection->links('pagination::bootstrap-4') }}
      </div>
     </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->    
@endsection