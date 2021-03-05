<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

    protected $fillable = [
        'first_name', 'last_name', 'birth_day', 'student_code', 'sex', 'vnu_mail', 'other_mail', 'contact_1', 'contact_2'
    ];
}
