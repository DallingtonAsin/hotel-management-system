@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Departments</strong>
                <span class="badge badge-info total_departments">
                    @isset($total_departments)
                        {{ number_format($total_departments) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewDepartment">
                <i class="fa fa-plus-circle pr-1"></i>Add department</button>
        </div>

        <div class="card-body">

            <div class="col-lg-8 text-center nunito-font">

                @if (session()->get('success'))
                    <div class='alert alert-success alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span></button>
                        <strong>Yello!</strong> {{ session()->get('success') }}<i class="fa fa-check-circle"></i>
                    </div>
                @endif

                @if (session()->get('fail'))
                    <div class='alert alert-danger alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span></button>
                        <strong>Oops!</strong> {{ session()->get('fail') }}
                    </div>
                @endif

            </div>

            <div class="table table-sm table-responsive">

                <table class="table table-bordered table-hover departments-table" id="departments-table">

                    <thead>
                        <tr>
                            <th></th>
                            <th>Department Code</th>
                            <th>Department Name</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>



    <!--Add department -->
    <div class="modal fade nunito-font addDepartmentModal" id="addDepartmentModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="departments" id="DepartmentsForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new department</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control departmentId  departmentId" name="id"
                                placeholder="Enter department id" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Department Code</span>
                            <input type="text" class="form-control code " name="code"
                                placeholder="Enter department code" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Department Name</span>
                            <input type="text" class="form-control name " name="name"
                                placeholder="Enter department name" required autofocus>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addDepartmentBtn"
                                name="addDepartmentBtn">Save</button>
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

    <!--Import Rooms -->
    <div class="modal fade nunito-font" id="importRooms" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ Route('suppliers.import') }}" method="post" enctype="multipart/form-data"
                    name="inportExpensesForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold">
                            Import an excel file of departments </h6>
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


    <!--Modal Delete Departments -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete department</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this department
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
    </div> <!-- end of modal Delete Departments-->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('departments.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'department';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {


            //code that displays results of the table index()
            let table = $('#departments-table');
            let title = "List of registered departments in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'name',
                    name: 'name'
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

            $('#addNewDepartment').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_departments, function(department) {
                    DisableTableFields(false);
                    ShowBtns();
                    $('.addDepartmentBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.departmentId').val('');
                    $('#DepartmentsForm').trigger("reset");
                    $('#modalHeading').html("Register new department");
                    $('#addDepartmentModal').modal('show');
                });
            });


            Numberize(".debt");
            Numberize(".credit");

            $('.addDepartmentBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#DepartmentsForm').serialize(),
                        url: "{{ route('departments.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#DepartmentsForm').trigger("reset");
                            $('#addDepartmentModal').modal("hide");
                            let resp = data.success || data.error;
                            let type = data.success ? 'success' : 'error';

                            if (data.success) {
                                ResetTblInfo(data);
                                let tbl = $('#departments-table').DataTable();
                                tbl.ajax.reload();
                            }

                            displayResponse('.response', resp, type);


                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addDepartmentBtn').html('Save Changes');
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

            //modal used to edit departments details [each row of the tbl]
            $('body').on('click', '#edit-department', function(event) {
                let department_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_departments, function() {
                    editDepartment(department_id);
                });
            });

            function editDepartment(department_id) {
                $.get("{{ route('departments.index') }}" + '/' + department_id + '/edit', function(data) {
                    $('#modalHeading').html("Edit details of department " + data.name + "");
                    $('.addDepartmentBtn').text("Edit department");
                    $('#addDepartmentModal').modal('show');
                    $('.departmentId').val(data.id);
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


            //View Modal used to view each row [departments details]
            $('body').on('click', '#view-department', function(event) {
                let department_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_departments, function() {
                    viewDepartment(department_id);
                });
            });

            function viewDepartment(department_id) {
                $.get("{{ route('departments.index') }}" + '/' + department_id + '', function(data) {

                    $('#modalHeading').html("Details of department " + data.name + "");
                    $('#addDepartmentModal').modal('show');
                    $('.departmentId').val(data.id);
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

            //this pops up confirm delete modal
            $('body').on('click', '#delete-department', function(e) {
                let department_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.cancel_departments, function() {
                    $("#deleteSuppliersModal").modal('show');
                    $(".delete-alert-text").html(
                    "Are you sure you want to delete this department?");
                    $('.delete-ok-btn').on('click', function() {
                        deleteRecord(department_id);
                    });
                });
            });


            function deleteRecord(id) {
                let deleteUrl = '{{ route('departments.destroy', ':id') }}';
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
                        let tbl = $('#departments-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.departmentId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addDepartmentBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addDepartmentBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_departments').html(totl_number);
            }

            function validateForm() {

                let code = $('.code').val();
                let name = $('.name').val();

                let errors = [];
                if (code.length < 1) {
                    errors.push("Please enter department code");
                }
                if (name.length < 1) {
                    errors.push("Please enter the name of the department");
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
                    title: 'Delete all departments',
                    content: 'Are you sure you want to remove all departments',
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
                                $(".total_departments").text(data.total);
                                let tbl = $('#departments-table').DataTable();
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
