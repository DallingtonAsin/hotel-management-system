   <!--View Reservation Form -->
   <div class="modal fade nunito-font viewReservationModal" id="viewReservationModal" tabindex="-1"
       aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
       role="dialog" aria-labelledby="myModalLabel">
       <div class="modal-dialog mx-auto modal-dialog-xlg">
           <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="modal-title w-100 font-weight-bold">Details of Reservation</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
              @include('pages.main.accomodation.reservations.forms.reservation')
            </div>
           </div>
       </div>
   </div>
