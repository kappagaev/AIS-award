<?php 
namespace App\Models\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::all();
    }
    public function headings(): array
    {
        return ['№', "Призвіще, ім'я, по батькові співробітника", 'Факультет', 'Нагорода', 'Державна нагорода', 'Протокол', 'Рік нагороди', 'Рік державної нагороди'];

    }
}