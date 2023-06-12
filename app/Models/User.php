<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $login
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property bool|null $sex
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property School|null $school
 * @property Carbon|null $birthday
 * @property string|null $class
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, "school_id");
    }
}
