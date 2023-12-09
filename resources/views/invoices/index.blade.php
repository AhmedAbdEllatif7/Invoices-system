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


@if (session()->has('deleteSelected'))
<script>
window.onload = function() {
    notif({
        msg: 'تم حذف العناصر المحددة بنجاح',
        type: 'success'
    })
}
</script>
@endif


@if (session()->has('archiveSelectedInvoices'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم أرشفة العناصر المحددة بنجاح',
                    type: 'success'
                })
            }
        </script>
    @endif


@if (session()->has('changeStatusGroup'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم تعديل حالة دفع العناصر المحددة بنجاح',
                    type: 'success'
                })
            }
        </script>
    @endif



@if (session()->has('error'))
<script>
window.onload = function() {
    notif({
        msg: 'عفوا لا توجد فاتورة بهذا الرقم !',
        type: 'error'
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
                        <a class="modal-effect btn btn-sm btn-success" href="{{ url('users/export/') }}"
                            style="color:white"><i class="fas fa-file-download"></i>&nbsp;&nbsp;&nbsp;تصدير اكسيل</a>
                    @endcan

                    &nbsp;

                    <button type="button" class="modal-effect btn btn-sm btn-danger" id="btn_delete_all">
                        <i class="fas fa-trash"></i>&nbsp;&nbsp;&nbsp;حذف العناصر المحددة
                    </a>
                    </button>

                    &nbsp;


                    <button type="button" class="modal-effect btn btn-sm btn-warning" id="btn_archive_selected">
                        <i class="fas fa-archive"></i>&nbsp;&nbsp;&nbsp;أرشفة العناصر المحددة</a>

                    </button>

                    &nbsp;


                    <button type="button" class="modal-effect btn btn-sm btn-primary" id="btn_change_selected_status">
                        <i class="fas fa-edit"></i>&nbsp;&nbsp;&nbsp;تغيير حالة العناصر المحددة</a>

                    </button>

                    <br>

                    &nbsp;
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /> </th>
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
                                        <td><input type="checkbox"  value="{{ $invoice->id }}" class="box1" ></td>
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
                                        @include('modals.invoices.delete')
                                        @include('modals.invoices.changeSelectedStatus')

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('modals.invoices.deleteSelected')
            @include('modals.invoices.archives.archiveSelected')
            @include('modals.invoices.archives.archive')

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





{{-- archiev all selected --}}
<script type="text/javascript">
    $(function() {
        $("#btn_archive_selected").click(function() {
            var selected = new Array();
            $(".box1:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#archive_selected_id').val(selected);
                $('#archive_selected').modal('show');
            } else {
                // If no checkboxes are checked, show a message or handle accordingly
                // For example:
                alert('Please select at least one item to archive.');
            }
        });
    });
</script>




{{-- delete all selected --}}
<script type="text/javascript">
    $(function() {
        $("#btn_delete_all").click(function() {
            var selected = new Array();
            $(".box1:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#delete_all_id').val(selected);
                $('#delete_all').modal('show');
            } else {
                // If no checkboxes are checked, show a message or handle accordingly
                // For example:
                alert('Please select at least one item to delete.');
            }
        });
    });
</script>





{{-- //change status --}}
<script type="text/javascript">
    $(function() {
        $("#btn_change_selected_status").click(function() {
            var selected = new Array();
            $(".box1:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#change_status_selected_id').val(selected);
                $('#change_delected_status').modal('show');
            } else {
                // If no checkboxes are checked, show a message or handle accordingly
                // For example:
                alert('Please select at least one item to change its status.');
            }
        });
    });
</script>


<script>
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;

        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }
</script>

<script>
    // $(document).ready(function() {
    //     // Hide the selected element initially
    //     $('#product').hide();
    //     $('#section').hide();
    //     $('#rate_vat').hide();
    // });
</script>




    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
