@extends('layouts.main')

@section('content')
<form method=post action="{{ route('payments_store') }}">
    @csrf
    Кредит: <select name="loan">
        @foreach($loans as $loan)
            <option value="{{ $loan->id }}">{{ $loan->id }} ({{ $loan->client->name }})</option>
        @endforeach
        </select><br>
    Сума: <input type=number name="amount" step="0.01"><br>
    <input type=submit value="Плати">
</form>
@endsection