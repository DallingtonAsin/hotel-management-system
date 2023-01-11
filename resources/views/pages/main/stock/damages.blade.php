@extends('layouts.template')

@section('content')
      <span class="response"></span>
      <div class="card">
        <div class="card-header row d-flex justify-content-between align-items-center">

          <div class="col">
              <h6 class="text-left text-dark">
                  <i class="fa fa-home text-success"> /</i>
                  <strong>Recorded Damaged Items</strong>
                  <span class="badge badge-info totl_damages">
                      @isset($number_of_damages)
                          {{ number_format($number_of_damages) }}
                      @endisset
                  </span>
              </h6>
          </div>

          <div class="col">
              <h6 class="text-center">
                Cost of damages: shs:
                  <span class="text-success text-center">shs.
                      <strong class="totl_cost">
                          @isset($cost_of_damages)
                              {{ number_format($cost_of_damages) }}
                          @endisset
                      </strong>
                  </span>
              </h6>
          </div>

          <div class="col">
              <div class="btn-group float-right justify-content-between mb-2">
                  <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewDamage"><i
                          class="fa fa-plus-circle pr-1"></i>Add damage</button>
                  {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                      data-bs-target="#importStock"><i class="fa fa-file-import pr-1"></i>Import file</button> --}}
              </div>
          </div>

      </div>

        <div class="card-body">

              <div class="table table-responsive">
                <table class="table table-bordered" id="damages-table">

                  <thead>
                    <tr>
                        @can('isAdmin') 
                        <th></th>
                        @endcan
                        @can('isCashier') 
                        <th>No</th>
                        @endcan
                      <th>item code</th>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Cost price</th>
                      <th>Total Cost</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>


              <!-- Add Damage Details -->
              <div class="modal fade" id="addDamagesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-md">

                  <div class="modal-content nunito-font rounded-0">
                    <form name="damagesForm" id="damagesForm">
                      @csrf
                      <div class="modal-header text-center">
                        <h6 class="modal-title w-100 nunito-font font-weight-bold" id="modalHeading">
                          <i class="fa fa-info-circle"></i>
                          Add damaged item
                        </h6>

                        <button type="button" class="close view-close text-dark"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">

                      <div class="form-group">
                        <span>Item</span>
                        <input type="hidden" class="form-control damageId" name="id" id="id">
                        <input type="text" class="form-control bg-white item-name" name="damage-item"
                        id="item" placeholder="Enter item" autocomplete="off" spellcheck="false">
                      </div>

                      <div class="form-group">
                        <span>Quantity</span>
                        <input type="text" id="qty" class="form-control quantity bg-white" name="quantity" placeholder="Quantity" Required autofocus>
                      </div>


                      <div class="form-group categoryDiv">
                        <span>Category</span>
                        <input type="text" class="form-control bg-white text-dark item-category"
                        value="" placeholder="Enter item category">
                      </div>

                      <div class="form-group bpriceDiv">
                        <span>Buying Price</span>
                        <input type="text" class="form-control bg-white text-dark bprice"
                        value="" readonly>
                      </div>

                      <div class="form-group lamountDiv">
                        <span>Lost amount</span>
                        <input type="text" class="form-control bg-white text-danger lamount"
                        value="" readonly>
                      </div>

                      <div class="form-group record-date-div">
                        <span>Recorded on</span>
                        <input type="text" class="form-control bg-white record-date"
                        value="" readonly>
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary addDamageBtn"  name="AdddamageBtn">Save</button>
                        <button type="reset" class="btn btn-danger clearBtn">Clear</button>
                        <button type="button" class="btn btn-dark closeBtn" data-bs-dismiss="modal">Close</button>
                      </div>

                      <div class="form-group">
                        <span class="errors-section text-danger nunito-font"></span>
                      </div>


                    </form>
                  </div>
                </div>


              </div>
            </div>
            <!-- end of modal AddDamage-->



            <!--Modal DeleteDamage -->
            <div class="modal fade" id="deleteDamageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
            aria-labelledby="ModalLabel">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header text-center">
                  <h6 class="modal-title w-100 font-weight-bold">Delete damaged item</h6>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <div class="form-group">
                    <div class="text-center">
                      <label class="text-danger">Are you sure you want to delete damage
                        <small class="text-dark text-muted bolded">
                        </small>
                        ?
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary delete-ok-btn"  name="ConfirmBtn">Yes</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- end of modal Deletedamage-->

          <!--Import Damaged Items -->
          <div class="modal fade nunito-font" id="importDamages" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">

                <form action="{{ Route('damages.import') }}" method="post"
                enctype="multipart/form-data" name="importDamagesForm" >
                @csrf

                <div class="modal-header text-center">
                  <h6 class="modal-title w-100 font-weight-bold">Import damaged items from Excel file</h6>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="form-group">
                    <span>Select file for Upload</span>
                  </div>

                  <div class="form-group">
                    <input type="file" class="form-control-file @error('select_file') is-invalid @enderror" name="select_file" Required autofocus>
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
  const ajaxUrl = @json(route('get-damages'));
  const deletedSeletectedUrl = @json(route('selected-damages.remove'));
  const cat = 'damages';
  const token = "{{ csrf_token() }}";
  let table = $('#damages-table');
  let title = "List of recorded damaged items in the system";
  let columns = [0,1,2,3,4,5,6,7];

</script>

@can('isAdmin')
<script>
      let dataColumns = [
      {data: 'checkbox', name:'checkbox'},
      // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
         // {data: 'id', name:'id'},
         
        {data: 'item_id', name:'item_id'},
        {data: 'item', name:'item'},
        // {data: 'category', name:'category'},
        {data: 'quantity', name:'quantity'},
        {data: 'buying_price', name:'buying_price'},
        {data: 'total_cost', name:'total_cost'},
        {data: 'recordedOn', name:'recordedOn'},
        {data: 'action', name: 'action',orderable: false,searchable: false},
        ];
      makeDataTable(table, title, columns, dataColumns);
</script>
@endcan

@can('isCashier')
<script>
      let dataColumns = [
      // {data: 'checkbox', name:'checkbox'},
      {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,  searchable: false },
         // {data: 'id', name:'id'},
         
        {data: 'item_id', name:'item_id'},
        {data: 'item', name:'item'},
        // {data: 'category', name:'category'},
        {data: 'quantity', name:'quantity'},
        {data: 'buying_price', name:'buying_price'},
        {data: 'total_cost', name:'total_cost'},
        {data: 'recordedOn', name:'recordedOn'},
        {data: 'action', name: 'action',orderable: false,searchable: false},
        ];
         makeDataTable2(table, title, columns, dataColumns);
</script>
@endcan

  <script type="text/javascript">

       const onSearchItemUrl = @json(route('item.search'));
        onSearchItem('.item-name');

    $(document).ready(function(){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      OnclickingSubmitBtn();
     
      $('#createNewDamage').click(function (e) {
        e.preventDefault();
        ClearFormFields();
        ShowOnAddNewDamagedItem(false);
        ShowHideBtns('show');
        $('.addDamageBtn').text("Record damage");
        $('#damagesForm').trigger("reset");
        ShowHideContent('hide');
        $('#modalHeading').html("Record new damage");
        $('#addDamagesModal').modal('show');
      });

       Numberize(".quantity");

      //modal used to edit damages details [each row of the tbl]

      $('body').on('click', '#edit-damage', function (event) {
        let damage_id = $(this).data('id');
        event.preventDefault();
        ShowHideContent('hide');
        $('.addDamageBtn').text("Edit damage");

        let Url = "{{ route('damaged-stock-items.show', ':id') }}";
        Url = Url.replace(':id', damage_id);
        $.ajax({

          url: Url,
          type: "GET",
          dataType: 'json',
          success: function (data) {

            $('#modalHeading').html("Edit details of damaged stock item " + data.item + "");
            $('.addDamageBtn').text("Edit damage");
            $('#addDamagesModal').modal('show');
            $('.damageId').val(damage_id);
            $('.item-name').val(data.item);
            $('.item-category').val(data.category);
            $('.quantity').val(data.quantity);
            $('.bprice').val(data.buying_price);
            $('.lamount').val(data.total_cost);
            $('.record-date').val(data.recordedOn);
            DisableFormFields(false);
            ShowHideBtns('show');
            $('#addDamagesModal').modal('show');

          },
          error: function (data) {
            console.log('Error:', data.error);
            displayResponse('.response', data.error, 'error');
          }
        });

      });


      //View Modal used to view each row [damages details]
      $('body').on('click', '#view-damage', function (event) {
        let damage_id = $(this).data('id');
        event.preventDefault();

        $.get("{{ route('damaged-stock-items.index') }}" +'/' +damage_id +'', function (data) {

          $('#modalHeading').html("Details of damaged item " + data.item + "");
          $('#addDamagesModal').modal('show');
          $('.damageId').val(damage_id);
          $('.item-name').val(data.item);
          $('.item-category').val(data.category);
          $('.quantity').val(data.quantity);
          $('.bprice').val(FormatNumber(data.buying_price));
          $('.lamount').val(FormatNumber(data.total_cost));
          $('.record-date').val(data.recordedOn);
          ShowHideContent('show');
          DisableFormFields(true);
          ShowHideBtns('hide');
        })
      });


      function recordDamagedItem(){

        $('.addDamageBtn').html('Saving data...');
        $.ajax({
          data: $('#damagesForm').serialize(),
          url: "{{ route('damaged-stock-items.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

            $('#damagesForm').trigger("reset");
            $('#addDamagesModal').modal("hide");
            let resp = data.success || data.error;
            let type = data.success ? 'success' : 'error';

            if(data.success){
              ResetTblInfo(data);
              let tbl = $('#damages-table').DataTable();
              tbl.ajax.reload();
            }

            displayResponse('.response', resp, type);
           

          },
          error: function (data) {
            console.log('Error:', data.error);
            displayResponse('.response', data.error, 'error');
            $('.addDamageBtn').html('Save Changes');
          }
        });

      }

      function UpdateDamagedItem(damageId){
       // alert(damageId);
        let updateUrl =  '{{ route("damaged-stock-items.update", ":id") }}';
        updateUrl  = updateUrl .replace(':id', damageId);

        $('.addDamageBtn').html('Updating...');
        $.ajax({
          data: $('#damagesForm').serialize(),
          url: updateUrl ,
          type: "PUT",
          dataType: 'json',
          success: function (data) {

            $('#damagesForm').trigger("reset");
            $('#addDamagesModal').modal("hide");
            let resp = data.success;
            displayResponse('.response', resp, 'success');
            ResetTblInfo(data);
            let tbl = $('#damages-table').DataTable();
            tbl.ajax.reload();

          },
          error: function (data) {
            console.log('Error:', data.fail);
            displayResponse('.response', data.error, 'error');
            $('.addDamageBtn').html('Save Changes');
          }
        });

      }


      function OnclickingSubmitBtn(){
        $('.addDamageBtn').click(function (e) {
          let id = $('.damageId').val();
          console.log(id);
          e.preventDefault();
          let Errors = validateForm();
          console.log(Errors);
          if(Errors.length == 0){
            $('.errors-section').html('');
            if(id){
              UpdateDamagedItem(id);
            }else{
              recordDamagedItem();
            }

          }else
          {
            let i;
            let message ="";
            for(i=0; i<Errors.length; i++){
              message += Errors[i] + "<br>";
            }
            $('.errors-section').html(message);

          }

        });
      }


      //this pops up confirm delete modal
      $('body').on('click', '#delete-damage', function (e) {
        let damage_id = $(this).data("id");
        e.preventDefault();
        $("#deleteDamageModal").modal('show');
        $('.delete-ok-btn').on('click', function(){
          ListenAndDoDeletion(damage_id);
        });

      });


      $("#item").typeahead({
        source:function(query,result){
          $.ajax({
            url:"{{ Route('stock-item.search') }}",
            method:'post',
            data:{
              query:query,
            },
            dataType:'json',
            success: function(data){
              result($.map(data, function(item){
                return item;
              }));
            },
            error:function(data){
              console.log('am not getting anything');
            },
          });
        }
      });


      function ListenAndDoDeletion(id){
        let deleteUrl = '{{ route("damaged-stock-items.destroy", ":id") }}';
        deleteUrl = deleteUrl.replace(':id', id);
        $('.delete-ok-btn').html('Deleting...');
        $.ajax({
          type: "DELETE",
          url: deleteUrl,
          success: function (data) {
            let resp = data.success;
            $('.delete-ok-btn').html('Yes');
            $('#deleteDamageModal').modal("hide");
            displayResponse('.response', resp, 'success');
            ResetTblInfo(data);
            let tbl = $('#damages-table').DataTable();
            tbl.ajax.reload();
          },
          error: function (data) {
            console.log('Error:', data);
            displayResponse('.response', data.error, 'error');
          }
        });
      }

      function ClearFormFields()
      {
        $('.damageId').val('');
        $('.item-name').val('');
        $('.item-category').val('');
        $('.quantity').val('');
        $('.bprice').val('');
        $('.lamount').val('');
        $('.record-date').val('');
      }

      function ShowOnAddNewDamagedItem(bool){
        $('.item-name').attr('disabled', bool);
        $('.quantity').attr('disabled', bool);
      }


      function DisableFormFields(bool){

        $('.item-name').attr('disabled', bool);
        $('.item-category').attr('disabled', bool);
        $('.quantity').attr('disabled', bool);
        $('.bprice').attr('disabled', bool);
        $('.lamount').attr('disabled', bool);
        $('.record-date').attr('disabled', bool);
      }

      function ShowHideContent(action){

        if(action == 'hide'){
          $('.categoryDiv').hide();
          $('.bpriceDiv').hide();
          $('.lamountDiv').hide();
          $('.record-date-div').hide();
        }
        else if(action == 'show'){
          $('.categoryDiv').show();
          $('.bpriceDiv').show();
          $('.lamountDiv').show();
          $('.record-date-div').show();
        }
      }

      function ShowHideBtns(action){
        if(action == 'hide'){
          $('.addDamageBtn').hide();
          $('.clearBtn').hide();
          $('.closeBtn').hide();
        }
        else if(action == 'show'){
          $('.addDamageBtn').show();
          $('.clearBtn').show();
          $('.closeBtn').show();
        }

      }

      function ResetTblInfo(response)
      {
        let  totl_damages , totl_cost;
        totl_damages = FormatNumber(response.totl_no);
        totl_cost = FormatNumber(response.totl_amt);

        $('.totl_damages').html(totl_damages);
        $('.totl_cost').html( totl_cost);
      }

      function validateForm()
      {
        let item_name = $('.item-name').val();
        let qty = $('#qty').val();
        let errors = [];
        if(item_name.length < 1){
          let nameErr = "Please enter the damaged item";
          errors.push(nameErr);
        }
        if(qty == "" || parseInt(qty) <= 0){
          let qtyErr = "Please enter valid quantity of the damaged item "+qty+"";
          errors.push(qtyErr);
        }

        return errors;

      }


      $("#removeAllDamages").bind("click", function(){
        RemoveAllDamages();
      });

      function RemoveAllDamages(){
      $.confirm({
        boxWidth: '30%',
        icon: 'fa fa-warning',
        theme:'light',
        closeIcon: true,
        draggable:true,
        closeIconClass: 'fa fa-close text-danger',
        title: 'Delete all damages',
        content:'Are you sure you want to remove all damages',
        buttons:{
            confirm:function(){
          let self = this;
          return $.ajax({
              data: {
                  "_token": "{{ csrf_token() }}",
                  },
              url: '{{ Route("damages.truncate") }}',
              type: 'POST',
          }).done(function (data) {

              $.alert({
                  title: 'Message',
                  content: data.success,
              });
               $(".totl_damages").text(data.totl_no);
               $(".totl_cost").text(data.totl_amt);
               let tbl = $('#damages-table').DataTable();
               tbl.ajax.reload();

          }).fail(function(data){
              $.alert({
                  title: 'Response',
                  content:"Damages not deleted:"+data.fail,
              });
              console.log(data);

          });

            },
            cancel:function(){

            }
        },
      });

        }


    });

  </script>

  @endsection
