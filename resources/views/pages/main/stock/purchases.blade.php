@extends('layouts.template')

@section('content')
    <div class="card">
        <span class="response"></span>
        <div class="card-header row d-flex justify-content-between align-items-center">

            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Purchases</strong>
                    <span class="badge badge-info totl-no">
                        @isset($no_of_purchases)
                            {{ number_format($no_of_purchases) }}
                        @endisset
                    </span>
                </h6>
            </div>

            <div class="col">
                <h6 class="text-center">
                    Total cost::
                    <span class="text-success text-center">shs.
                        <strong class="purchase-value totl-purchases">
                            @isset($totl_cost_of_purchases)
                                {{ number_format($totl_cost_of_purchases) }}
                            @endisset
                        </strong>
                    </span>
                </h6>
            </div>

            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewpurchase"><i
                            class="fa fa-plus-circle pr-1"></i>Add purchase</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#importPurchases"><i class="fa fa-file-import pr-1"></i>Import file</button>
                </div>
            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm  table-bordered table-hover purchase-table" id="purchase-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Item Code</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>C.Price</th>
                            <th>T.Cost</th>
                            <!-- <th>BoughtOn</th> -->
                            <!-- <th>Supplier</th> -->
                            <!-- <th>RecordedBy</th>  -->
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>




    <!--Add new purchase -->
    <div class="modal fade nunito-font" id="addPurchaseModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="purchaseForm" id="purchaseForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">
                            Add new purchase item</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <span>Serial Number</span>
                            <input type="hidden" class="purchaseId" name="id">
                            <input type="text" class="form-control bg-white serial_no" name="serial_no"
                                placeholder="Enter serial number of the purchased item">
                        </div>

                        <div class="form-group">
                            <span>Receipt Number</span>
                            <input type="text" class="form-control bg-white receipt_no" name="receipt_no"
                                placeholder="Enter receipt number of the purchased item">
                        </div>

                        <div class="form-group">
                            <span>Item ID</span>
                            <input type="text" class="form-control bg-white item_code" name="item_code"
                                placeholder="Enter item ID">
                        </div>


                        <div class="form-group">
                            <span><span class="text-danger">*</span> Item</span>
                            <input type="text" class="form-control bg-white item-name" name="item"
                                placeholder="Enter item" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Quantity</span>
                            <input type="text" class="form-control bg-white quantity" id="qty" name="quantity"
                                placeholder="Enter Quantity" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Price per Item</span>
                            <input type="text" class="form-control bg-white cost_price" name="cost_price"
                                placeholder="Enter original cost price of each item" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Retail selling price</span>
                            <input type="text" class="form-control bg-white retail_price" name="retail_price"
                                placeholder="Enter retail price" Required autofocus>
                        </div>


                        <div class="form-group">
                            <span>Wholesale selling price</span>
                            <input type="text" class="form-control bg-white wholesale_price" name="wholesale_price"
                                placeholder="Enter wholesale price">
                        </div>


                        <div class="form-group">
                            <span>Supplier</span>
                            <input class="form-control bg-white supplier " id="supplier" name="supplier"
                                placeholder="Enter supplier's name">
                        </div>

                        <div class="form-group">
                            <span>Supplier's contact</span>
                            <input type="text" class="form-control bg-white supplier_contact" name="supplier_contact"
                                placeholder="Enter supplier's contact">
                        </div>

                        <div class="form-group">
                            <span>Date of purchase</span>
                            <input type="date" class="form-control bg-white date_of_purchase" name="date_of_purchase"
                                value="{{ date('Y-m-d') }}" placeholder="Enter date of purchase">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addPurchaseBtn" name="AddItemBtn">Save</button>
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

    <!--Import Purchases -->
    <div class="modal fade nunito-font" id="importPurchases" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ Route('purchases.import') }}" method="post" enctype="multipart/form-data"
                    name="inportPurchasesForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold">
                            Import an excel file of purchases</h6>
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
                            <button type="submit" class="btn btn-primary" name="AddItemBtn">Upload</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal Deletepurchase -->
    <div class="modal fade" id="deletepurchaseModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100 font-weight-bold">Delete Purchased Item</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger">Are you sure you want to delete purchase
                                <small class="text-dark text-muted bolded purchase-to-delete">
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
    </div>
    <!-- end of modal Deletepurchase-->


    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>


    <script type="text/javascript">

        const ajaxUrl = @json(route('get-purchases'));
        const deletedSeletectedUrl = @json(route('selected-purchases.remove'));
        const cat = 'purchases';
        const token = "{{ csrf_token() }}";

        const onSearchItemUrl = @json(route('item.search'));
        onSearchItem('.item-name');

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //code that displays results of the table index()
            let table = $('.purchase-table');
            let title = "List of purchased items in the system";
            let columns = [0, 1, 2, 3, 4, 5, 6, 7];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
                //  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'item',
                    name: 'item'
                },
                {
                    data: 'item_code',
                    name: 'item_code'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'cost_price_per_item',
                    name: 'cost_price_per_item'
                },
                {
                    data: 'total_cost_price',
                    name: 'total_cost_price'
                },
                // {data: 'date_of_purchase', name:'date_of_purchase'},
                //  {data: 'supplier', name:'supplier'},
                //  {data: 'created_by', name:'created_by'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            onClickSubmitBtn();

            $('#createNewpurchase').click(function(e) {
                e.preventDefault();
                NullifyFields();
                ShowHideBtns('show');
                $('.addPurchaseBtn').text("Record purchase");
                $('#purchaseForm').trigger("reset");
                $('#modalHeading').html("Record new purchase");
                DisableFormFields(false);
                $('#addPurchaseModal').modal('show');

            });


            Numberize(".cost_price");
            Numberize(".retail_price");
            Numberize(".wholesale_price");

            //modal used to edit purchase details [each row of the tbl]
            $('body').on('click', '#edit-purchase', function(event) {
                let purchase_id = $(this).data('id');
                event.preventDefault();
                HideContentOnEditing('hide');

                ShowHideBtns('show');
                $('.addPurchaseBtn').text("Edit purchase");
                $('#addPurchaseModal').modal('show');
                let Url = "{{ route('purchases.show', ':id') }}";
                Url = Url.replace(':id', purchase_id);
                $.ajax({

                    url: Url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {

                        $('#modalHeading').html("Edit details of purchase item " + data.item +
                            "");
                        $('.purchaseId').val(purchase_id);
                        $('.serial_no').val(data.serial_no);
                        $('.receipt_no').val(data.receipt_no);
                        $('.item_code').val(data.item_code);
                        $('.item-name').val(data.item);
                        $('.quantity').val(data.quantity);
                        $('.cost_price').val(data.cost_price_per_item);
                        $('.retail_price').val(data.retail_price);
                        $('.wholesale_price').val(data.wholesale_price);
                        $('.supplier').val(data.supplier);
                        $('.supplier_contact').val(data.supplier_contact);
                        $('.date_of_purchase').val(data.date_of_purchase);
                        $('.item-name').css('pointer-events', 'none');
                        DisableFormFields(true);
                        DisableFormFields(false);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                    }
                });

            });

            function UpdatePurchase(purchase_id) {

                $('.errors-section').html('');
                $('.addPurchaseBtn').html('Updating item...');

                let Url = "{{ route('purchases.update', ':id') }}";
                Url = Url.replace(':id', purchase_id);
                $.ajax({
                    data: $('#purchaseForm').serialize(),
                    url: Url,
                    type: "PUT",
                    dataType: 'json',
                    success: function(data) {

                        $('#purchaseForm').trigger("reset");
                        $('#addPurchaseModal').modal("hide");
                        let resp = data.success;
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('.purchase-table').DataTable();
                        tbl.ajax.reload();

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addPurchaseBtn').html('Save Changes');
                    }
                });


            }

            function submitPurchase() {

                $('.errors-section').html('');
                $('.addPurchaseBtn').html('Sending data..');

                $.ajax({
                    data: $('#purchaseForm').serialize(),
                    url: "{{ route('purchases.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#purchaseForm').trigger("reset");
                        $('#addPurchaseModal').modal("hide");

                        let resp = data.success || data.error;
                        let type = data.success ? 'success' : 'error';

                        if (data.success) {
                            ResetTblInfo(data);
                            let tbl = $('.purchase-table').DataTable();
                            tbl.ajax.reload();
                        }

                        displayResponse('.response', resp, type);

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addPurchaseBtn').html('Save Changes');
                    }
                });

            }


            //View Modal used to view each row [purchase details]
            $('body').on('click', '#view-purchase', function(event) {
                let purchase_id = $(this).data('id');
                event.preventDefault();
                HideContentOnEditing('show');
                let showUrl = '{{ route('purchases.show', ':id') }}';
                showUrl = showUrl.replace(":id", purchase_id);
                ShowHideBtns('hide');
                $.ajax({
                    url: showUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let qty = FormatNumber(data.quantity);
                        let cprice = FormatNumber(data.cost_price_per_item);
                        let sprice = data.selling_price;
                        $('#modalHeading').html("Details of purchase item " + data.item + "");
                        $('#addPurchaseModal').modal('show');
                        $('.purchaseId').val(purchase_id);
                        $('.serial_no').val(data.serial_no);
                        $('.receipt_no').val(data.receipt_no);
                        $('.item_code').val(data.item_code);
                        $('.item-name').val(data.item);
                        $('.quantity').val(data.quantity);
                        $('.cost_price').val(data.cost_price_per_item);
                        $('.retail_price').val(data.retail_price);
                        $('.wholesale_price').val(data.wholesale_price);
                        $('.supplier').val(data.supplier);
                        $('.supplier_contact').val(data.supplier_contact);
                        $('.date_of_purchase').val(data.date_of_purchase);
                        DisableFormFields(true);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });

            });

            function FormatDate(givenDate) {
                let result = moment(givenDate).format('dd-MM-yyyy');
                return result;
            }


            function onClickSubmitBtn() {
                $('.addPurchaseBtn').click(function(e) {
                    let id = $(".purchaseId").val();
                    e.preventDefault();
                    let Errors = validateForm();
                    if (Errors.length == 0) {
                        if (id) {
                            UpdatePurchase(id);

                        } else {
                            submitPurchase();
                        }

                    } else {
                        let i;
                        let message = "";
                        for (i = 0; i < Errors.length; i++) {
                            message += Errors[i] + "<br>";
                        }
                        //displayResponse('.errors-section', resp, 'error');
                        $('.errors-section').html(message);

                    }

                });
            }




            //this pops up confirm delete modal
            $('body').on('click', '#delete-purchase', function(e) {
                let purchase_id = $(this).data("id");
                $("#deletepurchaseModal").modal('show');
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(purchase_id);
                });

            });


            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('purchases.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        let resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deletepurchaseModal').modal("hide");
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('.purchase-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function NullifyFields() {

                $('.item_code').val('');
                $('.item-name').val('');
                $('.quantity').val('');
                $('.cost_price').val('');
                $('.total_cost').val('');
                $('#supplier').val('');
                $('.record_date').val('');
            }



            function DisableFormFields(bool) {

                $('.purchaseId').attr('disabled', bool);
                $('.item_code').attr('disabled', bool);
                $('.item-name').attr('disabled', bool);
                $('.quantity').attr('disabled', bool);
                $('.cost_price').attr('disabled', bool);
                $('.total_cost').attr('disabled', bool);
                $('#supplier').attr('disabled', bool);
                $('.record_date').attr('disabled', bool);
            }

            function HideContentOnEditing(action) {
                if (action == 'hide') {
                    $('.TcostDiv').hide();
                    $('.recordedByDiv').hide();
                } else if (action == 'show') {
                    $('.TcostDiv').show();
                    $('.recordedByDiv').show();
                }

            }

            function ShowHideBtns(action) {

                if (action == 'hide') {
                    $('.addPurchaseBtn').hide();
                    $('.clearBtn').hide();
                    $('.closeBtn').hide();
                } else if (action == 'show') {
                    $('.addPurchaseBtn').show();
                    $('.clearBtn').show();
                    $('.closeBtn').show();
                }
            }


            function ResetTblInfo(response) {
                let totl_no = FormatNumber(response.totl_no);
                let totl_purchases = FormatNumber(response.totl_purchases);
                $('.totl-no').html(totl_no);
                $('.totl-purchases').html(totl_purchases);

            }

            function validateForm() {
                let item = $('.item-name').val();
                let qty = $('.quantity').val();
                let bprice = $('.cost_price').val();
                let rprice = $('.retail_price').val();

                let errors = [];
                if (item.length < 1) {
                    let itemNameErr = "Please enter the name of purchased item";
                    errors.push(itemNameErr);
                }
                if (qty.length < 1) {
                    let qtyErr = "Please enter valid quantity of purchase";
                    errors.push(qtyErr);
                }
                if (bprice == "") {
                    let bPriceErr = "Please enter valid cost price of the purchase";
                    errors.push(bPriceErr);
                }
                if (rprice == "") {
                    let bPriceErr = "Please enter valid retail price of the purchase";
                    errors.push(bPriceErr);
                }
                return errors;

            }


            $("#removeAllPurchases").bind("click", function() {
                RemoveAllPurchases();
            });

            function RemoveAllPurchases() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all purchases',
                    content: 'Are you sure you want to remove all purchases',
                    buttons: {
                        confirm: function() {
                            let self = this;
                            return $.ajax({
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                url: '{{ Route('purchases.truncate') }}',
                                type: 'POST',
                                // dataType: 'json',
                            }).done(function(data) {

                                $.alert({
                                    title: 'Message',
                                    content: data.success,
                                });
                                $(".totl-no").text(data.totl_no);
                                $(".totl-purchases").text(data.totl_purchases);
                                let tbl = $('.purchase-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "Purchases not deleted:" + data.fail,
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
