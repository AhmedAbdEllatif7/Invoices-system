            <!-- إستعادة مجموعة صفوف -->
            <div class="modal fade" id="restore_archive_selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">أرشفة الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <form action="{{route('restore.selected.invoices')}}" method="POST">
                    @method('DELETE')
                    {{ csrf_field() }}
                    <div class="modal-body">
                        هل انت متأكد من إستعادة العناصر المحددة؟
                        <input class="text" type="hidden" id="restore_archive_selected_id" name="restore_archive_selected_id" value=''>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success">تأكيد الإستعادة</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
