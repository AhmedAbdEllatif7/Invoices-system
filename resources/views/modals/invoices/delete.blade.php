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
