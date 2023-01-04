populateDepartments();

function populateDepartments() {
                $.ajax({
                    type: "GET",
                    url: departmentsAjaxUrl,
                    success: function(resp) {
                        let obj = JSON.parse(resp);
                        for (let i = 0; i < obj.length; i++) {
                            let id = obj[i]['id'];
                            let department = obj[i]['name'];
                            $('.departments_section').append('<option value=' + id + '>' + department +
                                '</option>');
                        }
                    }
                });
}