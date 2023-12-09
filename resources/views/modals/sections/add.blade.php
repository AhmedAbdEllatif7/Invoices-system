{{-- Start Modal --}}
<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('sections.store')}}" method="post">
                    {{csrf_field()}}

                <div class="form-group">
                    <label for="exampleInputEmail1">اسم القسم</label>
                    <input type="text" class="form-control" id="section_name" name="section_name"  >
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">ملاحظات</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">تاكيد</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Basic modal -->