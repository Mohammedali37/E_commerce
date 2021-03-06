@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">
<h2>Categories</h2>
<div class="btn-toolbar mb-2 mb-mb-0">
 <a href="{{route('admin.category.create')}}" class="btn btn-sm btn-ouyline-secondary" >Add/Edit Category</a> 
</div>
</div>
<div class="col-sm-12">
  @if (session()->has('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
  @endif
  </div>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
     <tr>
        <th>#</th>
        <th>Title</th>
        <th>Description</th>
        <th>Categories</th>
        <th>Date Created</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @if($categories)
    @foreach($categories as $category)
     <tr>
        <td>{{$category->id}}</td>
        <td>{{$category->title}}</td>
        <td>{{$category->description}}</td>
        <td>
          @if($category->childrens()->count() > 0)
              @foreach($category->childrens as $children)
                  {{$children->title}},
              @endforeach
          @else
              <strong>{{" Parent Category "}}</strong>
          @endif
        </td>
        <td>{{$category->created_at}}</td>
        <td><a class="btn btn-info btn-sm" href="{{route('admin.category.edit',$category->id)}}">Edit</a> | <a class="btn btn-danger btn-sm" href="javascript:;"onclick="confirmDelete('{{$category->id}}')">Delete</a></td>
        <form id="delete-category-{{$category->id}}" action="{{ route('admin.category.destroy',$category->id) }}" method="POST" style="display: none;">
        <input type="hidden" name="category" value="{{$category->id}}">
        @method('DELETE')
        @csrf
        </form>        
      </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5">No Category Found..</td>
    </tr>
    @endif
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
      {{$categories->links()}}
  </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
  function confirmDelete(id){
    let choice = confirm("Are You sure , you want to delete this record ? ")
    if(choice){
      document.getElementById('delete-category-'+id).submit();
    }
  }
</script>
@endsection
