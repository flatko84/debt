@extends('layouts.main')

@section('content')
<form method=post action="{{ route('loans_store') }}">
    @csrf
    Име: <input type=text name="client_name"><br>
    Сума: <input type=number name="amount" step="0.01"><br>
    Срок: <input type=number name="months" min="3" max="120"><br>
    <input type=submit value="Създай">
</form>
@endsection