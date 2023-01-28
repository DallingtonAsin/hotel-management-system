@extends('layouts.master')

@section('content')
    <div class="card">
        <span class="response"></span>
        <div class="card-header row d-flex justify-content-between align-items-center">
            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Staff Payments</strong>
                    <span class="badge badge-info totl_no">
                        @isset($total_payments)
                            {{ number_format($total_payments) }}
                        @endisset
                    </span>
                </h6>
            </div>


            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewPayment"><i
                            class="fa fa-plus-circle pr-1"></i>Add payment</button>
                </div>
            </div>

        </div>

        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered staff-payments-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Employee Id</th>
                            <th>Payment Category</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>PaymentSlip</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add payment categories -->
    <div class="modal fade nunito-font" id="addExpensesModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="paymentCategories" id="PaymentCategoriesForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new payment category</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control expense_id  expense_id" name="id"
                                placeholder="Enter expense id" Required autofocus>
                        </div>


                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Amount</span>
                            <input type="text" class="form-control amount " name="expenditure_amount"
                                placeholder="Amount in shs." Required autofocus>

                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Date</span>
                            <input type="date" class="form-control date " value="{{ date('Y-m-d') }}"
                                name="date_of_expense" placeholder="Enter cost of expense" Required autofocus>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="addExpensesBtn"
                                name="AddExpenseBtn">Save</button>
                            <button type="reset" class="btn btn-danger clearBtn">Clear</button>
                        </div>

                        <div class="form-group">
                            <span class="errors-section text-danger nunito-font"></span>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

 


    <!--Modal Delete Payment Category -->

    <div class="modal fade" id="deletePaymentCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">




        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete payment category</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">
                                Are you sure you want to delete this payment category?

                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary delete-ok-btn" name="ConfirmBtn">Yes</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal DeleteExpenses-->

 
    <script>
        const ajaxUrl = @json(route('staff.payments.ajax.fetch'));
        const cat = 'payment-categories';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //code that displays results of the table index()
            let table = $('.staff-payments-table');
            let title = "List of recorded staff payments in the system";
            let columns = [0, 1, 2, 3];
            let dataColumns = [
             
                 {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                {
                    data: 'employee_name',
                    name: 'employee_name'
                },
                {
                    data: 'employee_id',
                    name: 'employee_id'
                },
                {
                    data: 'payment_category',
                    name: 'payment_category'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'payment_date',
                    name: 'payment_date'
                },
                {
                    data: 'payment_slip',
                    name: 'payment_slip'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('#createNewPayment').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_expenses, function(expense) {
                    DisableFormFields(false);
                    ShowBtns();
                    $('#addExpensesBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.expense_id').val('');
                    $('#PaymentCategoriesForm').trigger("reset");
                    $('#modalHeading').html("Record new expense");
                    $('#addExpensesModal').modal('show');
                });
            });

            function SanitizeString(str) {
                let newStr = str.replace(/,/g, '').trim();
                return newStr;
            }

            Numberize(".amount");

            //modal used to edit expenses details [each row of the tbl]
            $('body').on('click', '#edit-expense', function(event) {
                let expense_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_expenses, function(expense) {
                    editExpense(expense_id);
                });
            });

            function editExpense(expense_id) {
                $.get("{{ route('expenses.index') }}" + '/' + expense_id + '/edit', function(data) {
                    $('#modalHeading').html("Edit details of expense " + data.type_name + "");
                    $('#addExpensesBtn').text("Edit expense");
                    $('#addExpensesModal').modal('show');
                    populateExpenseDetails(data);
                    DisableFormFields(false);
                    ShowBtns();
                });
            }


            //View Modal used to view each row [expenses details]
            $('body').on('click', '#view-expense', function(event) {
                let expense_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_expenses, function(expense) {
                    viewExpense(expense_id);
                });
            });

            function viewExpense(expense_id) {
                $.get("{{ route('expenses.index') }}" + '/' + expense_id + '', function(data) {
                    $('#modalHeading').html("Details of expense " + data.type_name + "");
                    $('#addExpensesModal').modal('show');
                    populateExpenseDetails(data);
                    DisableFormFields(true);
                    HideBtns();
                });
            }

            function populateExpenseDetails(data){
                    $('.expense_id').val(data.id);
                    $('.expense').val(data.type_id);
                    $('.amount').val(FormatNumber(data.amount));
                    $('.date').val(data.date_of_expenditure);
            }


            $('#addExpensesBtn').click(function(e) {

                e.preventDefault();
                let isValidForm = validateForm();

                if (isValidForm) {

                    let id = $('.expense_id').val();
                    let url = "", method = "";
                    if(id){
                        url = "{{ route('expenses.update', ':id') }}",
                        url = url.replace(':id', id);
                        method = "PUT";
                    }else{
                        url = "{{ route('expenses.store') }}";
                        method = "POST";
                    }

                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#PaymentCategoriesForm').serialize(),
                        url: url,
                        type: method,
                        dataType: 'json',
                        success: function(response) {

                            let message = response.success || response.error;
                            let type = response.success ? 'success' : 'error';
                            if(response.success){
                                let data = response.data;

                                ResetTblInfo(data);
                                let tbl = $('.staff-payments-table').DataTable();
                                tbl.ajax.reload();
                                $('#PaymentCategoriesForm').trigger("reset");
                                $('#addExpensesModal').modal("hide");
                            }

                            displayResponse(null, message, type);
                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse(null, data.error, 'error');
                            $('#addExpensesBtn').html('Save Changes');
                        }
                    });
                } 

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-expense', function(e) {
                let expense_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_expenses, function(expense) {
                $.get("{{ route('expenses.index') }}" + '/' + expense_id + '/edit', function(data) {
                    $("#deletePaymentCategoryModal").modal('show');
                    $(".delete-alert-text").html(`Are you sure you want to delete expense ${data.type_name}?`);
                    $('.delete-ok-btn').on('click', function() {
                        deleteRecord(expense_id);
                    });
                });
                });
            });


            function deleteRecord(id) {

                let url = '{{ route('expenses.destroy', ':id') }}';
                url = url.replace(':id', id);

                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function(response) {
                        let message = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if(response.success){
                            let data = response.data;
                            $('.delete-ok-btn').html('Yes');
                            $('#deletePaymentCategoryModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('.staff-payments-table').DataTable();
                            tbl.ajax.reload();
                        }
                        displayResponse(null, message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse(null, data.error, 'error');
                    }
                });
            }




            function DisableFormFields(bool) {
                $('.expense').attr('disabled', bool);
                $('.amount').attr('disabled', bool);
                $('.date').attr('disabled', bool);
            }

            function HideBtns() {
                $('#addExpensesBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('#addExpensesBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_amt, totl_no;
                totl_no = FormatNumber(response.total);
                totl_amt = FormatNumber(response.value);
                $('.totl_no').html(totl_no)
                $('.totl_amt').html(totl_amt);
            }

            function validateForm() {

                let expense = $('.expense').val();
                let amt = $('.amount').val();
                let date = $('.date').val();
                let isValidForm = false;
                
                if (expense.length < 1) {
                    displayResponse(null, "Please select expense type", 'error');
                }
                else if (!amt) {
                    displayResponse(null, "Please enter the amount", 'error');
                }

                else if (!Date.parse(date)) {
                    displayResponse(null, "Please enter a valid date of expenditure", 'error');
                }
                else{
                    isValidForm = true;
                }

                return isValidForm;
            }

            function isValidDate(value) {
                let re =
                    /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
                let flag = re.test(value);
                return flag;
            }


            $("#removeAllExpenses").bind("click", function() {
                RemoveAllExpenses();
            });

            function RemoveAllExpenses() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all expenses',
                    content: 'Are you sure you want to remove all expenses',
                    buttons: {
                        confirm: function() {
                            let self = this;
                            return $.ajax({
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                url: '{{ Route('expenses.truncate') }}',
                                type: 'POST',
                                // dataType: 'json',
                            }).done(function(data) {

                                $.alert({
                                    title: 'Message',
                                    content: data.success,
                                });
                                $(".totl_no").text(data.totl_no);
                                $(".totl_amt").text(data.totl_expenses);
                                let tbl = $('.staff-payments-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "Expenses not deleted:" + data.fail,
                                });
                                console.log(data);

                            });

                        },
                        cancel: function() {

                        }
                    },
                });

            }
        });
    </script>
@endsection
