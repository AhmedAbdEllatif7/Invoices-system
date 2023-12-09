 {{-- Start Modal --}}
 <div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المنتج</label>
                        <input type="text" class="form-control" id="product_name" name="product_name">
                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                    <select name="section_id" id="section_id" class="form-control">
                        <option value="" selected disabled> --حدد القسم--</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                    <br>
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