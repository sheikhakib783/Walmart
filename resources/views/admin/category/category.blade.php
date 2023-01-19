@extends('layouts.dashboard')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Category</a></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h3>Category List</h3>
        </div>
        <div class="card-body">
          @if (session('delete_success'))
          <div class="alert alert-success">{{session('delete_success')}}</div>
            
          @endif 
          <form action="{{route('check.delete')}}" method="POST">
            @csrf
          <table class="table table-bordered">
            <tr>
              <th>
                <input type="checkbox" id="chkAllcat">Chack All</th>
              <th>SL</th>
              <th>Category Name</th>
              <th>Category Image</th>
              <th>Action</th>
            </tr>
            @foreach ($categories as $sl=>$category)
            <tr>
              <td><input class="category" type="checkbox" name="category_id[]" value="{{$category->id}}"></td>
              <td>{{$sl+1}}</td>
              <td>{{$category->category_name}}</td>
              <td><img width="70" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
              <td>
                <div class="dropdown mb-2">
                  <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item d-flex align-items-center" href="{{route('category.edit', $category->id)}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="{{route('category.delete', $category->id)}}"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </table>
          <div class="my-3">
            <button type="submit" class="btn btn-danger ">Delete Checked</button>
          </div>
        </form>
        </div>
      </div>

      {{-- Trash Category List --}}
      @if ($trash_categories->count()>=1)
      <div class="card mt-5">
        <div class="card-header">
          <h3> Trash Category List</h3>
        </div>
        <div class="card-body">
          @if (session('perdelete_success'))
          <div class="alert alert-success">{{session('perdelete_success')}}</div>
          
          @endif
          <form action="{{route('restore.single')}}" method="POST">
            @csrf
          <table class="table table-bordered">
            <tr>
              <th><input type="checkbox" id="checkBoxOne">Select All</th>
              <th>SL</th>
              <th>Category Name</th>
              <th>Category Image</th>
              <th>Action</th>
            </tr>
            @foreach ($trash_categories as $sl=>$category)
            <tr>
              <td>
                <input type="checkbox"  name="trash[]" class="category" id="checkBoxOne" value="{{$category->id}}">
              </td>
              <td>{{$sl+1}}</td>
              <td>{{$category->category_name}}</td>
              <td><img width="70" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
              <td>
                <div class="dropdown mb-2">
                  <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item d-flex align-items-center" href="{{route('category.restore', $category->id)}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Restore</span></a>

                    <a class="dropdown-item d-flex align-items-center" href="{{route('category.del', $category->id)}}"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete Permanetly</span></a>
                  </div>
                </div>
              </td>
              @endforeach
            </tr>
          </table>
          {{-- restore_btn d-none --}}
          <div class="my-3">
            <button type="submit" class="btn btn-success restore_btn d-none" >Restore All</button>
            <button type="submit" class="btn btn-danger delete_btn d-none">Permanent Delete</button>
          </div>
        </form>
        </div>
      </div>
      @endif

      {{-- Permanent delete
      @if ($trash_categories->count()>=1)
      <div class="card mt-5">
        <div class="card-header">
          <h3> Trash Category List</h3>
        </div>
        <div class="card-body">
          @if (session('perdelete_success'))
          <div class="alert alert-success">{{session('perdelete_success')}}</div>
          
          @endif
          <form action="{{route('permanent.delete')}}" method="POST">
            @csrf
          <table class="table table-bordered">
            <tr>
              <th><input type="checkbox" id="checkBoxOne">Select All</th>
              <th>SL</th>
              <th>Category Name</th>
              <th>Category Image</th>
              <th>Action</th>
            </tr>
            @foreach ($trash_categories as $sl=>$category)
            <tr>
              <td>
                <input type="checkbox"  name="trash[]" class="category" id="checkBoxOne" value="{{$category->id}}">
              </td>
              <td>{{$sl+1}}</td>
              <td>{{$category->category_name}}</td>
              <td><img width="70" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
              <td>
                <div class="dropdown mb-2">
                  <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item d-flex align-items-center" href="{{route('category.restore', $category->id)}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Restore</span></a>

                    <a class="dropdown-item d-flex align-items-center" href="{{route('category.del', $category->id)}}"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete Permanetly</span></a>
                  </div>
                </div>
              </td>
              @endforeach
            </tr>
          </table>
          <div class="my-3">
            <button type="submit" class="btn btn-danger delete_btn d-none">Permanent Delete</button>
          </div>
        </form>
        </div>
      </div>
      @endif --}}
    </div>

    <div class="col-lg-4">
          <div class="card-body">
            <h6 class="card-title">Add New Category</h6>
            <form class="forms-sample" action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="exampleInputUsername1">Category Name</label>
                <input type="text" name="category_name" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="Category Name">
                @error('category_name')
                <strong class="text-danger">{{$message}}</strong>
                  
                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInputUsername1">Category Image</label>
                <input type="file" name="category_image" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="Username">
                @error('category_image')
                <strong class="text-danger">{{$message}}</strong>
                  
                @enderror
              </div>
              <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
          </div>
    </div>
  </div>
@endsection

@section('footer_script')
<script>

  $("#checkBoxOne").on('click', function() {
      $('.restore_btn').toggleClass('d-none');
          this.checked ? $(".category").prop("checked", true) : $(".category").prop("checked", false);
          $('.delete_btn').toggleClass('d-none');
          this.checked ? $(".category").prop("checked", true) : $(".category").prop("checked", false);
  })

  $(".category").on('click', function() {
      $('.restore_btn').toggleClass('d-none');         
      $('.delete_btn').toggleClass('d-none');         
  })
</script>
@endsection