@extends('layouts.master')

@section('content')
    <div class="card">
        <span class="response"></span>
        <div class="card-header row d-flex justify-content-between align-items-center">
            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Expenses</strong>
                    <span class="badge badge-info totl_no">
                        @isset($number_of_total_expenses)
                            {{ number_format($number_of_total_expenses) }}
                        @endisset
                    </span>
                </h6>
            </div>

            <div class="col">
                <h6 class="text-center">
                    Total expenses: shs.
                    <span class="text-danger text-center">shs.
                        <label class="totl_amt">
                            @isset($total_expenses)
                                {{ number_format($total_expenses) }}
                            @endisset
                        </label>
                    </span>
                </h6>
            </div>

            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill mx-2" id="createNewExpense"><i
                            class="fa fa-plus-circle pr-1"></i>Add expense</button>
                    {{-- <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#importExpenses"><i class="fa fa-file-import pr-1"></i>Import file</button> --}}
                </div>
            </div>

        </div>

        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered expenses-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>expense</th>
                            <th>Amount</th>
                            <th>Date of Expenditure</th>
                            <th>Is deleted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add expenses -->
    <div class="modal fade nunito-font" id="addExpensesModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="expenses" id="ExpensesForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new expense</h6>
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
                            <span><span class="text-danger pr-1">*</span>Expense</span>
                            <select class="form-control expense" name="expense">
                                <option value="">Select expense type</option>
                                @foreach ($expense_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option> 
                                @endforeach
                            </select>
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

    <!--Import Expenses -->
    <div class="modal fade nunito-font" id="importExpenses" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ Route('expenses.import') }}" method="post" enctype="multipart/form-data"
                    name="inportExpensesForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold">Import an excel file of expenses</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <span>Select file for Upload</span>
                        </div>

                        <div class="form-group">
                            <input type="file" class="form-control-file @error('select_file') is-invalid @enderror"
                                name="select_file" Required autofocus>
                        </div>

                        @error('select_file')
                            <div class='alert alert-danger alert-dismissible text-center' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span></button>
                                <strong>Sorry!</strong> {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="AddItemBtn">Upload</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--Modal Delete Expenses -->

    <div class="modal fade" id="deleteExpensesModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">




        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete expense</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">
                                Are you sure you want to delete this expense?

                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary delete-ok-btn" name="ConfirmBtn">Yes</button>
                        <button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal DeleteExpenses-->

    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
    <script>
        const ajaxUrl = @json(route('get-expenses'));
        const deletedSeletectedUrl = @json(route('selected-expenses.remove'));
        const cat = 'expenses';
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
            let table = $('.expenses-table');
            let title = "List of recorded expenses in the system";
            let columns = [0, 1, 2, 3];
            let dataColumns = [
             
                 {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                {
                    data: 'expense_type',
                    name: 'expense'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'date_of_expenditure',
                    name: 'date-of_expenditure'
                },
                
                {
                    data: 'is_deleted',
                    name: 'is_deleted'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('#createNewExpense').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_expenses, function(expense) {
                    disableFormFields(false);
                    ShowBtns();
                    $('#addExpensesBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.expense_id').val('');
                    $('#ExpensesForm').trigger("reset");
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
                    disableFormFields(false);
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
                    disableFormFields(true);
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
                        data: $('#ExpensesForm').serialize(),
                        url: url,
                        type: method,
                        dataType: 'json',
                        success: function(response) {

                            let message = response.success || response.error;
                            let type = response.success ? 'success' : 'error';
                            if(response.success){
                                let data = response.data;

                                ResetTblInfo(data);
                                let tbl = $('.expenses-table').DataTable();
                                tbl.ajax.reload();
                                $('#ExpensesForm').trigger("reset");
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
                    $("#deleteExpensesModal").modal('show');
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
                            $('#deleteExpensesModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('.expenses-table').DataTable();
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




            function disableFormFields(bool) {
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
                                let tbl = $('.expenses-table').DataTable();
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
