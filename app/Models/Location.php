<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = ['plz', 'city', 'street', 'street_number', 'loc_desc'];

    public function vaccinations():HasMany{
        return $this->hasMany(Vaccination::class);
    }
}
