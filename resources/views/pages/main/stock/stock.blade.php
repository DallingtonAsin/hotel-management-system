@extends('layouts.template')

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
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewStock"><i
                            class="fa fa-plus-circle pr-1"></i>Add stock</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#importStock"><i class="fa fa-file-import pr-1"></i>Import file</button>
                </div>
            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="stock-table">
                    <thead>
                        <tr>
                            @can('isAdmin')
                                <th></th>
                            @endcan
                            @can('isCashier')
                                <th>No</th>
                            @endcan
                            <th>Item</th>
                            <th>Item Code</th>
                            <th>Qty</th>
                            @can('isAdmin')
                                <th>Buying Price</th>
                            @endcan
                            <th>Retail Price</th>
                            <th>Wholesale Price</th>
                            <th>Action</th>
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


                                <div class="form-group">
                                    <span><span class="text-danger pr-1">*</span>Item</span>
                                    <input type="text" class="form-control  item-name" name="item"
                                        placeholder="Enter item" required autofocus>

                                </div>

                                <div class="form-group">
                                    <span>Item ID</span>
                                    <input type="hidden" class="stockId" name="id">
                                    <input type="text" class="form-control  item_code" name="item_code"
                                        placeholder="Enter item id or barcode">
                                </div>

                                <div class="form-group">
                                    <span>Category</span>
                                    <select class="form-control  category" name="category" required autofocus
                                        id="category">
                                        <option value="" selected="true">choose category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->name }}"> {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <span>Supplier</span>
                                    <select class="form-control " id="supplier" name="supplier" required autofocus>
                                        <option value="" selected="true">choose supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->name }}"> {{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <span>Expiry Date</span>
                                    <input type="date" class="form-control  expiry_date" name="expiry_date"
                                        placeholder="Enter who bought it">
                                </div>

                                <div class="row form-group">
                                    <div class=" col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Quantity</span>
                                        <input type="text" class="form-control  quantity" id="qty"
                                            name="quantity" placeholder="Enter Quantity" required autofocus>
                                    </div>

                                    <div class="col-md-6">
                                        <span>Threshold Quantity</span>
                                        <input type="text" class="form-control threshold_qty" id="threshold_qty"
                                            name="thresholdQty" placeholder="Enter threshold quantity">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <span><span class="text-danger pr-1">*</span>Buying Price</span>
                                            <input type="text" class="form-control  original_price"
                                                name="original_price" placeholder="Enter original price" required
                                                autofocus>
                                        </div>

                                        <div class="col-lg-4 form-group">
                                            <span><span class="text-danger pr-1">*</span>Retail Price</span>
                                            <input type="text" class="form-control  selling_price"
                                                name="selling_price" placeholder="Enter selling price" required autofocus>
                                        </div>

                                        <div class="col-lg-4 form-group">
                                            <span>Wholesale Price</span>
                                            <input type="text" class="form-control   wholesale_price"
                                                name="wholesale_price" placeholder="Enter wholesale price" required
                                                autofocus>
                                        </div>

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
                                    <label class="text-danger">Are you sure you want to delete item
                                        <small class="text-dark text-muted bolded">
                                        </small>
                                        ?
                                    </label>
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
        const ajaxUrl = @json(route('get-stock'));
        const deletedSeletectedUrl = @json(route('selected-stock.remove'));
        const cat = 'stock';
        const token = "{{ csrf_token() }}";
    </script>

    @can('isAdmin')
        <script>
            //code that displays results of the table index()
            let table = $('#stock-table');
            let title = "List of stock items in the system";
            let columns = [1, 2, 3, 4, 5];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
                // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                // {data: 'id', name:'id'},
                //  {data: 'item_code', name:'item_code'},
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
                //  {data: 'threshold_qty', name:'threshold_qty'},
                {
                    data: 'buying_price',
                    name: 'buying_price'
                },
                {
                    data: 'selling_price',
                    name: 'selling_price'
                },
                {
                    data: 'wholesale_price',
                    name: 'wholesale_price'
                },
                //  {data: 'supplier', name:'supplier'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            makeDataTable(table, title, columns, dataColumns);
        </script>
    @endcan

    @can('isCashier')
        <script>
            //code that displays results of the table index()
            let table = $('#stock-table');
            let title = "List of stock items in the system";
            let columns = [1, 2, 3, 4, 5];
            let dataColumns = [
                //  {data: 'id', name:'id'},
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
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
                    data: 'selling_price',
                    name: 'selling_price'
                },
                {
                    data: 'wholesale_price',
                    name: 'wholesale_price'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            makeDataTable2(table, title, columns, dataColumns);
        </script>
    @endcan


    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Numberize(".quantity");
            Numberize(".thresholdQty");
            Numberize(".original_price");
            Numberize(".selling_price");
            Numberize(".wholesale_price");

            $.fn.dataTable.ext.errMode = 'none';
            $('#stock-table').on('error.dt', function(e, settings, techNote, message) {
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
                $('.addStockBtn').text("Edit stock");
                $('#addStockModal').modal('show');
                let Url = "{{ route('stock.show', ':id') }}";
                Url = Url.replace(':id', stock_id);
                $.ajax({

                    url: Url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {

                        $('#modalHeading').html("Edit details of stock item " + data.item + "");
                        $('.stockId').val(data.id);
                        $('.item_code').val(data.item_code);
                        $('.item-name').val(data.item);
                        if (data.category) {
                            $('#category').val(data.category);
                        } else {
                            $('#category').val("choose category");
                        }
                        $('#supplier').val(data.supplier);
                        $('.quantity').val(data.quantity);
                        $('.threshold_qty').val(data.threshold_qty);
                        $('.expiry_date').val(data.expiry_date);
                        $('.original_price').val(data.buying_price);
                        $('.selling_price').val(data.selling_price);
                        $('.wholesale_price').val(data.wholesale_price);
                        DisableFormFields(false);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
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
                    success: function(data) {

                        $('#StockForm').trigger("reset");
                        $('#addStockModal').modal("hide");
                        let resp = data.success;
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#stock-table').DataTable();
                        tbl.ajax.reload();

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
                    success: function(data) {

                        $('#StockForm').trigger("reset");
                        $('#addStockModal').modal("hide");

                        let resp = data.success || data.error;
                        let type = data.success ? 'success' : 'error';

                        if (data.success) {
                            ResetTblInfo(data);
                            let tbl = $('#stock-table').DataTable();
                            tbl.ajax.reload();
                        }

                        displayResponse('.response', resp, type);

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addStockBtn').html('Save Changes');
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
                $.get("{{ route('stock.index') }}" + '/' + stock_id + '', function(data) {
                    let bprice = data.buying_price;
                    let sprice = data.selling_price;
                    let wprice = data.wholesale_price;
                    $('#modalHeading').html("Details of stock " + data.item + "");
                    $('#addStockModal').modal('show');
                    $('.stockId').val(stock_id);
                    $('.item_code').val(data.item_code);
                    $('.item-name').val(data.item);
                    $('.category').val(data.category);
                    $('#supplier').val(data.supplier);
                    $('.quantity').val(data.quantity);
                    $('.thresholdQty').val(data.threshold_qty)
                    $('.expiry_date').val(data.expiry_date);
                    $('.original_price').val(bprice);
                    $('.selling_price').val(sprice);
                    $('.wholesale_price').val(wprice);
                    DisableFormFields(true);
                });
            }


            function onClickSubmitBtn() {
                $('.addStockBtn').click(function(e) {
                    let id = $(".stockId").val();
                    e.preventDefault();
                    let Errors = validateForm();
                    if (Errors.length == 0) {
                        if (id) {
                            UpdateStock(id);

                        } else {
                            recordStock();
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
            $('body').on('click', '#delete-stock', function(e) {
                let stock_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_stock, function(stock) {
                    $("#deleteStockModal").modal('show');
                    $('.delete-ok-btn').on('click', function() {
                        deleteRecord(stock_id);
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
                    success: function(data) {
                        let resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteStockModal').modal("hide");
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#stock-table').DataTable();
                        tbl.ajax.reload();
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
                $('.item-name').val('');
                $('.category').val('');
                $('#supplier').val('');
                $('.quantity').val('');
                $('.expiry_date').val('');
                $('.original_price').val('');
                $('.selling_price').val('');
                $('.wholesale_price').val('');
            }



            function DisableFormFields(bool) {

                $('.stockId').attr('disabled', bool);
                $('.item_code').attr('disabled', bool);
                $('.item-name').attr('disabled', bool);
                $('.category').attr('disabled', bool);
                $('#supplier').attr('disabled', bool);
                $('.quantity').attr('disabled', bool);
                $('.expiry_date').attr('disabled', bool);
                $('.original_price').attr('disabled', bool);
                $('.selling_price').attr('disabled', bool);
                $('.wholesale_price').attr('disabled', bool);
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
                totl_stock = FormatNumber(response.totl_stock);
                stockValue = FormatNumber(response.stock_value);

                $('.totl-stock').html(totl_stock);
                $('.stock-value').html(stockValue);
            }

            function validateForm() {
                let item = $('.item-name').val();
                let qty = $('#qty').val();
                let bprice = $('.original_price').val();
                let sprice = $('.selling_price').val();

                let errors = [];
                if (item.length < 1) {
                    let itemNameErr = "Please enter the name of stock item";
                    errors.push(itemNameErr);
                }
                if (qty.length < 1) {
                    let qtyErr = "Please enter valid quantity of stock";
                    errors.push(qtyErr);
                }
                if (bprice == "") {
                    let bPriceErr = "Please enter valid buying price of an item";
                    errors.push(bPriceErr);
                }

                if (sprice == "") {
                    let sPriceErr = "Please enter valid selling price of an item";
                    errors.push(sPriceErr);
                }

                return errors;

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
