<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    protected $table = "users";


    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $guarded = ['id'];


    public function ads(): HasMany
    {
        return $this->hasMany(Ads::class,'user_id','id');
    }
}
