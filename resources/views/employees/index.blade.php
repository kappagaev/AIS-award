<?php
use App\Models\Employee;

?>

@extends('layout')

@section('content')
    <h1>Таблиця</h1>
    <form method="get" action='/employees'>
        @foreach (Employee::$filterFields as $filterFieldName)
            <select class="selectpicker" multiple data-live-search="true" name="{{ $filterFieldName }}[]"
                title="{{ Employee::attributes()[$filterFieldName] }}">
                <?php
                $selected = app('request')->input($filterFieldName) ?? [];
                ?>
                @foreach (Employee::getUnique($filterFieldName) as $uniqueField)
                    <option value="{{ $uniqueField }}" @if (in_array($uniqueField, $selected)) selected @endif>{{ $uniqueField }}
                    </option>
                @endforeach
            </select>
        @endForeach

        <button class="btn btn-primary">Пошук</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Призвіще, ім'я, по батькові співробітника</th>
                <th scope="col">Факультет/ННІ</th>
                <th scope="col">Нагорода (Почесне звання, відзнака та грамота)</th>
                <th scope="col">Державна нагорода</th>
                <th scope="col">№ протоколу ВР КПІ ім. Ігоря Сікорського про відзначення</th>
                <th scope="col">Рік відзначення КПІ</th>
                <th scope="col">Рік призначення державою</th>
                <th scope="col">Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <th scope="row">{{ $employee->id }}</th>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->faculty }}</td>
                    <td>{{ $employee->award }}</td>
                    <td>{{ $employee->state_award }}</td>
                    <td>{{ $employee->protocol }}</td>
                    <td>{{ $employee->award_year }}</td>
                    <td>{{ $employee->state_award_year }}</td>
                    <td>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                </tr>
            @endForeach

        </tbody>

    </table>
@endSection
