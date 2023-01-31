<?php

namespace App\Http\Controllers\Accomodation;

use App\Http\Controllers\Controller;
use App\Models\FrequentContact;
use Illuminate\Http\Request;
use App\DataTables\Accomodation\ReservationsDataTable;
use App\Models\Reservation;
use App\Models\GuestType;
use App\Models\ReservationInvoice;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Repositories\RoomRepository;

class ReservationController extends Controller
{

    protected $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function index()
    {
        $total_reservations = Reservation::count();
        return view('pages.main.accomodation.reservations.index', ['total_reservations' => $total_reservations]);
    }

    public function getReservations(ReservationsDataTable $dataTable)
    {
        return $dataTable->render('pages.main.accomodation.reservations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $frequent_contacts =  FrequentContact::all();
        $guest_types = GuestType::all();
        return view('pages.main.accomodation.reservations.add', 
        ['guest_types' => $guest_types, 'frequent_contacts' => $frequent_contacts]);
    }

    private function validateRegularGuestReq(){

        $reqObj = [
            'guest_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'job_title' => 'sometimes|nullable',
            'guest_tin' => 'sometimes|nullable',
            'company_name' => 'sometimes|nullable',
            'company_contact' => 'sometimes|nullable',
            'company_email' => 'sometimes|nullable',
            'company_tin' => 'sometimes|nullable',
            'daily_price' => 'sometimes|nullable',
            'nationality' => 'required',
            'phone_number' => 'required|min:10',
            'email' => 'sometimes|nullable|email',
            'passport_number' => 'sometimes|nullable',
            'nin' => 'sometimes|nullable',
            'card_issue_date' => 'sometimes|nullable',
            'card_expiry_date' => 'sometimes|nullable',
            'room_number' => 'required',
            'occupancy_type' => 'required',
            'arrival_date' => 'required',
            'departure_date' => 'required',
            'discount' => 'required',
            'total' => 'required',
            'purpose_of_visit' => 'required',
            'payment_mode' => 'required'
        ];
        return $reqObj;
    }

    private function validateCorporateGuestReq(){

        $reqObj = [
            'guest_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'job_title' => 'sometimes|nullable',
            'guest_tin' => 'sometimes|nullable',
            'company_name' => 'required',
            'company_contact' => 'required',
            'company_email' => 'required',
            'company_tin' => 'required',
            'daily_price' => 'required',
            'nationality' => 'required',
            'phone_number' => 'required|min:10',
            'email' => 'sometimes|nullable|email',
            'passport_number' => 'sometimes|nullable',
            'nin' => 'sometimes|nullable',
            'card_issue_date' => 'sometimes|nullable',
            'card_expiry_date' => 'sometimes|nullable',
            'room_number' => 'required',
            'occupancy_type' => 'required',
            'arrival_date' => 'required',
            'departure_date' => 'required',
            'discount' => 'sometimes|nullable',
            'total' => 'sometimes|nullable',
            'purpose_of_visit' => 'required',
            'payment_mode' => 'required'
        ];
        return $reqObj;
    }

    private function validateDailyUseGuestReq(){

        $reqObj = [
            'guest_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'sometimes|nullable',
            'job_title' => 'sometimes|nullable',
            'guest_tin' => 'sometimes|nullable',
            'company_name' => 'sometimes|nullable',
            'company_contact' => 'sometimes|nullable',
            'company_email' => 'sometimes|nullable',
            'company_tin' => 'sometimes|nullable',
            'daily_price' => 'sometimes|nullable',
            'nationality' => 'required',
            'phone_number' => 'required|min:10',
            'email' => 'sometimes|nullable|email',
            'passport_number' => 'sometimes|nullable',
            'nin' => 'sometimes|nullable',
            'card_issue_date' => 'sometimes|nullable',
            'room_number' => 'required',
            'card_expiry_date' => 'sometimes|nullable',
            'occupancy_type' => 'required',
            'arrival_date' => 'required',
            'departure_date' => 'required',
            'discount' => 'required',
            'total' => 'required',
            'purpose_of_visit' => 'required',
            'payment_mode' => 'required'
        ];
        return $reqObj;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $guest_type = $request->input('guest_type');
        if (stripos($guest_type, 'regular') !== false) {

            $validator = Validator::make($request->all(), $this->validateRegularGuestReq());

        } else if(stripos($guest_type, 'corporate') !== false){
            $validator = Validator::make($request->all(), $this->validateCorporateGuestReq());
      
        }else{
            $validator = Validator::make($request->all(), $this->validateDailyUseGuestReq());
           
        }

        try {
            if ($validator->fails()) {

                return redirect('reservations/create')
                    ->withErrors($validator)
                    ->withInput();

            } else {
                
                $start_date = $request->input('arrival_date');
                $end_date = $request->input('departure_date');
                if($start_date >  $end_date){
                    return back()->withInput()->with(['error' => 'Departure date must be greater than arrival date']);
                }

                $first_name = ucfirst($request->input('first_name'));
                $last_name = ucfirst($request->input('last_name'));
                $guest_tin = $request->input('guest_tin');
                $job_title = $request->input('job_title');
                $phone_number = $request->input('phone_number');
                $email = $request->input('email');

                $company_contact = $request->input('company_contact');
                $company_email = $request->input('company_email');
                $company_tin = $request->input('company_tin');
                $daily_price = Helper::Numberize($request->input('daily_price'));

                $nationality = ucfirst($request->input('nationality'));
                $passport_number = $request->input('passport_number');
                $card_issue_date = $request->input('card_issue_date');
                $card_expiry_date = $request->input('card_expiry_date');

                $nin = $request->input('nin');
                $occupancy_type = $request->input('occupancy_type');

                $room_number = $request->input('room_number');
                $purpose_of_visit = $request->input('purpose_of_visit');
                $payment_mode = $request->input('payment_mode');

                if($request->filled('discount')){
                    $discount = Helper::Numberize($request->input('discount'));
                }else{
                    $discount = 0;
                }

                $arrival_date = date('Y-m-d, H:i:s', strtotime($start_date));
                $departure_date = date('Y-m-d, H:i:s', strtotime($end_date));
                $created_by = Helper::getLoggedInUserId();

                $company_name = null;
                if($request->filled('company_name')){
                    $company_id = $request->input('company_name');
                    $company_name = FrequentContact::where('id', $company_id)->value('name');
                }
               
                $guest_type_id = GuestType::where('name', 'like', "%" . $guest_type . "%")->value('id');

                $room = $this->roomRepository->findRoomByNumber($room_number);
                if ($room->exists()) {
                    $room_details = $room->first();
                    $room_id = $room_details->id;
                    $room_type_id = $room_details->type_id;
                } else {
                    return back()->with('error', 'Room with number ' . $room_number . ' does not exist in the system');
                }

                $roomType = RoomType::find($room_type_id);

                 if(stripos($guest_type, 'corporate') !== false){
                      $price_rate = $daily_price;
                 }else{
                        $price_rate = (stripos($occupancy_type, 'single') !== false)
                        ?  $roomType->single_occupancy_rate
                        : $roomType->double_occupancy_rate;
                 }

                $nights = floatval(Carbon::parse($arrival_date)->diffInDays(Carbon::parse($departure_date)));
                $nights = $nights < 1 ? 1 : $nights;
                $amount = $nights * floatval($price_rate);
                $amount = $amount - $discount;
                $tax_amount = 0.18 * $amount;

                $guestData = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone_number' => $phone_number,
                    'email' => $email,
                    'job_title' => $job_title,
                    'tin_number' => $guest_tin,
                    'company_name' => $company_name,
                    'company_contact' => $company_contact,
                    'company_email' => $company_email,
                    'company_tin' => $company_tin,
                    'nationality' => $nationality,
                    'passport_number' => $passport_number,
                    'nin' => $nin,
                    'card_issue_date' => $card_issue_date,
                    'card_expiry_date' => $card_expiry_date,
                    'created_by' => $created_by
                ];

                $exists = $this->checkIfGuestExists($phone_number, $email);
           
                if ($exists) {

                    $findGuest = Guest::where('phone_number', $phone_number)->first();
                    Guest::where('phone_number', $phone_number)->update($guestData);
                    $guest_id = $findGuest->id;

                } else {
                    $guest = $this->addNewGuest($guestData);
                    if ($guest) {
                        $guest_id = $guest->id;
                    } else {
                        return back()->with('error', "Technical error in adding guest details");
                    }
                }

                $reservation_details = [
                    'arrival_date' => $arrival_date,
                    'departure_date' => $departure_date,
                    'room_id' => $room_id,
                    'guest_id' => $guest_id,
                    'guest_type_id' => $guest_type_id,
                    'occupancy_type' => $occupancy_type,
                    'purpose_of_visit' => $purpose_of_visit,
                    'created_by' => $created_by,
                ];

                $resp = $this->addNewReservation($reservation_details);
                $key = $resp['execKey'];
                if ($key == 'success') {

                    $reservationDetails = $resp['data'];
                    $reservation_id = $reservationDetails->id;
                    $guestInvoiceNumber  = Helper::generateUniqueNumber('reservation_invoices', 'invoice_number', 10, 'CMH');

                    $invoiceData = [
                        'invoice_number' => $guestInvoiceNumber,
                        'reservation_id' => $reservation_id,
                        'discount_percent' => 0,
                        'amount' => $amount,
                        'tax' => $tax_amount,
                        'payment_method' => $payment_mode,
                        'issued_on' => Carbon::now(),
                        'issued_by' => $created_by
                    ];

                    $invoice = $this->createInvoiceForGuest($invoiceData);
                    if ($invoice) {

                        $guest = $this->getGuestDetails($guest_id);
                        $guest_names = $guest->first_name . ' ' . $guest->last_name;
                        $message = "Reservation for guest " . $guest_names . " has been created successfully";
                        $execKey = "success";
                    } else {
                        $message = "Technical error in adding invoice details";
                        $execKey = "error";
                    }
                    return back()->with($execKey, $message);

                } else {
                    return back()->with('error', "Technical error in adding reservation details");
                }
            }
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
    }

    private function createInvoiceForGuest($data)
    {
        try {
            return ReservationInvoice::create($data);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
    private function checkIfGuestExists($phone_number, $email)
    {
        try {
            $obj = Guest::where('phone_number', $phone_number);
            // if ($email) {
            //     $obj = $obj->where('email', $email);
            // }
            $exists = $obj->exists();
            return $exists;

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function addNewGuest($guest)
    {
        try {
        return Guest::create($guest);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function addNewReservation($reservation)
    {
        try {

            $isReservationInserted = false;
            $reservation = Reservation::create($reservation);
            if ($reservation) {
                $isReservationInserted = true;
            }

            return [
                'execKey' => $isReservationInserted,
                'data' => $reservation
            ];

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function getGuestDetails($guest_id)
    {
        try {
            $guest = Guest::find($guest_id);
            return $guest;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function GetReservationStats()
    {
        try {

            $reservations = Reservation::all();
            $total_reservations = Reservation::count();

            $data = array(
                'data' => $reservations,
                'total' => $total_reservations
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


}