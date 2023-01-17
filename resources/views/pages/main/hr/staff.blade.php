@extends('layouts.template')

@section('content')
    <!--Add staff -->
    <div class="modal fade nunito-font" id="addStaffModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog mx-auto modal-dialog-xlg" role="document">
            <div class="modal-content">

                <form mname="user" id="userForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h5 class="modal-title w-100 font-weight-bold modalHeading" id="modalHeading">Add new staff</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row form-group">
                            <div class="col-md-6">
                                <input type="hidden" class="userId" name="id">
                                <span><span class="text-danger pr-1">*</span>First Name</span>
                                <input type="text" class="form-control first_name bg-white" name="first_name"
                                    placeholder="Enter first name" required autofocus>
                            </div>

                            <div class="col-md-6">
                                <span><span class="text-danger pr-1">*</span>Last Name</span>
                                <input type="text" class="form-control last_name bg-white" name="last_name"
                                    placeholder="Enter last name" required autofocus>
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-md-4">
                                <span><span class="text-danger pr-1">*</span>Primary Tel No.</span>
                                <input type="text" class="form-control phone_number bg-white" name="phone_number"
                                    placeholder="Enter primary telephone number" required autofocus>
                            </div>

                            <div class="col-md-4">
                                <span>Other Tel No.</span>
                                <input type="text" class="form-control other_phone_number bg-white"
                                    name="other_phone_number" placeholder="Enter other telephone number">
                            </div>

                            <div class="col-md-4">
                                <span><span class="text-danger pr-1">*</span>Address</span>
                                <input type="text" class="form-control address bg-white" name="address"
                                    placeholder="Enter address" required autofocus>
                            </div>
                        </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <span><span class="text-danger pr-1">*</span>Gender</span>
                            <select class="form-control gender bg-white" name="gender">
                                <option value="">Select gender</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <span> Email</span>
                            <input type="email" class="form-control email bg-white" name="email"
                                placeholder="Enter email">
                        </div>
                    </div>

                        <div class="row form-group">
                            <div class="col-md-3">
                                <span>Tin Number</span>
                                <input type="text" class="form-control tin_number bg-white" name="tin_number"
                                    placeholder="Enter tin number" required autofocus>
                            </div>

                            <div class="col-md-3">
                                <span>NSSF Number</span>
                                <input type="text" class="form-control nssf_number bg-white" name="nssf_number"
                                    placeholder="Enter nssf number" required autofocus>
                            </div>

                            <div class="col-md-3">
                                <span>NIN</span>
                                <input type="text" class="form-control nin bg-white" name="nin"
                                    placeholder="Enter national id number" required autofocus>
                            </div>

                            <div class="col-md-3">
                                <span>Next of Kin</span>
                                <input type="text" class="form-control next_of_kin bg-white" name="next_of_kin"
                                    placeholder="Enter next of kin" required autofocus>
                            </div>

                        </div>

                        <div class="row form-group">

                        </div>


                        <div class="row form-group">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <span><span class="text-danger pr-1">*</span>Department</span>
                                    <select class="form-control departments_section bg-white" name="department">
                                        <option value="">Select department</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <span><span class="text-danger pr-1">*</span>Designation</span>
                                    <select class="form-control bg-white designation_section" name="designation">
                                        <option value="">Select designation</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <span><span class="text-danger pr-1">*</span>Staff Type</span>
                                <select class="form-control staff_type bg-white" name="staff_type">
                                    <option value="">Select staff type</option>
                                    <option value="permanent">Permanent</option>
                                    <option value="temporary">Temporary</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <span><span class="text-danger pr-1">*</span>Status</span>
                                <select class="form-control status bg-white" name="status">
                                    <option value="">Select status</option>
                                    <option value="Available" selected="true">Available</option>
                                    <option value="On Duty">On Duty</option>
                                    <option value="On Leave">On Leave</option>
                                </select>
                            </div>

                            <span class="errors-section text-danger"></span>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary addStaffBtn" id="addStaffBtn"
                                name="addStaffBtn"><i class="fa fa-plus-circle pr-1"></i>Save</button>
                            <button type="reset" class="btn btn-danger"><i
                                    class="fas fa-f12d text-white fa-lg pr-1"></i>Clear</button>

                            <span class="response"></span>
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
                    <h5 class="modal-title delete-modal-title w-100 font-weight-bold">Delete staff</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this staff
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
    </div> <!-- end of modal Deletestaff-->


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
            <div class="table-responsive">
                <table class="table table-bordered table-hover staff-table" id="staff-table">

                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Staff #</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Phone Number</th>
                            <th>NIN</th>
                            {{-- <th>Tin #</th> --}}
                            {{-- <th>NSSF #</th>
                            <th>NOK</th> --}}
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
        const cat = 'staff';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            //code that displays results of the table index()
            let table = $('#staff-table');
            let title = "List of registered staff in the system";
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
                // {
                //     data: 'tin_number',
                //     name: 'tin_number'
                // },

                // {
                //     data: 'nssf_number',
                //     name: 'nssf_number'
                // },
                // {
                //     data: 'next_of_kin',
                //     name: 'next_of_kin'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('body').on('click', '#edit-permissions', function(event) {
                let staff_id = $(this).data('id');
                event.preventDefault();
                window.location.href = 'staff-members/'+staff_id+'/permissions/edit';
            });

            $('#addNewStaff').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addStaffBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                $('.staffId').val('');
                $('#userForm').trigger("reset");
                $('#modalHeading').html("Add new staff");
                $('#addStaffModal').modal('show');
            });

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
                        $('.designation_section').empty().append(
                            '<option selected="selected" value="">Select designation</option>');

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
                        displayResponse('.response', data.error, 'error');
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
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }


            //modal used to edit staff details [each row of the tbl]
            $('body').on('click', '#edit-staff', function(event) {
                let staff_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('users.index') }}" + '/' + staff_id + '/edit', function(data) {

                    $('#modalHeading').html(
                        `Edit details of staff ${data.first_name} ${data.last_name} `);
                    $('.addStaffBtn').text("Edit staff");
                    $('#addStaffModal').modal('show');
                    $('.userId').val(data.id);
                    $('.first_name').val(data.first_name);
                    $('.last_name').val(data.last_name);
                    $('.address').val(data.address);
                    $('.email').val(data.email);
                    $('.employee_id').val(data.staff_id);
                    $('.nin').val(data.nationalID_no);
                    $('.phone_number').val(data.phone_number);
                    $('.other_phone_number').val(data.other_phone_number);
                    $('.designation_section').val(data.designation_id);
                    $('.departments_section').val(data.department_id);
                    $('.gender').val(data.gender);
                    DisableTableFields(false);
                    ShowBtns();
                })
            });

            //View Modal used to view each row [staff details]
            $('body').on('click', '#view-staff', function(event) {
                let staff_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('users.index') }}" + '/' + staff_id + '', function(data) {

                    $('#modalHeading').html(
                        `Details of staff ${data.first_name} ${data.last_name} `);
                    $('#addStaffModal').modal('show');
                    $('.userId').val(data.id);
                    $('.first_name').val(data.first_name);
                    $('.last_name').val(data.last_name);
                    $('.address').val(data.address);
                    $('.email').val(data.email);
                    $('.employee_id').val(data.staff_id);
                    $('.nin').val(data.nationalID_no);
                    $('.phone_number').val(data.phone_number);
                    $('.other_phone_number').val(data.other_phone_number);
                    $('.designation_section').val(data.designation_id);
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
                    $('.errors-section').html('');

                    $.ajax({
                        data: $('#userForm').serialize(),
                        url: "{{ route('users.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#addStaffModal').modal("hide");

                            let resp = data.success || data.error;
                            let type = data.success ? 'success' : 'error';

                            if (data.success) {
                                $('#userForm').trigger("reset");
                                ResetTblInfo(data);
                                let tbl = $('#staff-table').DataTable();
                                tbl.ajax.reload();
                            }
                            displayResponse('.response', resp, type);
                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
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
            $('body').on('click', '#delete-staff', function(e) {
                let staff_id = $(this).data("id");
                e.preventDefault();
                $("#deleteStaffModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this staff?");
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(staff_id);
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
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#staff-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
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
                        displayResponse('.response', resp, 'success');
                        let tbl = $('#staff-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
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
                $('.phone_number').attr('disabled', bool);
                $('.other_phone_number').attr('disabled', bool);
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

            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_staff').html(totl_number);
            }

            function validateForm() {

                let first_name = $('.first_name').val();
                let last_name = $('.last_name').val();
                let address = $('.address').val();
                let national_id = $('.national_id').val();
                let phone_number = $('.phone_number').val();
                let designation = $('.designation_section').val();
                let gender = $('.gender').val();
                let staff_type = $('.staff_type').val();
                let status = $('.status').val();

                let errors = [];
                if (first_name.length < 1) {
                    errors.push("Please enter first name");
                }
                if (last_name.length < 1) {
                    errors.push("Please enter last name");
                }
                if (address.length < 1) {
                    errors.push("Please enter address");
                }

                if (phone_number.length < 1) {
                    errors.push("Please enter primary phone number");
                }
                if (designation.length < 1) {
                    errors.push("Please enter staff's designation");
                }

                if (gender.length < 1) {
                    errors.push("Please select gender");
                }

                if (staff_type.length < 1) {
                    errors.push("Please select staff type");
                }

                if (status.length < 1) {
                    errors.push("Please select status");
                }

                return errors;

            }

            $("#removeAllStaffs").bind("click", function() {
                RemoveAllStaff();
            });

            function RemoveAllStaff() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all staff',
                    content: 'Are you sure you want to remove all staff',
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
                                let tbl = $('#staff-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "staff not deleted:" + data.fail,
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
