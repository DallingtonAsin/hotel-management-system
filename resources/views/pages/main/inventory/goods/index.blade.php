@extends('layouts.template')

@section('content')
    <span class="response"></span>
    <div class="card">

        <div class="card-header row d-flex justify-content-between align-items-center">

            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Goods</strong>
                    <span class="badge badge-info totl_goods">
                        @isset($number_of_goods)
                            {{ number_format($number_of_goods) }}
                        @endisset
                    </span>
                </h6>
            </div>

            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewGood"><i
                            class="fa fa-plus-circle pr-1"></i>Add good</button>
                    {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#importStock"><i class="fa fa-file-import pr-1"></i>Import file</button> --}}
                </div>
            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="goods-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Good Name</th>
                            <th>Good Code</th>
                            <th>Measure Unit</th>
                            <th>U. Price</th>
                            <th>Currency</th>
                            <th>C. Category</th>
                            <th>Have E.Tax</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <!--Add new Stock -->
            <div class="modal fade nunito-font" id="addGoodModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog mx-auto modal-dialog-xlg">
                    <div class="modal-content">

                        <form name="GoodsForm" id="GoodsForm">
                            @csrf
                            <div class="modal-header d-flex justify-content-between">
                                <h6 class="modal-title w-100 font-weight-bold" id="modalHeading"> Add new good</h6>
                                <button type="button" class="close mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="row form-group">

                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Good Name</span>
                                        <input type="text" class="form-control  goods_name" name="goods_name"
                                            placeholder="Enter good name">
                                    </div>

                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Good Code</span>
                                        <input type="hidden" class="good_id" name="id">
                                        <input type="text" class="form-control  goods_code" name="goods_code"
                                            placeholder="Enter good code">
                                    </div>
                                </div>


                                <div class="row form-group">

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Commodity Category</span>
                                        <select name="commodity_category" class="form-control commodity_category">
                                            <option value="">Select commodity category</option>
                                            @foreach ($commodity_categories as  $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Commodity Category Id</span>
                                        <input type="text" class="form-control  commodity_category_id" name="commodity_category_id" readonly>
                                    </div>

                                    <div class="col-md-4">
                                        <span>Description</span>
                                        <textarea class="form-control description" placeholder="Enter description" name="description" rows="2"></textarea>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span> Measure Unit</span>
                                        <select class="form-control measure_unit" name="measure_unit"
                                            id="measure_unit">
                                            @foreach (config('measure-units') as $key => $value)
                                                <option value="{{ $value }}"
                                                    {{ str_contains($key, 'local') ? 'selected' : '' }}>{{ $value }}:
                                                    {{ ucwords(str_replace('_', ' ', str_replace('&', '/ ', $key))) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class=" col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Unit Price</span>
                                        <input type="text" class="form-control  unit_price" id="unit_price"
                                            name="unit_price" placeholder="Enter unit price">
                                    </div>

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Currency</span>
                                        <select class="form-control currency" name="currency" id="currency">
                                            <option value="">Select currency</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}" {{ $currency->code == 'UGX' ? 'selected' : ''  }}> {{ $currency->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>HaveExerciseTax</span>
                                        <select class="form-control have_excise_tax" id="have_excise_tax" name="have_excise_tax">
                                            <option value="101">101: Yes</option>
                                            <option value="102" selected="true">102: No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Stock Prewarning</span>
                                        <input type="text" class="form-control stock_prewarning" name="stock_prewarning" value="10"
                                            placeholder="Enter stock prewarning">
                                    </div>

                                    <div class="col-md-4">
                                        <span><span class="text-danger pr-1">*</span>Have Piece Unit</span>
                                        <select class="form-control have_piece_unit" id="have_piece_unit" name="have_piece_unit">
                                            <option value="101">101: Yes</option>
                                            <option value="102" selected="true">102: No</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <span>Piece Unit Price</span>
                                        <select class="form-control have_unit_price" id="have_unit_price" name="have_unit_price">
                                            <option value="" selected="true">Select piece unit price</option>
                                            <option value="101">101: Yes</option>
                                            <option value="102">102: No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <span>Package Scaled Value</span>
                                        <select class="form-control package_scale_value" id="package_scale_value" name="package_scale_value">
                                            <option value="" selected="true">Select package scale value</option>
                                            <option value="101">101: Yes</option>
                                            <option value="102">102: No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <span>Piece Scaled Value</span>
                                        <input type="text" class="form-control piece_scaled_value" name="piece_scaled_value"
                                            placeholder="Enter piece scaled value">
                                    </div>

                                </div>

                                <div class=" row form-group">

                                    <div class="col-md-6">
                                        <span>Goods Type Code</span>
                                        <select class="form-control package_scale_value" id="package_scale_value" name="package_scale_value">
                                            <option value="101" selected="true">101: Goods</option>
                                            <option value="102">102: Fuel</option>
                                        </select>
                                    </div>

                                        <div class="col-lg-6">
                                            <span>Excise Duty Code</span>
                                            <input type="text" class="form-control  excise_duty_code"
                                                name="excise_duty_code" placeholder="Enter excise duty code">
                                        </div>
                                </div>

                                <div class=" row form-group">

                                    <div class="col-md-3">
                                        <span>Other Unit</span>
                                        <select class="form-control have_other_unit" id="have_other_unit" name="have_other_unit">
                                            <option value="101">Yes</option>
                                            <option value="102" selected="true">No</option>
                                        </select>
                                    </div>

                                        <div class="col-md-3">
                                            <span>Other Price</span>
                                            <input type="text" class="form-control other_price" name="other_price" placeholder="Enter other price">
                                        </div>

                                        <div class="col-md-3">
                                            <span>Other Scale</span>
                                            <input type="text" class="form-control other_scale" name="other_scale" placeholder="Enter other scale">
                                        </div>

                                        <div class="col-md-3">
                                            <span>Package Scaled</span>
                                            <input type="text" class="form-control package_scale" name="package_scale" placeholder="Enter package scale">
                                        </div>
                                </div>

                             
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary addGoodBtn"
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
                            name="inportGoodsForm">
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
            <div class="modal fade" id="deleteGoodModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                                    <label class="text-danger delete-confirm-text">Are you sure you want to delete item?</label>
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
 
    <script>
        const ajaxUrl = @json(route('goods.ajax'));
        const cat = 'stock';
        const token = "{{ csrf_token() }}";
    </script>

        <script>
          
            let table = $('#goods-table');
            let title = "List of recorded goods in the system";
            let columns = [1, 2, 3, 4, 5];
            let dataColumns = [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
                {
                    data: 'goods_name',
                    name: 'goods_name'
                },
                {
                    data: 'goods_code',
                    name: 'goods_code'
                },
                {
                    data: 'measure_unit',
                    name: 'measure_unit'
                },
                {
                    data: 'unit_price',
                    name: 'unit_price'
                },
                {
                    data: 'currency_code',
                    name: 'currency_code'
                },

                {
                    data: 'commodity_category_id',
                    name: 'commodity_category_id'
                },
                {
                    data: 'have_excise_tax',
                    name: 'have_excise_tax'
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

            Numberize(".unit_price");
            Numberize(".stock_prewarning");
            Numberize(".other_price");

            onSelectCommodityCategory();
            
            function onSelectCommodityCategory() {
                $('.commodity_category').on('change', function() {
                    let id = $(this).find(":selected").val();
                    if (id) {
                        populateCommodityCatId(id);
                    }
                });
            }

            function populateCommodityCatId(id) {
                console.log(`Commodity cat id`, id);
                let url = '{{ route('commodities.category.ajax.find', ':id') }}';
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            if(data){
                               $('.commodity_category_id').val(data.code);
                            }
                        } else {
                            displayResponse(null, response.error, 'error');
                        }
                    },
                    error: function(data) {
                        console.log('Error on fetching commodity category details', data);
                        displayResponse(null, data.error, 'error');
                    }
                });
            }

            onClickSubmitBtn();

            $('#createNewGood').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_stock, function(stock) {
                    NullifyFields();
                    ShowHideBtns('show');
                    $('.addGoodBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('#GoodsForm').trigger("reset");
                    $('#modalHeading').html("Add new good");
                    DisableFormFields(false);
                    $('#addGoodModal').modal('show');
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
                $('.addGoodBtn').text("Update stock");
                $('#addGoodModal').modal('show');
                let Url = "{{ route('goods.show', ':id') }}";
                Url = Url.replace(':id', stock_id);
                $.ajax({

                    url: Url,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('#modalHeading').html("Edit details of good " + data.goods_name +
                                "");
                            populateGoodDetails(data);
                            DisableFormFields(false);
                        } else {
                            $('.addGoodBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                            displayResponse(null, response.error, 'error');
                        }

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        $('.addGoodBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                        displayResponse(null, data.error, 'error');
                    }
                });
            }

            function updateGoods(stock_id) {

                $('.errors-section').html('');
                $('.addGoodBtn').html('Updating item...');
                let Url = "{{ route('goods.update', ':id') }}";
                Url = Url.replace(':id', stock_id);

                $.ajax({
                    data: $('#GoodsForm').serialize(),
                    url: Url,
                    type: "PUT",
                    dataType: 'json',
                    success: function(response) {
                        let message = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if (response.success) {
                            let data = response.data;
                            $('#GoodsForm').trigger("reset");
                            $('#addGoodModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#goods-table').DataTable();
                            tbl.ajax.reload();
                        }

                        displayResponse(null, message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addGoodBtn').html('Save Changes');
                    }
                });

            }

            function recordGoods() {
                $('.errors-section').html('');
                $('.addGoodBtn').html('Sending data..');
                $.ajax({
                    data: $('#GoodsForm').serialize(),
                    url: "{{ route('goods.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {

                        let resp = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if (response.success) {
                            let data = response.data;
                            $('#GoodsForm').trigger("reset");
                            $('#addGoodModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#goods-table').DataTable();
                            tbl.ajax.reload();
                        }else{
                           $('.addGoodBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                        }

                        displayResponse('.response', resp, type);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addGoodBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
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
                $.get("{{ route('goods.index') }}" + '/' + stock_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of stock " + data.goods_name + "");
                        $('#addGoodModal').modal('show');
                        populateGoodDetails(data);
                        DisableFormFields(true);
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateGoodDetails(data) {
                $('.stockId').val(data.id);
                $('.item_code').val(data.item_code);
                $('.goods_type_code').val(data.goods_type_code);
                $('.stockin_type_code').val(data.stockin_type_code);
                $('.goods_name').val(data.goods_name);
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
                $('.addGoodBtn').click(function(e) {
                    let id = $(".stockId").val();
                    e.preventDefault();
                    let isValidForm = validateForm();
                    if (isValidForm) {
                        if (id) {
                            updateGoods(id);

                        } else {
                            if(confirm(`Are you sure you want to add this as good?`)){
                                recordGoods();
                            }
                        }
                    }
                });
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-good', function(e) {
                let stock_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_stock, function(stock) {
                    $.get("{{ route('goods.index') }}" + '/' + stock_id + '', function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('.delete-confirm-text').html(
                                `Are you sure you want to delete good ${data.goods_name}?`
                            );
                            $("#deleteGoodModal").modal('show');
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
                let deleteUrl = '{{ route('goods.destroy', ':id') }}';
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
                            $('#deleteGoodModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#goods-table').DataTable();
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
                $('.goods_name').val('');
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
                $('.goods_name').attr('disabled', bool);
                $('.category').attr('disabled', bool);
                $('#supplier').attr('disabled', bool);
                $('.quantity').attr('disabled', bool);
                $('.expiry_date').attr('disabled', bool);
                $('.original_price').attr('disabled', bool);
                $('.selling_price').attr('disabled', bool);
            }

            function ShowHideBtns(action) {

                if (action == 'hide') {
                    $('.addGoodBtn').hide();
                    $('.clearBtn').hide();
                    $('.closeBtn').hide();
                } else if (action == 'show') {
                    $('.addGoodBtn').show();
                    $('.clearBtn').show();
                    $('.closeBtn').show();
                }
            }


            function ResetTblInfo(response) {
                let totl_goods = FormatNumber(response.total);
                $('.totl_goods').html(totl_goods);
            }

            function validateForm() {

                let goods_name = $('.goods_name').val();
                let goods_code = $('.goods_code').val();
                let measure_unit = $('.measure_unit').val();
                let unit_price = $('.unit_price').val();
                let currency = $('.currency').val();
                let commodity_category = $('.commodity_category').val();
                let commodity_category_id = $('.commodity_category_id').val();
                let stock_prewarning = $('.stock_prewarning').val();
                let have_excise_tax = $('.have_excise_tax').val();
                let have_piece_unit = $('.have_piece_unit').val();
                let have_other_unit = $('.have_other_unit').val();


                let isValidForm = false;

                if (goods_name.length < 1) {
                    displayResponse(null, `Please enter the name of the good`, `error`);
                } else if (goods_code.length < 1) {
                    displayResponse(null, `Please enter code of the good`, `error`);
                } else if (commodity_category.length < 1) {
                    displayResponse(null, `Please select commodity category`, `error`);
                } else if (commodity_category_id.length < 1) {
                    displayResponse(null, `Please ensure commodity category id is not empty`, `error`);
                } else if (measure_unit.length < 1) {
                    displayResponse(null, `Please select measure unit`, `error`);
                } else if (unit_price.length < 1) {
                    displayResponse(null, `Please enter unit price`, `error`);
                } else if (currency.length < 1) {
                    displayResponse(null, `Please select currency`, `error`);
                } else if (have_excise_tax.length < 1) {
                    displayResponse(null, `Please select excise tax`, `error`);
                }  else if (stock_prewarning.length < 1) {
                    displayResponse(null, `Please enter valid stock prewarning`, `error`);
                } else if (have_piece_unit.length < 1) {
                    displayResponse(null, `Please select have piece unit`, `error`);
                } else if (have_other_unit.length < 1) {
                    displayResponse(null, `Please select other unit`, `error`);
                }else {
                    isValidForm = true;
                }

                return isValidForm;
            }

        });
    </script>
@endsection
