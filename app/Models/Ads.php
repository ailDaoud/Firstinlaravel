<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    protected $table = "ads";

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $guarded = [
        'id'
    ];
    public function images(): HasMany
    {
        return $this->hasMany(Img::class,'ade_id','id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
