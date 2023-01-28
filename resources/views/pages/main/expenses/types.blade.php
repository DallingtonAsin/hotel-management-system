@extends('layouts.master')

@section('content')
    <div class="card">
        <span class="response"></span>
        <div class="card-header row d-flex justify-content-between align-items-center">
            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Expense Types</strong>
                    <span class="badge badge-info total_no">
                        @isset($total_expense_types)
                            {{ number_format($total_expense_types) }}
                        @endisset
                    </span>
                </h6>
            </div>

            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewExpenseType"><i
                            class="fa fa-plus-circle pr-1"></i>Add expense type</button>
                </div>
            </div>

        </div>

        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered expense-types-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>is deleted</th>
                            <th>created by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add expenses -->
    <div class="modal fade nunito-font" id="addExpenseTypesModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="expenses" id="ExpenseTypesForm">
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
                            <input type="hidden" class="form-control expense_type_id  expense_type_id" name="id"
                                placeholder="Enter expense id" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Type name</span>
                            <input type="text" class="form-control name " name="name" placeholder="Enter type name"
                                Required autofocus>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="addExpenseTypeBtn"
                                name="AddExpenseBtn">Save</button>
                            <button type="reset" class="btn btn-danger clearBtn">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--Modal Deleteexpenses -->

    <div class="modal fade" id="deleteExpenseTypesModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal DeleteExpenses-->

    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
    <script>
        const ajaxUrl = @json(route('expenses.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-expenses.remove'));
        const cat = 'expense-types';
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
            let table = $('.expense-types-table');
            let title = "List of recorded expense types in the system";
            let columns = [0, 1, 2, 3];
            let dataColumns = [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'is_deleted',
                    name: 'is_deleted'
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

            $('#createNewExpenseType').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_expenses, function(expense) {
                    DisableFormFields(false);
                    ShowBtns();
                    $('#addExpenseTypeBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.expense_type_id').val('');
                    $('#ExpenseTypesForm').trigger("reset");
                    $('#modalHeading').html("Add new expense type");
                    $('#addExpenseTypesModal').modal('show');
                });
            });

            function SanitizeString(str) {
                let newStr = str.replace(/,/g, '').trim();
                return newStr;
            }

            Numberize(".amount");

            //modal used to edit expenses details [each row of the tbl]
            $('body').on('click', '#edit-expense-type', function(event) {
                let expense_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_expenses, function(expense) {
                    editExpense(expense_id);
                });
            });

            function editExpense(expense_id) {
                $.get("{{ route('expense-types.index') }}" + '/' + expense_id + '/edit', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Edit details of expense " + data.name + "");
                        $('#addExpenseTypeBtn').text("Edit expense");
                        $('#addExpenseTypesModal').modal('show');
                        populateExpenseTypeDetails(data);
                        DisableFormFields(false);
                        ShowBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }


            //View Modal used to view each row [expenses details]
            $('body').on('click', '#view-expense-type', function(event) {
                let expense_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_expenses, function(expense) {
                    viewExpense(expense_id);
                });
            });

            function viewExpense(expense_id) {
                $.get("{{ route('expense-types.index') }}" + '/' + expense_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of expense type " + data.name + "");
                        $('#addExpenseTypesModal').modal('show');
                        populateExpenseTypeDetails(data);
                        DisableFormFields(true);
                        HideBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateExpenseTypeDetails(data) {
                $('.expense_type_id').val(data.id);
                $('.name').val(data.name);
            }


            $('#addExpenseTypeBtn').click(function(e) {

                e.preventDefault();
                let isValidForm = validateForm();

                if (isValidForm) {

                    $(this).html('Sending..');
                    let url = '', method = '';

                    let id = $('.expense_type_id').val();
                    if(id){
                        url = "{{ route('expense-types.update', ':id') }}";
                        url = url.replace(':id', id);
                       method = 'PUT';
                    }else{
                       url = "{{ route('expense-types.store') }}";
                       method = 'POST';
                    }


                    $.ajax({
                        data: $('#ExpenseTypesForm').serialize(),
                        url: url,
                        type: method,
                        dataType: 'json',
                        success: function(response) {

                            let message = response.success || response.error;
                            let type = response.success ? 'success' : 'error';

                            if (response.success) {
                                let data = response.data;
                                resetTableInfo(data);
                                let tbl = $('.expense-types-table').DataTable();
                                tbl.ajax.reload();
                                $('#ExpenseTypesForm').trigger("reset");
                                $('#addExpenseTypesModal').modal("hide");
                            }

                            displayResponse('.response', message, type);

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('#addExpenseTypeBtn').html('Save Changes');
                        }
                    });
                } 

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-expense-type', function(e) {
                let expense_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_expenses, function(expense) {
                    $.get("{{ route('expense-types.index') }}" + '/' + expense_id + '/edit',
                        function(response) {
                            if (response.success) {
                                let data = response.data;
                                $("#deleteExpenseTypesModal").modal('show');
                                $(".delete-alert-text").html(
                                    `Are you sure you want to delete expense type ${data.name}?`
                                    );
                                $('.delete-ok-btn').on('click', function() {
                                    deleteRecord(expense_id);
                                });
                            } else {
                                displayResponse(null, response.error, 'error');
                            }
                        });
                });
            });


            function deleteRecord(id) {

                let url = '{{ route('expense-types.destroy', ':id') }}';
                url = url.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');

                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function(response) {

                        let message = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if (response.success) {
                            let data = response.data;
                            $('.delete-ok-btn').html('Yes');
                            $('#deleteExpenseTypesModal').modal("hide");
                            resetTableInfo(data);
                            let tbl = $('.expense-types-table').DataTable();
                            tbl.ajax.reload();
                        }

                        displayResponse(null, message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }


            function DisableFormFields(bool) {
                $('.name').attr('readonly', bool);
            }

            function HideBtns() {
                $('#addExpenseTypeBtn').hide();
                $('.clearBtn').hide();
            }

            function ShowBtns() {
                $('#addExpenseTypeBtn').show();
                $('.clearBtn').show();
            }


            function resetTableInfo(response) {
                if(response.total){
                    $('.total_no').html(FormatNumber(response.total));
                }
            }

            function validateForm() {
                let name = $('.name').val();
                let isValidForm = false;
                if (name.length < 1) {
                    displayResponse(null, "Please enter the name of the expense type", 'error');
                } else {
                    isValidForm = true;
                }

                return isValidForm;
            }


        });
    </script>
@endsection
