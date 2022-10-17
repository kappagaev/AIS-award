<?php
use App\Models\Employee;

$dropFields = ['name', 'faculty', 'award', 'state_award'];

?>
<form method="post" action="{{ $action }}">
    @if (isset($method))
        @method($method)
    @endif
    @csrf
    @foreach ($dropFields as $field)
        <div class="form-group">
            <div class="form-group">
                <label for="{{ $field }}">{{ Employee::attributes()[$field] }}</label>

                <input value="{{ $employee->$field ?? '' }}" id="{{ $field }}type="text" name="{{ $field }}"
                    class="form-control" list="{{ $field . '-datalist' }}" />
            </div>
            <datalist id="{{ $field . '-datalist' }}">
                @foreach (Employee::getUnique($field) as $uniqueField)
                    <option value="{{ $uniqueField }}">
                        {{ $uniqueField }}
                    </option>
                @endforeach
            </datalist>

        </div>
    @endForeach

    <div class="form-group">
        <label for="protocol">№ протоколу ВР КПІ ім. Ігоря Сікорського про відзначення</label>
        <input type="text" class="form-control" id="protocol" name="protocol"
            value="{{ $employee->protocol ?? '' }}">
    </div>
    <div class="form-group">
        <label for="award_year">Рік відзначення КПІ</label>
        <input type="number" min="1990" max="2022" class="form-control" id="award_year" name="award_year"
            value="{{ $employee->award_year ?? '2022' }}">
    </div>
    <div class="form-group">
        <label for="state_award_year">Рік призначення державою</label>
        <input type="number" min="1990" max="2022" class="form-control" id="state_award_year"
            name="state_award_year" value="{{ $employee->state_award_year ?? '2022' }}">
    </div>
    <button type="submit" class="btn btn-success">Відправити</button>
</form>
