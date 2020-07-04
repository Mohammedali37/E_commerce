<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreProduct;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(5);
        return view('admin.products.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        // $thumbnail = $request->thumbnail->originalClientName().time();
        // echo $thumbnail;
        $path = 'images/no-thumbnail.jpeg';
        if($request->has('thumbnail')){
            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(), $extension).time();
            $name = $name.$extension;
            $path = $request->thumbnail->storeAs('images', $name, 'public');
        }
        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $path,
            'status' => $request->status,
            'featured' =>($request->featured) ? $request->featured : 0,
            'price' => $request->price,
            'discount' => $request->discount ? $request->discount : 0,
            'discount_price' =>($request->discount_price) ? $request->discount_price : 0
        ]);
        if($product){
            $product->categories()->attach($request->category_id,['created_at'=>now(), 'updated_at'=>now()]);
            return redirect(route('admin.product.index'))->with('message', 'Product Successfully Added');
       }else{
            return back()->with('message', 'Error Inserting Product');
       }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $categories = Category::all();
        $products = Product::all();
        return view('products.all',compact('categories','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.create',compact('product','categories'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, Product $product)
    {

        $product->title = $request->title;
        $product->description = $request->description;
        // detach all parent catagory
        $product->categories()->detach();
        // attach selected parent category
        $product->categories()->attach($request->category_id);
        // save Current record into database
        $saved =$product->save();
        // return back to the add/edit 
        return back()->with('message','Record Successfully Updated!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->categories()->detach() && $product->forcedelete()){
            Storage::delete($product->thabmnail);
            return back()->with('message','Record Successfully Deleted!');
        }else{
            return back()->with('message','Error Deleteing Record !!');
        }
    }
}
