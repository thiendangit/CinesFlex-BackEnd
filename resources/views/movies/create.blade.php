@extends('layouts.admin')

@section('title')
<title>{{ trans('message.movies.title') }}</title>
@endsection

@section('css')
  <style>
    .select2-selection--multiple .select2-selection__choice__display {
      color: black !important;
    }
    .select2-container--default .select2-search--inline .select2-search__field:focus {
      border: transparent !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
      border-right: transparent !important; 
    }
  </style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('partials.header-content', ['name' => trans('message.movies.create'), 'collection' => [
    [
      'name' => trans('message.movies.breadcrumb'),
      'route' => route('movies.index'),
      'active' => false,
    ],
    [
      'name' => trans('message.movies.breadcrumb_create'),
      'active' => true,
    ]
  ]])
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12" style="margin-bottom: 100px;">
        <form action="{{ route('movies.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">{{ trans('message.movies.name') }}</label>
              <span style="color: red">*</span>
              <input type="name" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group col-md-6">
              <label for="description">{{ trans('message.movies.description')}}</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="caster_ids">{{ trans('message.movies.casters') }}</label>
              <select id="caster_ids" class="form-control select-multiple" name="caster_ids[]" multiple>
                @foreach ($casters as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="category_ids">{{ trans('message.movies.categories') }}</label>
              <select id="category_ids" class="form-control select-multiple" name="category_ids[]" multiple>
                @foreach ($categories as $item)
                  <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="language_ids">{{ trans('message.movies.languages') }}</label>
              <select id="language_ids" class="form-control select-multiple" name="language_ids[]" multiple>
                @foreach ($languages as $item)
                  <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="screen_ids">{{ trans('message.movies.screens') }}</label>
              <select id="screen_ids" class="form-control select-multiple" name="screen_ids[]" multiple>
                @foreach ($screens as $item)
                    <optgroup label="{{ $item['name'] }}">
                      @if (sizeof($item['children']) > 0)
                        @foreach ($item['children'] as $children)
                          <option value="{{ $children['id'] }}">{{ $children['name'] }}</option>
                        @endforeach
                      @endif
                    </optgroup>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="show_times">{{ trans('message.movies.show_time') }}</label>
              <select id="show_times" class="form-control select-multiple" name="show_times[]" multiple>
                @foreach ($show_times as $key=>$item)
                  <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="director">{{ trans('message.movies.director') }}</label>
              <span style="color: red">*</span>
              <input type="director" class="form-control" id="director" name="director" placeholder="Director" required>
            </div>
            <div class="form-group col-md-6">
              <label for="duration_min">{{ trans('message.movies.duration_min') }}</label>
              <input type="number" class="form-control" id="duration_min" name="duration_min" min=0 value="0">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="trailer_path">{{ trans('message.movies.trailer_path') }}</label>
              <span style="color: red">*</span>
              <input type="trailer_path" class="form-control" id="trailer_path" name="trailer_path" placeholder="Trailer Path" required>
            </div>
            <div class="form-group col-md-6">
              <label for="rated">{{ trans('message.movies.rated') }}</label>
              <input type="number" class="form-control" id="rated" name="rated" min=0 value="0">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="price">{{ trans('message.movies.price') }}</label>
              <input type="number" class="form-control" id="price" name="price" min=0 value="0">
            </div>
            <div class="form-group col-md-6">
              <label for="rating">{{ trans('message.movies.rating') }}</label>
              <input type="number" class="form-control" id="rating" name="rating" min=0 value="0">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="date_begin">{{ trans('message.movies.date_begin')}}</label>
              <span style="color: red">*</span>
              <input type="text" class="date form-control" id="datepicker" name="date_begin" required>
            </div>
            <div class="form-group col-md-6">
              <label for="date_end">{{ trans('message.movies.date_end')}}</label>
              <span style="color: red">*</span>
              <input type="text" class="date form-control" id="datepicker" name="date_end" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>{{ trans('message.movies.photo')}}</label>
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

  $('.select-multiple').select2({
    // templateResult: formatScreen
    tags: true
  });

  // function formatScreen (state) {
  //   if (!state.id) {
  //     return state.text;
  //   }
  //   var baseUrl = "/user/pages/images/flags";
  //   var $state = $(
  //     '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
  //   );
  //   return $state;
  // };


</script> 

@endsection