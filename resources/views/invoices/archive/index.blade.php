@extends('layouts.master')
@section('title')
    الفواتير المؤرشفة
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
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير
                    المؤرشفة</span>
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
                        msg: 'تم حذف الفاتورة نهائيا بنجاح',
                        type: 'success'
                    })
                }
            </script>
        @endif


        @if (session()->has('restore'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تمت إستعادة الفاتورة بنجاح',
                    type: 'success'
                })
            }
        </script>
  @endif

        @if (session()->has('restoreSelected'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تمت إستعادة العناصر المحددة بنجاح',
                    type: 'success'
                })
            }
        </script>
    @endif



        @if (session()->has('deleteSelectedInvoices'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم حذف العناصر المحددة بنجاح',
                    type: 'success'
                })
            }
        </script>
    @endif


        


    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">

                    <button type="button" class="modal-effect btn btn-sm btn-success" id="btn_restore_selected">
                        <i class="fas fa-exchange-alt"></i>&nbsp;&nbsp;&nbsp;إستعادة العناصر المحددة</a>
                    </button>


                    &nbsp;

                    <button type="button" class="modal-effect btn btn-sm btn-danger" id="btn_delete_all_selected">
                        <i class="fas fa-trash"></i>&nbsp;&nbsp;&nbsp;حذف العناصر المحددة
                    </a>
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /> </th>
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
                                        <td><input type="checkbox"  value="{{ $invoice->id }}" class="box1" ></td>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>
                                            {{ $invoice->section->section_name }}
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
                                                    id="dropdownMenuButton" type="button">العمليات<i
                                                        class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">

                                                    <button style="width: 150px" class="btn btn-outline-danger btn-sm"
                                                        data-id="{{ $invoice->id }}"
                                                        data-invoice_number="{{ $invoice->invoice_number }}"
                                                        data-section="{{ $invoice->section->section_name }}"
                                                        data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                            class="fas fa-trash-alt"></i>&nbsp;&nbsp;&nbsp;حذف</button>

                                                            <button style="width: 150px" class="btn btn-outline-success btn-sm"
                                                            data-id="{{ $invoice->id }}"
                                                            data-invoice_number="{{ $invoice->invoice_number }}"
                                                            data-section="{{ $invoice->section->section_name }}"
                                                            data-toggle="modal" href="#modaldemo10" title="إستعادة"><i
                                                                class="text-success fas fa-exchange-alt"></i>&nbsp;&nbsp;&nbsp;إستعادة</button>
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


        @include('modals.invoices.archives.forceDelete')

        @include('modals.invoices.archives.restore')
        <!-- row closed -->


        @include('modals.invoices.archives.restoreSelected')
        @include('modals.invoices.archives.forceDeleteSelected')

    </div>
    <!-- Container closed -->
</div>
</div>    </div>
</div>
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


<script type="text/javascript">
    $(function() {
        $("#btn_restore_selected").click(function() {
            var selected = new Array();
            $(".box1:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#restore_archive_selected_id').val(selected);
                $('#restore_archive_selected').modal('show');
            } else {
                // If no checkboxes are checked, show a message or handle accordingly
                // For example:
                alert('Please select at least one item to restore.');
            }
        });
    });
</script>



<script type="text/javascript">
    $(function() {
        $("#btn_delete_all_selected").click(function() {
            var selected = new Array();
            $(".box1:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#force_delete_selected_id').val(selected);
                $('#force_delete_selected').modal('show');
            } else {
                // If no checkboxes are checked, show a message or handle accordingly
                // For example:
                alert('Please select at least one item to force delete.');
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
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
