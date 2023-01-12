@extends('layouts.template')

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Frequent Contacts</strong>
                <span class="badge badge-info total_freq_contacts">
                    @isset($total_frequent_contacts)
                        {{ number_format($total_frequent_contacts) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewDepartment">
                <i class="fa fa-plus-circle pr-1"></i>Add Frequent Contact</button>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover frequent-contacts-table" id="frequent-contacts-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>Phone Number</th>
                            <th>tin</th>
                            <th>Contact person</th>
                            <th>Price</th>
                            <th>Currency</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add frequent contact -->
    <div class="modal fade nunito-font addFrequentContactMOdal" id="addFrequentContactMOdal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="frequent_contacts" id="FreqContactForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new frequent contact</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control freqContactId bg-white freqContactId" name="id"
                                placeholder="Enter frequent contact id" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Name</span>
                            <input type="text" class="form-control name bg-white" name="name" placeholder="Enter name"
                                required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Email</span>
                            <input type="email" class="form-control email bg-white" name="email"
                                placeholder="Enter email" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Phone Number</span>
                            <input type="text" class="form-control phone_number bg-white" name="phone_number"
                                placeholder="Enter phone_number" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Tin</span>
                            <input type="text" class="form-control tin bg-white" name="tin" placeholder="Enter tin"
                                required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Contact Person</span>
                            <input type="text" class="form-control contact_person bg-white" name="contact_person"
                                placeholder="Enter contact person" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><i class="text-danger pr-1">*</i>Price</span>
                            <input type="text" class="form-control price bg-white" name="price"
                                placeholder="Enter price" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Currency</span>
                            <select class="form-control currency bg-white" name="currency">
                                <option value="">select currency</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addFreqContactBtn"
                                name="addFreqContactBtn">Save</button>
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


    <!--Modal Delete Frequent Contact -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete frequent contact</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this frequent
                                contact
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

   
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        const ajaxUrl = @json(route('frequent-contacts.index.ajax'));
        const currencyCodeAjaxUrl = @json(route('currencies.ajax.fetch'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const cat = 'frequent_contacts';
        const token = "{{ csrf_token() }}";

        populateCurrencies('.currency');

        $(document).ready(function() {

            let table = $('#frequent-contacts-table');
            let title = "List of registered frequent contacts in the system";
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
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'tin',
                    name: 'tin'
                },
                {
                    data: 'contact_person',
                    name: 'contact_person'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'currency_code',
                    name: 'currency_code'
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

            $('#addNewDepartment').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addFreqContactBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                $('.freqContactId').val('');
                $('#FreqContactForm').trigger("reset");
                $('#modalHeading').html("Add new frequent contact");
                $('#addFrequentContactMOdal').modal('show');
            });


            Numberize(".price");

            $('.addFreqContactBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {

                    $(this).html('Sending..');
                    $('.errors-section').html('');

                    $.ajax({
                        data: $('#FreqContactForm').serialize(),
                        url: "{{ route('frequent-contacts.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#FreqContactForm').trigger("reset");
                            $('#addFrequentContactMOdal').modal("hide");

                            let resp = data.success || data.error;
                            let type = data.success ? 'success' : 'error';

                            if (data.success) {
                                ResetTblInfo(data);
                                let tbl = $('#frequent-contacts-table').DataTable();
                                tbl.ajax.reload();
                            }
                            displayResponse('.response', resp, type);

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addFreqContactBtn').html('Save Changes');
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

            //modal used to edit frequent contacts details [each row of the tbl]
            $('body').on('click', '#edit-frequent-contact', function(event) {
                let freq_contact_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('frequent-contacts.index') }}" + '/' + freq_contact_id + '/edit', function(
                    data) {

                    $('#modalHeading').html("Edit details of frequent contact " + data.name + "");
                    $('.addFreqContactBtn').text("Edit frequent contact");
                    $('#addFrequentContactMOdal').modal('show');
                    $('.freqContactId').val(data.id);
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


            //View Modal used to view each row [frequent contacts details]
            $('body').on('click', '#view-frequent-contact', function(event) {
                let freq_contact_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('frequent-contacts.index') }}" + '/' + freq_contact_id + '', function(
                data) {

                    $('#modalHeading').html("Details of frequent contact " + data.name + "");
                    $('#addFrequentContactMOdal').modal('show');
                    $('.freqContactId').val(data.id);
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
            $('body').on('click', '#delete-frequent-contact', function(e) {
                let freq_contact_id = $(this).data("id");
                e.preventDefault();
                $("#deleteSuppliersModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this frequent contact?");
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(freq_contact_id);
                });

            });


            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('frequent-contacts.destroy', ':id') }}';
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
                        let tbl = $('#frequent-contacts-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.freqContactId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addFreqContactBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addFreqContactBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_freq_contacts').html(totl_number);
            }

            function validateForm() {

                let name = $('.name').val();
                let email = $('.email').val();
                let phone_number = $('.phone_number').val();
                let tin = $('.tin').val();
                let contact_person = $('.contact_person').val();
                let price = $('.price').val();
                let currency = $('.currency').val();

                let errors = [];
                if (name.length < 1) {
                    errors.push('Please enter the name of the frequent contact');
                }
                if (email.length < 1) {
                    errors.push('Please enter the email of the frequent contact');
                }
                if (phone_number.length < 1) {
                    errors.push('Please enter phone number');
                }
                if (tin.length < 1) {
                    errors.push('Please enter tin number');
                }
                if (contact_person.length < 1) {
                    errors.push('Please enter contact person');
                }
                if (price.length < 1) {
                    errors.push('Please enter price you charge frequent contact');
                }
                if (currency.length < 1) {
                    errors.push('Please select currency');
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
                    title: 'Delete all frequent contacts',
                    content: 'Are you sure you want to remove all frequent contacts',
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
                                $(".total_freq_contacts").text(data.total);
                                let tbl = $('#frequent-contacts-table').DataTable();
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
