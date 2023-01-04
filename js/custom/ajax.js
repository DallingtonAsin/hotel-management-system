
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