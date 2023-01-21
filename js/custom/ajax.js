
function populateDepartments() {
    $.ajax({
        type: "GET",
        url: departmentsAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let department = obj[i]['name'];
                $('.departments_section').append('<option value=' + id + '>' + department + '</option>');
            }
        }
    });
}

function populateRoomTypes() {
    $.ajax({
        type: "GET",
        url: roomTypesAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let room_type = obj[i]['name'];
                $('.room_types_section').append('<option value=' + id + '>' + room_type + '</option>');
            }
        }
    });
}


function populateRooms() {
    $.ajax({
        type: "GET",
        url: roomsAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let room_number = obj[i]['number'];
                $('.rooms_section').append('<option value=' + room_number + '>' + room_number + '</option>');
            }
        }
    });
}


function populateStaffMemebers() {
    $.ajax({
        type: "GET",
        url: staffAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let name = obj[i]['first_name'] + ' ' + obj[i]['last_name'];
                $('.staff_members_section').append('<option value=' + id + '>' + name + '</option>');
            }
        }
    });
}


function populateGuests() {
    $.ajax({
        type: "GET",
        url: guestsAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let name = obj[i]['first_name'] + ' ' + obj[i]['last_name'];
                $('.guest_section').append('<option value=' + id + '>' + name + '</option>');
            }
        }
    });
}


function populateMenuItems() {
    $.ajax({
        type: "GET",
        url: menuItemsAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let menu_item = obj[i]['name'];
                $('.menu-items-section').append('<option value=' + id + '>' + menu_item + '</option>');
            }
        }
    });
}

function onTypingRoomNumber(element, afterSelect) {

    let search_qry = $(element).val();
    $(element).typeahead({
        source: function (search_qry, result) {
            $.ajax({
                url: searchRoomUrl,
                method: 'post',
                data: {
                    query: search_qry,
                },
                dataType: 'json',
                success: function (data) {
                    result($.map(data, function (item) {
                        return item;
                    }));
                },
                error: function (data) {
                    console.log(data);
                },
            });
        },
        afterSelect: afterSelect
    });

}


function onSearchItem(element) {
    let item_name = $().val();
    $(element).typeahead({
        source: function (item_name, result) {
            $.ajax({
                url: onSearchItemUrl,
                method: 'post',
                data: {
                    query: item_name,
                },
                dataType: 'json',
                success: function (data) {
                    result($.map(data, function (item) {
                        return item;
                    }));
                },
                error: function (data) {
                    console.log(data);
                },
            });
        }
    });
}


function populateMenuItemCategories(select_element) {
    $.ajax({
        type: "GET",
        url: menuItemCatAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let category_name = obj[i]['name'];
                $(select_element).append('<option value=' + id + '>' + category_name + '</option>');
            }
        }
    });
}


function populateCurrencies(select_element) {
    $.ajax({
        type: "GET",
        url: currencyCodeAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let currency_code = obj[i]['code'];
                $(select_element).append('<option value=' + id + '>' + currency_code + '</option>');
            }
        }
    });
}

function populateFrequentContacts(select_element) {
    $.ajax({
        type: "GET",
        url: freqContactAjaxUrl,
        success: function (resp) {
            let obj = JSON.parse(resp);
            for (let i = 0; i < obj.length; i++) {
                let id = obj[i]['id'];
                let name = obj[i]['name'];
                $(select_element).append('<option value=' + id + '>' + name + '</option>');
            }
        }
    });
}

function checkPermission(permission_name, next) {
    let permissionsUrl = '/staff-member/permission/' + permission_name + ''
    $.ajax({
        type: 'GET',
        url: permissionsUrl,
        success: function (response) {
            // console.log('Response from checking permissions', response);
            if (response.hasPermission === true) {
                next();
            } else {
                displayResponse('.response', response.error, 'error');
            }
        }
    });
}



function viewOrder(url) {
    $.get(url, function (response) {
        if (response.success) {
            let data = response.data;
            $('#viewKitchenOrderForm').trigger("reset");
            $('.order_no').text(data.order_number);

            let order_items = data.items;
            if (order_items.length > 0) {
                let table = $('.kitchen-order-details-body');
                table.empty();
                $.each(order_items, function (index, item) {
                    let item_name, quantity, price, total;
                    item_name = item.name;
                    quantity = item.quantity;
                    price = FormatNumber(item.price);
                    total = FormatNumber(item.total);

                    let row = "<tr>"
                    row += "<td>" + item_name + "</td><td>" + quantity + "</td>" +
                        "<td>" + price + "</td><td>" + total + "</td>";
                    row += "</tr>";
                    table.append(row);
                });

                let invoice = data.invoice;
                invoice = invoice[0];
                $('#sub_total').html(FormatNumber(invoice.sub_total));
                $('#tax_amount').html(FormatNumber(invoice.tax));
                $('#total_amount').html(FormatNumber(invoice.total));
                if (invoice.cancelled_for) {
                    $('.cancelled_for').html(invoice.cancelled_for);
                }
                if (invoice.cancelled_at) {
                    $('.cancelled_at').html(invoice.cancelled_at);
                }
                if (invoice.cancelled_by) {
                    $('.cancelled_by').html(invoice.cancelled_by);
                }
                if (invoice.paid_at) {
                    $('.paid_at').html(invoice.paid_at);
                }
                if (invoice.completed_by) {
                    $('.completed_by').html(invoice.completed_by);
                }
                if (invoice.completed_at) {
                    $('.completed_at').html(invoice.completed_at);
                }
                if (invoice.payment_method) {
                    $('.payment_method').html(invoice.payment_method);
                }
            }

            $('#viewKitchenOrderModal').modal('show');

            if (data.guest) {
                let guest = data.guest;
                let guest_names = guest.first_name + ' ' + guest.last_name;
                $('.guest_names').empty();
                $('.guest_names').append('<option value=' + guest_names + '>' + guest_names +
                    '</option>');
                $('.customer').val(guest_names);
                $('.phone_no').val(guest.phone_number);
                $('.tin_no').val(guest.tax_number)
                $('.email_id').val(guest.email);
            } else {
                $('.customer').val(data.customer_name);
                $('.phone_no').val(data.phone_number);
                $('.tin_no').val(data.tin_number)
                $('.email_id').val(data.email);
            }

            if (data.room_number) {
                $('.room_no').val(data.room_number);
            }

            $('.order_status').empty();
            $('.order_status').append('<option value=' + data.status + '>' + data.status +
                '</option>');
        } else {
            displayResponse(null, response.error, 'error');
        }
    });
}

function downloadKOT(invoice_id, type) {
    let download_kot_url = `invoice/kitchen-order/download/${invoice_id}`;
    checkPermission(permissions.download_kitchen_order_invoice, function() {
        $.ajax({
            url: download_kot_url,
            type: 'POST',
            data: {
                type: type,
            },
            success: function(response) {
                let returned_url = response.url;
                // console.log('Returned url is', response.url);
                window.open(returned_url, '_blank');
            }
        });
    });
}


