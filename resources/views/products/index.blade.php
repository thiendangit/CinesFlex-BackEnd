@extends('layouts.admin')

@section('title')
<title>{{ trans('message.products.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.products.products'), 'collection' => [
    [
      'name' => trans('message.home.home'),
      'route' => url('/home'),
      'active' => false,
    ],
    [
      'name' => trans('message.products.breadcrumb'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-2" style="text-align: center">
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
      </div>
       <div class="col-md-12">
        <a href="{{ route('products.create') }}" class="btn btn-success float-right m-2">{{ trans('message.home.create_btn') }}</a>
       </div>
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">{{ trans('message.products.photo') }}</th>
              <th scope="col">{{ trans('message.products.name') }}</th>
              <th scope="col">{{ trans('message.products.reference') }}</th>
              <th scope="col">{{ trans('message.products.type') }}</th>
              <th scope="col">{{ trans('message.products.price') }}</th>
              {{-- <th scope="col">{{ trans('message.products.description') }}</th> --}}
              <th scope="col">{{ trans('message.home.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($collection as $item)
            <tr>
              <td>
                @if($item->images && isset($item->images[0]))
                  <img alt="{{ $item->name }}" src="{{ asset($item->images[0]->url) }}" width="60"/>
                @endif
              </td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->reference }}</td>
              <td>{{ $item->type == 1 ? 'Food' : 'Beverage' }}</td>
              <td>{{ $item->price .' Vnd'}}</td>
              {{-- <td>{{ $item->description }}</td> --}}
              <td>
                <a href="{{ route('products.edit', ['product' => $item]) }}" class="btn btn-primary">{{ trans('message.home.edit_btn') }}</a>
                <a href="{{ route('products.destroy', ['product' => $item]) }}" class="btn btn-danger">{{ trans('message.home.delete_btn') }}</a>
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