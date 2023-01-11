@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Kitchen Menu Item Categories</strong>
                <span class="badge badge-info total_menu_items_cats">
                    @isset($total_menu_item_cats)
                        {{ number_format($total_menu_item_cats) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewMenuItemCategory">
                <i class="fa fa-plus-circle pr-1"></i>Add Menu Item</button>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover menu-items-cats-table" id="menu-items-cats-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>created by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add menu item -->
    <div class="modal fade nunito-font addMenuItemCategoryModal" id="addMenuItemCategoryModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="menu-items" id="MenuItemCatForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new menu item category</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control menuItemCatId bg-white menuItemCatId" name="id"
                                placeholder="Enter menu item id" required>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Category Name</span>
                            <input type="text" class="form-control name bg-white" name="name"
                                placeholder="Enter menu item name" required autofocus>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addMenuItemCatBtn"
                                name="addMenuItemCatBtn">Save</button>
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


    <!--Modal Delete Menu Item -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete menu item</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this menu item
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
    </div> <!-- end of modal Delete Menu Items-->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('menu-item-categories.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'menu_items';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            let table = $('#menu-items-cats-table');
            let title = "List of recorded menu item categories in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
                {
                    data: 'name',
                    name: 'name'
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

            $('#addNewMenuItemCategory').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addMenuItemCatBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                $('.menuItemCatId').val('');
                $('#MenuItemCatForm').trigger("reset");
                $('#modalHeading').html("Add new menu item category");
                $('#addMenuItemCategoryModal').modal('show');
            });

            $('.addMenuItemCatBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {

                    $(this).html('Sending..');
                    $('.errors-section').html('');


                    $.ajax({
                        data: $('#MenuItemCatForm').serialize(),
                        url: "{{ route('menu-item-categories.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#MenuItemCatForm').trigger("reset");
                            $('#addMenuItemCategoryModal').modal("hide");
                            let resp = data.success || data.error;
                            let type = data.success ? 'success' : 'error';
                            if (data.success) {
                                ResetTblInfo(data);
                                let tbl = $('#menu-items-cats-table').DataTable();
                                tbl.ajax.reload();
                            }
                            displayResponse('.response', resp, type);


                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addMenuItemCatBtn').html('Save Changes');
                        }
                    });
                } else {
                    let i;
                    let message = "";
                    for (i = 0; i < Errors.length; i++) {
                        message += Errors[i] + "<br>";
                    }
                    $('.errors-section').html(message);

                }

            });

            //modal used to edit menu-items details [each row of the tbl]
            $('body').on('click', '#edit-menu-item-cat', function(event) {
                let menu_item_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('menu-item-categories.index') }}" + '/' + menu_item_id + '/edit', function(
                    data) {

                    $('#modalHeading').html("Edit details of menu item " + data.name + "");
                    $('.addMenuItemCatBtn').text("Edit menu item");
                    $('#addMenuItemCategoryModal').modal('show');
                    $('.menuItemCatId').val(data.id);
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


            //View Modal used to view each row [menu items details]
            $('body').on('click', '#view-menu-item-cat', function(event) {
                let menu_item_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('menu-item-categories.index') }}" + '/' + menu_item_id + '', function(
                data) {

                    $('#modalHeading').html("Details of menu item " + data.name + "");
                    $('#addMenuItemCategoryModal').modal('show');
                    $('.menuItemCatId').val(data.id);
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

            //this pops up confirm delete modal
            $('body').on('click', '#delete-menu-item-cat', function(e) {
                let menu_item_id = $(this).data("id");
                e.preventDefault();
                $("#deleteSuppliersModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this menu item?");
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(menu_item_id);
                });

            });


            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('menu-item-categories.destroy', ':id') }}';
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
                        let tbl = $('#menu-items-cats-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.menuItemCatId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addMenuItemCatBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addMenuItemCatBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_menu_items_cats').html(totl_number);
            }

            function validateForm() {
                let name = $('.name').val();

                let errors = [];
                if (name.length < 1) {
                    errors.push("Please enter the name of the menu item category");
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
                    title: 'Delete all menu items',
                    content: 'Are you sure you want to remove all menu items',
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
                                $(".total_menu_items_cats").text(data.total);
                                let tbl = $('#menu-items-cats-table').DataTable();
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
