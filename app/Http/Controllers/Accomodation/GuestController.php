<?php

namespace App\Http\Controllers\Accomodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Accomodation\GuestsDataTable;
use App\Models\FrequentContact;
use App\Models\Guest;

class GuestController extends Controller
{
    
    public function index()
    {

        $total_guests = Guest::count();
        return view('pages.main.accomodation.guests.index')->with(compact('total_guests'));
    }

    public function getGuests(GuestsDataTable $dataTable)
    {
        return $dataTable->render('pages.main.accomodation.guests.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    private function getGuestDetails($id)
    {
        try {
            $data = Guest::find($id);
            if($data->company_name){
                $data->company_id = FrequentContact::where('name', $data->company_name)->value('id');
            }
            return response()->json(['success' => 'ok', 'data' => $data]);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
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
        return $this->getGuestDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getGuestDetails($id);
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

    public function fetchGuestsAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                $guests = Guest::get();
                echo json_encode($guests);
                die();
            }
        } catch (\Exception $ex) {
            echo "Error " . $ex->getMessage();
        }
    }
}
