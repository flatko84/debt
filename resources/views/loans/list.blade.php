@extends('layouts.main')

@section('content')
@if(session()->has('report'))
{{ session('report') }}
@endif
<a href="{{ route('loans_create') }}">Нов кредит</a><a href="{{ route('payments_create') }}">Ново плащане</a>

<table>
    <thead>
        <tr>
            <td>Получател</td>
            <td>Сума</td>
            <td>Срок</td>
            <td>Вноска</td>
        </tr>
    </thead>
    <tbody>
        @foreach($loans as $loan)
        <tr>
            <td>{{ $loan->client->name }}</td>
            <td>{{ $loan->loan_amount }}</td>
            <td>{{ $loan->months }}</td>
            <td>{{ $loan->monthly_payment }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection