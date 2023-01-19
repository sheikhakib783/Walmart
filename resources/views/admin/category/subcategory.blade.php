@extends('layouts.dashboard')

@section('content')
 <div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Sub Category List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>SubCategory</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($subcategories as $SL=>$subcategory )
                    <tr>
                        <td>{{$SL+1}}</td>
                        <td>{{$subcategory->subcategory_name}}</td>
                        <td>{{$subcategory->rel_to_category->category_name}}</td>
                        <td><img src="{{asset('uploads/subcategory')}}/{{$subcategory->subcategory_image}}" alt=""></td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New SubCategory</h3>
            </div>
            <div class="card-body">
                <form action="{{route('subcategory.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Select Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">--Select Category--</option> 
                            @foreach ($categories as $category)                                    
                                <option  value="{{$category->id}}">{{$category->category_name}}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">SubCategory Image</label>
                        <input type="file" name="subcategory_image" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="Username">
                        {{-- @error('subcategory_image')
                        <strong class="text-danger">{{$message}}</strong>
                          
                        @enderror --}}
                      </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </div>
@endsection