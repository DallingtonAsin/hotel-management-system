@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Suppliers</strong>
                <span class="badge badge-info total_suppliers">
                    @isset($number_of_suppliers)
                        {{ number_format($number_of_suppliers) }}
                    @endisset
                </span>
            </h6>

            <h6 class="ml-5">
                Credit: shs.<strong class="text-success total_credit">
                    @isset($total_credit)
                        {{ number_format($total_credit) }}
                    @endisset

                </strong>
            </h6>

            <h6 class="ml-5">
                Debts: shs.<label class="text-danger total_debt">
                    @isset($total_debts)
                        {{ number_format($total_debts) }}
                    @endisset

                </label>
            </h6>

            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="createNewSupplier">
                <i class="fa fa-plus-circle pr-1"></i>Add supplier</button>
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

            <div class="table-responsive">

                <table class="table table-bordered table-hover suppliers-table" id="suppliers-table">

                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th class="td-sm">No</th>
                            <th>Supplier</th>
                            <th>Tin Number</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Credit</th>
                            <th>Debt</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>



    <!--Add suppliers -->
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
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control supplier_id  supplier_id" name="id"
                                placeholder="Enter supplier id" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Name</span>
                            <input type="text" class="form-control name " name="name"
                                placeholder="Enter supplier name" autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Tin Number</span>
                            <input type="text" class="form-control tin" name="tin"
                                placeholder="Enter TIN">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Phone Number</span>
                            <input type="text" class="form-control contact " name="contact"
                                placeholder="Enter phone number">
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Address</span>
                            <input type="text" class="form-control address " name="address" placeholder="Enter address">
                        </div>

                       
                        <div class="form-group">
                            <span>Email</span>
                            <input type="email" class="form-control email " name="email" placeholder="Email">
                        </div>


                        <div class="form-group">
                            <span>Debt</span>
                            <input type="text" class="form-control debt " name="debt" placeholder="Enter debt">
                        </div>


                        <div class="form-group">
                            <span>Credit</span>
                            <input type="text" class="form-control credit " name="credit" placeholder="Enter credit">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addSupplierBtn"
                                name="addSupplierBtn">Save</button>
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

    <!--Import Suppliers -->
    <div class="modal fade nunito-font" id="importSuppliers" tabindex="-1" aria-labelledby="exampleModalLabel"
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

                    <div class="form-group text-center">
                        <label class="text-center text-danger delete-alert-text">Are you sure you want to delete this
                            supplier? </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary delete-ok-btn" name="ConfirmBtn">Yes</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal Deletesuppliers-->


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('suppliers.home'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'supplier';
        const token = "{{ csrf_token() }}";

        $(document).ready(function() {

            let table = $('#suppliers-table');
            let title = "List of registered suppliers in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [
                // {
                //     data: 'checkbox',
                //     name: 'checkbox'
                // },
                 {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
            
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'tin',
                    name: 'tin'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'credit',
                    name: 'credit'
                },
                {
                    data: 'debt',
                    name: 'debt'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('#createNewSupplier').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_suppliers, function(supplier) {
                    DisableTableFields(false);
                    ShowBtns();
                    $('.addSupplierBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.supplier_id').val('');
                    $('#SuppliersForm').trigger("reset");
                    $('#modalHeading').html("Add new supplier");
                    $('#addSuppliersModal').modal('show');
                });
            });


            Numberize(".debt");
            Numberize(".credit");

            //modal used to edit suppliers details [each row of the tbl]
            $('body').on('click', '#edit-supplier', function(event) {
                let supplier_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_suppliers, function(supplier) {
                    editSupplier(supplier_id);
                });
            });

            function editSupplier(supplier_id) {
                $.get("{{ route('suppliers.index') }}" + '/' + supplier_id + '/edit', function(response) {
                    if (response.success) {
                        let data = response.data;
                        populateSupplierDetails(data)
                        $('#modalHeading').html("Edit details of supplier " + data.name + "");
                        $('#addSuppliersModal').modal('show');
                        $('.addSupplierBtn').html('Update');
                        DisableTableFields(false);
                        ShowBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }


            //View Modal used to view each row [suppliers details]
            $('body').on('click', '#view-supplier', function(event) {
                let supplier_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_suppliers, function(supplier) {
                    viewSupplier(supplier_id);
                });
            });

            function viewSupplier(supplier_id) {
                $.get("{{ route('suppliers.index') }}" + '/' + supplier_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        populateSupplierDetails(data)
                        $('#modalHeading').html("Details of supplier " + data.name + "");
                        $('#addSuppliersModal').modal('show');
                        DisableTableFields(true);
                        HideBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateSupplierDetails(data) {
                $('.supplier_id').val(data.id);
                $('.name').val(data.name);
                $('.tin').val(data.tin);
                $('.contact').val(data.phone_number);
                $('.address').val(data.address);
                $('.email').val(data.email);
                let debt = data.debt ?  FormatNumber(data.debt) : data.debt;
                let credit = data.credit ?  FormatNumber(data.credit) : data.credit;
                $('.debt').val(debt);
                $('.credit').val(credit);
            }


            $('.addSupplierBtn').click(function(e) {

                e.preventDefault();
                let isValidForm = validateForm();

                if (isValidForm) {
                    
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#SuppliersForm').serialize(),
                        url: "{{ route('suppliers.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#SuppliersForm').trigger("reset");
                            $('#addSuppliersModal').modal("hide");
                            $('.addSupplierBtn').html(
                                "<i class='fa fa-plus-circle pr-1'></i>Submit");

                            let resp = data.success || data.error;
                            let type = data.success ? 'success' : 'error';
                            displayResponse('.response', resp, type);

                            if (data.success) {
                                ResetTblInfo(data);
                                let tbl = $('#suppliers-table').DataTable();
                                tbl.ajax.reload();
                            }
                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addSupplierBtn').html('Save Changes');
                        }
                    });
                }

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-supplier', function(e) {
                let _id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_suppliers, function(supplier) {
                    $.get("{{ route('suppliers.index') }}" + '/' + _id + '', function(response) {
                        if (response.success) {
                            let data = response.data;
                            $("#deleteSuppliersModal").modal('show');
                            $(".delete-alert-text").html(
                                `Are you sure you want to delete supplier ${data.name}?`
                            );
                            $('.delete-ok-btn').on('click', function() {
                                deleteRecord(_id);
                            });
                        } else {
                            displayResponse(null, response.error, 'error');
                        }
                    });
                });
            });


            function deleteRecord(id) {
                let url = '{{ route('suppliers.destroy', ':id') }}';
                url = url.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function(response) {
                        let message = response.success || response.error;
                        let type = response.success ? 'success' : 'error';
                        if (response.success) {
                            let data = response.data;
                            $('.delete-ok-btn').html('Yes');
                            $('#deleteSuppliersModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#suppliers-table').DataTable();
                            tbl.ajax.reload();
                        }
                        displayResponse('.response', message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }


            function DisableTableFields(bool) {

                $('.supplier_id').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addSupplierBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addSupplierBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {

                let totl_number, sum_of_credits, sum_of_debts;
                totl_number = FormatNumber(response.totl_no);
                sum_of_credits = FormatNumber(response.totl_credit);
                sum_of_debts = FormatNumber(response.totl_debt);

                $('.total_suppliers').html(totl_number);
                $('.total_credit').html(sum_of_credits);
                $('.total_debt').html(sum_of_debts);
            }

            function validateForm() {

                let isValidForm = false;
                let name = $('.name').val();
                let tin = $('.tin').val();
                let contact = $('.contact').val();
                let address = $('.address').val();

                let errors = [];
                if (name.length < 1) {
                    displayResponse(null, "Please enter the name of the supplier", 'error');
                }
                else if (tin.length < 1) {
                    displayResponse(null, "Please enter the tin number of the supplier", 'error');
                }
                else if (contact.length < 1) {
                    displayResponse(null, "Please enter the phone number of the supplier", 'error');
                }
                else if (address.length < 1) {
                    displayResponse(null, "Please enter the address of the supplier", 'error');
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
                    title: 'Delete all suppliers',
                    content: 'Are you sure you want to remove all suppliers',
                    buttons: {
                        confirm: function() {
                            let self = this;
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
                                $(".total_suppliers").text(data.totl_no);
                                $(".total_credit").text(data.totl_credit);
                                $(".total_debt").text(data.totl_debt);
                                let tbl = $('#suppliers-table').DataTable();
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
