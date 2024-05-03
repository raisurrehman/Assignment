@extends('admin.layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add New Product</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <form method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" name="name" value="{{ $product->name }}"
                                            placeholder="name..." class="form-control">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="name">Categories</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <select class="select2" multiple="multiple" data-placeholder="Select categories"
                                            name="categories[]" style="width: 100%;">
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->
                                                categories->contains($category->id) ? 'selected' : '' }}>{{
                                                $category->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('categories')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="price">Price</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="number" name="price" value="{{ $product->price }}"
                                            placeholder="123" class="form-control">
                                        @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="email">Description</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <textarea name="description" value="" placeholder="description..."
                                            class="form-control" cols="30"
                                            rows="5">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="email">Images</label>
                                    </div>
                                    <div class="col-md-10 form-group border p-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="featured_image">Featured Image</label>
                                                <img src="{{$product->featured_image_url}}" alt="Featured Image"
                                                    class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="gallery">Gallery Images</label>
                                                <div class="gallery-images">
                                                    @foreach ($product->getMedia('gallery') as $image)
                                                    <img src="{{ $image->getUrl() }}" alt="Product Image"
                                                        class="img-thumbnail"
                                                        style="max-width: 100px; margin-right: 10px;">
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-file mt-3">
                                            <input type="file" name="images[]" class="form-control" multiple>
                                        </div>
                                        @error('images')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="active">Active</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="checkbox" name="active" data-bootstrap-switch
                                            data-off-color="danger" data-on-color="primary" data-size="small"
                                            data-on-text="Yes" data-off-text="No" value="1" {{ $product->active ?
                                        'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
