@extends('layouts.admin')

@section('title')
<title>{{ trans('message.gifts.title') }}</title>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.gifts.gifts'), 'collection' => [
    [
      'name' => trans('message.home.home'),
      'route' => url('/home'),
      'active' => false,
    ],
    [
      'name' => trans('message.gifts.breadcrumb'),
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
        <a href="{{ route('gifts.create') }}" class="btn btn-success float-right m-2">{{ trans('message.home.create_btn') }}</a>
       </div>
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">{{ trans('message.gifts.photo') }}</th>
              <th scope="col">{{ trans('message.gifts.title_name') }}</th>
              <th scope="col">{{ trans('message.gifts.coin') }}</th>
              <th scope="col">{{ trans('message.gifts.discount') }}</th>
              {{-- <th scope="col">{{ trans('message.gifts.description') }}</th> --}}
              <th scope="col">{{ trans('message.home.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($collection as $item)
            <tr>
              <td>
                @if($item->images && isset($item->images[0]))
                  <img alt="{{ $item->title }}" src="{{ asset($item->images[0]->url) }}" width="60"/>
                @endif
              </td>
              <td>{{ $item->title }}</td>
              <td>{{ $item->coin }}</td>
              <td>{{ $item->discount . '%'}}</td>
      
              {{-- <td>{{ $item->description }}</td> --}}
              <td>
                <a href="{{ route('gifts.edit', ['gift' => $item]) }}" class="btn btn-primary">{{ trans('message.home.edit_btn') }}</a>
                <a href="{{ route('gifts.destroy', ['gift' => $item]) }}" class="btn btn-danger">{{ trans('message.home.delete_btn') }}</a>
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