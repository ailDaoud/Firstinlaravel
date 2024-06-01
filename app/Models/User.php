<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    protected $table = "users";

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone-number',
        'address',
        'is_active',
        'verify_email',
        'verify_number'
    ];
    protected $casts=[
        'is_active'=>'boolean'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden=['created_at', 'updated_at'];

    public function ads():HasMany{
        return $this->hasMant(Ads::class);
    }
}
