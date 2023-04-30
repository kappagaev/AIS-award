<?php

use App\Models\Employee;

$suggestFields = ['name'];
$dropFields = ['faculty', 'award', 'state_award'];

$faculties = ['ІАТ', 'ІАТЕ', 'ІЕЕ', 'ІМЗ', 'ІПСА', 'ІТС', 'ММІ', 'ФТІ', 'ІХФ', 'ПБФ', 'РТФ', 'ФБМІ', 'ФБТ', 'ФЕА', 'ФЕЛ', 'ФІОТ', 'ФЛ', 'ФММ', 'ФМФ', 'ФПМ', 'ФСП', 'ХТФ', 'ІСЗЗІ'];

$awards = ['Грамота Вченої ради (№ протоколу ВР КПІ)', 'Почесна грамота Вченої ради (№ протоколу ВР КПІ)', 'Почесна відзнака Вченої ради (№ протоколу ВР КПІ)', 'почесне звання «Заслужений викладач КПІ» (№ протоколу ВР КПІ)', 'почесне звання «Заслужений професор КПІ» (№ протоколу ВР КПІ)', 'почесне звання «Заслужений науковець КПІ» (№ протоколу ВР КПІ)', 'почесне звання «Заслужений працівник КПІ» (№ протоколу ВР КПІ)', 'почесна відзнака «Видатний діяч КПІ» (№ протоколу ВР КПІ)', 'почесне звання «Почесний доктор КПІ» (№ протоколу ВР КПІ)', 'почесна відзнака «За служіння та відданість КПІ» (№ протоколу ВР КПІ)', 'почесна відзнака «За заслуги  перед КПІ» (№ протоколу ВР КПІ)'];
$stateAwards = ['Подяка МОН України', 'Грамота МОН України', 'Почесна грамота МОН України', 'нагрудний знак «Відмінник освіти»', 'почесне звання «Заслужений діяч науки і техніки України»', 'Подяка КМ України', 'Грамота КМ України'];

?>
<form method="post" action="{{ $action }}">
    @if (isset($method))
    @method($method)
    @endif
    @csrf
    @foreach ($suggestFields as $field)
    <div class="form-group">
        <div class="form-group">
            <label for="{{ $field }}">{{ Employee::attributes()[$field] }}</label>

            <input value="{{ $employee->$field ?? '' }}" id="{{ $field }}type=" text" name="{{ $field }}" class="form-control" list="{{ $field . '-datalist' }}" />
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
        <label for="faculty">{{ Employee::attributes()['faculty'] }}</label>
        <select name="faculty" id="faculty" class="form-control">
            @foreach ($faculties as $faculty)
            <option value="{{ $faculty }}" @if (isset($employee) && $employee->faculty == $faculty) selected @endif>
                {{ $faculty }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="is_state_award">Тип нагороди</label>
        <select id="is_state_award" name="is_state_award" class="form-control">
            <option value="0" @if (isset($employee) && $employee->is_state_award) selected @endif>Нагорода</option>
            <option value="1"@if (isset($employee) && $employee->is_state_award) selected @endif>Державна нагорода</option>
        </select>
    </div>

    <div class="form-group">
        <label for="award" id="award_lable">{{ Employee::attributes()['award'] }}</label>
        <select name="award" id="award" class="form-control">
            @foreach ($awards as $award)
            <option value="{{ $award }}" @if (isset($employee) && $employee->award == $award) selected @endif>
                {{ $award }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="stateAward" id="state_award_lable">{{ Employee::attributes()['state_award'] }}</label>
        <select name="state_award" id="stateAward" class="form-control">
            @foreach ($stateAwards as $state_award)
            <option value="{{ $state_award }}" @if (isset($employee) && $employee->state_award == $state_award) selected @endif>
                {{ $state_award }}
            </option>
            @endforeach
        </select>

        <div class="form-group">
            <label for="protocol">№ протоколу ВР КПІ ім. Ігоря Сікорського про відзначення</label>
            <input type="text" class="form-control" id="protocol" name="protocol" value="{{ $employee->protocol ?? '' }}">
        </div>
        <div class="form-group">
            <label for="award_year">Рік відзначення</label>
            <input type="number" min="1990" max="2022" class="form-control" id="award_year" name="award_year" value="{{ $employee->award_year ?? '2022' }}">
        </div>
        <button type="submit" class="btn btn-success">Відправити</button>
</form>

<script>

const changeAwards = (type) => {
    console.log(type);
    if (type === "0") {
        $("#award").show();
        $("#stateAward").hide();

        $("#award_lable").show();
        $("#state_award_lable").hide();
    } else {
        $("#award").hide();
        $("#stateAward").show();

        $("#award_lable").hide();
        $("#state_award_lable").show();
    }
}
$("#is_state_award").on("change", () => {
    const type = $("#is_state_award").val();
    changeAwards(type);
})
changeAwards($("#is_state_award").val());
</script>
