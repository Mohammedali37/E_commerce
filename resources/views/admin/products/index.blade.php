@extends('admin.app')
@section('breadcrumbs')
  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">Products</li>
@endsection
@section('content')

<div class="row d-block">
    <div class="col-sm-12"> 
      @if (session()->has('message'))
      <div class="alert alert-success">
        {{session('message')}}
      </div> 
      @endif
    </div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h2 class="h2">Products List</h2>
  <div class="btn-toolbar mb-2 mb-md-0">
    <a href="{{route('admin.product.create')}}" class="btn btn-sm btn-outline-secondary">
      Add Product
    </a>
  </div>
</div>
<div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Categories</th>
                  <th>Price</th>
                  <th>Thumbnail</th>
                  <th>Date Created</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @if($products->count() > 0)
              @foreach($products as $product)
                <tr>
                  <td>{{$product->id}}</td>
                  <td>{{$product->title}}</td>
                  <td>{!! $product->description !!}</td>
                  <td>
                    @if($product->categories()->count() > 0)
                    @foreach($product->categories as $children)
                    {{$children->title}},
                    @endforeach
                    @else
                    <strong>{{"product"}}</strong>
                    @endif
                  </td>
                  <td>${{$product->price}}</td>
                  <td><img src="{{asset('storage/app/public/'.$product->thumbnail)}}" alt="{{$product->title}}"  height="50px"/></td>
                  
                  <td>{{$product->created_at}}</td>
                  <td><a class="btn btn-info btn-sm" href="{{route('admin.product.edit',$product->id)}}">Edit</a>  | <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$product->id}}')">Delete</a>
                  <form id="delete-product-{{$product->id}}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                  </form>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="7" class="alert alert-info">No products Found..</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-12">
                {{$products->links()}}
            </div>
          </div>
</div>

@endsection 
@section('scripts')
<script type="text/javascript">
  function confirmDelete(id){
    let choice = confirm("Are You sure, You want to Delete this Product ?")
    if(choice){
      document.getElementById('delete-product-'+id).submit();
    }
  }
</script>
@endsection