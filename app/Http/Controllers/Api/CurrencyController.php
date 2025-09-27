<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();
        return response()->json([
            'currencies' => $currencies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'               => 'required|string|size:3|unique:currencies,code',
            'name'               => 'required|string|max:255',
            'symbol'             => 'required|string|max:5',
            'decimal_separator'  => 'nullable|string|in:.,,|size:1',
            'thousand_separator' => 'nullable|string|in:.,, ,_|size:1',
            'decimal_places'     => 'nullable|integer|min:0|max:8',
            'is_active'          => 'nullable|boolean',
        ]);

        $currency = Currency::create($validated);
        return response()->json([
            'currency' => $currency
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currency = Currency::findOrFail($id);
        return response()->json($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $currency = Currency::findOrFail($id);

        $validated = $request->validate([
            'code'               => 'sometimes|string|size:3|unique:currencies,code,' . $currency->id,
            'name'               => 'sometimes|string|max:255',
            'symbol'             => 'sometimes|string|max:5',
            'decimal_separator'  => 'sometimes|string|in:.,,|size:1',
            'thousand_separator' => 'sometimes|string|in:.,, ,_|size:1',
            'decimal_places'     => 'sometimes|integer|min:0|max:8',
            'is_active'          => 'sometimes|boolean',
        ]);

        $currency->update($validated);

        return response()->json([
            'currency' => $currency
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();

        return response()->json([
            'success' => true
        ], 200);
    }
}
