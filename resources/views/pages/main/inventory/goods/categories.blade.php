@extends('layouts.template')

@section('content')
    <span class="response"></span>
    <div class="card">

        <div class="card-header row d-flex justify-content-between align-items-center">

            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Commodity Categories</strong>
                    <span class="badge badge-info totl_categories">
                        @isset($number_of_categories)
                            {{ number_format($number_of_categories) }}
                        @endisset
                    </span>
                </h6>
            </div>

         
            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewStock"><i
                            class="fa fa-plus-circle pr-1"></i>Add commodity category</button>
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
            <div class="modal fade nunito-font" id="addCommodityCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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

                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Category Name</span>
                                        <input type="text" class="form-control category_name" name="category_name"
                                            placeholder="Enter category name">
                                    </div>

                                    <div class="col-md-6">
                                        <span><span class="text-danger pr-1">*</span>Category Code (EFRIS)</span>
                                        <input type="hidden" class="category_id" name="category_id">
                                        <input type="text" class="form-control category_code" name="category_code"
                                            placeholder="Enter category code">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary addCommodityCatBtn"
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

            <!--Import Commodity Categories -->
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

            <!--Modal Delete Stock -->
            <div class="modal fade" id="deleteCommodityCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
            <!-- end of modal Delete Stock-->
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
         
            onClickSubmitBtn();

            $('#createNewStock').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_stock, function(stock) {
                    NullifyFields();
                    ShowHideBtns('show');
                    $('.addCommodityCatBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('#StockForm').trigger("reset");
                    $('#modalHeading').html("Add new commodity category");
                    DisableFormFields(false);
                    $('#addCommodityCategoryModal').modal('show');
                });
            });

            //modal used to edit stock details [each row of the tbl]
            $('body').on('click', '#edit-commodity-category', function(event) {
                let stock_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_stock, function(stock) {
                    editCommodityCategory(stock_id);
                });
            });

            function editCommodityCategory(stock_id) {
                ShowHideBtns('show');
                $('.addCommodityCatBtn').text("Update stock");
                $('#addCommodityCategoryModal').modal('show');
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
                            $('.addCommodityCatBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                            displayResponse(null, response.error, 'error');
                        }

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        $('.addCommodityCatBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                        displayResponse(null, data.error, 'error');
                    }
                });
            }

            function updateCommodityCategory(stock_id) {

                $('.errors-section').html('');
                $('.addCommodityCatBtn').html('Updating item...');
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
                            $('#addCommodityCategoryModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#commodity-category-table').DataTable();
                            tbl.ajax.reload();
                        }

                        displayResponse(null, message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addCommodityCatBtn').html('Save Changes');
                    }
                });

            }

            function addCommodityCategory() {
                $('.errors-section').html('');
                $('.addCommodityCatBtn').html('Sending data..');
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
                            $('#addCommodityCategoryModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#commodity-category-table').DataTable();
                            tbl.ajax.reload();
                        } else {
                            $('.addCommodityCatBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                        }

                        displayResponse('.response', resp, type);
                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addCommodityCatBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    }
                });

            }

            //View Modal used to view each row [stock details]
            $('body').on('click', '#view-stock', function(event) {
                let stock_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_stock, function(stock) {
                    viewCommodityCategory(stock_id);
                });
            });

            function viewCommodityCategory(stock_id) {
                ShowHideBtns('hide');
                $.get("{{ route('stock.index') }}" + '/' + stock_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of stock " + data.item_name + "");
                        $('#addCommodityCategoryModal').modal('show');
                        populateProductDetails(data);
                        DisableFormFields(true);
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populateProductDetails(data) {
                $('.category_id').val(data.category_id);
                $('.category_name').val(data.category_name);
                $('.category_code').val(data.category_code);
            }


            function onClickSubmitBtn() {
                $('.addCommodityCatBtn').click(function(e) {
                    let id = $(".category_id").val();
                    e.preventDefault();
                    let isValidForm = validateForm();
                    if (isValidForm) {
                        if (id) {
                            updateCommodityCategory(id);

                        } else {
                            if (confirm(`Are you sure you want to add this as commodity category`)) {
                                addCommodityCategory();
                            }
                        }
                    }
                });
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-commodity-category', function(e) {
                let stock_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_stock, function(stock) {
                    $.get("{{ route('stock.index') }}" + '/' + stock_id + '', function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('.delete-confirm-text').html(
                                `Are you sure you want to delete commodity category ${data.item_name}?`
                            );
                            $("#deleteCommodityCategoryModal").modal('show');
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
                            $('#deleteCommodityCategoryModal').modal("hide");
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
                $('.category_id').val('');
                $('.category_name').val('');
                $('.category_code').val('');
            }

            function DisableFormFields(bool) {

                $('.category_id').attr('disabled', bool);
                $('.category_name').attr('disabled', bool);
                $('.category_code').attr('disabled', bool);
            }

            function ShowHideBtns(action) {

                if (action == 'hide') {
                    $('.addCommodityCatBtn').hide();
                    $('.clearBtn').hide();
                    $('.closeBtn').hide();
                } else if (action == 'show') {
                    $('.addCommodityCatBtn').show();
                    $('.clearBtn').show();
                    $('.closeBtn').show();
                }
            }


            function ResetTblInfo(response) {
                let totl_categories;
                totl_categories = FormatNumber(response.totl);
                $('.totl_categories').html(totl_categories);
            }

            function validateForm() {

                let category_name = $('.category_name').val();
                let category_code = $('.category_code').val();

                let isValidForm = false;

                if (category_name.length < 1) {
                    displayResponse(null, `Please enter category name`, `error`);
                } else if (category_code.length < 1) {
                    displayResponse(null, `Please enter category code`, `error`);
                } else {
                    isValidForm = true;
                }

                return isValidForm;
            }

        });
    </script>
@endsection
