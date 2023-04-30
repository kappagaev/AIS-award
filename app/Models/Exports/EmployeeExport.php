<?php
namespace App\Models\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::all()->map(function ($employee) {
            if($employee->is_state_award) {
                return [
                    $employee->id,
                    $employee->name,
                    $employee->faculty,
                    '', // 'award
                    $employee->state_award,
                    $employee->protocol,
                    $employee->award_year,
                ];
            } else {
                return [
                    $employee->id,
                    $employee->name,
                    $employee->faculty,
                    $employee->award,
                    '', // 'state_award
                    $employee->protocol,
                    $employee->award_year,
                ];
            }
        });
    }
    public function headings(): array
    {
        return ['№', "Призвіще, ім'я, по батькові співробітника", 'Факультет', 'Нагорода', 'Державна нагорода', 'Протокол', 'Рік нагороди'];
    }
}
