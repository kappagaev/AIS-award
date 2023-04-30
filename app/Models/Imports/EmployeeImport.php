<?php

namespace App\Models\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EmployeeImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $state_award = $row[4];
        $is_state_award = false;
        if (trim($state_award) != '' && $state_award) {
            $is_state_award = true;
        }

        return new Employee([
            'id' => $row[0],
            'name' => $row[1],
            'faculty' => $row[2],
            'award' => $row[3],
            'state_award' => $row[4],
            'protocol' => $row[5],
            'award_year' => $row[6],
            'state_award_year' => $row[7],
            'is_state_award' => $is_state_award,
        ]);
    }
}
