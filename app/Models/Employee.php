<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'job_position',
        'birth_date',
        'address',
    ];

    /**
     * Get the skills for the employees.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('qualify');;
    }

}
