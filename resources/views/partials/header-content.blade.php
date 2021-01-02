<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ $name }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            @foreach ($collection as $item)
                @if ($item['active'])
                    <li class="breadcrumb-item active">{{ $item['name'] }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ $item['route'] ?? url('/home') }}">{{ $item['name'] }}</a></li>
                @endif
            @endforeach
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>