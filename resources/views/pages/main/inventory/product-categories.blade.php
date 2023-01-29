@extends('layouts.master')

@section('content')
    <span class="response"></span>
    <div class="card">
        <div class="card-header row d-flex justify-content-between align-items-center">
            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Stock categories</strong>
                    <span class="badge badge-info totl-PdtCategory">
                        @isset($total_categories)
                            {{ number_format($total_categories) }}
                        @endisset
                    </span>
                </h6>
            </div>

            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill mx-2" id="createNewPdtCategory"><i
                            class="fa fa-plus-circle pr-1"></i>Add stock category</button>
                    {{-- <button type="button" class="btn btn-primary btn-sm outline-none rounded-pill" data-bs-toggle="modal"
                data-bs-target="#importCategories"><i class="fa fa-file-import pr-1"></i>Import file</button> --}}
                </div>
            </div>

        </div>


        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered product-categories-table" id="product-categories-table">
                    <thead>
                        <tr class="text-center">
                            <th style="width:20%">#</th>
                            <th style="width:50%">Category name</th>
                            <th style="width:50%">Is Deleted</th>
                            <th style="width:50%">Created By</th>
                            <th style="width:20%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>

            <!--Modal DeleteItemCategory -->
            <div class="modal fade" id="deletePdtCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
                aria-labelledby="deleteModalLabel">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h6 class="modal-title w-100 font-weight-bold">Delete Category</h6>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <div class="text-center">
                                    <label class="text-danger confirm-delete-text">Are you sure you want
                                        to delete item category
                                        <small class="text-dark text-muted bolded">
                                        </small>
                                        ?

                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary delete-ok-btn" id="delete-ok-btn"
                                    name="ConfirmBtn">Yes</button>
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end of modal DeleteItemCategory-->

            <!--Add product category -->
            <div class="modal fade nunito-font" id="addItemCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <form name="categories" id="PdtCategoryForm">
                            @csrf
                            <div class="modal-header text-center">
                                <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add item category</h6>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="form-group">
                                    <span>Item Category</span>
                                    <input type="hidden" name="id" class="category_id">
                                    <input type="text" class="form-control name " name="name"
                                        placeholder="Enter item category" Required autofocus>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary addCategoryBtn"
                                        name="AddCategoryBtn">Save</button>
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

            <!--Import PdtCategory Categories -->
            <div class="modal fade nunito-font" id="importCategories" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <form action="{{ Route('categories.import') }}" method="post" enctype="multipart/form-data"
                            name="importCategoriesForm">
                            @csrf

                            <div class="modal-header text-center">
                                <h6 class="modal-title w-100 font-weight-bold">
                                    Import an excel file of product category categories </h6>
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
        </div>
    </div>


    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('get-stockItems'));
        const deletedSeletectedUrl = @json(route('selected-stockcats.remove'));
        const cat = 'stockcats';
        const token = "{{ csrf_token() }}";
    </script>
    <script>
        //code that displays results of the table index()
        let table = $('#product-categories-table');
        let title = "List of recorded item categories in the system";
        let columns = [0, 1];
        let dataColumns = [
            // {data: 'checkbox', name:'checkbox'},
            {
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
                data: 'is_deleted',
                name: 'is_deleted'
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
    </script>



    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            onClickSubmitBtn();

            $('#createNewPdtCategory').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.add_product_categories, function(category) {
                    NullifyFields();
                    ShowHideBtns('show');
                    $('.addCategoryBtn').text("Submit");
                    $('#PdtCategoryForm').trigger("reset");
                    $('#modalHeading').html("Record New Pdt Category");
                    DisableFormFields(false);
                    $('#addItemCategoryModal').modal('show');
                });
            });

            //modal used to edit PdtCategory details [each row of the tbl]
            $('body').on('click', '#edit-pdt-category', function(event) {
                let category_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_product_categories, function(category) {
                    editProductCategory(category_id);
                });
            });

            function editProductCategory(category_id) {
                ShowHideBtns('show');
                $('.addCategoryBtn').text("Update");
                $('#addItemCategoryModal').modal('show');
                let Url = "{{ route('product-categories.show', ':id') }}";
                Url = Url.replace(':id', category_id);
                $.ajax({

                    url: Url,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('#modalHeading').html("Edit details of product category " + data.name +
                                "");
                            $('.category_id').val(data.id);
                            $('.name').val(data.name);
                            DisableFormFields(false);
                        } else {
                            displayResponse(null, response.error, 'error');
                        }

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function UpdatePdtCategory(category_id) {

                $('.errors-section').html('');
                $('.addCategoryBtn').html('Updating item...');

                let Url = "{{ route('product-categories.update', ':id') }}";
                Url = Url.replace(':id', category_id);
                $.ajax({
                    data: $('#PdtCategoryForm').serialize(),
                    url: Url,
                    type: "PUT",
                    dataType: 'json',
                    success: function(data) {

                        $('#PdtCategoryForm').trigger("reset");
                        $('#addItemCategoryModal').modal("hide");
                        let resp = data.success;
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#product-categories-table').DataTable();
                        tbl.ajax.reload();

                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addCategoryBtn').html('Save Changes');
                    }
                });

            }

            function recordPdtCategory() {

                $('.errors-section').html('');
                $('.addCategoryBtn').html('Sending data..');

                $.ajax({
                    data: $('#PdtCategoryForm').serialize(),
                    url: "{{ route('product-categories.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        let message = data.success || data.error;
                        let type = data.success ? 'success' : 'error';

                        if (data.success) {
                            $('#PdtCategoryForm').trigger("reset");
                            $('#addItemCategoryModal').modal("hide");
                            ResetTblInfo(data);
                            let tbl = $('#product-categories-table').DataTable();
                            tbl.ajax.reload();
                        }

                        displayResponse('.response', message, type);


                    },
                    error: function(data) {
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                        $('.addCategoryBtn').html('Save Changes');
                    }
                });

            }


            //View Modal used to view each row [PdtCategory details]
            $('body').on('click', '#view-pdt-category', function(event) {
                let category_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_product_categories, function(category) {
                    viewProductCategory(category_id);
                });
            });

            function viewProductCategory(category_id) {
                ShowHideBtns('hide');
                $.get("{{ route('product-categories.index') }}" + '/' + category_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of product category " + data.name +
                            "");
                        $('#addItemCategoryModal').modal('show');
                        $('.category_id').val(data.id);
                        $('.name').val(data.name);
                        DisableFormFields(true);
                    } else {
                        displayResponse(null, response.error, 'error');
                    }

                });
            }


            function onClickSubmitBtn() {
                $('.addCategoryBtn').click(function(e) {
                    let id = $(".category_id").val();
                    e.preventDefault();
                    let errors = validateForm();

                    if (errors.length == 0) {
                        if (id) {
                            UpdatePdtCategory(id);

                        } else {
                            recordPdtCategory();
                        }

                    } else {
                        let i;
                        let message = "";
                        for (i = 0; i < errors.length; i++) {
                            message += errors[i] + "<br>";
                        }
                        //displayResponse('.errors-section', resp, 'error');
                        $('.errors-section').html(message);

                    }

                });
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-pdt-category', function(e) {
                let category_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_product_categories, function(category) {
                    $.get("{{ route('product-categories.index') }}" + '/' + category_id + '',
                        function(response) {
                            if (response.success) {
                                let data = response.data;
                                $("#deletePdtCategoryModal").modal('show');
                                $('.confirm-delete-text').html(`Are you sure you want to delete item category ${data.name}?`);
                                $('.delete-ok-btn').on('click', function() {
                                    deleteRecord(category_id);
                                });
                            } else {
                                displayResponse(null, response.error, 'error');
                            }
                        });
                });
            });


            function deleteRecord(id) {
                let deleteUrl = '{{ route('product-categories.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(response) {

                        $('.delete-ok-btn').html('Yes');
                        $('#deletePdtCategoryModal').modal("hide");

                        let message = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if (response.success) {
                            ResetTblInfo(response.data);
                            let tbl = $('#product-categories-table').DataTable();
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

            function NullifyFields() {
                $('.category_id').val('');
                $('.name').val('');
            }



            function DisableFormFields(bool) {
                $('.name').attr('disabled', bool);
            }

            function ShowHideBtns(action) {

                if (action == 'hide') {
                    $('.addCategoryBtn').hide();
                    $('.clearBtn').hide();
                    $('.closeBtn').hide();
                } else if (action == 'show') {
                    $('.addCategoryBtn').show();
                    $('.clearBtn').show();
                    $('.closeBtn').show();
                }
            }


            function ResetTblInfo(response) {
                let totl_Of_PdtCategories;
                totl_Of_PdtCategories = FormatNumber(response.totl_no);
                $('.totl-PdtCategory').html(totl_Of_PdtCategories);
            }

            function validateForm() {
                let item = $('.name').val();

                let errors = [];
                if (item.length < 1) {
                    let itemCatNameErr = "Please enter the name of item category";
                    errors.push(itemCatNameErr);
                }

                return errors;

            }


            $("#removeAllStockCats").bind("click", function() {
                RemoveAllStockCategories();
            });

            function RemoveAllStockCategories() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all stock categories',
                    content: 'Are you sure you want to remove all stock categories',
                    buttons: {
                        confirm: function() {
                            let self = this;
                            return $.ajax({
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                url: '{{ Route('categories.truncate') }}',
                                type: 'POST',
                            }).done(function(data) {

                                $.alert({
                                    title: 'Message',
                                    content: data.success,
                                });
                                $(".totl-PdtCategory").text(data.totl_no);
                                let tbl = $('#product-categories-table').DataTable();
                                tbl.ajax.reload();

                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "Categories of stock not deleted:" + data
                                        .fail,
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
