   <!--View Kitchen Order Form -->
   <div class="modal fade nunito-font viewKitchenOrderModal" id="viewKitchenOrderModal" tabindex="-1"
       aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
       role="dialog" aria-labelledby="myModalLabel">
       <div class="modal-dialog mx-auto modal-dialog-xlg">
           <div class="modal-content">

               <form name="kitchen-orders" id="viewKitchenOrderForm">
                   <div class="modal-header text-center">
                       <h6 class="modal-title w-100 font-weight-bold">kitchen Order Details</h6>
                       <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>

                   <div class="modal-body border border-default m-3">

                       <div class="row form-group">
                           <div class="col-md-3">
                               <label for="table_number">Table Number</label>
                               <input type="text" class="form-control tbl_number" id="tbl_number" name="tbl_number"
                                   placeholder="Enter table number">
                           </div>

                           <div class="col-md-3">
                               <label for="room_number">Room No</label>
                               <input type="text" class="form-control room_no" name="room_no" id="room_no"
                                   placeholder="Enter room number">
                           </div>

                           <div class="col-md-3">
                               <label for="guest-">Guest Names</label>
                               <select name="guest" class="form-control guest_names" id="guest_names" disabled>
                                   <option value=""></option>
                               </select>
                           </div>

                           <div class="col-md-3">
                               <label for="status"><span class="text-danger pr-1">*</span>Status</label>
                               <select class="form-control order_status" name="order_status" id="order_status">
                                   <option value=""></option>
                               </select>
                           </div>
                       </div>

                       <div class="row form-group">
                           <div class="col-md-3">
                               <label for="customer_name">Customer Names</label>
                               <input type="text" class="form-control customer" name="customer" id="customer"
                                   placeholder="Enter customer names">
                           </div>

                           <div class="col-md-3">
                               <label for="room_number">Telephone Number</label>
                               <input type="text" class="form-control phone_no" name="phone_no" id="phone_no"
                                   placeholder="Enter telephone number">
                           </div>

                           <div class="col-md-3">
                               <label for="tin_number">Tin Number</label>
                               <input type="text" class="form-control tin_no" id="tin_no" name="tin_no"
                                   placeholder="Enter tin number">
                           </div>


                           <div class="col-md-3">
                               <label for="room_number">Email</label>
                               <input type="email" class="form-control email_id" name="email_id" id="email_id"
                                   placeholder="Enter email">
                           </div>
                       </div>

                   </div>
               </form>

               <div class="card-body">
                   <div class="table-response">
                       <table class="table table-bordered menu-item-cart" id="menu-item-cart">
                           <thead>
                               <tr>
                                   <th>Item</th>
                                   <th>Quantity</th>
                                   <th>Price</th>
                                   <th>Amount</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody class="menu-item-cart-body"></tbody>
                       </table>


                       <div class="d-flex justify-content-between" id="menu-cart-footer">
                           <div class="float-left">
                               <button type="submit" class="btn btn-primary submit-order-btn"><i
                                       class="fa fa-plus-circle pr-1"></i>Submit Order</button>
                           </div>
                           <div id="totals" class="float-right">
                               <div class="d-flex">
                                   <h5 class="mr-2">Subtotal:</h5> $<span id="sub_total">0.00</span>
                               </div>
                               <div class="d-flex">
                                   <h5 class="mr-2">Tax (18%):</h5> $<span id="tax_amount">0.00</span>
                               </div>
                               <div class="d-flex">
                                   <h5 class="mr-2">Total:</h5>$<span id="total_amount">0.00</span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

