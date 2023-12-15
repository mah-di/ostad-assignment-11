<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product_id = $request->product_id;

        try {
            $product = DB::table('products')->select(['id', 'title', 'price', 'stock'])->find($product_id);

            if ($product === null) {
                return Redirect::back()->with(['error' => true, 'message' => 'No such product exists']);
            }

            return view('sales.create', compact('product'));
        } catch (Exception $exception) {
            return Redirect::back()->with(['error' => true, 'message' => 'Unexpected error occured.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|numeric',
            'unit' => 'required|numeric|gte:1'
        ]);

        try{
            $product = DB::table('products')->find($validatedData['product_id']);
        } catch (Exception $exception) {
            return Redirect::back()->with(['error' => true, 'message' => 'An unexpected error occured.']);
        }

        if ($product === null) {
            return Redirect::back()->with(['error' => true, 'message' => 'No such product found.']);
        }
        
        if ($validatedData['unit'] > $product->stock) {
            return Redirect::back()->with(['error' => true, 'message' => 'Units to be sold exceeds current stock.']);
        }

        $validatedData['total'] = $product->price * $validatedData['unit'];

        $newStock = $product->stock - $validatedData['unit'];

        try {
            DB::beginTransaction();

            $saleId = DB::table('sales')->insertGetId($validatedData);
            DB::table('products')->where('id', '=', $product->id)->update(['stock' => $newStock]);

            DB::commit();

            return Redirect::route('sale.show', $saleId);
        } catch (Exception $exception) {
            DB::rollBack();
            
            return Redirect::back()->with(['error' => true, 'message' => 'Sale was not recorded. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
