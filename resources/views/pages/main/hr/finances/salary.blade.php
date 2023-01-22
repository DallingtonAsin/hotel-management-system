@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Salaries</strong>
                <span class="badge badge-info total_salaries">
                    @isset($total_salaries)
                        {{ number_format($total_salaries) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewPayment">
                <i class="fa fa-plus-circle pr-1"></i>Record salary</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover salaries-table" id="salaries-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Employee Name</th>
                            <th>Amount</th>
                            <th>Pay Date</th>
                            <th>Added by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Salary -->
    <div class="modal fade nunito-font addSalaryModal" id="addSalaryModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="salaries" id="SalaryForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new salary</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control salaryId  salaryId" name="id"
                                placeholder="Enter salary id" autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Staff member</span>
                            <select class="form-control staff_members_section " name="employee">
                                <option value="">select staff member</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Amount</span>
                            <input type="text" class="form-control  amount" name="amount"
                                placeholder="Enter salary amount" required autofocus>
                        </div>

                        <div class="form-group">
                            <span class="text-muted"><span class="text-danger pr-2">*</span>Payment Date</span>
                            <input type="date" class="form-control payment_date" name="payment_date"
                                value="{{ old('payment_date', now()->format('Y-m-d')) }}" autocomplete="on">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addSalaryBtn" name="addSalaryBtn">Save</button>
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

    <!--Import Designations -->
    <div class="modal fade nunito-font" id="importRooms" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ Route('suppliers.import') }}" method="post" enctype="multipart/form-data"
                    name="inportExpensesForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold">
                            Import an excel file of salaries </h6>
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
                                name="select_file" required autofocus>
                        </div>

                        @error('select_file')
                            <div class='alert alert-danger alert-dismissible text-center' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span></button>
                                <strong>Sorry!</strong> {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--Modal Delete Designations -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete salary</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this salary
                                <small class="text-dark text-muted bolded">
                                </small>
                                ?

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
    </div> <!-- end of modal Delete Designations-->

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const ajaxUrl = @json(route('salaries.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const staffAjaxUrl = @json(route('staff.ajax.fetch'));
        const cat = 'salary';
        populateStaffMemebers();

        $(document).ready(function() {

            let table = $('#salaries-table');
            let title = "List of recorded salaries in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
                {
                    data: 'employee_name',
                    name: 'employee_name'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'pay_date',
                    name: 'pay_date'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('#addNewPayment').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_salaries, function(salary) {
                    DisableTableFields(false);
                    ShowBtns();
                    $('.addSalaryBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.salaryId').val('');
                    $('#SalaryForm').trigger("reset");
                    $('#modalHeading').html("Add new salary");
                    $('#addSalaryModal').modal('show');
                });
            });

            Numberize(".amount");

            //modal used to edit salaries details [each row of the tbl]
            $('body').on('click', '#edit-salary', function(event) {
                let salary_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_salaries, function(salary) {
                    editSalary(salary_id);
                });
            });

            function editSalary(salary_id) {
                $.get("{{ route('salary.index') }}" + '/' + salary_id + '/edit', function(data) {
                    $('#modalHeading').html("Edit details of salary " + data.name + "");
                    $('.addSalaryBtn').text("Edit salary");
                    $('#addSalaryModal').modal('show');
                    $('.salaryId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(false);
                    ShowBtns();
                });
            }


            //View Modal used to view each row [salaries details]
            $('body').on('click', '#view-salary', function(event) {
                let salary_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_salaries, function(salary) {
                    viewSalary(salary_id);
                });
            });

            function viewSalary(salary_id) {
                $.get("{{ route('salary.index') }}" + '/' + salary_id + '', function(data) {
                    $('#modalHeading').html("Details of salary " + data.name + "");
                    $('#addSalaryModal').modal('show');
                    $('.salaryId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(true);
                    HideBtns();
                });
            }


            $('.addSalaryBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {
                    $('.errors-section').html('');
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#SalaryForm').serialize(),
                        url: "{{ route('salary.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#SalaryForm').trigger("reset");
                            $('#addSalaryModal').modal("hide");
                            let resp = data.success;
                            displayResponse('.response', resp, 'success');
                            ResetTblInfo(data);
                            let tbl = $('#salaries-table').DataTable();
                            tbl.ajax.reload();

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addSalaryBtn').html('Save Changes');
                        }
                    });
                } else {
                    let i;
                    let message = "";
                    for (i = 0; i < Errors.length; i++) {
                        message += Errors[i] + "<br>";
                    }
                    $('.errors-section').html(message);

                }

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-salary', function(e) {
                let salary_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.cancel_salaries, function(salary) {
                    $("#deleteSuppliersModal").modal('show');
                    $(".delete-alert-text").html("Are you sure you want to delete this salary?");
                    $('.delete-ok-btn').on('click', function() {
                        deleteRecord(salary_id);
                    });
                });
            });

            function deleteRecord(id) {
                let deleteUrl = '{{ route('salary.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        let resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteSuppliersModal').modal("hide");
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#salaries-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.salaryId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addSalaryBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addSalaryBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_salaries').html(totl_number);
            }

            function validateForm() {

                let employee = $('.staff_members_section').val();
                let amount = $('.amount').val();
                let payment_date = $('.payment_date').val();

                let errors = [];
                if (employee.length < 1) {
                    errors.push(`Please select staff member`);
                }
                if (amount.length < 1) {
                    errors.push(`Please enter salary amount`);
                }
                if (payment_date.length < 1) {
                    errors.push(`Please select payment date`);
                }
                return errors;
            }

            $("#removeAllSuppliers").bind("click", function() {
                RemoveAllSuppliers();
            });

            function RemoveAllSuppliers() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all salaries',
                    content: 'Are you sure you want to remove all salaries',
                    buttons: {
                        confirm: function() {
                            let self = this;
                            return $.ajax({
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                url: '{{ Route('suppliers.truncate') }}',
                                type: 'POST',
                                // dataType: 'json',
                            }).done(function(data) {

                                $.alert({
                                    title: 'Message',
                                    content: data.success,
                                });
                                $(".total_salaries").text(data.totl_no);
                                $(".totl_credit").text(data.totl_credit);
                                $(".totl_debt").text(data.totl_debt);
                                let tbl = $('#salaries-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "Suppliers not deleted:" + data.fail,
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
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
