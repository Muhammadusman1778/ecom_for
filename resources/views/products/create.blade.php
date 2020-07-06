@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            <div class="card card-default">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @include('partials.errors')
                    <form action="{{isset($product)?route('products.update',$product->id):route('products.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @if(isset($product))
                            {{method_field('PUT')}}
                        @endif
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ isset($product)?$product->name:old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ isset($product)?$product->price:old('price') }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{isset($product)?$product->description: old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button class="form-control btn btn-success" type="submit">{{isset($product)?'Update Product':'Save Product'}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection