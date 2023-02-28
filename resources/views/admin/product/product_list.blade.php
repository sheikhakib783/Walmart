@extends('layouts.dashboard')

@section('content')
@include('sweetalert::alert')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#"> Product List</a></li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
                @if (session('seccess'))
                <script>
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            )
                        }
                    })
                </script>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>After Discount</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($all_products as $product)
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td> &#2547;{{$product->price}}</td>
                        <td>{{$product->discount==null?'0':$product->discount}}%</td>
                        <td>&#2547;{{$product->after_discount}}</td>
                        <td><img src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt=""></td>
                        <td>
                            <a href="{{route('product.inventory', $product->id)}}" class="btn btn-success btn-icon">
                                <i data-feather="layers"></i>
                            </a>
                            <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary btn-icon">
                                <i data-feather="edit"></i>
                            </a>
                            <a href="{{route('product.delete',$product->id)}}" class="btn btn-danger btn-icon" onclick="conformation(even)">
                                <i data-feather="trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
 
