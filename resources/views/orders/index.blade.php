@extends('layouts.admin')

@section('title')
<title>{{ trans('message.orders.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.orders.orders'), 'collection' => [
    [
      'name' => trans('message.home.home'),
      'route' => url('/home'),
      'active' => false,
    ],
    [
      'name' => trans('message.orders.breadcrumb'),
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
        {{-- <a href="{{ route('orders.create') }}" class="btn btn-success float-right m-2">{{ trans('message.home.create_btn') }}</a> --}}
       </div>
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">{{ trans('message.orders.reference') }}</th>
              <th scope="col">{{ trans('message.orders.total') }}</th>
              <th scope="col">{{ trans('message.orders.discount') }}</th>
              <th scope="col">{{ trans('message.orders.total_paid') }}</th>

              {{-- <th scope="col">{{ trans('message.orders.description') }}</th> --}}
              {{-- <th scope="col">{{ trans('message.home.action') }}</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($collection as $item)
            <tr>
              <td>{{ $item->reference}}</td>
              <td>{{ $item->paid}}</td>
              @if($item->voucher && isset($item->voucher))
              <td>{{ $item->voucher->value . '%'}}</td>
              @else
              <td>{{ 0 }}</td>
              @endif
              <td>{{ $item->total_paid}}</td>


              {{-- @if($item->voucher && isset($item->voucher))
                <td>{{ $item->voucher[0]->value . '%'}}</td>
              @else
                <td>{{ 0 }}</td>
              @endif --}}
              {{-- <td>{{ $item->description }}</td> --}}
              {{-- <td>
                <a href="{{ route('orders.edit', ['order' => $item]) }}" class="btn btn-primary">{{ trans('message.home.edit_btn') }}</a>
                <a href="{{ route('orders.destroy', ['order' => $item]) }}" class="btn btn-danger">{{ trans('message.home.delete_btn') }}</a>
              </td> --}}
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