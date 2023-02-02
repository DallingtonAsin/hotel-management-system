@extends('layouts.master')

@section('content')
    <div class="card">

        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Rooms</strong>
                <span class="badge badge-info total_rooms">
                    @isset($total_rooms)
                        {{ number_format($total_rooms) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill ml-auto mb-2" id="addNewRoom">
                <i class="fa fa-plus-circle pr-1"></i>Add room</button>
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

                <table class="table table-bordered table-hover rooms-table" id="rooms-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room No.</th>
                            <th>Room Type</th>
                            <th>Floor No.</th>
                            <th>Current Status</th>
                            <th>Description</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>



    <!--Add rooms -->
    <div class="modal fade nunito-font addRoomModal" id="addRoomModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="rooms" id="RoomsForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new room</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control room_id  room_id" name="id"
                                placeholder="Enter room id" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Room Type</span>
                            <select class="form-control room_types_section " name="room_type">
                                <option value="">Select room type</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Room number</span>
                            <input type="text" class="form-control room_number " name="room_number"
                                placeholder="Enter room number" required autofocus>
                        </div>


                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Floor number</span>
                            <input type="number" class="form-control floor_number " name="floor_number"
                                placeholder="Enter floor number" required autofocus>
                        </div>


                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Status</span>
                            <select name="status" class="form-control status">
                                <option value="">Select status</option>
                                @foreach ($room_statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <span>Description</span>
                            <textarea class="form-control description" rows="3" name="description" placeholder="Enter description"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary rounded-pill addRoomBtn" name="addRoomBtn">Save</button>
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
                            Import an excel file of rooms </h6>
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


    <!--Modal Delete rooms -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete room</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this room
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
    </div> <!-- end of modal Delete Suppliers-->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const ajaxUrl = @json(route('rooms.index.ajax'));
        const roomTypesAjaxUrl = @json(route('room_types.ajax.fetch'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));

        const cat = 'rooms';
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

                    populateRoomTypes();

                    //code that displays results of the table index()
                    let table = $('#rooms-table');
                    let title = "List of registered rooms in the system";
                    let columns = [0, 1, 2, 3, 4, 5, 6];
                    let dataColumns = [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                        {
                            data: 'number',
                            name: 'number'
                        },
                        {
                            data: 'room_type',
                            name: 'room_type'
                        },
                        {
                            data: 'floor_number',
                            name: 'floor_number'
                        },
                        {
                            data: 'room_status',
                            name: 'room_status'
                        },

                        {
                            data: 'description',
                            name: 'description'
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

                    $('#addNewRoom').click(function(e) {
                        e.preventDefault();
                        checkPermission(permissions.create_rooms, function(room) {
                            DisableTableFields(false);
                            ShowBtns();
                            $('.addRoomBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                            $('.room_id').val('');
                            $('#RoomsForm').trigger("reset");
                            $('#modalHeading').html("Add new room");
                            $('#addRoomModal').modal('show');
                        });
                    });


                    Numberize(".debt");
                    Numberize(".credit");

                    //modal used to edit rooms details [each row of the tbl]
                    $('body').on('click', '#edit-room', function(event) {
                        let room_id = $(this).data('id');
                        event.preventDefault();
                        checkPermission(permissions.edit_rooms, function(room) {
                            editRoomDetails(room_id);
                        });
                    });

                    function editRoomDetails(room_id) {
                        $.get("{{ route('rooms.index') }}" + '/' + room_id + '/edit', function(response) {
                            if (response.success) {
                                let data = response.data;
                                $('#modalHeading').html("Edit details of room " + data.number + "");
                                $('.addRoomBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                                $('#addRoomModal').modal('show');
                                populateRoomDetails(data);
                                DisableTableFields(false);
                                ShowBtns();
                            } else {
                                displayResponse(null, response.error, 'error');
                            }
                        });
                    }

                    function populateRoomDetails(data) {
                        $('.room_id').val(data.id);
                        $('.room_types_section').val(data.type_id);
                        $('.room_number').val(data.number);
                        $('.floor_number').val(data.floor_number);
                        $('.status').val(data.status_id);
                        $('.description').val(data.description);
                    }


                    //View Modal used to view each row [rooms details]
                    $('body').on('click', '#view-room', function(event) {
                        let room_id = $(this).data('id');
                        event.preventDefault();
                        checkPermission(permissions.view_rooms, function(room) {
                            viewRoomDetails(room_id);
                        });
                    });


                    function viewRoomDetails(room_id) {
                        $.get("{{ route('rooms.index') }}" + '/' + room_id + '', function(response) {
                            if (response.success) {
                                let data = response.data;
                                $('#modalHeading').html("Details of room " + data.number + "");
                                $('#addRoomModal').modal('show');
                                populateRoomDetails(data);
                                DisableTableFields(true);
                                HideBtns();
                            } else {
                                displayResponse(null, response.error, 'error');
                            }
                        });
                    }

                    $('.addRoomBtn').click(function(e) {

                        e.preventDefault();

                        let isValidForm = validateForm();
                        if (isValidForm) {
                            $(this).html('Sending..');

                            $.ajax({
                                data: $('#RoomsForm').serialize(),
                                url: "{{ route('rooms.store') }}",
                                type: "POST",
                                dataType: 'json',
                                success: function(data) {

                                    $('#RoomsForm').trigger("reset");
                                    $('#addRoomModal').modal("hide");
                                    let resp = data.success;
                                    displayResponse('.response', resp, 'success');
                                    ResetTblInfo(data);
                                    let tbl = $('#rooms-table').DataTable();
                                    tbl.ajax.reload();

                                },
                                error: function(data) {
                                    console.log('Error:', data.error);
                                    displayResponse('.response', data.error, 'error');
                                    $('.addRoomBtn').html('Save Changes');
                                }
                            });
                        }

                    });

                    //this pops up confirm delete modal
                    $('body').on('click', '#delete-room', function(e) {
                        let room_id = $(this).data("id");
                        e.preventDefault();
                        checkPermission(permissions.delete_rooms, function(room) {
                            $.get("{{ route('rooms.index') }}" + '/' + room_id + '/edit', function(
                                response) {
                                if (response.success) {
                                    let data = response.data;
                                    $("#deleteSuppliersModal").modal('show');
                                    $(".delete-alert-text").html(
                                        `Are you sure you want to delete room number ${data.number}?`
                                        );
                                    $('.delete-ok-btn').on('click', function() {
                                        deleteRoom(room_id);
                                    });
                                } else {
                                    displayResponse(null, response.error, 'error');
                                }
                            });
                        });

                        });


                        function deleteRoom(id) {
                            let deleteUrl = '{{ route('rooms.destroy', ':id') }}';
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
                                    let tbl = $('#rooms-table').DataTable();
                                    tbl.ajax.reload();
                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                    displayResponse('.response', data.error, 'error');
                                }
                            });
                        }


                        function DisableTableFields(bool) {
                            $('.room_id').attr('disabled', bool);
                            $('.room_types_section').attr('disabled', bool);
                            $('.room_number').attr('disabled', bool);
                            $('.floor_number').attr('disabled', bool);
                            $('.status').attr('disabled', bool);
                            $('.description').attr('disabled', bool);
                        }

                        function HideBtns() {
                            $('.addRoomBtn').hide();
                            $('.clearBtn').hide();
                            $('.closeBtn').hide();
                        }

                        function ShowBtns() {
                            $('.addRoomBtn').show();
                            $('.clearBtn').show();
                            $('.closeBtn').show();
                        }

                        function ResetTblInfo(response) {
                            let total = FormatNumber(response.total);
                            $('.total_rooms').html(total);
                        }

                        function validateForm() {

                            let room_type = $('.room_types_section').val();
                            let room_number = $('.room_number').val();
                            let floor_number = $('.floor_number').val();
                            let status = $('.status').val();
                            let description = $('.description').val();

                            let isValidForm = false;

                            if (room_type.length < 1) {
                                displayResponse(null, "Please select room type", "error");
                            }
                            else if (room_number.length < 1) {
                                displayResponse(null, "Please enter room number", "error");
                            }
                            else if (floor_number.length < 1) {
                                displayResponse(null, "Please enter floor number on which the room is located", "error");
                            }

                            else if (status.length < 1) {
                                displayResponse(null, "Please select room status", "error");
                            }

                            else {
                                isValidForm = true;
                            }

                            return isValidForm;

                        }

                    });
    </script>
@endsection
