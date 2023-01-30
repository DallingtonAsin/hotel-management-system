@extends('layouts.master')

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
            <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill ml-auto mb-2" id="addNewDepartment">
                <i class="fa fa-plus-circle pr-1"></i>Add department</button>
        </div>

        <div class="card-body">

            <div class="table table-sm table-responsive">
                <table class="table table-bordered table-hover departments-table" id="departments-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Department Code</th>
                            <th>Department Name</th>
                            <th>is deleted</th>
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
                            <input type="hidden" class="form-control department_id  department_id" name="id"
                                placeholder="Enter department id">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Department Code</span>
                            <input type="text" class="form-control code " name="code"
                                placeholder="Enter department code">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Department Name</span>
                            <input type="text" class="form-control name " name="name"
                                placeholder="Enter department name">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary rounded-pill addDepartmentBtn"
                                name="addDepartmentBtn">Save</button>
                            <button type="reset" class="btn btn-danger rounded-pill clearBtn">Clear</button>
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
                                name="select_file">
                        </div>

                        @error('select_file')
                            <div class='alert alert-danger alert-dismissible text-center' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span></button>
                                <strong>Sorry!</strong> {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary rounded-pill">Upload</button>
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
                        <button type="submit" class="btn btn-primary rounded-pill delete-ok-btn"
                            name="ConfirmBtn">Yes</button>
                        <button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">No</button>
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

            let table = $('#departments-table');
            let title = "List of registered departments in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
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

            $('.modal').on('hidden.bs.modal', function () {
               $('.department_id').val('');
            });


            $('#addNewDepartment').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_departments, function(department) {
                    DisableTableFields(false);
                    ShowBtns();
                    $('.addDepartmentBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.department_id').val('');
                    $('#DepartmentsForm').trigger("reset");
                    $('#modalHeading').html("Register new department");
                    $('#addDepartmentModal').modal('show');
                });
            });


            Numberize(".debt");
            Numberize(".credit");

            $('.addDepartmentBtn').click(function(e) {

                e.preventDefault();
                let department_id = $('.department_id').val();
                let method, url;

                if(department_id){
                  url = "{{ route('departments.update', ':id') }}";
                  url = url.replace(":id", department_id);
                  method = 'PUT';
                }else{
                    url = "{{ route('departments.store') }}";
                    method = 'POST';
                }

                let isValidForm = validateForm();

                if (isValidForm) {
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#DepartmentsForm').serialize(),
                        url: url,
                        type: method,
                        dataType: 'json',
                        success: function(response) {

                            let message = response.success || response.error;
                            let type = response.success ? 'success' : 'error';

                            if(response.success){
                                let data = response.data;
                                $('#DepartmentsForm').trigger("reset");
                                $('#addDepartmentModal').modal("hide");
                                resetTblInfo(data);
                                let tbl = $('#departments-table').DataTable();
                                tbl.ajax.reload();
                            }

                            displayResponse(null, message, type);
                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addDepartmentBtn').html('Save Changes');
                        }
                    });
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
                $('.department_id').val(department_id);
                $.get("{{ route('departments.index') }}" + '/' + department_id + '/edit', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Edit details of department " + data.name + "");
                        $('.addDepartmentBtn').text("Edit department");
                        $('#addDepartmentModal').modal('show');
                        $('.department_id').val('');
                        populateDepartmentDetails(data);
                        DisableTableFields(false);
                        ShowBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
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
                $.get("{{ route('departments.index') }}" + '/' + department_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of department " + data.name + "");
                        $('#addDepartmentModal').modal('show');
                        populateDepartmentDetails(data);
                        DisableTableFields(true);
                        HideBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateDepartmentDetails(data) {
                $('.department_id').val(data.id);
                $('.code').val(data.code);
                $('.name').val(data.name);
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-department', function(e) {
                let department_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.cancel_departments, function() {
                    $.get("{{ route('departments.index') }}" + '/' + department_id + '', function(response) {
                    if (response.success) {

                    let data = response.data;
                    let action = data.is_deleted == 1 ? 'undelete' : 'delete';
                    $("#deleteSuppliersModal").modal('show');
                    $(".delete-alert-text").html(
                        `Are you sure you want to ${action} department ${data.name}?`);
                    $('.delete-ok-btn').on('click', function() {
                        deleteRecord(department_id);
                    });
                } else {
                        displayResponse(null, response.error, 'error');
                    }
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
                    success: function(response) {

                       let type = response.success ? 'success' : 'error';
                       let message = response.success || response.error;

                       if(response.success){

                        let data = response.data;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteSuppliersModal').modal("hide");
                        resetTblInfo(data);
                        let tbl = $('#departments-table').DataTable();
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

            function DisableTableFields(bool) {
                $('.department_id').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.code').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addDepartmentBtn').hide();
                $('.clearBtn').hide();
            }

            function ShowBtns() {
                $('.addDepartmentBtn').show();
                $('.clearBtn').show();
            }


            function resetTblInfo(data) {
                if(data.total){
                    let total = FormatNumber(data.total);
                    $('.total_departments').html(total);
                }
            }

            function validateForm() {

                let code = $('.code').val();
                let name = $('.name').val();
                let isValidForm = false;

                if (code.length < 1) {
                    displayResponse(null, "Please enter department code", "error");
                } else if (name.length < 1) {
                    displayResponse(null, "Please enter the name of the department", "error");
                } else {
                    isValidForm = true;
                }

                return isValidForm;

            }

        });
    </script>

@endsection
