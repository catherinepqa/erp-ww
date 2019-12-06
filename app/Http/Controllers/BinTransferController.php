<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BinTransfer;
use App\Locations;
use App\BinItransferredItems;
use App\Items;
use App\BinItems;
use App\Bins;
use Redirect;

class BinTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Locations::all();
        return view('bin_transfer.create_bin_transfer', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save  = BinTransfer::storeBin($request);

        if ($save !== false) {
                return redirect('/bin_transfer')->with('success', 'Successfully created new bin transfer!');
        } else {
            return Redirect::back()->withErrors('Failed to transfer bin. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $bin_transfer = BinTransfer::findOrFail($id);
        return view('bin_transfer.view_bin_transfer', compact('bin_transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bin_transfer = BinTransfer::findOrFail($id);
        $locations = Locations::all();
        return view('bin_transfer.edit_bin_transfer', compact('bin_transfer', 'locations'));
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
        $update  = BinTransfer::updateBin($request, $id);

        if ($update !== false) {
                return redirect('/bin_transfer')->with('success', 'Successfully updated a bin transfer!');
        } else {
            return Redirect::back()->withErrors('Failed to update bin transfer. Please try again.')->withInput();
        }
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

    /**
     * Get all items from specific location
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkLocationItems (Request $request)
    {
        $items = Items::where(['location_id' => $request->get('location_id')])->get();

        if (!empty($items)) {
            $notEmpty = true;
        } else {
            $notEmpty = false;
        }

        return json_encode([
            'success' => $notEmpty,
            'data' => $items
        ]);
    }

    /**
     * Get all bins for specific item
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkItemBin (Request $request)
    {
        $item       = null;
        $binItem    = null;

        if ($request->get('item_id') != null) {
            $binItem = BinItems::with(['Bins', 'Items'])
                ->where(['item_id' => $request->get('item_id'), 'location_id' => $request->get('location_id')])
                ->first();

            $item = Items::with('UnitOfMeasures')
                    ->findOrFail($request->get('item_id'));
        } else {

            $binItem = BinItems::with(['Bins', 'Items.UnitOfMeasures'])
                ->where(['location_id' => $request->get('location_id')])
                ->get();
        }

        if (!empty($binItem)) {
            $notEmpty = true;
        } else {
            $notEmpty = false;
        }

        return json_encode([
            'success' => $notEmpty,
            'bin' => $binItem,
            'item' => $item
        ]);
    }

    /**
     * Get item and get bins of locations to fill the form
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inventoryDetailForm (Request $request)
    {

        $item = Items::findOrFail($request->get('item_id'));

        $fromBins = BinItems::with('Bins')->where([
            'item_id' => $request->get('item_id'),
            'location_id' => $request->get('location_id')
        ])->first();

        $toBins = Bins::where('location_id', $request->get('location_id'))
                        ->where('bin_id', '!=', $fromBins->bin_id)
                        ->get();

        if (!empty($binItem)) {
            $notEmpty = true;
        } else {
            $notEmpty = false;
        }

        return json_encode([
            'success' => $notEmpty,
            'fromBins' => $fromBins,
            'toBins' => $toBins,
            'item' => $item
        ]);
    }


    /**
     * Save Inventory detail frm Bin Transfer
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function binInventoryDetail (Request $request)
    {
        $save = BinItransferredItems::saveInventoryDetail($request);
        if ($update !== false) {
            $saved = true;
        } else {
            $saved = false;
        }

        return json_encode([
            'success' => $saved,
        ]);
    }


}
