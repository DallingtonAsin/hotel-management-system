

        <div class="row container h-100 d-flex justify-content-center">
            <div class="col-md-12">
        @if(isset($companyData) && isset($companyData['company_logo']))
        <img src="{{ asset('uploads/images/company/logo/'.$companyData['company_logo'].'') }}" class="co-icon-center" alt="">
        @else
        <img src="{{ asset('uploads/images/company/logo/default/brand.png') }}" class="co-icon-center">
        @endif

            <h4 class="centered">RECEIPT
                Mukono
                Kampala Road
            </h4>
            </div>

            <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="success">
                        <th>Item Code</th>
                        <th>Item</th>
                         <th c>Quantity</th>
                         <th>Total (UGX)</th>
                         <th >Discount (UGX)</th>
                        <th>Amount (UGX)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="quantity">ARD</td>
                        <td class="description">ARDUINO UNO R3</td>
                        <td>4</td>
                        <td>5000</td>
                        <td>200</td>
                        <td class="price">4800.00</td>
                    </tr>
                    <tr>
                        <td class="quantity">Jav B</td>
                        <td class="description">JAVASCRIPT BOOK</td>
                        <td>4</td>
                          <td>5000</td>
                        <td>200</td>
                        <td class="price">4800.00</td>
                    </tr>
                    <tr>
                        <td class="quantity">STI</td>
                        <td class="description">STICKER PACK</td>
                        <td>4</td>
                        <td>5000</td>
                        <td>200</td>
                        <td class="price">4800.00</td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                      <td  class="bolded total" colspan="3">Total :</td>
                      <td class="bolded">200</td>
                    </tr>
               </tfoot>


            </table>
        </div>

        <div class="col-md-12">
             
                     <h5>Thanks for your purchase!</h5>
                     <h6>issajabrian.com</h6>
                      <button id="btnPrint" class="btn btn-sm  btn-primary">Print Receipt</button>
        </div>


    </div>
        
  
    <script type="text/javascript">
        const $btnPrint = document.querySelector("#btnPrint");
        $btnPrint.addEventListener("click", () => {
            window.print();
        });
    </script>
