@extends('frontend.master')


@section('content')

<!-- ======================= Top Breadcrubms ======================== -->
			<div class="gray py-3">
				<div class="container">
					<div class="row">
						<div class="colxl-12 col-lg-12 col-md-12">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item"><a href="#">Library</a></li>
									<li class="breadcrumb-item active" aria-current="page">Data</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ======================= Top Breadcrubms ======================== -->
			
			<!-- ======================= Product Detail ======================== -->
			<section class="middle">
				<div class="container">
					<div class="row justify-content-between">
					
						<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
							<div class="quick_view_slide">                                
								@foreach ($galleries as $gallery)
                                    <div class="single_view_slide"><a href="{{asset('uploads/product/gallery')}}/{{$gallery->gallery}}" data-lightbox="roadtrip" class="d-block mb-4"><img src="{{asset('uploads/product/gallery')}}/{{$gallery->gallery}}" class="img-fluid rounded" alt="" />
                                </a>
                                </div>	
                                @endforeach								
							</div>
						</div>
						
						<div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
							<div class="prd_details pl-3">
																
								<div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1">{{$product_info->rel_to_category->category_name}}</span></div>
								<div class="prt_02 mb-3">
									<h2 class="ft-bold mb-1">{{$product_info->product_name}}</h2>
									<div class="text-left">
										<div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="small">(412 Reviews)</span>
										</div>
										<div class="elis_rty"><span class="ft-medium text-muted line-through fs-md mr-2">&#2547;{{$product_info->price}}</span><span class="ft-bold theme-cl fs-lg mr-2">&#2547;{{$product_info->after_discount}}</span></div>
									</div>
								</div>
								
								<div class="prt_03 mb-4 text-dark">
									<strong>{{$product_info->short_desp}}</strong>
								</div>

								{{-- form start --}}
								<form action="{{route('cart.store')}}" class="quantity" method="POST">
									@csrf
									
								<div class="prt_04 mb-2">
									<p class="d-flex align-items-center mb-0 text-dark ft-medium">Color: </p>
                                                         
									<div class="text-left">                         
                                        @foreach ($colors as $color)
											<div class="form-check form-option form-check-inline mb-1">
											<input data-product="{{$product_info->id}}"class="form-check-input color_id" type="radio" value="{{$color->color_id}}" name="color_id" id="white{{$color->color_id}}" value="{{$color->color_id}}">

											<label class="form-option-label rounded-circle" for="white{{$color->color_id}}"><span class="form-option-color  rounded-circle" style="background:{{$color->rel_to_color->color_code}}"></span></label>
										    </div>							
                                        @endforeach                                  
									</div>                                 
								</div>
								
								<div class="prt_04 mb-4">
									
									<p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
									<div class="text-left pb-0 pt-2" id="size">
										

                                        @foreach ($sizes as $size)
											
										@if($size->size_id == 1)
											<div class="form-check size-option form-option form-check-inline mb-2">
											<input checked class="form-check-input" type="radio" name="size_id" id="size_id" value="{{$size->size_id}}">

											<label class="form-option-label" for="size_id">{{$size->rel_to_size->size_name}}</label>
										</div>
										@else
											<div class="form-check size-option form-option form-check-inline mb-2">
											<input checked class="form-check-input" type="radio" name="size_id" id="size_id" value="{{$size->size_id}}">

											<label class="form-option-label" for="size_id">{{$size->rel_to_size->size_name}}</label>
										</div>
										
										@endif
                                                                           
                                        @endforeach
									</div>
								</div>
								
								<div class="prt_05 mb-4">
									<div class="form-row mb-7">
										<div class="col-12 col-lg-auto">
											<!-- Quantity -->
											{{-- <select name="quantity" class="mb-2 custom-select">
												@for ($i = 1; $i < 15; $i++)
													<option value="{{$i}}" >{{$i}}</option>
												@endfor
											</select> --}}
											<form action="" class="quantity">
												<input type='button' value='-' class='qtyminus minus' field='quantity' />
												<input type='text' name='quantity' value='1' class='qty' />
												<input type='button' value='+' class='qtyplus plus' field='quantity' />
											</form>
										</div>
										<div class="col-12 col-lg">
											<!-- Submit -->
											<input type="hidden" name="product_id" value="{{$product_info->id}}">
											<button name="one" value="1" type="submit" class="btn btn-block custom-height bg-dark mb-2">
												<i class="lni lni-shopping-basket mr-2"></i>Add to Cart</i>
											</button>
										</div>
										<div class="col-12 col-lg-auto">
											<!-- Wishlist -->
											<button name="two" value="2" type="submit" class="btn custom-height btn-default btn-block mb-2 text-dark">
												<i class="lni lni-heart mr-2"></i>Wishlist
											</button>
										</div>
								  </div>
								</div>
								
								<div class="prt_06">
									<p class="mb-0 d-flex align-items-center">
									  <span class="mr-4">Share:</span>
									  <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
										<i class="fab fa-twitter position-absolute"></i>
									  </a>
									  <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
										<i class="fab fa-facebook-f position-absolute"></i>
									  </a>
									  <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted" href="#!">
										<i class="fab fa-pinterest-p position-absolute"></i>
									  </a>
									</p>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- ======================= Product Detail End ======================== -->
			
			<!-- ======================= Product Description ======================= -->
			<section class="middle">
				<div class="container">
					<div class="row align-items-center justify-content-center">
						<div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
							<ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
									<a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
								</li>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
								</li>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
								</li>
							</ul>
							
							<div class="tab-content" id="myTabContent">
								
								<!-- Description Content -->
								<div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
									<div class="description_info">
										<p class="p-0 mb-2">{!!$product_info->long_desp!!}</p>
										
									</div>
								</div>
								
								<!-- Additional Content -->
								<div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
									<div class="additionals">
										@if ($product_info->additional_info != null)
                                        <p class="p-0 mb-2">{!!$product_info->additional_info!!}</p>                                 
                                        @endif
                                         <strong class="p-0 mb-2">No Info Found !!</strong> 
									</div>
								</div>
								
								<!-- Reviews Content -->
								<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
									<div class="reviews_info">
										@foreach ($all_review as $review)
										<div class="single_rev d-flex align-items-start br-bottom py-3">
											<div class="single_rev_thumb"><img src="assets/img/team-1.jpg" class="img-fluid circle" width="90" alt="" /></div>
											<div class="single_rev_caption d-flex align-items-start pl-3">
												<div class="single_capt_left">
													<h5 class="mb-0 fs-md ft-medium lh-1">{{$review->rel_to_customer->name}}</h5>
													<span class="small">{{$review->created_at->format('d-M-Y')}}</span>
													<p>{{$review->review}}</p>
												</div>
												<div class="single_capt_right">
													<div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
													@for ($i=1; $i=$review->star; $i++)
														<i class="fas fa-star filled"></i>
													@endfor
													@for ($i=$review->star; $i=4; $i++)
														<i class="fas fa-star "></i>
													@endfor
													</div>
												</div>
											</div>
										</div>																@endforeach		
									</div>
									
								<div class="reviews_rate">
									@auth('customerlogin')	
									@if (App\Models\OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->id)->exists())
									@if (App\Models\OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->id)->whereNotNull('review')->first() == false)									
										<form  class="row" action="{{route('review.store')}}" method="POST">
											@csrf
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<h4>Submit Rating</h4>
											</div>
											
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
													<div class="srt_013">
														<div class="submit-rating">
														<input class="rating" id="star-5" type="radio" name="rating" value="5" />
														<label for="star-5" title="5 stars">
															<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input class="rating" id="star-4" type="radio" name="rating" value="4" />
														<label for="star-4" title="4 stars">
															<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input class="rating" id="star-3" type="radio" name="rating" value="3" />
														<label for="star-3" title="3 stars">
															<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input class="rating" id="star-2" type="radio" name="rating" value="2" />
														<label for="star-2" title="2 stars">
															<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input class="rating" id="star-1" type="radio" name="rating" value="1" />
														<label for="star-1" title="1 star">
															<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														</div>
													</div>
													
													<div class="srt_014">
														<input type="hidden"  value="{{$product_info->id}}" name="product_id">
														<input type="hidden" id="rating_value" value="" name="rating">
														<h6 class="mb-0"><span id="rating">0</span> Star</h6>
													</div>
												</div>
											</div>
											
											<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
												<div class="form-group">
													<label class="medium text-dark ft-medium">Full Name</label>
													<input value="{{Auth::guard('customerlogin')->user()->name}}" type="text" class="form-control" />
												</div>
											</div>
											
											<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
												<div class="form-group">
													<label class="medium text-dark ft-medium">Email Address</label>
													<input value="{{Auth::guard('customerlogin')->user()->email}}" type="email" class="form-control" />
												</div>
											</div>
											
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="medium text-dark ft-medium">Description</label>
													<textarea class="form-control"></textarea>
												</div>
											</div>
											
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group m-0">
													<button type="submit" class="btn btn-white stretched-link hover-black">Submit Review <i class="lni lni-arrow-right"></i></button>
												</div>
											</div>
											
										</form>
										@else
											<div class="alert alert-info">
												<h3 class="d-flex justify-content-between align-items-center"><strong>You alreday Review this product</strong></h3>
											</div>
										@endif	
										@else
											<div class="alert alert-info">
												<h3 class="d-flex justify-content-between align-items-center"><strong>You did not purchase this product Yet</strong></h3>
											</div>
											@endif	
										@else
											<div class="alert alert-info">
												<h3 class="d-flex justify-content-between align-items-center"><strong>You must login to submit your review</strong> <a href="{{route('customer.register.login')}}" class="btn btn-success">login</a></h3>
											</div>
										@endauth
									</div>
									
								</div>

							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- ======================= Product Description End ==================== -->

            <!-- ======================= Similar Products Start ============================ -->
			<section class="middle pt-0">
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center">
								<h2 class="off_title">Similar Products</h2>
								<h3 class="ft-bold pt-3">Matching Producta</h3>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="slide_items">		
								<!-- single Item -->
                                @forelse ( $releted_products as $matching )
                                   <div class="single_itesm">
									<div class="product_grid card b-0 mb-0">
										<div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
										<div class="card-body p-0">
											<div class="shop_thumb position-relative">
												<a class="card-img-top d-block overflow-hidden" href="{{route('details', $matching->id)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$matching->preview}}" alt="..."></a>
											</div>											
										</div>
										<div class="card-footer b-0 p-3 pb-0 d-flex align-items-start justify-content-center">
											<div class="text-left">
												<div class="text-center">
													<h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{route('details', $matching->id)}}">{{$matching->product_name}}</a></h5>
													<div class="elis_rty"><span class="ft-medium text-muted line-through fs-md mr-2">&#2547;{{$product_info->price}}</span><span class="ft-bold theme-cl fs-lg mr-2">&#2547;{{$product_info->after_discount}}</span></div>
												</div>
											</div>
										</div>
									</div>
								</div>	 
                                @empty
                                    <div>
                                        <h4>No Matching Products Found !!</h4>
                                    </div>
                                @endforelse
							</div>
						</div>
					</div>	
				</div>
			</section>
@endsection


@section('footer_script')
{{-- Get --}}
	<script>
		$('.color_id').click(function(){
			var color_id = $(this).val();
			var product_id = $(this).attr('data-product');

			
			$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
			$.ajax({
				type:'POST',
				url:'/getSize',
				data:{'color_id' : color_id, 'product_id' : product_id},
				success:function(data){
					 $('#size').html(data);					
				}
			});
		});
	</script>
	{{--quantity  --}}
<script>
jQuery(document).ready(($) => {
        $('.quantity').on('click', '.plus', function(e) {
            let $input = $(this).prev('input.qty');
            let val = parseInt($input.val());
            $input.val( val+1 ).change();
        });
 
        $('.quantity').on('click', '.minus', 
            function(e) {
            let $input = $(this).next('input.qty');
            var val = parseInt($input.val());
            if (val > 1) {
                $input.val( val-1 ).change();
            } 
        });
    });
</script>
{{-- Toster --}}
<script>
@if(Session::has('cart_added'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('cart_added') }}");
  @endif
</script>
<script>
	@if(Session::has('delete'))
			toastr.options =
			{
				"closeButton" : true,
				"progressBar" : true
			}
			toastr.success("{{session('delete')}}");
	@endif
</script>
<script>
	@if(Session::has('wish_success'))
			toastr.options =
			{
				"closeButton" : true,
				"progressBar" : true
			}
			toastr.success("{{session('wish_success')}}");
	@endif
</script>
<script>
	@if(Session::has('wish_delete'))
			toastr.options =
			{
				"closeButton" : true,
				"progressBar" : true
			}
			toastr.success("{{session('wish_delete')}}");
	@endif
</script>

{{-- Star Rating --}}
<script>
	$('.rating').click(function(){
		var rating = $(this).val();
		$('#rating').html(rating);
		$('#rating_value').attr('value',rating);
	});
</script>
		
@endsection