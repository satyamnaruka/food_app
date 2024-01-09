@extends('layouts/master')

@section('title',__('Service Partner List'))

@section('content')

<section class="content">
    <div class="container-fluid">
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><i class="fa fa-th"></i> Go To</h2>
                    </div>
                    <div class="body">
                        
                        @if($status!='pending')
                        <div class="btn-group top-head-btn">
                            <a class="btn-primary" href="{{ url('admin/service-partner/pending') }}">
                                <i class="fa fa-list"></i> Pending Service Partner
                            </a>  
                        </div>
                        @endif
                        
                        @if($status!='confirmed')
                        <div class="btn-group top-head-btn">
                            <a class="btn-primary" href="{{ url('admin/service-partner/confirmed') }}">
                                <i class="fa fa-list"></i> Confirmed Service Partner
                            </a>  
                        </div>
                        @endif
                        
                        @if($status!='rejected')
                            <div class="btn-group top-head-btn">
                                <a class="btn-primary" href="{{ url('admin/service-partner/rejected') }}">
                                    <i class="fa fa-list"></i> Rejected Service Partner
                                </a> 
                                
                            </div>
                        @endif
                         
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                <div class="header">
						<h2><i class="fa fa-th"></i> Service Partner {{ucfirst($status)}} List</h2>
					</div>
                    <div class="body">
                        <div class="table-">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-hover js-basic-example contact_list dataTable"
                                            id="DataTables_Table_0" role="grid"
                                            aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="center sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        style="width: 48.4167px;" aria-sort="ascending"
                                                        aria-label="#: activate to sort column descending"># ID</th>
                                                    <th class="center sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        style="width: 126.333px;"
                                                        aria-label=" Name : activate to sort column ascending"> Shop Name
                                                    </th>
                                                    <th class="center sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        style="width: 126.333px;"
                                                        aria-label=" Name : activate to sort column ascending"> Owner Name
                                                    </th>
                                                  
                                                    <th class="center sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        style="width: 193.017px;"
                                                        aria-label=" Email : activate to sort column ascending"> Mobile
                                                    </th>
													@if(\Auth::user()->designation_id=='1' || \Auth::user()->designation_id=='4')
														<!-- <th class="center sorting" tabindex="0"
															aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
															style="width: 85px;"
															aria-label=" Action : activate to sort column ascending"> Otp Verify
														</th>
														<th class="center sorting" tabindex="0"
															aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
															style="width: 85px;"
															aria-label=" Action : activate to sort column ascending"> Block User
														</th> -->
														
                                                        @if($status == 'pending')
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                                style="width: 85px;"
                                                                aria-label=" Action : activate to sort column ascending"> Action
                                                            </th>
                                                        @endif
													@endif
                                                </tr>
                                            </thead>
                                            <tbody>
												@if(!empty($result))
													@foreach($result as $key=>$value)
														<tr class="gradeX odd">
															<td class="center">{{ $key+1}}</td>
															<td class="center">{{ ucfirst($value['shop_name']) }}</td>
															<td class="center">{{ ucfirst($value['owner_name']) }}</td>
															<td class="center">@if($value['mobile']) {{ $value['mobile'] }} @else N/A @endif</td>
															
															<!-- <td class="center">
																@if($value['otp_verify']=='0')
																	<div style="color:orange">Not Verify</div>
																@elseif($value['otp_verify']=='1')
																	<div style="color:green">Verify</div>	
																@endif
															</td> -->
                                                            <!-- @if(\Auth::user()->designation_id=='1' || \Auth::user()->designation_id=='4')
																<td class="center">
																	<div class="switch mt-3">
																		<label>
																			<input type="checkbox" class="-change" data-id="{{ $value['id'] }}" @if($value['block_user']=='1'){{ 'checked' }} @endif>
																			<span class="lever switch-col-red layout-switch"></span>
																		</label>
																	</div>
																</td>
																
															@endif -->
                                                            @if($value['status']=='Pending')
															<td class="center">
                                                                    <a href="{{ url('admin/service-partner/confirmed/'.$value['id'] )}}" title="Confirmed" class="btn btn-tbl-edit">
                                                                        <i class="fas fa-check"></i>
                                                                    </a>
                                                                    <a href="{{ url('admin/service-partner/rejected/'.$value['id'] )}}" title="Rejected" class="btn btn-tbl-delete">
                                                                        <i class="fas fa-times" aria-hidden="true"></i>
                                                                    </a>
                                                            </td>
															@endif

															
														</tr>
													@endforeach
												@endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="center" rowspan="1" colspan="1"># ID</th>
                                                    <th class="center" rowspan="1" colspan="1"> Shop Name </th>
                                                    <th class="center" rowspan="1" colspan="1"> Owner Name</th>
                                                    <th class="center" rowspan="1" colspan="1"> Mobile </th>
													@if(\Auth::user()->designation_id=='1' || \Auth::user()->designation_id=='4')
                                                    <!-- <th class="center" rowspan="1" colspan="1"> Otp Verify </th>
													<th class="center" rowspan="1" colspan="1"> Block User </th> -->
													@endif
                                                    @if($status == 'pending')
                                                        <th class="center" rowspan="1" colspan="1"> Action </th>
													@endif
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('custom_js')
    <script>
        $('.-change').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.user.block') }}",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                data: {
                    'status': status, 
                    'id': id
                },
                beforeSend:function(){
                    $('#preloader').css('display','block');
                },
                error:function(xhr,textStatus){
					
                    if(xhr && xhr.responseJSON.message){
						sweetAlertMsg('error', xhr.status + ': ' + xhr.responseJSON.message);
					}else{
						sweetAlertMsg('error', xhr.status + ': ' + xhr.statusText);
					}
                    $('#preloader').css('display','none');
                },
                success: function(data){
					$('#preloader').css('display','none');
                    sweetAlertMsg('success',data.message);
                }
            });
		});
		

        $("form#formconsultation").submit(function(e) {

            e.preventDefault();

            var formId = $(this).attr('id');
            var formAction = $(this).attr('action');

            $.ajax({
                url: formAction,
                data: new FormData(this),
                dataType: 'json',
                type: 'post',
                async: false,
                beforeSend: function() {
                    $('#preloader').css('display', 'block');
                },
                error: function(xhr, textStatus) {

                    if (xhr && xhr.responseJSON.message) {
                        sweetAlertMsg('error', xhr.status + ': ' + xhr.responseJSON.message);
                    } else {
                        sweetAlertMsg('error', xhr.status + ': ' + xhr.statusText);
                    }

                    $('#preloader').css('display', 'none');
                },
                success: function(data) {

                    setTimeout(() => {
                        location.reload();
                    }, 500);
                    sweetAlertMsg('success', data.message);
                    $('#preloader').css('display', 'none');
                },
                cache: false,
                contentType: false,
                processData: false,
                timeout: 5000
            });

});
    </script>                                           
@endpush