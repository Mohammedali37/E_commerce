     
      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
@foreach($products as $product)
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top img-thumbnail" src="{{asset('storage'.$product->thumbnail)}}" data-holder-rendered="true">
                <div class="card-body">
                    <h4 class=card-title> {!! $product->title !!}</h4>
                  <p class="card-text">{!! $product->description !!}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
 @endforeach
        </div>
      </div>
