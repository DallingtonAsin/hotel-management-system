@extends('layouts.template')

@section('content')
    <div class="card">

        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Guest Types</strong>
                <span class="badge badge-info total_departments">
                    @isset($total_guest_types)
                        {{ number_format($total_guest_types) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewGuestType">
                <i class="fa fa-plus-circle pr-1"></i>Add guest type</button>
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

            <div class="custom-family">

                <table class="table table-bordered table-hover room-types-table" id="room-types-table">

                    <thead>
                        <tr>
                            <th></th>
                            <th>Guest Type</th>
                            <th>Is Regular</th>
                            <th>Is Corporate</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>



    <!--Add guest types -->
    <div class="modal fade nunito-font addGuestTypeModal" id="addGuestTypeModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="guestTypes" id="GuestTypesForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new guest type</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control guestTypeId bg-white guestTypeId" name="id"
                                placeholder="Enter guest type id" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Name</span>
                            <input type="text" class="form-control name bg-white" name="name"
                                placeholder="Enter guest type name" required autofocus>
                        </div>

                        <div class="form-group">
                          <span><span class="text-danger pr-1">*</span>Is Regular</span><br>
                          <input type="radio" id="yes" name="is_regular" value="Yes">
                          <label for="yes">Yes</label>
                          <input type="radio" id="no" name="is_regular" value="No" checked="true">
                          <label for="no">No</label>
                        </div>
  

                      <div class="form-group">
                        <span><span class="text-danger pr-1">*</span>Is Corporate</span><br>
                        <input type="radio" id="yes" name="is_corporate" value="Yes">
                          <label for="yes">Yes</label>
                          <input type="radio" id="no" name="is_corporate" value="No" checked="true">
                          <label for="no">No</label>
                    </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addGuestTypeBtn"
                                name="addGuestTypeBtn">Save</button>
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
                            Import an excel file of guest types </h6>
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


    <!--Modal Delete Guest types -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete guest type</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this guest type
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
    </div> <!-- end of modal Delete guest types-->


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('guesttypes.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'guest_types';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {


            //code that displays results of the table index()
            let table = $('#room-types-table');
            let title = "List of registered room types in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'is_regular',
                    name: 'is_regular'
                },
                {
                    data: 'is_corporate',
                    name: 'is_corporate'
                },
               {
                    data: 'added_by',
                    name: 'added_by'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('#addNewGuestType').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addGuestTypeBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                $('.guestTypeId').val('');
                $('#GuestTypesForm').trigger("reset");
                $('#modalHeading').html("Add new guest type");
                $('#addGuestTypeModal').modal('show');
            });


            Numberize(".debt");
            Numberize(".credit");

            function Numberize(i) {
                $(document).on("keyup", i, function() {
                    if (this.value.length > 0) {
                        let n = parseInt(this.value.replace(/\D/g, ''), 10);
                        $(this).val(n.toLocaleString());
                    }
                });
            }

            //modal used to edit guest types details [each row of the tbl]
            $('body').on('click', '#edit-guest-type', function(event) {
                let guest_type_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('guest_types.index') }}" + '/' + guest_type_id + '/edit', function(data) {

                    $('#modalHeading').html("Edit details of guest type " + data.name + "");
                    $('.addGuestTypeBtn').text("Edit guest type");
                    $('#addGuestTypeModal').modal('show');
                    $('.guestTypeId').val(data.id);
                    $('.name').val(data.name);
                    DisableTableFields(false);
                    ShowBtns();
                })
            });


            //View Modal used to view each row [guest types details]
            $('body').on('click', '#view-guest-type', function(event) {
                let guest_type_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('guest_types.index') }}" + '/' + guest_type_id + '', function(data) {

                    $('#modalHeading').html("Details of guest-type " + data.name + "");
                    $('#addGuestTypeModal').modal('show');
                    $('.guestTypeId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(true);
                    HideBtns();
                })
            });


            $('.addGuestTypeBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#GuestTypesForm').serialize(),
                        url: "{{ route('guest_types.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#GuestTypesForm').trigger("reset");
                            $('#addGuestTypeModal').modal("hide");
                            let resp = data.success;
                         
                            ShowResponse('.response', resp, 'success');
                            ResetTblInfo(data);
                            let tbl = $('#room-types-table').DataTable();
                            tbl.ajax.reload();

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            ShowResponse('.response', data.error, 'error');
                            $('.addGuestTypeBtn').html('Save Changes');
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
            $('body').on('click', '#delete-guest-type', function(e) {
                let guest_type_id = $(this).data("id");
                e.preventDefault();
                $("#deleteSuppliersModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this guest type?");
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(guest_type_id);
                });

            });


            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('guest_types.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        let resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteSuppliersModal').modal("hide");
                        ShowResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#room-types-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        ShowResponse('.response', data.error, 'error');
                    }
                });
            }


            function DisableTableFields(bool) {

                $('.guestTypeId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addGuestTypeBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addGuestTypeBtn').show();
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
                $('.total_guest_types').html(totl_number);
            }

            function validateForm() {
                let name = $('.name').val();
                let errors = [];
                if (name.length < 1) {
                    errors.push("Please enter the name of the guest type");
                }
                return errors;
            }



            $("#removeAllGuestTypes").bind("click", function() {
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
                    title: 'Delete all guest types',
                    content: 'Are you sure you want to remove all guest types',
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
                                $(".total_guest_types").text(data.total);
                                let tbl = $('#room-types-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "Guest types not deleted:" + data.fail,
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
