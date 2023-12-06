@extends('layouts.master')
@section('title')
	الصفحة الرائيسية
@endsection
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					
				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white"> إجمالي الفواتير</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{number_format(App\Models\Invoice::sum('total'),2)}}</h4>
											<p class="mb-0 tx-12 text-white op-7">عدد الفواتير ({{$number_of_invoices = App\Models\Invoice::count()}})</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">
												
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعة</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												{{number_format(App\Models\Invoice::where('value_status', 0)->sum('total'),2)}}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">عدد الفواتير  ({{$unpaid_n = App\Models\Invoice::where('value_status', 0)->count()}})</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">
			
												@php
												$number_of_invoices = App\Models\Invoice::count();
												$unpaid_n = App\Models\Invoice::where('value_status', 0)->count()	;		
												if($unpaid_n == 0){
													echo $unpaid_n = 0;
												}
												else{
													echo number_format($unpaid_n = $unpaid_n / $number_of_invoices *100,2);
												}
												@endphp
			
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{number_format(App\Models\Invoice::where('value_status', 1)->sum('total'),2)}}</h4>
											<p class="mb-0 tx-12 text-white op-7">عدد الفواتير  ({{ $paid_n = App\Models\Invoice::where('value_status', 1)->count()}})</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">
			
												@php
												$number_of_invoices = App\Models\Invoice::count();
												$paid_n = App\Models\Invoice::where('value_status', 1)->count()	;		
												if($paid_n == 0){
													echo $paid_n = 0;
												}
												else{
												   echo number_format($paid_n = $paid_n / $number_of_invoices *100,2);
												}
												@endphp
			
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{number_format(App\Models\Invoice::where('value_status', 2)->sum('total'),2)}}</h4>
											<p class="mb-0 tx-12 text-white op-7">عدد الفواتير  ({{$p_paid_n=App\Models\Invoice::where('value_status', 2)->count()}})</p>
										</div>
										<span class="float-right my-auto mr-auto">
										<i class="fas fa-arrow-circle-down text-white"></i>
										<span class="text-white op-7">
			
											@php
											$number_of_invoices = App\Models\Invoice::count();
											$p_paid_n = App\Models\Invoice::where('value_status', 2)->count()	;		
											if($p_paid_n == 0){
												echo $p_paid_n = 0;
											}
											else{
												echo number_format($p_paid_n = $p_paid_n / $number_of_invoices *100,2);
											}
											@endphp
										</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
				</div>
				<!-- row closed -->
				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-md-12 col-lg-12 col-xl-7">
						<div class="card">
							<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-0">نسبة إحصائية الفواتير</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body"> 
								{!! $chartjs->render() !!}
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-xl-5">
						<div class="card card-dashboard-map-one">
							<label class="main-content-label">نسبة إحصائية الفواتير</label>
							<div class="">
							</div>
							{!! $chartjs2->render() !!}
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- row opened -->

				<!-- row close -->

				<!-- row opened -->

				<!-- /row -->
			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>	
@endsection


