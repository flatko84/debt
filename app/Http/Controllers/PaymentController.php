<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function create()
    {
        $loans = Loan::all();
        return view('payments.create', ['loans' => $loans]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $loan = Loan::where('id', $data['loan'])->first();
        $remaining = (float)$loan->remaining_amount;
        if ((float)$data['amount'] <= $remaining) {
            $amount = (float)$data['amount'];
            $report = 'Вноската е успешна.';
        } else {
            $amount = $remaining;
            $report = sprintf('Внесени са %f лв.', $remaining);
        }
        $loan->payments()->create([
            'amount' => $amount,
        ]);
        $loan->remaining_amount -= $amount;
        $loan->save();
        return redirect('/')->with('report', $report);
    }
}
