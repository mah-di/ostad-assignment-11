<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchVal = $request->q;

        try {
            if($searchVal) {
                $products = DB::table('products')->where('title', 'LIKE', "{$searchVal}%")->orWhere('title', 'LIKE', "% {$searchVal}%")->orWhere('serial_number', '=', $searchVal)->paginate(15, ['id', 'title', 'price', 'stock']);
            }
            else {
                $products = DB::table('products')->paginate(15, ['id', 'title', 'price', 'stock']);
            }

            return view('products.index', compact(['products', 'searchVal']));
        } catch (Exception $exception) {
            return Redirect::route('dashboard')->with(['error' => true, 'message' => 'An unexpected error occured. Coudn\'t retrieve data.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'serial_number' => 'required|alpha_num|max:8|unique:products,serial_number'
        ]);

        $validatedData['user_id'] = $request->user()->id;

        try {
            DB::table('products')->insert($validatedData);

            $status = ['success' => true, 'message' => 'Product added.'];
        } catch (Exception $exception) {
            $status = ['error' => true, 'message' => 'An unexpected error occured.'];
        }

        return Redirect::back()->with($status);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = DB::table('products')->find($id);

            if ($product) {
                return view('products.show', ['product' => $product]);
            }

            return Redirect::back()->with(['info' => true ,'message' => 'No Such Product Found']);
        } catch (Exception $exception) {
            return Redirect::route('dashboard')->with(['error' => true, 'message' => 'An unexpected error occured. Coudn\'t retrieve data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = DB::table('products')->find($id);

            if ($product) {
                return view('products.edit', ['product' => $product]);
            }

            return Redirect::back()->with(['info' => true ,'message' => 'No Such Product Found']);
        } catch (Exception $exception) {
            return Redirect::route('dashboard')->with(['error' => true, 'message' => 'An unexpected error occured. Coudn\'t retrieve data.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'current_stock' => 'required|numeric',
            'new_stock' => 'required|numeric|gte:0',
            'serial_number' => ['required', 'alpha_num', 'max:8', Rule::unique('products', 'serial_number')->ignore($id)]
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['current_stock'] + $validatedData['new_stock'],
            'serial_number' => $validatedData['serial_number']
        ];

        try {
            DB::table('products')->where('id', $id)->update($data);

            $status = ['success' => true, 'message' => 'Product updated.'];

            return Redirect::route('product.show', $id)->with($status);
        } catch (Exception $exception) {
            $status = ['error' => true, 'message' => 'An unexpected error occured.'];

            return Redirect::back()->with($status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::table('products')->delete($id);

            $status = ['success' => true, 'message' => 'Product was deleted.'];

            return Redirect::route('product.index')->with($status);
        } catch (Exception $exception) {
            $status = ['error' => true, 'message' => 'Unable to delete.'];

            return Redirect::back()->with($status);
        }
    }
}
