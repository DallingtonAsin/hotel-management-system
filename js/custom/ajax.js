
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
                let name = obj[i]['first_name'] + ' '+ obj[i]['last_name'];
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
                let name = obj[i]['first_name'] + ' '+ obj[i]['last_name'];
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
        source: function(search_qry, result) {
            $.ajax({
                url: searchRoomUrl,
                method: 'post',
                data: {
                    query: search_qry,
                },
                dataType: 'json',
                success: function(data) {
                    result($.map(data, function(item) {
                        return item;
                    }));
                },
                error: function(data) {
                    console.log(data);
                },
            });
        },
        afterSelect: afterSelect
    });

}


function onSearchItem(element){
    let item_name = $().val();
    $(element).typeahead({
      source:function(item_name,result){
        $.ajax({
          url: onSearchItemUrl,
          method:'post',
          data:{
            query: item_name,
          },
          dataType:'json',
          success: function(data){
            result($.map(data, function(item){
              return item;
            }));
          },
          error:function(data){
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


