<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $max_total = 80000;

    protected $interest = 0.079;

    public function index()
    {
        $loans = Loan::all();
        return view('loans.list', ['loans' => $loans]);
    }

    public function create()
    {
        return view('loans.create');
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $client = Client::firstOrCreate(['name' => $data['client_name']]);
        $total = $client->loans()->sum('loan_amount');
        if ($total + (float)$data['amount'] > $this->max_total) {
            return redirect('loans.index')->with(['report' => sprintf('Общият брой на кредитите не трябва да надвишава %f', $this->max_total)]);
        }
        $loan_amount = (float)$data['amount'];
        $return_amount = $this->getReturnAmount($loan_amount, (float)$data['months']);
        $montly_payment = $return_amount / (int)$data['months'];
        $client->loans()->create([
            'loan_amount' => $data['amount'],
            'return_amount' => $return_amount,
            'remaining_amount' => $return_amount,
            'months' => $data['months'],
            'monthly_payment' => $montly_payment,
        ]);
        $client->save();
        return redirect('/')->with('report', 'Заемът е създаден успешно!');
    }

    protected function getReturnAmount(float $loan_amount, int $months): float
    {
        $principal_per_month = $loan_amount / $months;
        $remaining_amount = $loan_amount;
        $interest = 0;
        $full_years = floor($months / 12);
        $incomplete_year_months = $months % 12;
        for ($y = 0; $y < $full_years; $y++) {
            $interest += $remaining_amount * $this->interest;
            $remaining_amount -= $principal_per_month * 12;
        }
        if ($incomplete_year_months > 0) {
            $interest += $remaining_amount * $this->interest;
        }

        return $loan_amount + $interest;
    }
}
