  <!--Add new Stock -->
  <div class="modal fade nunito-font" id="guestDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

          <form name="guestForm" id="guestForm">
              @csrf
              <div class="modal-header d-flex justify-content-between">
                  <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Guest Details</h6>
                  <button type="button" class="close mt-1" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>

              <div class="modal-body">


                <div class="row form-group"> 

                    <div class="col-md-6">
                        <span><span class="text-danger pr-1">*</span>First Name</span>
                        <input type="text" class="form-control  first_name" name="first_name" placeholder="Enter First Name" required autofocus>
                    </div>

                    <div class="col-md-6">
                        <span><span class="text-danger pr-1">*</span>Last Name</span>
                        <input type="text" class="form-control  last_name" name="last_name" placeholder="Enter Last Name" required autofocus>
                    </div>

                </div>

                <div class="row form-group"> 

                    <div class="col-md-6">
                        <span>Email</span>
                        <input type="text" class="form-control  email" name="email" placeholder="Enter email" required autofocus>
                    </div>

                    <div class="col-md-6">
                        <span>Phone Number</span>
                        <input type="text" class="form-control  phone_number" name="phone_number" placeholder="Enter phone number" required autofocus>
                    </div>

                </div>

                <div class="row form-group"> 

                    <div class="col-md-4">
                        <span><span class="text-danger pr-1">*</span>Company Name</span>
                        <select class="form-control company_name " name="company_name">
                            <option value="">Select company name</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <span>Company contact person</span>
                        <input type="text" class="form-control  contact_person" name="contact_person" placeholder="Enter contact person" required autofocus>
                    </div>

                    <div class="col-md-4">
                        <span>Company Email</span>
                        <input type="text" class="form-control  company_email" name="company_email" placeholder="Enter company email" required autofocus>
                    </div>

                </div>

                <div class="row form-group"> 
                    <div class="col-md-4">
                        <span>TIN</span>
                        <input type="text" class="form-control  tin" name="tin" placeholder="Enter TIN" required autofocus>
                    </div>

                    <div class="col-md-4">
                        <span>Passport No.</span>
                        <input type="text" class="form-control  passport_number" name="passport_number" placeholder="Enter passport number" required autofocus>
                    </div>

                    <div class="col-md-4">
                        <span>Nin</span>
                        <input type="text" class="form-control  nin" name="nin" placeholder="Enter national id number" required autofocus>
                    </div>

                </div>
                

                  <div class="form-group">
                      <span>Other details</span>
                      <textarea name="other_details" class="form-control other_details"></textarea>
                  </div>


                  <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-sm outline-none rounded-pill editGuestBtn"
                          name="editGuestBtn"><i class="fa fa-plus-circle pr-1"></i>Update</button>
                      <button type="reset" class="btn btn-sm btn-danger clearBtn">Clear</button>
                  </div>

                  <div class="form-group">
                      <span class="errors-section text-danger nunito-font"></span>
                  </div>

              </div>
          </form>
      </div>
  </div>
</div>