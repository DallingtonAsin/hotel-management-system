<?php

namespace App\Http\Controllers\Accomodation;

use App\Http\Controllers\Controller;
use App\Models\FrequentContact;
use Illuminate\Http\Request;
use App\DataTables\Accomodation\ReservationsDataTable;
use App\Models\Reservation;
use App\Models\GuestType;
use App\Models\InvoiceGuest;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use Carbon\Carbon;

class ReservationController extends Controller
{

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
        $guest_types = GuestType::all();
        return view('pages.main.accomodation.reservations.add', ['guest_types' => $guest_types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $guest_type = $request->input('guest_type');
        if (stripos($guest_type, 'regular') !== false) {
            $validator = Validator::make($request->all(), [
                'guest_type' => 'required',
                'first_name' => 'required|max:55',
                'last_name' => 'required|max:55',
                'company_name' => 'sometimes|nullable',
                'tax_number' => 'sometimes|nullable',
                'company_contact' => 'sometimes|nullable',
                'company_email' => 'sometimes|nullable',
                'phone_number' => 'required|min:10',
                'email' => 'sometimes|nullable|email',
                'passport_number' => 'sometimes|nullable',
                'nin' => 'sometimes|nullable',
                'occupancy_type' => 'required',
                'room_number' => 'required',
                'arrival_date' => 'required',
                'departure_date' => 'required',
                'other_details' => 'sometimes|nullable'
            ]);
            $tab = '?tab=regular-tab';
        } else {
            $validator = Validator::make($request->all(), [
                'guest_type' => 'required',
                'first_name' => 'required|max:55',
                'last_name' => 'required|max:55',
                'company_name' => 'required',
                'tax_number' => 'required',
                'company_contact' => 'required',
                'company_email' => 'required',
                'phone_number' => 'required|min:10',
                'email' => 'required|email',
                'passport_number' => 'sometimes|nullable',
                'nin' => 'sometimes|nullable',
                'occupancy_type' => 'required',
                'room_number' => 'required',
                'arrival_date' => 'required',
                'departure_date' => 'required',
                'other_details' => 'sometimes|nullable'
            ]);
            $tab = '?tab=corporate-tab';
        }

        try {
            if ($validator->fails()) {

                return redirect('reservations/create' . $tab)
                    ->withErrors($validator)
                    ->withInput();

            } else {

                $first_name = ucfirst($request->input('first_name'));
                $last_name = ucfirst($request->input('last_name'));
             
                $tax_number = $request->input('tax_number');
                $company_contact = $request->input('company_contact');
                $company_email = $request->input('company_email');
                $phone_number = $request->input('phone_number');
                $email = $request->input('email');
                $passport_number = $request->input('passport_number');
                $nin = $request->input('nin');
                $occupancy_type = $request->input('occupancy_type');
                $other_details = $request->input('other_details');
                $arrival_date = date('Y-m-d, H:i:s', strtotime($request->input('arrival_date')));
                $departure_date = date('Y-m-d, H:i:s', strtotime($request->input('departure_date')));
                $created_by = Helper::getLoggedInUserId();

                $company_name = null;
                if($request->filled('company_name')){
                    $company_id = $request->input('company_name');
                    $company_name = FrequentContact::where('id', $company_id)->value('name');
                }
               
                $guest_type_id = GuestType::where('name', 'like', "%" . $guest_type . "%")->value('id');
                $room_number = $request->input('room_number');

                $doesRoomExist = Room::where('number', $room_number)->exists();
                if ($doesRoomExist) {
                    $room_details = Room::where('number', $room_number)->first();
                    $room_id = $room_details->id;
                    $room_type_id = $room_details->type_id;
                } else {
                    return back()->with('error', 'Room with number ' . $room_number . ' does not exist in the system');
                }

                $roomType = RoomType::find($room_type_id);

                if (stripos($occupancy_type, 'single') !== false) {
                    $price_rate = $roomType->single_occupancy_rate;
                } else {
                    $price_rate = $roomType->double_occupancy_rate;
                }

                $nights = floatval(Carbon::parse($arrival_date)->diffInDays(Carbon::parse($departure_date)));
                $nights = $nights < 1 ? 1 : $nights;
                $amount = $nights * floatval($price_rate);
                $tax_amount = 0.18 * $amount;

                $guestData = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'company_name' => $company_name,
                    'company_contact' => $company_contact,
                    'company_email' => $company_email,
                    'tax_number' => $tax_number,
                    'passport_number' => $passport_number,
                    'nin' => $nin,
                    'other_details' => $other_details,
                    'created_by' => $created_by,
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
                    'created_by' => $created_by,
                ];

                $resp = $this->addNewReservation($reservation_details);
                $key = $resp['execKey'];
                if ($key == 'success') {

                    $reservationDetails = $resp['data'];
                    $reservation_id = $reservationDetails->id;
                    $guestInvoiceNumber  = Helper::generateUniqueNumber('invoice_guests', 'invoice_number', 10, 'CMH');

                    $invoiceData = [
                        'invoice_number' => $guestInvoiceNumber,
                        'reservation_id' => $reservation_id,
                        'discount_percent' => 0,
                        'amount' => $amount,
                        'tax' => $tax_amount,
                        'ts_issued' => Carbon::now(),
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
            return InvoiceGuest::create($data);
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
            $guest = Guest::create($guest);
            return $guest;

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