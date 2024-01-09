@extends('layouts/master')

@section('title')
	@if(!empty($result))
		Update 
	@else
		Add 
	@endif
	Product
@endsection

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="header">
						<h2><i class="fa fa-th"></i>  Go To</h2>
					</div>
					<div class="body">
						<div class="btn-group top-head-btn">
                            <a class="btn-primary" href="{{ url('admin/product/list')}}">
                                <i class="fa fa-list"></i> Product List
							</a>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="header">
						<h2><i class="fa fa-th"></i> @if(!empty($result)) Update @else Add @endif Product</h2>
					</div>
					<div class="body">
						<form id="form" action="{{ route('admin.product.add') }}" method="post" enctype="multipart/form-data" autocomplete="off">
						@csrf
						
						<input type="hidden" name="id" value="@if(!empty($result)){{$result['id']}}@else{{ 0 }}@endif"  required />
						<div class="row clearfix">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Category <label class="text-danger">*</label></label>
										<select class="form-control" name="category_id" required>
											<option disabled selected>--select--</option>
											@if (count($category)>0)
												@foreach ($category as $row)
													<option value="{{$row['id']}}" @if (!empty($result) && $result->category_id  == $row['id']) {{'selected'}} @endif>
														{{$row['name']}}
													</option>													
												@endforeach
											@endif
											
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Name <label class="text-danger">*</label></label>
										<input type="text" name="name" required class="form-control" placeholder="Enter name" value="@if(!empty($result)){{ $result['name'] }}@endif"/>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Size <label class="text-danger">*</label></label>
										<input type="text" name="size" required class="form-control" placeholder="Enter size" value="@if(!empty($result)){{ $result['size'] }}@endif"/>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Time <label class="text-danger">*</label></label>
										<input type="text" name="time" required class="form-control" placeholder="Enter time" value="@if(!empty($result)){{ $result['time'] }}@endif"/>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Rating <label class="text-danger">*</label></label>
										<input type="text" name="rating" required class="form-control" placeholder="Enter rating" value="@if(!empty($result)){{ $result['rating'] }}@endif"/>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Price <label class="text-danger">*</label></label>
										<input type="text" name="price" required class="form-control" placeholder="Enter price" value="@if(!empty($result)){{ $result['price'] }}@endif"/>
									</div>
								</div>
							</div>
						</div>

						<div class="row clearfix">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Image <label class="text-danger">*</label></label>
										<input type="file" id="uploadImage" class="form-control image"  name="image" @if(!$result) required @endif  data-type="single" data-image-preview="product" accept="image/*"   >
										<p style="color:red;width:100%">Size must be 1920*750</p>
									</div>
								</div>
								
								<div class="form-group previewimages col-md-6" id="product">
									@if($result)
										<img src="{{ asset('uploads/product/'.$result->image) }}" style="width: 100px;border:1px solid #222;margin-right: 13px" />
										<input type="hidden" name="old_image" value="{{ $result->image }}" />
									@endif
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="form-line">
										<label for="inputName">Description <label class="text-danger">*</label></label>
										<input type="text" placeholder="Enter description" name="description" value="@if(!empty($result)){{ $result['description'] }}@endif" required class="form-control"/>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-12 p-t-20 text-center">
							@if(empty($result)) 
								<button type="reset" class="btn btn-danger waves-effect">Reset</button>
							@endif
							<button style="background:#353c48;" type="submit" class="btn btn-primary waves-effect m-r-15" >@if(!empty($result)) Update @else Submit @endif</button> 
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('custom_js')
	<script>
		function resetFormData(){
			
			$('.previewimages').html('');
		}
	</script>
@endpush