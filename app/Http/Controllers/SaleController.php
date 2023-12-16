<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sales = DB::table('sales as s')->select(['s.*', 'p.title', 'p.serial_number'])->join('products as p', 's.product_id', '=', 'p.id')->latest()->paginate(15);

            return view('sales.index', compact('sales'));
        } catch (Exception $exception) {
            return Redirect::route('dashboard')->with(['error' => true, 'message' => 'An unexpected error occured. Coudn\'t retrieve data.']);
        }
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
            $product = DB::table('products')->select(['id', 'price', 'stock'])->find($validatedData['product_id']);
        } catch (Exception $exception) {
            return Redirect::back()->with(['error' => true, 'message' => 'An unexpected error occured.']);
        }

        if ($product === null) {
            return Redirect::back()->with(['error' => true, 'message' => 'No such product found.']);
        }

        if ($validatedData['unit'] > $product->stock) {
            return Redirect::back()->with(['error' => true, 'message' => 'Units to be sold exceeds current stock.']);
        }

        $validatedData['selling_price'] = $product->price;

        $validatedData['total'] = $product->price * $validatedData['unit'];

        try {
            DB::beginTransaction();

            $saleId = DB::table('sales')->insertGetId($validatedData);
            DB::table('products')->where('id', '=', $product->id)->decrement('stock', $validatedData['unit']);

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
        try {
            $sale = DB::table('sales as s')->select(['s.*', 'p.title', 'p.description', 'p.serial_number'])->where('s.id', '=', $id)->join('products as p', 's.product_id', '=', 'p.id')->first();

            if ($sale) {
                return view('sales.show', ['sale' => $sale]);
            }

            return Redirect::back()->with(['info' => true ,'message' => 'No Such Invoice Found']);
        } catch (\Throwable $th) {
            return Redirect::route('dashboard')->with(['error' => true, 'message' => 'An unexpected error occured. Coudn\'t retrieve data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Redirect::route('sale.show', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return Redirect::route('sale.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $sale = DB::table('sales')->select(['product_id', 'unit'])->find($id);

            DB::table('sales')->delete($id);
            DB::table('products')->where('id', '=', $sale->product_id)->increment('stock', $sale->unit);

            DB::commit();

            return Redirect::route('sale.index')->with(['success' => true, 'message' => 'Product returned to inventory']);
        } catch (Exception $exception) {
            DB::rollBack();

            return Redirect::back()->with(['error' => true, 'message' => 'Unexpected error occured, couldn\'t return product.']);
        }
    }

    public function getSalesReport()
    {
        $data = [];

        $data['today'] = Carbon::today();
        $data['yesterday'] = Carbon::today()->subDay();
        $data['thisMonth'] = Carbon::today();
        $data['lastMonth'] = Carbon::today()->subMonth();

        try {
            $data['salesReportToday'] = DB::table('sales')->select(DB::raw('count(id) salesMade, sum(total) as revenue'))->whereDate('created_at', '=', $data['today']->format('Y-m-d'))->first();

            $data['salesReportYesterday'] = DB::table('sales')->select(DB::raw('count(id) salesMade, sum(total) as revenue'))->whereDate('created_at', '=', $data['yesterday']->format('Y-m-d'))->first();

            $data['salesReportThisMonth'] = DB::table('sales')->select(DB::raw('count(id) salesMade, sum(total) as revenue'))->whereMonth('created_at', '=', $data['thisMonth']->month)->whereYear('created_at', '=', $data['thisMonth']->year)->first();

            $data['salesReportLastMonth'] = DB::table('sales')->select(DB::raw('count(id) salesMade, sum(total) as revenue'))->whereMonth('created_at', '=', $data['lastMonth']->month)->whereYear('created_at', '=', $data['lastMonth']->year)->first();

            $data['salesReportHistorical'] = DB::table('sales')->select(DB::raw('count(id) salesMade, sum(total) as revenue'))->first();

            $data['topPerformerToday'] = DB::table('sales as s')->select(['p.id', 'p.title', DB::raw('sum(unit) unitSold, sum(total) revenue')])->join('products as p', 's.product_id', '=', 'p.id')->whereDate('s.created_at', '=', $data['today']->format('Y-m-d'))->groupBy('p.id')->orderBy('unitSold', 'desc')->limit(10)->get();

            $data['topPerformerYesterday'] = DB::table('sales as s')->select(['p.id', 'p.title', DB::raw('sum(unit) unitSold, sum(total) revenue')])->join('products as p', 's.product_id', '=', 'p.id')->whereDate('s.created_at', '=', $data['yesterday']->format('Y-m-d'))->groupBy('p.id')->orderBy('unitSold', 'desc')->limit(10)->get();

            $data['topPerformerThisMonth'] = DB::table('sales as s')->select(['p.id', 'p.title', DB::raw('sum(unit) unitSold, sum(total) revenue')])->join('products as p', 's.product_id', '=', 'p.id')->whereMonth('s.created_at', '=', $data['thisMonth']->month)->whereYear('s.created_at', '=', $data['thisMonth']->year)->groupBy('p.id')->orderBy('unitSold', 'desc')->limit(10)->get();

            $data['topPerformerLastMonth'] = DB::table('sales as s')->select(['p.id', 'p.title', DB::raw('sum(unit) unitSold, sum(total) revenue')])->join('products as p', 's.product_id', '=', 'p.id')->whereMonth('s.created_at', '=', $data['lastMonth']->month)->whereYear('s.created_at', '=', $data['lastMonth']->year)->groupBy('p.id')->orderBy('unitSold', 'desc')->limit(10)->get();

            $data['topPerformerHistorical'] = DB::table('sales as s')->select(['p.id', 'p.title', DB::raw('sum(unit) unitSold, sum(total) revenue')])->join('products as p', 's.product_id', '=', 'p.id')->groupBy('p.id')->orderBy('unitSold', 'desc')->limit(10)->get();

            return view('sales.report', $data);
        } catch (Exception $exception) {
            return Redirect::route('dashboard')->with(['error' => true, 'message' => 'An unexpected error occured. Coudn\'t retrieve data.']);
        }
    }
}
