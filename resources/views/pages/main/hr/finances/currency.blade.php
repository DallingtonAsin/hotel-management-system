@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Currencies</strong>
                <span class="badge badge-info total_currencies">
                    @isset($total_currencies)
                        {{ number_format($total_currencies) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill ml-auto mb-2" id="addNewCurrency">
                <i class="fa fa-plus-circle pr-1"></i>Add currency</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover currencies-table" id="currencies-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Country</th>
                            <th>Currency Code</th>
                            <th>EFRIS Code</th>
                            <th>Rate</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add currency -->
    <div class="modal fade nunito-font addCurrencyModal" id="addCurrencyModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="currencies" id="CurrencyForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new currency</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control currencyId  currencyId" name="id" placeholder="Enter currency id">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Country</span>
                            <input type="text" class="form-control country_name " name="country_name" placeholder="Enter country name">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Currency Code</span>
                            <input type="text" class="form-control currency_code " name="currency_code" placeholder="Enter currency code">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>EFRIS Code</span>
                            <input type="text" class="form-control efris_code " name="efris_code" placeholder="Enter EFRIS code">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Rate</span>
                            <input type="text" class="form-control rate " name="rate" placeholder="Enter rate">
                        </div>

                        <div class="form-group">
                            <span>Description</span>
                            <textarea class="form-control description " name="description" placeholder="Enter description"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addCurrencyBtn"
                                name="addCurrencyBtn">Save</button>
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
                            Import an excel file of currencies </h6>
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
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete currency</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this currency
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
        const ajaxUrl = @json(route('currencies.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'currencies';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            //code that displays results of the table index()
            let table = $('#currencies-table');
            let title = "List of recorded currencies in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                {
                    data: 'country',
                    name: 'country'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'efris_code',
                    name: 'efris_code'
                },
                {
                    data: 'rate',
                    name: 'rate'
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

            $('#addNewCurrency').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_currencies, function(currency) {
                    DisableTableFields(false);
                    ShowBtns();
                    $('.addCurrencyBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.currencyId').val('');
                    $('#CurrencyForm').trigger("reset");
                    $('#modalHeading').html("Add new currency");
                    $('#addCurrencyModal').modal('show');
                });
            });


            Numberize(".rate");

            $('.addCurrencyBtn').click(function(e) {

                e.preventDefault();

                let isValidForm = validateForm();
                if (isValidForm) {

                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#CurrencyForm').serialize(),
                        url: "{{ route('currencies.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#CurrencyForm').trigger("reset");
                            $('#addCurrencyModal').modal("hide");
                            let resp = data.success || data.error;
                            let type = data.success ? 'success' : 'error';

                            if (data.success) {
                                ResetTblInfo(data);
                                let tbl = $('#currencies-table').DataTable();
                                tbl.ajax.reload();
                            }

                            displayResponse('.response', resp, type);

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addCurrencyBtn').html('Save Changes');
                        }
                    });
                }

            });

            //modal used to edit currencies details [each row of the tbl]
            $('body').on('click', '#edit-currency', function(event) {
                let currency_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_currencies, function(currency) {
                    editCurrency(currency_id);
                });
            });

            function editCurrency(currency_id) {
                $.get("{{ route('currencies.index') }}" + '/' + currency_id + '/edit', function(data) {
                    $('#modalHeading').html("Edit details of currency " + data.name + "");
                    $('.addCurrencyBtn').text("Edit currency");
                    $('#addCurrencyModal').modal('show');
                    $('.currencyId').val(data.id);
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


            //View Modal used to view each row [currencies details]
            $('body').on('click', '#view-currency', function(event) {
                let currency_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_currencies, function(currency) {
                    viewCurrency(currency_id);
                });
            });

            function viewCurrency(currency_id) {
                $.get("{{ route('currencies.index') }}" + '/' + currency_id + '', function(data) {
                    $('#modalHeading').html("Details of currency " + data.name + "");
                    $('#addCurrencyModal').modal('show');
                    $('.currencyId').val(data.id);
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
            $('body').on('click', '#delete-currency', function(e) {
                let currency_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.cancel_currencies, function(currency) {
                    $("#deleteSuppliersModal").modal('show');
                    $(".delete-alert-text").html("Are you sure you want to delete this currency?");
                    $('.delete-ok-btn').on('click', function() {
                        deleteRecord(currency_id);
                    });
                });
            });


            function deleteRecord(id) {
                let deleteUrl = '{{ route('currencies.destroy', ':id') }}';
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
                        let tbl = $('#currencies-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.currencyId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addCurrencyBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addCurrencyBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_currencies').html(totl_number);
            }

            function validateForm() {
                
                let isValidForm = false;
                let country_name = $('.country_name').val();
                let currency_code = $('.currency_code').val();
                let efris_code = $('.efris_code').val();
                let rate = $('.rate').val();

                let errors = [];
                if (country_name.length < 1) {
                    displayResponse(null, "Please enter country name", 'error');
                }
                else if (currency_code.length < 1) {
                    displayResponse(null, "Please enter currency code", 'error');
                }
                else if (efris_code.length < 1) {
                    displayResponse(null, "Please enter EFRIS code", 'error');
                }
                else if (rate.length < 1) {
                    displayResponse(null, "Please enter the rate", 'error');
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
                    title: 'Delete all currencies',
                    content: 'Are you sure you want to remove all currencies',
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
                                $(".total_currencies").text(data.total);
                                let tbl = $('#currencies-table').DataTable();
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
