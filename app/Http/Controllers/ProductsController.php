<?php

namespace App\Http\Controllers;

use App\Http\Requests\products\CreateProductRequest;
use App\Http\Requests\products\UpdateProductRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index')->with('products',Product::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product_image=$request->image;
        $product_image_new_name=time().$product_image->getClientOriginalName();
        $product_image->move('uploads/products',$product_image_new_name);
        $product=Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'image'=>'uploads/products/'.$product_image_new_name,
            'description'=>$request->description
        ]);
        $product->save();
        session()->flash('success','You created a new product');
        return redirect(route('products.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.create')->with('product',$product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //check if new image
        if($request->hasFile('image')){
            $product_image=$request->image;
            $product_image_new_name=time().$product_image->getClientOriginalName();
            $product_image->move('uploads/products',$product_image_new_name);
            $product_image='uploads/products/'.$product_image_new_name;
            $product->save();
        }

        //update attributes
        $data=[
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description];
        $product->update($data);

        //flash message
        session()->flash('success','Product updated successfully');

        //redirect user
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        if(file_exists($product->image)){
            unlink($product->image);
        }
        $product->delete();
        session()->flash('success','You deleted a product');
        return redirect(route('products.index'));
    }
}
