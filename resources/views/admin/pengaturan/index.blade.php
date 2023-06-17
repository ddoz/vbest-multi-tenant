@extends('layout.pengaturan')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Menu
								</div>
							</div>
						</div>
						<div class="card-body">
							@if(Session::has('success'))
								<div class="alert alert-success alertstatus">
									{{ Session::get('success') }}
										@php
										Session::forget('success');
									@endphp
								</div>
							@endif
							@if(Session::has('fail'))
								<div class="alert alert-danger alertstatus">
									{{ Session::get('fail') }}
									@php
										Session::forget('fail');
									@endphp
								</div>
							@endif
							<div class="table-responsive">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
                                            <th>No</th>
											<th>Nama Menu</th>
											<th>Required</th>
											<th>Hide</th>
										</tr>
									</thead>
									<tbody>
										@foreach($menu as $k => $m)
											<tr>
												<td>{{$k+1}}</td>
												<td>{{$m->menu}}</td>
												<td>
													<form action="{{route('pengaturan-menu.change')}}" method="POST" id="menu{{$m->id}}">
														@csrf
														<input type="hidden" name="id" value="{{$m->id}}">
														<div class="custom-control custom-switch">	
															<input type="hidden" name="tipe" value="required">								
															<input type="hidden" name="is_required" value="{{$m->is_required}}">						
															<input onclick="document.getElementById('menu{{$m->id}}').submit()" type="checkbox" @if($m->is_required) checked="checked" @endif class="custom-control-input" id="customSwitch{{$m->id}}">
															<label class="custom-control-label" for="customSwitch{{$m->id}}">Required</label>
														</div>
													</form>
												</td>
												<td>
													<form action="{{route('pengaturan-menu.change')}}" method="POST" id="menuH{{$m->id}}">
														@csrf
														<input type="hidden" name="id" value="{{$m->id}}">
														<div class="custom-control custom-switch">	
															<input type="hidden" name="tipe" value="hide">							
															<input type="hidden" name="hide" value="{{$m->hide}}">						
															<input onclick="document.getElementById('menuH{{$m->id}}').submit()" type="checkbox" @if($m->hide) checked="checked" @endif class="custom-control-input" id="customSwitchHide{{$m->id}}">
															<label class="custom-control-label" for="customSwitchHide{{$m->id}}">Hide</label>
														</div>
													</form>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
@endsection

@section('script')
@endsection