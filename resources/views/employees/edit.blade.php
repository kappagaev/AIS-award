@extends('layout')

@section('content')
    <h1>test</h1>
    <ul>

        @include('employees._form', [
            'method' => 'PUT',
            'employee' => $employee,
            'action' => route('employees.update', $employee->id),
        ])
    </ul>
@endSection
