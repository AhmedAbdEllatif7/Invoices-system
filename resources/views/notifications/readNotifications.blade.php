@extends('layouts.master')
@section('title')
    الإشعارات المقروءة  
@endsection
@section('css')

    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />

    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإشعارات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الإشعارات المقروءة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

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

                    <button type="button" class="modal-effect btn btn-sm btn-danger" id="btn_delete_all">
                        <i class="fas fa-trash"></i>&nbsp;&nbsp;&nbsp;حذف العناصر المحددة
                    </a>
                    </button>

                    &nbsp;
                    <br>

                    &nbsp;
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /> </th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">صنعت يواسطة</th>
                                    <th class="border-bottom-0">عنوان الإشعار</th>
                                    <th class="border-bottom-0">تاريخ الإنشاء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (auth()->user()->readNotifications as $notification)
                                    <tr>
                                        <td><input type="checkbox"  value="{{ $notification->id }}" class="box1" ></td>
                                        <td>{{ $notification->data['invoice_number'] }}</td>
                                        <td>{{ $notification->data['created_by'] }}</td>
                                        <td>{{ $notification->data['title'] }}</td>
                                        <td>{{ $notification->created_at->setTimezone('Africa/Cairo')->format('F j, Y g:i A') }}</td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('modals.notifications.deleteSelectedNotifications')


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
