<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Img extends Model
{
    use HasFactory;
    protected $table = "imgs";
 
    protected $guarded = [

        'ade_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
    public function ads(): BelongsTo
    {
        return $this->belongsTo(Ads::class);
    }
}
