@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Designations</strong>
                <span class="badge badge-info total_designations">
                    @isset($total_designations)
                        {{ number_format($total_designations) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill ml-auto mb-2" id="addNewDesignation">
                <i class="fa fa-plus-circle pr-1"></i>Add designation</button>
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

                <table class="table table-bordered table-hover designations-table" id="designations-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>



    <!--Add Designations -->
    <div class="modal fade nunito-font addDesignationModal" id="addDesignationModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="designations" id="DesignationsForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new designation</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control designationId  designationId" name="id"
                                placeholder="Enter designation id" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Department</span>
                            <select class="form-control departments_section " name="department">
                                <option value="">select department</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Designation</span>
                            <input type="text" class="form-control name  designation" name="designation"
                                placeholder="Enter designation name" required autofocus>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary rounded-pill addDesignationBtn"
                                name="addDesignationBtn">Save</button>
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
                            Import an excel file of designations </h6>
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
                            <button type="submit" class="btn btn-primary rounded-pill">Upload</button>
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
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete designation</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this designation
                                <small class="text-dark text-muted bolded">
                                </small>
                                ?

                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary rounded-pill delete-ok-btn" name="ConfirmBtn">Yes</button>
                        <button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">No</button>
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

        const ajaxUrl = @json(route('designations.index.fetch'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const departmentsAjaxUrl = @json(route('departments.ajax.fetch'));
        const cat = 'designation';
        populateDepartments();

        $(document).ready(function() {

            let table = $('#designations-table');
            let title = "List of designations in the system";
            let columns = [0, 1, 2, 3];
            let dataColumns = [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'department',
                    name: 'department'
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

            $('#addNewDesignation').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_designations, function(designation) {
                    DisableTableFields(false);
                    ShowBtns();
                    $('.addDesignationBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.designationId').val('');
                    $('#DesignationsForm').trigger("reset");
                    $('#modalHeading').html("Add new designation");
                    $('#addDesignationModal').modal('show');
                });
            });

            //modal used to edit designations details [each row of the tbl]
            $('body').on('click', '#edit-designation', function(event) {
                let designation_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_designations, function(designation) {
                    editDesignation(designation_id);
                });
            });

            function editDesignation(designation_id) {
                $.get("{{ route('designations.index') }}" + '/' + designation_id + '/edit', function(data) {
                    $('#modalHeading').html("Edit details of designation " + data.name + "");
                    $('.addDesignationBtn').text("Edit designation");
                    $('#addDesignationModal').modal('show');
                    $('.designationId').val(data.id);
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


            //View Modal used to view each row [designations details]
            $('body').on('click', '#view-designation', function(event) {
                let designation_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_designations, function(designation) {
                    viewDesignation(designation_id);
                });
            });

            function viewDesignation(designation_id) {
                $.get("{{ route('designations.index') }}" + '/' + designation_id + '', function(data) {
                    $('#modalHeading').html("Details of designation " + data.name + "");
                    $('#addDesignationModal').modal('show');
                    $('.designationId').val(data.id);
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


            $('.addDesignationBtn').click(function(e) {

                e.preventDefault();

                let isValidForm = validateForm();
                if (isValidForm) {

                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#DesignationsForm').serialize(),
                        url: "{{ route('designations.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#DesignationsForm').trigger("reset");
                            $('#addDesignationModal').modal("hide");
                            let resp = data.success;
                            displayResponse('.response', resp, 'success');
                            ResetTblInfo(data);
                            let tbl = $('#designations-table').DataTable();
                            tbl.ajax.reload();

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addDesignationBtn').html('Save Changes');
                        }
                    });
                }

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-designation', function(e) {
                let designation_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.cancel_designations, function(designation) {
                    $("#deleteSuppliersModal").modal('show');
                    $(".delete-alert-text").html(
                        "Are you sure you want to delete this designation?");
                    $('.delete-ok-btn').on('click', function() {
                        deleteRecord(designation_id);
                    });
                });

            });

            function deleteRecord(id) {
                let deleteUrl = '{{ route('designations.destroy', ':id') }}';
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
                        let tbl = $('#designations-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.designationId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addDesignationBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addDesignationBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_designations').html(totl_number);
            }

            function validateForm() {

                let department = $('.departments_section').val();
                let designation = $('.designation').val();
                let isValidForm = false;

                if (department.length < 1) {
                    displayResponse(null, `Please select department`, 'error');
                }
                else if (designation.length < 1) {
                    displayResponse(null, `Please select designation`, 'error');
                }else{
                    isValidForm = true;
                }

                return isValidForm;

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
                    title: 'Delete all designations',
                    content: 'Are you sure you want to remove all designations',
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
                                $(".total_designations").text(data.totl_no);
                                $(".totl_credit").text(data.totl_credit);
                                $(".totl_debt").text(data.totl_debt);
                                let tbl = $('#designations-table').DataTable();
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
@endsection
