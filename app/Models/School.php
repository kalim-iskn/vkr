<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\School
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class School extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function getShortNameAttribute(): string
    {
        $number = preg_replace("/[^0-9]/", '', $this->name);

        return "Школа №$number";
    }
}
