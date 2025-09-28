<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecurringTransaction;
use Illuminate\Http\Request;

class RecurringTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recurring_transactions = RecurringTransaction::with('category')->with('currency')->get();
        return response()->json([
            'recurringTransactions' => $recurring_transactions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'due_date'      => 'required|date',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'amount'        => 'required|numeric|min:0',
            'currency_id'   => 'required|exists:currencies,id',
            'category_id'   => 'required|exists:categories,id',
            'is_active'     => 'nullable|boolean',
        ]);

        $recurring_transaction = RecurringTransaction::create($validated);
        return response()->json([
            'recurringTransaction' => $recurring_transaction
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recurring_transaction = RecurringTransaction::with('category')->with('currency')->findOrFail($id);
        return response()->json($recurring_transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $recurring_transaction = RecurringTransaction::findOrFail($id);

        $validated = $request->validate([
            'due_date'      => 'sometimes|date',
            'name'          => 'sometimes|string|max:255',
            'description'   => 'nullable|string',
            'amount'        => 'sometimes|numeric|min:0',
            'currency_id'   => 'sometimes|exists:currencies,id',
            'category_id'   => 'sometimes|exists:categories,id',
            'is_active'     => 'nullable|boolean',
        ]);

        $recurring_transaction->update($validated);

        return response()->json([
            'recurringTransaction' => $recurring_transaction
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recurring_transaction = RecurringTransaction::findOrFail($id);
        $recurring_transaction->delete();

        return response()->json([
            'success' => true
        ], 200);
    }
}
