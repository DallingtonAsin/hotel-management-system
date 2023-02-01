@extends('layouts.master')

@section('content')
    <span class="response"></span>
    <div class="card">

        <div class="card-header row d-flex justify-content-between align-items-center">

            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Inventory</strong>
                    <span class="badge badge-info totl-stock">
                        @isset($number_of_stockItems)
                            {{ number_format($number_of_stockItems) }}
                        @endisset
                    </span>
                </h6>
            </div>

            <div class="col">
                <h6 class="text-center">
                    Current stock value:
                    <span class="text-success text-center">shs.
                        <strong class="stock-value">
                            @isset($stock_value)
                                {{ number_format($stock_value) }}
                            @endisset
                        </strong>
                    </span>
                </h6>
            </div>

            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill mx-2" id="createNewStock"><i
                            class="fa fa-plus-circle pr-1"></i>Add stock</button>
                    {{-- <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#importStock"><i class="fa fa-file-import pr-1"></i>Import file</button> --}}
                </div>
            </div>
        </div>


        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="stock-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Good T.Code</th>
                            <th>Good Type</th>
                            <th>Qty</th>
                            <th>B. Price</th>
                            <th>Unit Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <!--Add new Stock -->
            <div class="modal fade nunito-font" id="addStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog mx-auto modal-dialog-xlg">
                    <div class="modal-content">

                        <form name="StockForm" id="StockForm">
                            @csrf
                            <div class="modal-header d-flex justify-content-between">
                                <h6 class="modal-title w-100 font-weight-bold" id="modalHeading"> Add new stock item</h6>
                                <button type="button" class="close mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Product Name</span>
                                        <input type="text" class="form-control  item_name" name="item" placeholder="Enter product name">
                                    </div>

                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Product Code</span>
                                        <input type="hidden" class="stockId" name="id">
                                        <input type="text" class="form-control item_code" name="item_code"
                                            placeholder="Enter product code" readonly>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Product Type Code</span>
                                        <select name="goods_type_code" class="form-control goods_type_code">
                                            @foreach (config('goods-type-codes') as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}: {{ ucfirst($key) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span> Stockin Type</span>
                                        <select class="form-control stockin_type_code" name="stockin_type_code"
                                            id="stockin_type_code">
                                            @foreach (config('stockin-types') as $key => $value)
                                                <option value="{{ $value }}"
                                                    {{ str_contains($key, 'local') ? 'selected' : '' }}>{{ $value }}:
                                                    {{ ucwords(str_replace('_', ' ', str_replace('&', '/ ', $key))) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Supplier</span>
                                        <select class="form-control supplier" id="supplier" name="supplier">
                                            <option value="" selected="true">Select supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"> {{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Supplier Tin Number</span>
                                        <input type="text" class="form-control supplier_tin" name="supplier_tin"
                                            placeholder="Enter supplier tin" readonly>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class=" col-md-4">
                                        <span><span class="text-danger pr-1">*</span><span
                                                class="quantity_text">Quantity</span></span>
                                        <input type="text" class="form-control  quantity" id="qty"
                                            name="quantity" placeholder="Enter Quantity">
                                    </div>

                                    <div class="col-md-4 show-on-edit">
                                        <span>Threshold Quantity</span>
                                        <input type="text" class="form-control threshold_qty" id="threshold_qty"
                                            name="threshold_qty" placeholder="Enter threshold quantity">
                                    </div>

                                    <div class="col-md-4 show-on-edit">
                                        <span>Expiry Date</span>
                                        <input type="date" class="form-control  expiry_date" name="expiry_date"
                                            placeholder="Enter who bought it">
                                    </div>

                                    <div class="col-md-8 adjust-type-div">
                                        <span><span class="text-danger pr-1">*</span>AdjustType</span>
                                        <select class="form-control adjust_type" name="adjust_type" id="adjust_type">
                                            <option value="">Select Adjust Type</option>
                                            @foreach (config('stock-adjust-types') as $key => $type)
                                                <option value="{{ $value }}">
                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span><span class="text-danger pr-1">*</span>Buying Price</span>
                                            <input type="text" class="form-control  original_price"
                                                name="original_price" placeholder="Enter original price">
                                        </div>

                                        <div class="col-lg-6">
                                            <span><span class="text-danger pr-1">*</span>Unit Price</span>
                                            <input type="text" class="form-control selling_price" name="selling_price"
                                                placeholder="Enter selling price" readonly>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <span>Remarks</span>
                                        <textarea class="form-control remarks" name="remarks">add stock</textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <input type="hidden" class="form-control edit_stock_action"
                                        name="edit_stock_action">
                                    <button type="submit" class="btn btn-primary btn-sm outline-none rounded-pill addStockBtn"
                                        name="AddItemBtn"><i></i>Save</button>
                                    <button type="reset" class="btn btn-sm btn-danger rounded-pill clearBtn">Clear</button>
                                </div>

                                <div class="form-group">
                                    <span class="errors-section text-danger nunito-font"></span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Import Stock -->
            <div class="modal fade nunito-font" id="importStock" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <form action="{{ Route('stock.import') }}" method="post" enctype="multipart/form-data"
                            name="inportStockForm">
                            @csrf

                            <div class="modal-header text-center">
                                <h6 class="modal-title w-100 font-weight-bold">
                                    Import an excel file of stock items</h6>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="form-group">
                                    <span>Select file for Upload</span>
                                </div>

                                <div class="form-group">
                                    <input type="file"
                                        class="form-control-file @error('select_file') is-invalid @enderror"
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
                                    <button type="submit" class="btn btn-primary" name="AddItemBtn">Upload</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Modal DeleteStock -->
            <div class="modal fade" id="deleteStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
                aria-labelledby="ModalLabel">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h6 class="modal-title w-100 font-weight-bold">Delete Item</h6>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <div class="text-center">
                                    <label class="text-danger delete-confirm-text">Are you sure you want to delete
                                        item?</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary delete-ok-btn"
                                    name="ConfirmBtn">Yes</button>
                                <button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of modal DeleteStock-->
        </div>
    </div>

    <script>
        const ajaxUrl = @json(route('get-stock'));
        const deletedSeletectedUrl = @json(route('selected-stock.remove'));
        const cat = 'stock';
        const token = "{{ csrf_token() }}";
        const stock_actions = {
            increase: 0,
            decrease: 1,
            edit: 2,
            view: 3
        }
    </script>

    <script>
        //code that displays results of the table index()
        let table = $('#stock-table');
        let title = "List of stock items in the system";
        let columns = [1, 2, 3, 4, 5];
        let dataColumns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'item_name',
                name: 'item_name'
            },
            {
                data: 'item_code',
                name: 'item_code'
            },
            {
                data: 'goods_type_code',
                name: 'goods_type_code'
            },
            {
                data: 'goods_type',
                name: 'goods_type'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },

            {
                data: 'buying_price',
                name: 'buying_price'
            },
            {
                data: 'selling_price',
                name: 'selling_price'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
        makeDataTable(table, title, columns, dataColumns);
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            Numberize(".quantity");
            Numberize(".threshold_qty");
            Numberize(".original_price");
            Numberize(".selling_price");

            let searchGoodsUrl = '{{ route('goods.search.ajax') }}';
            onTyping('.item_name', searchGoodsUrl, afterSelectingProduct);

            function afterSelectingProduct(product_name) {
                populateGoodDetails(product_name);
            }

            function populateGoodDetails(product_name) {
                console.log("Details loading... for item", product_name);

                let url = "{{ route('good.find.ajax', ':product_name') }}"
                url = url.replace(':product_name', product_name);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            if (data.goods_code) {
                                $('.item_code').val(data.goods_code);
                            }
                            if (data.unit_price) {
                                $('.selling_price').val(FormatNumber(data.unit_price));
                            }
                        } else {
                            displayResponse(null, response.error, 'error');
                        }
                    },
                    error: function(data) {
                        console.log('Error on fetching product details', data);
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            onSelectSupplier();

            function onSelectSupplier() {
                $('.supplier').on('change', function() {
                    let supplier_id = $(this).find(":selected").val();
                    if (supplier_id) {
                        populateSupplierTin(supplier_id);
                    }
                });
            }

            function populateSupplierTin(supplier_id) {

                let url = '{{ route('supplier.details.ajax.fetch', ':supplier_id') }}';
                url = url.replace(':supplier_id', supplier_id);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('.supplier_tin').val(data.tin);
                        } else {
                            displayResponse(null, response.error, 'error');
                        }
                    },
                    error: function(data) {
                        console.log('Error on fetching supplier details', data);
                        displayResponse(null, data.error, 'error');
                    }
                });
            }


            onClickSubmitBtn();

            $('#createNewStock').click(function(e) {
                $('.edit_stock_action').val('');
                $('.show-on-edit').show();
                $('.adjust-type-div').hide();
                $('.quantity_text').text('Quantity');
                e.preventDefault();
                checkPermission(permissions.add_stock, function(stock) {
                    nullifyFields();
                    ShowHideBtns('show');
                    $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('#StockForm').trigger("reset");
                    $('#modalHeading').html("Record new stock");
                    disableFormFields(false);
                    $('#addStockModal').modal('show');
                });
            });



            function disableFieldsOnChangingQuantity() {
                $('.stockId').attr('readonly', true);
                $('.item_code').attr('readonly', true);
                $('.item_name').attr('readonly', true);
                $('.category').attr('readonly', true);
                $('.goods_type_code').attr('readonly', true);
                $('.stockin_type_code').attr('readonly', true);
                $('.threshold_qty').attr('readonly', true);
                $('#supplier').attr('readonly', true);
                $('.quantity').attr('readonly', false);
                $('.expiry_date').attr('readonly', true);
                $('.original_price').attr('readonly', true);
                $('.selling_price').attr('readonly', true);
            }

            $('body').on('click', '#increase-stock', function(event) {
                let stock_id = $(this).data('id');
                $('.edit_stock_action').val(stock_actions.increase);
                $('.show-on-edit').show();
                $('.adjust-type-div').hide();

                event.preventDefault();
                checkPermission(permissions.view_stock, function(stock) {
                    editStock(stock_id, disableFieldsOnChangingQuantity,
                        "Increase stock for stock item");
                    $('.quantity_text').text('New Quantity');
                    $('.remarks').text('increase stock');

                });
            });

            $('body').on('click', '#decrease-stock', function(event) {
                let stock_id = $(this).data('id');
                $('.edit_stock_action').val(stock_actions.decrease);
                $('.show-on-edit').hide();
                $('.adjust-type-div').show();

                event.preventDefault();
                checkPermission(permissions.view_stock, function(stock) {
                    editStock(stock_id, disableFieldsOnChangingQuantity,
                        "Decrease stock for stock item");
                    $('.quantity_text').text('Decrease quantity by');
                    $('.remarks').text('decrease stock');

                });
            });


            //modal used to edit stock details [each row of the tbl]
            $('body').on('click', '#edit-stock', function(event) {
                let stock_id = $(this).data('id');
                $('.edit_stock_action').val(stock_actions.edit);
                $('.show-on-edit').show();
                $('.adjust-type-div').hide();
                event.preventDefault();
                checkPermission(permissions.edit_stock, function(stock) {
                    editStock(stock_id, disableFormFields(false), "Edit details of stock item");
                });
            });

            function editStock(stock_id, disableFormFields, modal_title) {
                ShowHideBtns('show');
                $('.addStockBtn').text("Update stock");
                $('#addStockModal').modal('show');
                let Url = "{{ route('stock.show', ':id') }}";
                Url = Url.replace(':id', stock_id);
                $.ajax({

                    url: Url,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('#modalHeading').html(modal_title + ' ' + data.item_name);
                            populateProductDetails(data);
                            disableFormFields();
                        } else {
                            $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                            displayResponse(null, response.error, 'error');
                        }

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                        displayResponse(null, data.error, 'error');
                    }
                });
            }

            function UpdateStock(stock_id) {

                let url = "",
                    message = "";
                let action = $('.edit_stock_action').val();
                let item_name = $('.item_name').val();
                let quantity = $('.quantity').val();

                if (action == stock_actions.increase) {
                    url = "{{ route('stock.increase', ':id') }}";
                    url = url.replace(':id', stock_id);
                    message = "Are you sure you want to increase stock item " + item_name + " by " + quantity;
                } else if (action == stock_actions.decrease) {
                    url = "{{ route('stock.decrease', ':id') }}";
                    url = url.replace(':id', stock_id);
                    message = "Are you sure you want to reduce stock item " + item_name + " by " + quantity;
                } else if (action == stock_actions.edit) {
                    url = "{{ route('stock.update', ':id') }}";
                    url = url.replace(':id', stock_id);
                    message = "Are you sure you want to update stock item";
                }


                if (confirm(message)) {

                    $('.errors-section').html('');
                    $('.addStockBtn').html('Updating item...');

                    $.ajax({
                        data: $('#StockForm').serialize(),
                        url: url,
                        type: "PUT",
                        dataType: 'json',
                        success: function(response) {
                            let message = response.success || response.error;
                            let type = response.success ? 'success' : 'error';

                            if (response.success) {
                                let data = response.data;
                                $('#StockForm').trigger("reset");
                                $('#addStockModal').modal("hide");
                                ResetTblInfo(data);
                                let tbl = $('#stock-table').DataTable();
                                tbl.ajax.reload();
                                $('.edit_stock_action').val('');
                            }

                            displayResponse(null, message, type);
                            $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addStockBtn').html('Save Changes');
                        }
                    });
                }

            }

            function recordStock() {
                $('.errors-section').html('');
                $('.addStockBtn').html('Sending data..');
                $.ajax({
                    data: $('#StockForm').serialize(),
                    url: "{{ route('stock.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {

                        let resp = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if (response.success) {
                            let data = response.data;
                            $('#StockForm').trigger("reset");
                            $('#addStockModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#stock-table').DataTable();
                            tbl.ajax.reload();
                        }

                        $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                        displayResponse('.response', resp, type);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    }
                });

            }


            //View Modal used to view each row [stock details]
            $('body').on('click', '#view-stock', function(event) {
                let stock_id = $(this).data('id');
                $('.edit_stock_action').val(stock_actions.view);
                $('.show-on-edit').show();
                $('.adjust-type-div').hide();
                event.preventDefault();
                checkPermission(permissions.view_stock, function(stock) {
                    viewStock(stock_id);
                });
            });

            function viewStock(stock_id) {
                ShowHideBtns('hide');
                $.get("{{ route('stock.index') }}" + '/' + stock_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of stock " + data.item_name + "");
                        $('#addStockModal').modal('show');
                        populateProductDetails(data);
                        disableFormFields(true);
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateProductDetails(data) {
                $('.stockId').val(data.id);
                $('.item_name').val(data.item_name);
                $('.item_code').val(data.item_code);
                $('.goods_type_code').val(data.goods_type_code);
                $('.stockin_type_code').val(data.stockin_type_code);
                $('.category').val(data.category_id);
                $('#supplier').val(data.supplier_id);
                $('.supplier_tin').val(data.supplier_tin);
                $('.threshold_qty').val(data.threshold_qty);
                $('.expiry_date').val(data.expiry_date);
                $('.original_price').val(FormatNumber(data.buying_price));
                $('.selling_price').val(FormatNumber(data.selling_price));

                let action = $('.edit_stock_action').val();
                if (action == stock_actions.edit || action == stock_actions.view) {
                    $('.quantity').val(data.quantity);
                }
            }


            function onClickSubmitBtn() {
                $('.addStockBtn').click(function(e) {
                    let id = $(".stockId").val();
                    e.preventDefault();
                    let isValidForm = validateForm();
                    if (isValidForm) {
                        if (id) {
                            UpdateStock(id);
                        } else {
                            if (confirm(`Are you sure you want to add this as stock?`)) {
                                recordStock();
                            }
                        }
                    }
                });
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-stock', function(e) {
                let stock_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_stock, function(stock) {
                    $.get("{{ route('stock.index') }}" + '/' + stock_id + '', function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('.delete-confirm-text').html(
                                `Are you sure you want to delete item ${data.item_name}?`
                            );
                            $("#deleteStockModal").modal('show');
                            $('.delete-ok-btn').on('click', function() {
                                deleteRecord(stock_id);
                            });
                        } else {
                            displayResponse(null, response.error, 'error');
                        }
                    });
                });
            });


            function deleteRecord(id) {
                let deleteUrl = '{{ route('stock.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(response) {

                        let message = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if (response.success) {
                            let data = response.data;
                            $('.delete-ok-btn').html('Yes');
                            $('#deleteStockModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#stock-table').DataTable();
                            tbl.ajax.reload();
                        }
                        displayResponse(null, message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function nullifyFields() {
                $('.stockId').val('');
                $('.item_code').val('');
                $('.item_name').val('');
                $('.category').val('');
                $('#supplier').val('');
                $('.quantity').val('');
                $('.expiry_date').val('');
                $('.original_price').val('');
                $('.selling_price').val('');
                $('.supplier_tin').val('');
                $('.remarks').val('')
            }


            function disableFormFields(bool) {

                $('.stockId').attr('readonly', bool);
                $('.item_name').attr('readonly', bool);
                $('.category').attr('readonly', bool);
                $('.stockin_type_code').attr('readonly', bool);
                $('.goods_type_code').attr('readonly', bool);
                $('#supplier').attr('readonly', bool);
                $('.original_price').attr('readonly', bool);
                $('.remarks').attr('readonly', bool);
                let stock_action = $('.edit_stock_action').val();
                if (stock_action == stock_actions.edit) {
                    $('.quantity').attr('readonly', true);
                    $('.threshold_qty').attr('readonly', false);
                    $('.expiry_date').attr('readonly', false);
                } else if(stock_action == stock_actions.view){
                    $('.quantity').attr('readonly', true);
                    $('.threshold_qty').attr('readonly', true);
                    $('.expiry_date').attr('readonly', true);
                } else {
                    $('.quantity').attr('readonly', bool);
                    $('.threshold_qty').attr('readonly', bool);
                    $('.expiry_date').attr('readonly', bool);
                }
            }

            function ShowHideBtns(action) {

                if (action == 'hide') {
                    $('.addStockBtn').hide();
                    $('.clearBtn').hide();
                    $('.closeBtn').hide();
                } else if (action == 'show') {
                    $('.addStockBtn').show();
                    $('.clearBtn').show();
                    $('.closeBtn').show();
                }
            }


            function ResetTblInfo(response) {
                let totl_stock, stockValue;
                totl_stock = FormatNumber(response.totl);
                stockValue = FormatNumber(response.value);
                $('.totl-stock').html(totl_stock);
                $('.stock-value').html(stockValue);
            }

            function validateForm() {

                let item = $('.item_name').val();
                let item_code = $('.item_code').val();
                let goods_type_code = $('.goods_type_code').val();
                let stockin_type_code = $('.stockin_type_code').val();
                let supplier = $('.supplier').val();
                let supplier_tin = $('.supplier_tin').val();
                let qty = $('#qty').val();
                let bprice = $('.original_price').val();
                let sprice = $('.selling_price').val();
                let stock_action = $('.edit_stock_action').val();

                let isValidForm = false;

                if (item.length < 1) {
                    displayResponse(null, `Please enter product name`, `error`);
                } else if (item_code.length < 1) {
                    displayResponse(null, `Please enter product code`, `error`);
                } else if (goods_type_code.length < 1) {
                    displayResponse(null, `Please select goods type`, `error`);
                } else if (stockin_type_code.length < 1) {
                    displayResponse(null, `Please select stock in type`, `error`);
                } else if (supplier.length < 1) {
                    displayResponse(null, `Please select supplier`, `error`);
                } else if (supplier_tin.length < 1) {
                    displayResponse(null, `Please ensure supplier tin is not empty`, `error`);
                } else if (qty.length < 1) {
                    displayResponse(null, `Please enter valid quantity of stock`, `error`);
                } else if (bprice == "") {
                    displayResponse(null, `Please enter valid buying price`, `error`);
                } else if (sprice == "") {
                    displayResponse(null, `Please enter valid unit price`, `error`);
                } else {
                    if (stock_action == stock_actions.decrease) {
                        let adjust_type = $('.adjust_type').val();
                        if (adjust_type.length < 1) {
                            displayResponse(null, `Please select adjust type`, `error`);
                        } else {
                            isValidForm = true;
                        }
                    } else {
                        isValidForm = true;
                    }
                }

                return isValidForm;
            }

            $("#removeAllStockItems").bind("click", function() {
                RemoveAllStockItems();
            });

            function RemoveAllStockItems() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all stock',
                    content: 'Are you sure you want to remove all stock items',
                    buttons: {
                        confirm: function() {
                            let self = this;
                            return $.ajax({
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                url: '{{ Route('stock.truncate') }}',
                                type: 'POST',
                                // dataType: 'json',
                            }).done(function(data) {

                                $.alert({
                                    title: 'Message',
                                    content: data.success,
                                });
                                $(".totl-stock").text(data.totl_stock);
                                $(".stock-value").text(data.stock_value);
                                let tbl = $('#stock-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "Stock not deleted:" + data.fail,
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
