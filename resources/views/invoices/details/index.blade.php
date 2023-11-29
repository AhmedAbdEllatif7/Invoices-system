@extends('layouts.master')
@section('title')
    تفاصيل الفاتورة
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <br>
    <br>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتورة</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حاللات الدفع</a>
                                            </li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">مرفقات الفاتورة</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab4">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table text-md-nowrap" id="example1">
                                                        <thead>
                                                            <tr>
                                                                <th class="wd-15p border-bottom-0">#</th>
                                                                <th class="wd-15p border-bottom-0">الرقم التعريفي للفاتورة الأم</th>
                                                                <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                                <th class="wd-20p border-bottom-0">أسم المنتج</th>
                                                                <th class="wd-15p border-bottom-0">أسم القسم</th>
                                                                <th class="wd-10p border-bottom-0">الحالة</th>
                                                                <th class="wd-25p border-bottom-0">تاريخ الدفع</th>
                                                                <th class="wd-25p border-bottom-0">ملاحظات</th>
                                                                <th class="wd-25p border-bottom-0">تاريخ الإنشاء</th>
                                                                <th class="wd-25p border-bottom-0">تاريخ التحديث</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $invoiceDetails->id }}</td>
                                                                <td>{{ $invoiceDetails->invoice_id }}</td>
                                                                <td>{{ $invoiceDetails->invoice_number }}</td>
                                                                <td>{{ $invoiceDetails->product }}</td>
                                                                <td>{{ $invoiceDetails->section->section_name }}</td>
                                                                <td>
                                                                    @if ($invoiceDetails->value_status == 0)
                                                                        <span class="badge badge pill badge-danger">
                                                                            {{ $invoiceDetails->status }}
                                                                        </span>
                                                                    @elseif ($invoiceDetails->value_status == 1)
                                                                        <span class="badge badge pill badge-success">
                                                                            {{ $invoiceDetails->status }}
                                                                        </span>
                                                                    @else
                                                                        <span class="badge badge pill badge-warning">
                                                                            {{ $invoiceDetails->status }}
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $invoiceDetails->payment_date }}</td>
                                                                <td>{{ $invoiceDetails->note }}</td>
                                                                <td>{{ $invoiceDetails->created_at }}</td>
                                                                <td>{{ $invoiceDetails->updated_at }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table text-md-nowrap" id="example1">
                                                        <thead>
                                                            <tr>
                                                                <th class="wd-15p border-bottom-0">#</th>
                                                                <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                                <th class="wd-20p border-bottom-0">نوع المنتج</th>
                                                                <th class="wd-15p border-bottom-0">القسم</th>
                                                                <th class="wd-25p border-bottom-0">حالة الدفع</th>
                                                                <th class="wd-25p border-bottom-0">تاريخ الدفع</th>
                                                                <th class="wd-25p border-bottom-0">الملاحظات</th>
                                                                <th class="wd-25p border-bottom-0">تاريخ الإضافة</th>
                                                                <th class="wd-25p border-bottom-0">المستخدم</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($AllInvoiceDetails as $allInvoicesDetail)
                                                                <tr>
                                                                    <?php $i++; ?>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $allInvoicesDetail->invoice_number }}</td>
                                                                    <td>{{ $allInvoicesDetail->product }}</td>
                                                                    <td>{{ $allInvoicesDetail->section->section_name }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($allInvoicesDetail->value_status == 0)
                                                                            <span class="badge badge pill badge-danger">
                                                                                {{ $allInvoicesDetail->status }}
                                                                            </span>
                                                                        @elseif ($allInvoicesDetail->value_status == 1)
                                                                            <span class="badge badge pill badge-success">
                                                                                {{ $allInvoicesDetail->status }}
                                                                            </span>
                                                                        @else
                                                                            <span class="badge badge pill badge-warning">
                                                                                {{ $allInvoicesDetail->status }}
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $allInvoicesDetail->payment_date }}</td>
                                                                    <td>{{ $allInvoicesDetail->note }}</td>
                                                                    <td>{{ $allInvoicesDetail->created_at }}</td>
                                                                    <td>{{ $allInvoicesDetail->user }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab6">

                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="{{ route('attachments.store') }}"
                                                        enctype="multipart/form-data">
                                                        @method('POST')
                                                        {{ csrf_field() }}
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="customFile" name="file" required>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                value="{{ $invoiceDetails->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                value="{{ $invoiceDetails->invoice_id }}">
                                                            <label class="custom-file-label" for="customFile">حدد
                                                                المرفق</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm "
                                                            name="uploadedFile">تاكيد</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <br>


                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table text-md-nowrap" id="example1">
                                                        <thead>
                                                            <tr>
                                                                <th class="wd-15p border-bottom-0">#</th>
                                                                <th class="wd-20p border-bottom-0">أسم الملف</th>
                                                                <th class="wd-20p border-bottom-0">قام بالإضافة</th>
                                                                <th class="wd-25p border-bottom-0">تاريخ الإنشاء</th>
                                                                <th class="wd-25p border-bottom-0">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($AllInvoiceAttachments as $invoiceAttachment)
                                                                <tr>
                                                                    <?php $i++; ?>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $invoiceAttachment->file_name }}</td>
                                                                    <td>{{ $invoiceAttachment->created_by }}</td>
                                                                    <td>{{ $invoiceAttachment->created_at }}</td>
                                                                    <td colspan="2">
                                                                        <div class="dropdown">
                                                                            <button
                                                                                style="width: 102px;font-size: 12px;padding: 8px;"
                                                                                aria-expanded="false" aria-haspopup="true"
                                                                                class="btn ripple btn-primary"
                                                                                data-toggle="dropdown"
                                                                                id="dropdownMenuButton"
                                                                                type="button">العمليات
                                                                                <i class="fas fa-caret-down ml-1">
                                                                                </i>
                                                                            </button>
                                                                            
                                                                            <div class="dropdown-menu tx-13">
                                                                                @php
                                                                                $file = public_path('Attachments/' . $invoiceAttachment->invoice_number . '/' . $invoiceAttachment->file_name);
                                                                                @endphp

                                                                            @if (file_exists($file))
                                                                                <a style="width: 150px"
                                                                                    class=" btn btn-outline-success btn-sm"
                                                                                    href="{{ url('attachments/view/' . $invoiceDetails->invoice_number . '/' . $invoiceAttachment->file_name) }}"><i
                                                                                        class="fas fa-eye"></i>&nbsp;عرض</a>

                                                                                <a style="width: 150px"
                                                                                    class=" btn btn-outline-info btn-sm"
                                                                                    href="{{ url('attachments/download/' . $invoiceDetails->invoice_number . '/' . $invoiceAttachment->file_name) }}"><i
                                                                                    class="fas fa-download"></i>&nbsp;
                                                                                تحميل</a>
                                                                                @endif
                                                                                <button style="width: 150px"
                                                                                class="btn btn-outline-danger btn-sm "
                                                                                data-attachment_id="{{ $invoiceAttachment->id }}"
                                                                                data-file_name="{{ $invoiceAttachment->file_name }}"
                                                                                data-invoice_number="{{ $invoiceAttachment->invoice_number }}"
                                                                                data-toggle="modal"
                                                                                data-target="#modaldemo9"><i class="fas fa-trash-alt">
                                                                            </i>&nbsp;حذف</button>
                                                                            
                                                                            </div>
                                                                        </div>

                                                                        
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
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
            </div>
            <!-- /div -->
            <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">حذف المرفق</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('attachments.destroy', 'test') }}" method="post">
                            @method('DELETE')
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                <input type="hidden" name="attachment_id" id="attachment_id" value="">
                                <input class="form-control" name="file_name" id="file_name" type="text" readonly>
                                <input class="form-control" name="invoice_number" id="invoice_number" type="text"
                                    readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
    <!-- row closed -->
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

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var attachment_id = button.data('attachment_id')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #attachment_id').val(attachment_id);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
