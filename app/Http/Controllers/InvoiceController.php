<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceGuest;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{

    public function index()
    {
        //
    }

    public function generateInvoicePDF()
    {
        $pdf = PDF::loadView('pages.main.invoices.booking');

        return $pdf->download('nicesnippets.pdf');
    }

    private function createInvoicesDirIfnotExists($directory)
    {
        try {
            $path = public_path($directory);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function download($id)
    {

        try {
            // $invoice = InvoiceGuest::find($id);
            $directory = 'invoices';
            $this->createInvoicesDirIfnotExists(($directory));

            $filename = 'invoice-' . $id . '.pdf';
            $path = public_path('' . $directory . '/' . $filename);

            $pdf = PDF::loadView('pages.main.invoices.reservation');
            $pdf->save($path);

            $subpath = 'invoices/' . $filename;
            $url = Storage::disk('invoices')->url($subpath);
            return response()->json(['url' => $url]);

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

        // return $pdf->stream('nicesnippets.pdf');
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
}