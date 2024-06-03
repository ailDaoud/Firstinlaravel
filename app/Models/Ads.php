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
    protected $fillable = ['name', 'describtion', 'amount', 'price', 'note', 'user_id', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $guarded = [
        'id'
    ];
    public function images(): HasMany
    {
        return $this->hasMany(Img::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
