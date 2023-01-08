@extends('layouts.template')

@section('content')
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h6 class="text-left text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Reservations</strong>
                <span class="badge badge-info total_departments">
                    @isset($total_reservations)
                        {{ number_format($total_reservations) }}
                    @endisset
                </span>
            </h6>


            <div class="btn-group float-right justify-content-between mb-2">
                <a href="{{ route('reservations.create') }}"
                    class="btn btn-primary btn-sm mx-2 outline-none ml-auto mb-2 text-white" id="addNewDesignation">
                    <i class="fa fa-plus-circle pr-1"></i>Add reservation</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table table-sm table-responsive">

                <table class="table table-bordered table-hover reservations-table" id="reservations-table">

                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Guest name</th>
                            <th scope="col">Arrival date</th>
                            <th>Departure date</th>
                            <th scope="col">Days</th>
                            <th>Room No.</th>
                            <th>Discount (%)</th>
                            <th>T. Price</th>
                            <th scope="col">Recorded By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>

    <!--Add rooms -->
    <div class="modal fade nunito-font addSuppliersModal" id="addSuppliersModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="suppliers" id="SuppliersForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new supplier</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> --}}
                            <input type="hidden" class="form-control supplierId bg-white supplierId" name="id"
                                placeholder="Enter supplier id" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span>Name</span>
                            <input type="text" class="form-control name bg-white" name="name"
                                placeholder="Enter supplier name" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span>Address</span>
                            <input type="text" class="form-control address bg-white" name="address"
                                placeholder="Enter address" Required autofocus>
                        </div>


                        <div class="form-group">
                            <span>Contact</span>
                            <input type="text" class="form-control contact bg-white" name="contact"
                                placeholder="Enter contact" Required autofocus>
                        </div>


                        <div class="form-group">
                            <span>Email</span>
                            <input type="email" class="form-control email bg-white" name="email"
                                placeholder="Email (optional)">
                        </div>


                        <div class="form-group">
                            <span>Debt</span>
                            <input type="text" class="form-control debt bg-white" name="debt"
                                placeholder="Enter debt">
                        </div>


                        <div class="form-group">
                            <span>Credit</span>
                            <input type="text" class="form-control credit bg-white" name="credit"
                                placeholder="Enter credit">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addsupplierBtn"
                                name="AddsupplierBtn">Save</button>
                            <button type="reset" class="btn btn-danger clearBtn">Clear</button>
                            <button type="button" class="btn btn-dark closeBtn" data-bs-dismiss="modal">Close</button>
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
                            Import an excel file of suppliers </h6>
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
                                name="select_file" Required autofocus>
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


    <!--Modal Deletesuppliers -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete supplier</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this supplier
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
    </div> <!-- end of modal Deletesuppliers-->



    {{-- <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script> --}}


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('reservations.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'supplier';
        const token = "{{ csrf_token() }}";

        $(document).ready(function() {



            //code that displays results of the table index()
            var table = $('#reservations-table');
            var title = "List of registered departments in the system";
            var columns = [1, 2, 3, 4];
            var dataColumns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'guest',
                    name: 'guest'
                },
                {
                    data: 'arrival_date',
                    name: 'arrival_date'
                },
                {
                    data: 'departure_date',
                    name: 'departure_date'
                },
                {
                    data: 'nights',
                    name: 'nights'
                },
                {
                    data: 'room_number',
                    name: 'room_number'
                },
                {
                    data: 'discount_percent',
                    name: 'discount_percent'
                },
                {
                    data: 'total_amount',
                    name: 'total_amount'
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
                DisableTableFields(false);
                ShowBtns();
                $('.addsupplierBtn').text("Register supplier");
                $('.supplierId').val('');
                $('#SuppliersForm').trigger("reset");
                $('#modalHeading').html("Register new supplier");
                $('#addSuppliersModal').modal('show');
            });


            Numberize(".debt");
            Numberize(".credit");

    
            //Generate invoice
            $('body').on('click', '#generate-invoice', function(event) {

                var invoice_id = $(this).data('id');
                let url = "{{ route('invoice.generate', ':id') }}";
                url = url.replace(':id', invoice_id);

                event.preventDefault();
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {

                        let returned_url = response.url;
                        console.log('Returned url is', response.url);
                        window.open(returned_url, '_blank');
                    }
                });
            });

            //modal used to edit suppliers details [each row of the tbl]
            $('body').on('click', '#edit-supplier', function(event) {
                var supplier_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('suppliers.index') }}" + '/' + supplier_id + '/edit', function(data) {

                    $('#modalHeading').html("Edit details of supplier " + data.name + "");
                    $('.addsupplierBtn').text("Edit supplier");
                    $('#addSuppliersModal').modal('show');
                    $('.supplierId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(false);
                    ShowBtns();
                })
            });


            //View Modal used to view each row [suppliers details]
            $('body').on('click', '#view-supplier', function(event) {
                var supplier_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('suppliers.index') }}" + '/' + supplier_id + '', function(data) {

                    $('#modalHeading').html("Details of supplier " + data.name + "");
                    $('#addSuppliersModal').modal('show');
                    $('.supplierId').val(data.id);
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


            $('.addSupplierBtn').click(function(e) {

                e.preventDefault();

                var Errors = validateForm();
                if (Errors.length == 0) {
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#SuppliersForm').serialize(),
                        url: "{{ route('suppliers.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#SuppliersForm').trigger("reset");
                            $('#addSuppliersModal').modal("hide");
                            var resp = data.success;
                            ShowResponse('.response', resp, 'success');
                            ResetTblInfo(data);
                            var tbl = $('#reservations-table').DataTable();
                            tbl.ajax.reload();

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            ShowResponse('.response', data.error, 'error');
                            $('.addsupplierBtn').html('Save Changes');
                        }
                    });
                } else {
                    var i;
                    var message = "";
                    for (i = 0; i < Errors.length; i++) {
                        message += Errors[i] + "<br>";
                    }
                    $('.errors-section').html(message);

                }

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-supplier', function(e) {
                var supplier_id = $(this).data("id");
                e.preventDefault();
                $("#deleteSuppliersModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this supplier?");
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(supplier_id);
                });

            });


            function ListenAndDoDeletion(id) {
                var deleteUrl = '{{ route('suppliers.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        var resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteSuppliersModal').modal("hide");
                        ShowResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        var tbl = $('#reservations-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        ShowResponse('.response', data.error, 'error');
                    }
                });
            }


            function DisableTableFields(bool) {

                $('.supplierId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addsupplierBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addsupplierBtn').show();
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
                var FormattedNumber = parseFloat(number).toLocaleString('us', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                return FormattedNumber;
            }

            function ResetTblInfo(response) {
                var totl_number, sum_of_credits, sum_of_debts;
                totl_number = FormatNumber(response.totl_no);
                sum_of_credits = FormatNumber(response.totl_credit);
                sum_of_debts = FormatNumber(response.totl_debt);

                $('.totl_reservations').html(totl_number);
                $('.totl_credit').html(sum_of_credits);
                $('.totl_debt').html(sum_of_debts);
            }

            function validateForm() {
                var name = $('.name').val();
                var address = $('.address').val();
                var contact = $('.contact').val();
                var errors = [];
                if (name.length < 1) {
                    var nameErr = "Please enter the name of the supplier";
                    errors.push(nameErr);
                }
                if (address.length < 1) {
                    var addressErr = "Please enter the address of the supplier";
                    errors.push(addressErr);
                }
                if (contact.length < 1) {
                    var contactErr = "Please enter supplier's contact";
                    errors.push(contactErr);
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
                    title: 'Delete all suppliers',
                    content: 'Are you sure you want to remove all suppliers',
                    buttons: {
                        confirm: function() {
                            var self = this;
                            return $.ajax({
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                url: '{{ Route('suppliers.truncate') }}',
                                type: 'POST',
                            }).done(function(data) {

                                $.alert({
                                    title: 'Message',
                                    content: data.success,
                                });
                                $(".totl_reservations").text(data.totl_no);
                                $(".totl_credit").text(data.totl_credit);
                                $(".totl_debt").text(data.totl_debt);
                                var tbl = $('#reservations-table').DataTable();
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
