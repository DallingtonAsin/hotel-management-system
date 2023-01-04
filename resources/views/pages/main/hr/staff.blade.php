@extends('layouts.template')

@section('content')
    <!--Add staff -->
    <div class="modal fade nunito-font" id="addStaffModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <form mname="user" id="userForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h5 class="modal-title w-100 font-weight-bold modalHeading" id="modalHeading">Add new manager</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" class="userId" name="id">
                            <span><span class="text-danger">*</span> First Name</span>
                            <input type="text" class="form-control first_name bg-white" name="firstName"
                                placeholder="Enter first name" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Last Name</span>
                            <input type="text" class="form-control last_name bg-white" name="lastName"
                                placeholder="Enter last name" required autofocus>
                        </div>


                        <div class="form-group">
                            <span><span class="text-danger">*</span> Address</span>
                            <input type="text" class="form-control address bg-white" name="address"
                                placeholder="Enter address" required autofocus>
                        </div>

                        <div class="form-group">
                            <span> Email</span>
                            <input type="email" class="form-control email bg-white" name="email"
                                placeholder="Email (optional)">
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <span><span class="text-danger">*</span> Employee Number</span>
                                <input type="text" class="form-control employee_id bg-white" name="employee_id"
                                    placeholder="Enter employee number" required autofocus>
                            </div>

                            <div class="col-md-6">
                                <span>NIN</span>
                                <input type="text" class="form-control national_id bg-white" name="NationalIDNo"
                                    placeholder="Enter NationalID number(optional)" required autofocus>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <span><span class="text-danger">*</span> Primary Tel No.</span>
                                <input type="text" class="form-control tel_no bg-white" name="tel_no"
                                    placeholder="Enter primary telephone number" required autofocus>
                            </div>

                            <div class="col-md-6">
                                <span>Alternative Tel No.</span>
                                <input type="text" class="form-control alt_telno bg-white" name="alt_telno"
                                    placeholder="Enter alternative telephone number (optional)">
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <span><span class="text-danger">*</span> Department</span>
                                    <select class="form-control departments_section bg-white" name="department">
                                        <option value="">select department</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <span><span class="text-danger">*</span> Designation</span>
                                    <select class="form-control bg-white designation_section" name="designation">
                                        <option value="">select designation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <span><span class="text-danger">*</span> Gender</span>
                                <select class="form-control gender bg-white" name="gender">
                                    <option value="">select gender</option>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                </select>
                            </div>
                            <span class="errors-section text-danger"></span>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary addStaffBtn" id="addStaffBtn"
                                name="addStaffBtn"><i class="fa fa-plus-circle pr-1"></i>Save</button>
                            <button type="reset" class="btn btn-danger"><i
                                    class="fas fa-f12d text-white fa-lg pr-1"></i>Clear</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--Import managers -->
    <div class="modal fade nunito-font" id="importmanagers" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <form action="" method="post" enctype="multipart/form-data" name="inportExpensesForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h5 class="modal-title w-100 font-weight-bold">
                            Import an excel file of managers </h5>
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


    <!--Modal Delete staff -->
    <div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title delete-modal-title w-100 font-weight-bold">Delete manager</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this manager
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
    </div> <!-- end of modal Deletemanagers-->


    <div class="modal fade" id="accountChangeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title change-account-modal-title w-100 font-weight-bold">Lock or unlock user account
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger account-change-alert-text">Are you sure you want lock or unlock this
                                account?
                                <small class="text-dark text-muted bolded">
                                </small>
                                ?

                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary confirm-changeAccount-ok-btn"
                            name="ConfirmChangeBtn">Yes</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Staff Members</strong>
                <span class="badge badge-info total_staff">
                    @isset($total_staff)
                        {{ number_format($total_staff) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewStaff">
                <i class="fa fa-plus-circle pr-1"></i>Add staff</button>
        </div>

        <div class="card-body">
            <div class="row">
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
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover managers-table" id="managers-table">

                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Staff ID</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Phone Number</th>
                            <th>NIN</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#">Action 1</a>
        <a class="dropdown-item" href="#">Action 2</a>
        <button class="dropdown-item" type="button">Action 3</button>
    </div>

    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('staff.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-users.remove'));
        const cat = 'manager';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            //code that displays results of the table index()
            let table = $('#managers-table');
            let title = "List of registered managers in the system";
            let columns = [0, 1];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
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
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'staff_id',
                    name: 'staff_id'
                },
                {
                    data: 'department',
                    name: 'department'
                },
                {
                    data: 'designation',
                    name: 'designation'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'nin',
                    name: 'nin'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('#addNewStaff').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addStaffBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                $('.managerId').val('');
                $('#userForm').trigger("reset");
                $('#modalHeading').html("Add new staff");
                $('#addStaffModal').modal('show');
            });


            Numberize(".debt");
            Numberize(".credit");

            populateDepartments();
            onSelectDepartment();

            function onSelectDepartment() {
                $('.departments_section').on('change', function() {
                    let department_id = $(this).find(":selected").val();
                    if (department_id) {
                        populateDesignations(department_id);
                    }
                });
            }

            function populateDesignations(department_id) {

                let url = '{{ route('designations.ajax.fetch', ':department_id') }}';
                url = url.replace(':department_id', department_id);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(resp) {
                        let obj = JSON.parse(resp);
                        $('.designation_section').empty().append('<option selected="selected" value="">Select designation</option>');

                        for (let i = 0; i < obj.length; i++) {
                            let id = obj[i]['id'];
                            let designation = obj[i]['name'];
                            $('.designation_section').append('<option value=' + id + '>' + designation +
                                '</option>');
                        }
                    },
                    error: function(data) {
                        console.log('Error on fetching designations', data);
                        console.log('Error:', data.error);
                        ShowResponse('.response', data.error, 'error');
                    }
                });
            }

            function populateDepartments() {
                let url = "{{ route('departments.ajax.fetch') }}"
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(resp) {
                        let obj = JSON.parse(resp);
                        for (let i = 0; i < obj.length; i++) {
                            let id = obj[i]['id'];
                            let department = obj[i]['name'];
                            $('.departments_section').append('<option value=' + id + '>' + department +
                                '</option>');
                        }
                    },
                    error: function(data) {
                        console.log('Error on fetching departments', data);
                        console.log('Error:', data.error);
                        ShowResponse('.response', data.error, 'error');
                    }
                });
            }


            function Numberize(i) {
                $(document).on("keyup", i, function() {
                    if (this.value.length > 0) {
                        let n = parseInt(this.value.replace(/\D/g, ''), 10);
                        $(this).val(n.toLocaleString());
                    }
                });
            }

            //modal used to edit managers details [each row of the tbl]
            $('body').on('click', '#edit-user', function(event) {
                let manager_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('users.index') }}" + '/' + manager_id + '/edit', function(data) {

                    $('#modalHeading').html("Edit details of manager " + data.name + "");
                    $('.addStaffBtn').text("Edit manager");
                    $('#addStaffModal').modal('show');
                    $('.userId').val(data.id);
                    $('.first_name').val(data.first_name);
                    $('.last_name').val(data.last_name);
                    $('.address').val(data.address);
                    $('.email').val(data.email);
                    $('.nin').val(data.nationalID_no);
                    $('.tel_no').val(data.tel_no);
                    $('.alt_telno').val(data.alt_telno);
                    $('.designation_section').val(data.designtion_id);
                    $('.departments_section').val(data.department_id);
                    $('.gender').val(data.gender);
                    DisableTableFields(false);
                    ShowBtns();
                })
            });


            //View Modal used to view each row [managers details]
            $('body').on('click', '#view-user', function(event) {
                let manager_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('users.index') }}" + '/' + manager_id + '', function(data) {

                    $('#modalHeading').html("Details of manager " + data.name + "");
                    $('#addStaffModal').modal('show');
                    $('.userId').val(data.id);
                    $('.first_name').val(data.first_name);
                    $('.last_name').val(data.last_name);
                    $('.address').val(data.address);
                    $('.email').val(data.email);
                    $('.national_id').val(data.nationalID_no);
                    $('.tel_no').val(data.tel_no);
                    $('.alt_telno').val(data.alt_telno);
                    $('.designation_section').val(data.designtion_id);
                    $('.departments_section').val(data.department_id);
                    $('.gender').val(data.gender);
                    DisableTableFields(true);
                    HideBtns();
                })
            });


            $('.addStaffBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#userForm').serialize(),
                        url: "{{ route('users.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#userForm').trigger("reset");
                            $('#addStaffModal').modal("hide");
                            let tbl = $('#managers-table').DataTable();
                            tbl.ajax.reload();
                            let resp = data.success;
                            ShowResponse('.response', resp, 'success');
                            ResetTblInfo(data);

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            ShowResponse('.response', data.error, 'error');
                            $('.addStaffBtn').html('Save Changes');
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
            $('body').on('click', '#delete-user', function(e) {
                let manager_id = $(this).data("id");
                e.preventDefault();
                $("#deleteStaffModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this manager?");
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(manager_id);
                });

            });

            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('users.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        let resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteStaffModal').modal("hide");
                        ShowResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#managers-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        ShowResponse('.response', data.error, 'error');
                    }
                });
            }


            $('body').on('click', '#changeAccountBtn', function(e) {
                e.preventDefault();
                let user_id = $(this).data("id");
                let account_status = $(this).data("status");
                let name = $(this).data("name");
                let statusText;
                if (account_status) {
                    statusText = 'deactivate';
                    $('.change-account-modal-title').html("Deactivate user account");
                    $('.confirm-changeAccount-ok-btn').html('Deactivate');
                } else {
                    statusText = 'activate';
                    $('.change-account-modal-title').html("Activate user account");
                    $('.confirm-changeAccount-ok-btn').html('Activate');
                }
                $("#accountChangeModal").modal('show');
                $(".account-change-alert-text").html("Are you sure you want to " +
                    statusText + " " + name + "'s account?");
                $('.confirm-changeAccount-ok-btn').on('click', function() {
                    ChangeAccountStatus(user_id, account_status);
                });

            });

            function ChangeAccountStatus(id, status) {
                let accountChangeUrl = '{{ route('account.change') }}';
                let btnText;
                (status) ? btnText = 'Deactivating...': btnText = 'Activating...';
                $('.confirm-changeAccount-ok-btn').html(btnText);
                $.ajax({
                    type: "POST",
                    url: accountChangeUrl,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(data) {
                        let resp = data.success;
                        $('.confirm-changeAccount-ok-btn').html('Yes');
                        $('#accountChangeModal').modal("hide");
                        ShowResponse('.response', resp, 'success');
                        let tbl = $('#managers-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        ShowResponse('.response', data.error, 'error');
                    }
                });
            }


            function DisableTableFields(bool) {

                $('.userId').attr('disabled', bool);
                $('.first_name').attr('disabled', bool);
                $('.last_name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.national_id').attr('disabled', bool);
                $('.tel_no').attr('disabled', bool);
                $('.alt_telno').attr('disabled', bool);
                $('.designation_section').attr('disabled', bool);
                $('.gender').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addStaffBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addStaffBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }

            function ShowResponse(area, message, errorType) {
                $(area).notify(message, {
                    className: errorType,
                    autoHide: true,
                    clickToHide: true,
                    autoHideDelay: 45000,
                });
            }

            function FormatNumber(number) {
                let FormattedNumber = parseFloat(number).toLocaleString('us', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                return FormattedNumber;
            }

            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_staff').html(totl_number);
            }

            function validateForm() {

                let first_name = $('.first_name').val();
                let last_name = $('.last_name').val();
                let address = $('.address').val();
                let national_id = $('.national_id').val();
                let tel_no = $('.tel_no').val();
                let designation = $('.designation_section').val();
                let gender = $('.gender').val();

                let errors = [];
                if (first_name.length < 1) {
                    errors.push("Please enter the first name of the manager");
                }
                if (last_name.length < 1) {
                    errors.push("Please enter the last name of the manager");
                }
                if (address.length < 1) {
                    errors.push("Please enter the primary telephone number of the manager");
                }

                if (tel_no.length < 1) {
                    errors.push("Please enter the primary telephone number of the manager");
                }
                if (designation.length < 1) {
                    errors.push("Please enter user's role");
                }

                if (gender.length < 1) {
                    errors.push("Please enter user's gender");
                }

                return errors;

            }

            $("#removeAllmanagers").bind("click", function() {
                RemoveAllmanagers();
            });

            function RemoveAllmanagers() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all managers',
                    content: 'Are you sure you want to remove all managers',
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
                                $(".total_staff").text(data.totl_no);
                                $(".totl_credit").text(data.totl_credit);
                                $(".totl_debt").text(data.totl_debt);
                                let tbl = $('#managers-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "managers not deleted:" + data.fail,
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
