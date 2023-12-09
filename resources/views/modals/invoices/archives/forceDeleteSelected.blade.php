            <!-- حذف مجموعة صفوف -->
            <div class="modal fade" id="force_delete_selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <form action="{{route('forceDelete.selected.invoices')}}" method="POST">
                    @method('DELETE')
                    {{ csrf_field() }}
                    <div class="modal-body">
                        هل انت متأكد من حذف العناصر المحددة نهائيا؟
                        <input class="text" type="hidden" id="force_delete_selected_id" name="force_delete_selected_id" value=''>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف نهائيا</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
