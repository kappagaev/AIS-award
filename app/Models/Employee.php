<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $timestamps = false;
    // $table->string('name');
    // $table->string('faculty');
    // $table->string('award');
    // $table->string('state_award');
    // $table->integer('award_year');
    // $table->integer('state_award_year');
    protected $fillable = [
        'name',
        'faculty',
        'award',
        'state_award',
        'protocol',
        'award_year',
        'state_award_year'
    ];
    public static function getUnique($field) {
        $employees = Employee::all();
        $unique = [];
        foreach ($employees as $employee) {
            $unique[] = $employee->$field;
        }
        
        return array_unique($unique);
    }
    
    public static $filterFields = [
        'name',
        'faculty',
        'award',
        'state_award',
        'award_year',
        'state_award_year'
    ];

    public static function attributes() {
        return [
            'name' => "Призвіще, ім'я, по батькові співробітника",
            'faculty' => 'Факультет/ННІ',
            'award' => 'Нагорода (Почесне звання, відзнака та грамота)',
            'state_award'=> 'Державна нагорода',
            'award_year'=> 'Рік відзначення КПІ',
            'state_award_year'=> 'Рік призначення державою'
        ];
    }
}
