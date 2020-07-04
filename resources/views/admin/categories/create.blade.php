@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('admin.category.index')}}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
@endsection
@section('content')
<form action="@if(isset($category)) {{route('admin.category.update',$category->id)}}  @else {{route('admin.category.store')}} @endif" method="post">
  @csrf
  @if(isset($category))
    @method('PUT')
  @endif
  <div class="form-group row">
  <div class="col-sm-12">
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  </div>
  <div class="col-sm-12">
  @if (session()->has('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
  @endif
  </div>
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" id="title" value="{{ @$category->title }}" >
  </div>
  <div class="form-group row">
    <label for="description">Description</label>
    <textarea class="form-control" name="description" id="description" rows="3" >{!! @$category->description !!}</textarea>
  </div>
  <div class="form-group row">
    <div class="col-sm-12">
      <label for="form-control-level">Select Category:</label>
      <select name="parent_id[]" id="parent_id"  class="form-control"  >
        @if($categories)
          <option value="0">Top level</option>
          option
          @foreach($categories as $cat)
            <option value="{{$cat->id}}"  selected>{{$cat->title}}</option>          
          @endforeach
        @endif
        option   
      </select>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-12">
      @if(isset($category))
      <input type="submit" name="submit" class="btn btn-primary" value="Edit Category">
      @else
      <input type="submit" name="submit" class="btn btn-primary" value="Add Category">
      @endif
    </div>
  </div>

</form>

@endsection
@section('scripts')
<script type="text/javascript">
  $(function(){
    $('#parent_id').select2({
      placeholder:"Select a Parent Category",
      allowClear:true,
      minimumsultsForSearch: Infinity 
    });
  })
</script>




@endsection