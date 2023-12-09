            <!-- تغيير حالة دفع مجموعة صفوف -->
            <div class="modal fade" id="change_delected_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تغيير حالة الدفع للعناصر المحددة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <form action="{{route('change.group.status')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        هل انت متأكد من تغيير حالة الدفع للعناصر المحددة؟
                        <input class="text" type="hidden" id="change_status_selected_id" name="change_status_selected_id" value=''>
                    </div>


                    <div class="col">
                        <label for="exampleTextarea">حالة الدفع</label>
                        <select class="form-control" id="Status" name="Status" required>
                            <option selected="true" disabled="disabled">-- حدد حالة الدفع --</option>
                            <option value="مدفوعة" {{ old('Status', $invoice->status) == 'مدفوعة' ? 'selected' : '' }}>مدفوعة</option>
                            <option value="مدفوعة جزئيا" {{ old('Status', $invoice->status) == 'مدفوعة جزئيا' ? 'selected' : '' }}>مدفوعة جزئيا</option>
                        </select>
                    </div>
                    <br>
                
                    <div class="col">
                        <label>تاريخ الدفع</label>
                        <input class="form-control fc-datepicker" name="payment_date" placeholder="YYYY-MM-DD" type="date" value="{{ old('payment_date' , $invoice->details->last()->payment_date ?? '') }}" required>
                    </div>

                    <br>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success"> تغيير حالة الدفع</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
