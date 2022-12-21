
var oTable;
function makeDataTable(table, title, columnArray, dataColumns) {
    
     oTable = $(table).dataTable({
         dom:
             "<'row'<'col-sm-1'l><'col-sm-8 pb-3 text-center'B><'col-sm-3'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
         processing: true,
         stateSave: false,
         pageLength:15,
         ordering: false,
         "lengthMenu": [ [10, 15, 25, 50, -1], [10, 15, 25, 50, "All"] ],
         buttons: [
             {
                 text: "<i></i> Select all",
                 className: "btn btn-sm btn-default border-secondary btn-select-all",
                 action: function(e, dt, node, config) {
                     selectAllCheckBoxes();
                 }
             },

             {
                 text: "<i></i> Deselect all",
                 className: "btn btn-sm btn-default border-secondary",
                 action: function(e, dt, node, config) {
                     deselectAllCheckBoxes();
                 }
             },

             $.extend(
                 true,
                 {},
                 {
                     extend: "excelHtml5",
                     text: '<i class="fa fa-download "></i> Excel',
                     className: "btn btn-sm btn-default border-secondary",
                     title: title,
                     exportOptions: {
                         columns: columnArray
                     }
                 }
             ),

             $.extend(
                 true,
                 {},
                 {
                     extend: "pdfHtml5",
                     text: '<i class="fa fa-download"></i> Pdf',
                     className: "btn btn-default border-secondary btn-sm",
                     title: title,
                     exportOptions: {
                         columns: columnArray
                     }
                 }
             ),

             $.extend(
                 true,
                 {},
                 {
                     extend: "print",
                     exportOptions: {
                         columns: columnArray,
                         modifier: {
                             selected: null
                         }
                     },
                     text: '<i class="fa fa-save"></i> Print',
                     className: "btn btn-default border-secondary btn-sm",
                     title: title
                 }
             ),

             {
                 text: "<i></i> Delete selected",
                 className: "btn btn-danger btn-sm btn-deselect-all",
                 action: function(e, dt, node, config) {
                     deleteSelectedRows(table);
                 }
             }
         ],
         ajax: ajaxUrl,
         columns: dataColumns,
         order: [[0, "asc"]]
     });

    }


    function makeDataTable2(table, title, columnArray, dataColumns) {
    
     oTable = $(table).dataTable({
         dom:
             "<'row'<'col-sm-1'l><'col-sm-8 pb-3 text-center'B><'col-sm-3'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
         processing: true,
         stateSave: false,
         pageLength: 15,
         ordering: false,
         "lengthMenu": [ [10, 15, 25, 50, -1], [10, 15, 25, 50, "All"] ],
         buttons: [
             $.extend(
                 true,
                 {},
                 {
                     extend: "excelHtml5",
                     text: '<i class="fa fa-download "></i>Export Excel',
                     className: "btn btn-default btn-sm",
                     title: title,
                     exportOptions: {
                         columns: columnArray
                     }
                 }
             ),

             $.extend(
                 true,
                 {},
                 {
                     extend: "pdfHtml5",
                     text: '<i class="fa fa-download"></i>Export Pdf',
                     className: "btn btn-default btn-sm",
                     title: title,
                     exportOptions: {
                         columns: columnArray
                     }
                 }
             ),

             $.extend(
                 true,
                 {},
                 {
                     extend: "print",
                     exportOptions: {
                         columns: columnArray,
                         modifier: {
                             selected: null
                         }
                     },
                     text: '<i class="fa fa-save"></i> Print',
                     className: "btn btn-default btn-sm",
                     title: title
                 }
             )
         ],
         ajax: ajaxUrl,
         columns: dataColumns,
         order: [[0, "asc"]]
     });

    }





    function selectAllCheckBoxes() {
    var allPages = oTable.fnGetNodes();
        $('input[type=checkbox]', allPages).prop('checked', true);
}

function deselectAllCheckBoxes() {
     var allPages = oTable.fnGetNodes();
        $('input[type=checkbox]', allPages).prop('checked', false);
  
}
    
function deleteSelectedRows(table) {
  var arr = [];
  var allPages = oTable.fnGetNodes();
  $("input[type=checkbox]", allPages).each(function() {
      if (jQuery(this).is(":checked")) {
          var id = this.id;
          arr.push(id);
      }
  });

  if (arr.length > 0) {
      $.confirm({
          boxWidth: "30%",
          icon: "fa fa-warning",
          theme: "light",
          closeIcon: true,
          draggable: true,
          closeIconClass: "fa fa-close text-danger",
          title: "Delete "+cat,
          content: "Are you sure you want to remove these "+cat+"",
          buttons: {
              confirm: function() {
                  var self = this;
                  return $.ajax({
                      data: {
                          _token: token,
                          selected_rows: arr
                      },
                      url: deletedSeletectedUrl,
                      type: "POST"
                  })
                      .done(function(data) {
                          $.each(arr, function(i, l) {
                              $("#tr_" + l).remove();
                          });
                          updateTblStats(cat, data);
                          $(table)
                              .DataTable()
                              .ajax.reload();
                          $.alert({
                              title: "Message",
                              content: data.success
                          });
                          
                      })
                      .fail(function(data) {
                          $.alert({
                              title: "Response",
                              content: "" + cat + " not deleted: "
                          });
                          console.log(data);
                      });
              },
              cancel: function() {}
          }
      });
  } else {
      $.alert({
          closeIcon: true,
          title: "Information",
          content: "Please select atleast one "+cat+" to remove"
      });
  }
  console.log("Ids to delete", JSON.stringify(arr));

}


function updateTblStats(cat, response) {
  var totl_number , sum_of_credits, sum_of_debts;
  var totl_stock, stockValue;
  var totl_amt, totl_no, totl_purchases;
  var  totl_damages , totl_cost;
  var totl_Of_PdtCategories;
  var totl_sales, netWorth;
  switch (true) {
      case cat == "supplier":
          totl_number = FormatNumber(response.totl_no);
          sum_of_credits = FormatNumber(response.totl_credit);
          sum_of_debts = FormatNumber(response.totl_debt);
          $(".totl_suppliers").html(totl_number);
          $(".totl_credit").html(sum_of_credits);
          $(".totl_debt").html(sum_of_debts);
      case cat == "stock":
          totl_stock = FormatNumber(response.totl_stock);
          stockValue = FormatNumber(response.stock_value);
          $(".totl-stock").html(totl_stock);
          $(".stock-value").html(stockValue);
      case cat == "expenses":
          totl_no = FormatNumber(response.totl_no);
          totl_amt = FormatNumber(response.totl_expenses);
          $(".totl_no").html(totl_no);
          $(".totl_amt").html(totl_amt);
      case cat == "damages":
          totl_damages = FormatNumber(response.totl_no);
          totl_cost = FormatNumber(response.totl_amt);
          $(".totl_damages").html(totl_damages);
          $(".totl_cost").html(totl_cost);
      case cat == "purchases":
          totl_no = FormatNumber(response.totl_no);
          totl_purchases = FormatNumber(response.totl_purchases);
          $(".totl-no").html(totl_no);
          $(".totl-purchases").html(totl_purchases);
       case cat == "cashier":
          totl_no = FormatNumber(response.totl_no);
          $(".totl_cashiers").html(totl_no);
      case cat == "manager":
          totl_no = FormatNumber(response.totl_no);
          $(".totl_managers").html(totl_no);
      case cat == "customers":
          totl_number = FormatNumber(response.totl_no);
          sum_of_credits = FormatNumber(response.totl_credit);
          sum_of_debts = FormatNumber(response.totl_debt);
          $(".totl_customers").html(totl_number);
          $(".totl_credit").html(sum_of_credits);
          $(".totl_debt").html(sum_of_debts);
      case cat == "stockcats":
          totl_Of_PdtCategories = FormatNumber(response.totl_no);
      $(".totl-PdtCategory").html(totl_Of_PdtCategories);
      case cat == 'sales':
     totl_no = FormatNumber(response.totl_no);
     totl_sales = FormatNumber(response.totl_sales);
     netWorth = FormatNumber(response.net_worth);
     $('.totl_no').html(totl_no);
     $('.totl_sales').html(totl_sales);
     $(".net_value").html(netWorth);
     
  }

}

 function FormatNumber(number) {
     var FormattedNumber = parseFloat(number).toLocaleString("us", {
         minimumFractionDigits: 0,
         maximumFractionDigits: 0
     });
     return FormattedNumber;
 }


 
