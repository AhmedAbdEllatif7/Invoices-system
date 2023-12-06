@extends('layouts.master')
@section('title')
    قائمة الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        @if (session()->has('delete'))
            <script>
                window.onload = function() {
                    notif({
                        msg: 'تم حذف الفاتورة بنجاح',
                        type: 'success'
                    })
                }
            </script>
        @endif


        @if (session()->has('archiev'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تمت أرشفة الفاتورة بنجاح',
                    type: 'success'
                })
            }
        </script>
    @endif



        @if (session()->has('edit'))
            <script>
                window.onload = function() {
                    notif({
                        msg: 'تم تغيير حالة الدفع بنجاح',
                        type: 'success'
                    })
                }
            </script>
        @endif

        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    @can('اضافة فاتورة')
                        <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
                    @endcan
                    &nbsp;
                    @can('تصدير EXCEL')
                        <a class="modal-effect btn btn-sm btn-primary" href="{{ url('users/export/') }}"
                            style="color:white"><i class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>
                    @endcan
                    <br> <br>

                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الأستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الأجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>
                                            <a href="{{ route('details.index', ['id' => $invoice->id]) }}">
                                                {{ $invoice->section->section_name }}
                                            </a>
                                            
                                        </td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif($invoice->value_status == 2)
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button style="width: 102px;font-size: 12px;padding: 8px;"
                                                    aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary" data-toggle="dropdown"
                                                    id="dropdownMenuButton" type="button">العمليات
                                                    <i class="fas fa-caret-down ml-1"></i>
                                                </button>
                                                <div class="dropdown-menu tx-13">

                                                    @can('تعديل الفاتورة')
                                                    <a style="width: 150px; height:30px; font-size:13px" class=" btn btn-outline-info btn-sm"
                                                        href="{{ route('invoices.edit' , $invoice->id) }}"><i
                                                            class="fas fa-edit"></i>&nbsp;&nbsp;&nbsp;تعديل</a>
                                                    @endcan

                                                    @can('تغير حالة الدفع')
                                                    <a style="width: 150px; height:30px; font-size:13px" class=" btn btn-outline-success btn-sm"
                                                        href="{{ route('invoices.show' , $invoice->id) }}"><i
                                                            class="fas fa-money-bill"></i>&nbsp;&nbsp;&nbsp;تغيير حالة
                                                        الدفع</a>
                                                    @endcan


                                                    @can('حذف الفاتورة')
                                                    <button style="width: 150px;  height:30px; font-size:13px" class="btn btn-outline-danger btn-sm"
                                                        data-id="{{ $invoice->id }}"
                                                        data-invoice_number="{{ $invoice->invoice_number }}"
                                                        data-section="{{ $invoice->section->section_name }}"
                                                        data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                            class="fas fa-trash-alt"></i>&nbsp;&nbsp;&nbsp;حذف</button>
                                                    @endcan


                                                    @can('ارشفة الفاتورة')
                                                    <button style="width: 150px;  height:30px; font-size:13px" class="btn btn-outline-info btn-sm"
                                                        data-id="{{ $invoice->id }}"
                                                        data-invoice_number="{{ $invoice->invoice_number }}"
                                                        data-section="{{ $invoice->section->section_name }}"
                                                        data-toggle="modal" href="#modaldemo10" title="أرشفة"><i class="text-warning fas fa-exchange-alt">&nbsp;&nbsp;&nbsp;أرشفة</i></button>
                                                    @endcan


                                                    @can('طباعةالفاتورة')
                                                        <a style="width: 150px; height:30px ; font-size:13px" class=" btn btn-outline-success btn-sm"
                                                        href="{{ url('show-print/' . $invoice->id) }}"><i
                                                            class="fas fa-print"></i>&nbsp;&nbsp;&nbsp;طباعة</a>
                                                    @endcan

                                            </div>
                                        </td>
                                    </tr>

                                    <!-- delete -->
                                <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">حذف الفاتورة</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('invoices.destroy','test') }}" method="post">
                                                @method('DELETE') <!-- Use DELETE method for deletion -->
                                                @csrf
                                                <div class="modal-body">
                                                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                                    <input type="hidden" name="id" id="id" value="{{$invoice->id}}">
                                                    <label>رقم الفاتورة</label>
                                                    <input class="form-control" name="invoice_number" id="invoice_number" type="text"
                                                        readonly>
                                                    <label>اسم القسم</label>
                                                    <input class="form-control" name="section" id="section" type="text" readonly>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            



            <!-- archief -->
            <div class="modal fade" id="modaldemo10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">أرشفة الفاتورة</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{url('archive-invoice')}}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>هل انت متاكد من عملية الأرشفة ؟</p><br>
                                <input type="hidden" name="id" id="id" value="">
                                <label>رقم الفاتورة</label>
                                <input class="form-control" name="invoice_number" id="invoice_number" type="text"
                                    readonly>
                                <label>اسم القسم</label>
                                <input class="form-control" name="section" id="section" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-success">تاكيد</button>
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- row closed -->
    </div>
    </div>
    <!-- Container closed -->
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var invoice_number = button.data('invoice_number')
            var section = button.data('section')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
            modal.find('.modal-body #section').val(section);

        })
    </script>


<script>
    $('#modaldemo10').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var invoice_number = button.data('invoice_number')
        var section = button.data('section')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #invoice_number').val(invoice_number);
        modal.find('.modal-body #section').val(section);

    })
</script>

    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
