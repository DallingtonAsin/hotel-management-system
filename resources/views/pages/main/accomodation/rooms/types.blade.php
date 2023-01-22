@extends('layouts.template')

@section('content')
    <div class="card">

        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Room Types</strong>
                <span class="badge badge-info total_room_types">
                    @isset($total_room_types)
                        {{ number_format($total_room_types) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewRoomType">
                <i class="fa fa-plus-circle pr-1"></i>Add room type</button>
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

                <table class="table table-bordered table-hover room-types-table" id="room-types-table">

                    <thead>
                        <tr>
                            <th></th>
                            <th>Room Type</th>
                            <th>Single Occupancy Rate($)</th>
                            <th>Double Occupancy Rate($)</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>



    <!--Add rooms -->
    <div class="modal fade nunito-font addRoomTypeModal" id="addRoomTypeModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="roomTypes" id="RoomTypesForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new room type</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control room_type_id bg-white room_type_id" name="id"
                                placeholder="Enter room type id" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Name</span>
                            <input type="text" class="form-control name bg-white" name="name"
                                placeholder="Enter room type name" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Single Occupancy Rate</span>
                            <input type="text" class="form-control single_occupancy_rate bg-white"
                                name="single_occupancy_rate" placeholder="Enter single occupacy rate" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Double Occupancy rate</span>
                            <input type="text" class="form-control double_occupancy_rate bg-white"
                                name="double_occupancy_rate" placeholder="Enter double occupacy rate" required autofocus>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addRoomTypeBtn"
                                name="addRoomTypeBtn">Save</button>
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

    <!--Import Room Types -->
    <div class="modal fade nunito-font" id="importRooms" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ Route('suppliers.import') }}" method="post" enctype="multipart/form-data"
                    name="inportExpensesForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold">
                            Import an excel file of room typess </h6>
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


    <!--Modal Deleteroom typess -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete room type</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this room types
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
    </div> <!-- end of modal Delete room types-->


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('roomstypes.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'room_types';
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

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
                    data: 'single_occupancy_rate',
                    name: 'single_occupancy_rate'
                },
                {
                    data: 'double_occupancy_rate',
                    name: 'double_occupancy_rate'
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

            $('#addNewRoomType').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_room_types, function(room_type) {
                    DisableTableFields(false);
                    ShowBtns();
                    $('.addRoomTypeBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.room_type_id').val('');
                    $('#RoomTypesForm').trigger("reset");
                    $('#modalHeading').html("Add new room type");
                    $('#addRoomTypeModal').modal('show');
                });
            });


            Numberize(".single_occupancy_rate");
            Numberize(".double_occupancy_rate");

            //modal used to edit room types details [each row of the tbl]
            $('body').on('click', '#edit-room-type', function(event) {
                let room_type_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_room_types, function(room_type) {
                    editRoomType(room_type_id);
                });
            });

            function editRoomType(room_type_id) {
                $.get("{{ route('room_types.index') }}" + '/' + room_type_id + '/edit', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Edit details of room type " + data.name + "");
                        $('.addRoomTypeBtn').html("<i class='fa fa-plus-circle pr-1'></i>Update");
                        $('#addRoomTypeModal').modal('show');
                        populateRoomTypeDetails(data);
                        DisableTableFields(false);
                        ShowBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }


            //View Modal used to view each row [room types details]
            $('body').on('click', '#view-room-type', function(event) {
                let room_type_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_room_types, function(room_type) {
                    viewRoomType(room_type_id);
                });
            });

            function viewRoomType(room_type_id) {
                $.get("{{ route('room_types.index') }}" + '/' + room_type_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of room type " + data.name + "");
                        $('#addRoomTypeModal').modal('show');
                        populateRoomTypeDetails(data);
                        DisableTableFields(true);
                        HideBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateRoomTypeDetails(data) {
                $('.room_type_id').val(data.id);
                $('.name').val(data.name);
                $('.single_occupancy_rate').val(FormatNumber(data.single_occupancy_rate));
                $('.double_occupancy_rate').val(FormatNumber(data.double_occupancy_rate));
            }


            $('.addRoomTypeBtn').click(function(e) {
                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#RoomTypesForm').serialize(),
                        url: "{{ route('room_types.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#RoomTypesForm').trigger("reset");
                            $('#addRoomTypeModal').modal("hide");
                            let resp = data.success;
                            displayResponse('.response', resp, 'success');
                            ResetTblInfo(data);
                            let tbl = $('#room-types-table').DataTable();
                            tbl.ajax.reload();

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addRoomTypeBtn').html('Save Changes');
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
            $('body').on('click', '#delete-room-type', function(e) {
                let room_type_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_room_types, function(room_type) {
                    $.get("{{ route('room_types.index') }}" + '/' + room_type_id + '/edit',
                        function(response) {
                            if (response.success) {
                                let data = response.data;
                                $("#deleteSuppliersModal").modal('show');
                                $(".delete-alert-text").html(
                                    `Are you sure you want to delete room type ${data.name}?`
                                    );
                                $('.delete-ok-btn').on('click', function() {
                                    ListenAndDoDeletion(room_type_id);
                                });
                            } else {
                                displayResponse(null, response.error, 'error');
                            }
                        });
                });
            });


            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('room_types.destroy', ':id') }}';
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
                        let tbl = $('#room-types-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }


            function DisableTableFields(bool) {
                $('.room_type_id').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.single_occupancy_rate').attr('disabled', bool);
                $('.double_occupancy_rate').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addRoomTypeBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addRoomTypeBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }

            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_room_types').html(totl_number);
            }

            function validateForm() {
                let name = $('.name').val();
                let s_rate = $('.single_occupancy_rate').val();
                let d_rate = $('.double_occupancy_rate').val();

                let errors = [];
                if (name.length < 1) {
                    errors.push("Please enter the name of the room type");
                }
                if (s_rate.length < 1) {
                    errors.push("Please enter single occupancy rate");
                }
                if (d_rate.length < 1) {
                    errors.push("Please enter double occupancy rate");
                }
                return errors;

            }

        });
    </script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
