<!-- delete -->
<div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">حذف المنتج</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="sections/destroy" method="post">
            {{ method_field('delete') }}
            {{ csrf_field() }}
            <div class="modal-body">
                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                <input type="hidden" name="id" id="id" value="">
                <input class="form-control" name="section_name" id="section_name" type="text" readonly>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="submit" class="btn btn-danger">تاكيد</button>
            </div>
        </form>
    </div>
</div>
</div>
