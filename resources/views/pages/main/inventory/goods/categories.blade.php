@extends('layouts.template')

@section('content')
    <span class="response"></span>
    <div class="card">

        <div class="card-header row d-flex justify-content-between align-items-center">

            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Commodity Categories</strong>
                    <span class="badge badge-info totl-stock">
                        @isset($number_of_categories)
                            {{ number_format($number_of_categories) }}
                        @endisset
                    </span>
                </h6>
            </div>

         
            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewStock"><i
                            class="fa fa-plus-circle pr-1"></i>Add good</button>
                </div>
            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="commodity-category-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Commodity Name</th>
                            <th>Commodity Code</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <!--Add new Stock -->
            <div class="modal fade nunito-font" id="addStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
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

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Product Name</span>
                                        <input type="text" class="form-control  item_name" name="item"
                                            placeholder="Enter product name">
                                    </div>

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Product Code</span>
                                        <input type="hidden" class="stockId" name="id">
                                        <input type="text" class="form-control  item_code" name="item_code"
                                            placeholder="Enter product code">
                                    </div>

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Product Type Code</span>
                                        <select name="goods_type_code" class="form-control goods_type_code">
                                            @foreach (config('goods-type-codes') as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}: {{ ucfirst($key) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
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
                                        <span><span class="text-danger pr-1">*</span>Quantity</span>
                                        <input type="text" class="form-control  quantity" id="qty"
                                            name="quantity" placeholder="Enter Quantity">
                                    </div>

                                    <div class="col-md-4">
                                        <span>Threshold Quantity</span>
                                        <input type="text" class="form-control threshold_qty" id="threshold_qty"
                                            name="threshold_qty" placeholder="Enter threshold quantity">
                                    </div>

                                    <div class="col-md-4">
                                        <span>Expiry Date</span>
                                        <input type="date" class="form-control  expiry_date" name="expiry_date"
                                            placeholder="Enter who bought it">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span><span class="text-danger pr-1">*</span>Buying Price</span>
                                            <input type="text" class="form-control  original_price"
                                                name="original_price" placeholder="Enter original price" required
                                                autofocus>
                                        </div>

                                        <div class="col-lg-6">
                                            <span><span class="text-danger pr-1">*</span>Unit Price</span>
                                            <input type="text" class="form-control  selling_price"
                                                name="selling_price" placeholder="Enter selling price">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <span>Remarks</span>
                                        <textarea class="form-control remarks" name="remarks">add stock</textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary addStockBtn"
                                        name="AddItemBtn"><i></i>Save</button>
                                    <button type="reset" class="btn btn-sm btn-danger clearBtn">Clear</button>
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
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of modal DeleteStock-->
        </div>
    </div>

    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
    <script>
        const ajaxUrl = @json(route('commodities.category.ajax.fetch'));
        const cat = 'commodities.category';
        const token = "{{ csrf_token() }}";
    </script>

    <script>
        let table = $('#commodity-category-table');
        let title = "List of commodity categories in the system";
        let columns = [1, 2, 3, 4, 5];
        let dataColumns = [{
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
                data: 'code',
                name: 'code'
            },
            {
                data: 'created_by',
                name: 'created_by'
            }

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

            $.fn.dataTable.ext.errMode = 'none';
            $('#commodity-category-table').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            }).DataTable();

            onClickSubmitBtn();

            $('#createNewStock').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_stock, function(stock) {
                    NullifyFields();
                    ShowHideBtns('show');
                    $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('#StockForm').trigger("reset");
                    $('#modalHeading').html("Record new stock");
                    DisableFormFields(false);
                    $('#addStockModal').modal('show');
                });
            });

            //modal used to edit stock details [each row of the tbl]
            $('body').on('click', '#edit-stock', function(event) {
                let stock_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_stock, function(stock) {
                    editStock(stock_id);
                });
            });

            function editStock(stock_id) {
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
                            $('#modalHeading').html("Edit details of stock item " + data.item_name +
                                "");
                            populateProductDetails(data);
                            DisableFormFields(false);
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

                $('.errors-section').html('');
                $('.addStockBtn').html('Updating item...');
                let Url = "{{ route('stock.update', ':id') }}";
                Url = Url.replace(':id', stock_id);

                $.ajax({
                    data: $('#StockForm').serialize(),
                    url: Url,
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
                            let tbl = $('#commodity-category-table').DataTable();
                            tbl.ajax.reload();
                        }

                        displayResponse(null, message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addStockBtn').html('Save Changes');
                    }
                });

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
                            let tbl = $('#commodity-category-table').DataTable();
                            tbl.ajax.reload();
                        } else {
                            $('.addStockBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                        }

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
                        DisableFormFields(true);
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateProductDetails(data) {
                $('.stockId').val(data.id);
                $('.item_code').val(data.item_code);
                $('.goods_type_code').val(data.goods_type_code);
                $('.stockin_type_code').val(data.stockin_type_code);
                $('.item_name').val(data.item_name);
                $('.category').val(data.category_id);
                $('#supplier').val(data.supplier_id);
                $('.supplier_tin').val(data.supplier_tin);
                $('.quantity').val(data.quantity);
                $('.threshold_qty').val(data.threshold_qty)
                $('.expiry_date').val(data.expiry_date);
                $('.original_price').val(FormatNumber(data.buying_price));
                $('.selling_price').val(FormatNumber(data.selling_price));
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
                            if (confirm(`Are you sure you want to add this as stock`)) {
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
                            let tbl = $('#commodity-category-table').DataTable();
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

            function NullifyFields() {
                $('.stockId').val('');
                $('.item_code').val('');
                $('.item_name').val('');
                $('.category').val('');
                $('#supplier').val('');
                $('.quantity').val('');
                $('.expiry_date').val('');
                $('.original_price').val('');
                $('.selling_price').val('');
                $('.supplier_tin').val();
            }



            function DisableFormFields(bool) {

                $('.stockId').attr('disabled', bool);
                $('.item_code').attr('disabled', bool);
                $('.item_name').attr('disabled', bool);
                $('.category').attr('disabled', bool);
                $('#supplier').attr('disabled', bool);
                $('.quantity').attr('disabled', bool);
                $('.expiry_date').attr('disabled', bool);
                $('.original_price').attr('disabled', bool);
                $('.selling_price').attr('disabled', bool);
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
                    isValidForm = true;
                }

                return isValidForm;
            }

        });
    </script>
@endsection
