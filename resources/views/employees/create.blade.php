@extends('layout')

@section('content')
    <h1>test</h1>
    <ul>

        @include('employees._form', ['method' => 'post', 'action' => route('employees.store')])
    </ul>
@endSection
