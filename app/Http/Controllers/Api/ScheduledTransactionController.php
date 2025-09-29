<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecurringTransaction;
use App\Models\ScheduledTransaction;
use Illuminate\Http\Request;

class ScheduledTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduled_transactions = ScheduledTransaction::with('category')->with('currency')->with('recurringTransaction')->get();
        return response()->json([
            'scheduledTransactions' => $scheduled_transactions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'due_date'                  => 'required|date',
            'name'                      => 'required_without:recurring_transaction_id|string|max:255',
            'description'               => 'nullable|string',
            'amount'                    => 'required_without:recurring_transaction_id|numeric|min:0',
            'currency_id'               => 'required_without:recurring_transaction_id|exists:currencies,id',
            'category_id'               => 'required_without:recurring_transaction_id|exists:categories,id',
            'recurring_transaction_id'  => 'nullable|exists:recurring_transactions,id',
        ]);

        if (!empty($validated['recurring_transaction_id'])) {
            //Pesquisa o RecurringTransaction, caso seja enviado do formulário
            $recurring = RecurringTransaction::findOrFail($validated['recurring_transaction_id']);
            // Preencher os campos a partir do modelo
            $validated['name']        = $recurring->name;
            $validated['amount']      = $recurring->amount;
            $validated['currency_id'] = $recurring->currency_id;
            $validated['category_id'] = $recurring->category_id;
        }

        $scheduled_transactions = ScheduledTransaction::create($validated);
        return response()->json([
            'scheduledTransaction' => $scheduled_transactions
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scheduled_transaction = ScheduledTransaction::with('category')->with('currency')->with('recurringTransaction')->findOrFail($id);
        return response()->json($scheduled_transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $scheduled_transaction = ScheduledTransaction::findOrFail($id);

        $validated = $request->validate([
            'due_date'                  => 'sometimes|date',
            'name'                      => 'sometimes|string|max:255',
            'description'               => 'nullable|string',
            'amount'                    => 'sometimes|numeric|min:0',
            'currency_id'               => 'sometimes|exists:currencies,id',
            'category_id'               => 'sometimes|exists:categories,id',
            'recurring_transaction_id'  => 'sometimes|exists:recurring_transactions,id',
        ]);

        $scheduled_transaction->update($validated);

        return response()->json([
            'scheduledTransaction' => $scheduled_transaction
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scheduled_transaction = ScheduledTransaction::findOrFail($id);
        $scheduled_transaction->delete();

        return response()->json([
            'success' => true
        ], 200);
    }
}
