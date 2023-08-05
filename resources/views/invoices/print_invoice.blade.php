@extends('layouts.master')
@section('title')
    طباعة الفاتورة
@endsection
@section('css')
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<style>
	@media print {
		#print_button {
			display: none;
		}
	}
</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">طباعة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/طباعة الفاتورة</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->

                @if(session()->has('error'))
        <script>
            window.onload = function()
            {
                notif({
                    msg:'عفوا لا توجد فاتورة بهذا الرقم !',
                    type: 'error'
                })
            }
        </script>
    @endif
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="body">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">فاتورة تحصيل</h1>
										<div class="billed-from">
											
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<div class="col-md">
                                                <label class="tx-gray-600">معلومات الفاتورة</label>
                                                <p class="invoice-info-row"><span>الرقم التعريفي</span> <span>{{$invoice->id}}</span></p>
                                                <p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{$invoice->invoice_number}}</span></p>
                                                <p class="invoice-info-row"><span>تاريخ الإنشاء :</span> <span>{{$invoice->created_at}}</span></p>
                                                <p class="invoice-info-row"><span>تاريخ الأستحقاق :</span> <span>{{$invoice->due_date}}</span></p>
                                                <p class="invoice-info-row"><span>تاريخ الأستحقاق :</span> <span>{{$invoice->section->section_name}}</span></p>
                                            </div>
										</div>
										
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">المنتج</th>
													<th class="wd-40p">مبلغ التحصيل</th>
													<th class="tx-center">مبلغ العمولة</th>
													<th class="tx-right">الإجمالي</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th class="wd-20p">{{$invoice->product}}</th>
													<th class="wd-40p">{{number_format($invoice->amount_collection,2)}}</th>
													<th class="tx-center">{{number_format($invoice->amount_commission,2)}}</th>
                                                    <?php $total = $invoice->amount_collection + $invoice->amount_commission ?>
													<th class="tx-right">{{number_format($total,2)}}</th>
												</tr>
												<tr>
													<td class="valign-middle" colspan="1" rowspan="4">
														<div class="invoice-notes">
															<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
														</div><!-- invoice-notes -->
													</td>
													<td class="tx-right">الإجمالي</td>
													<td class="tx-right" colspan="2">{{number_format($total,2)}}</td>
												</tr>
												<tr>
													<td class="tx-right">نسبة الضريبة ({{$invoice->rate_vat}})</td>
													<td class="tx-right" colspan="2">{{$invoice->value_vat}}</td>
												</tr>
												<tr>
													<td class="tx-right">الخصم</td>
													<td class="tx-right" colspan="2">{{$invoice->discount}}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الإجمالي شامل الضريبة</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">{{number_format($invoice->total,2)}}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									<a href="" class="btn btn-danger float-left mt-3 mr-2" id="print_button" onclick="printDiv()">
										<i class="mdi mdi-printer ml-1"></i>طباعة
									</a>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')


<script type="text/javascript">
	function printDiv() {
		var printContents = document.getElementById('body').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
		location.reload();
	}
</script>
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection