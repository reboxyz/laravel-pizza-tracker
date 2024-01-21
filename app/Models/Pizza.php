<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $guarded = []; // Note! Since we don't set any field, all values are fillable

    /*
    protected $fillable = [
        'size', 'crust', 'toppings', 'status', 'user_id'
    ];
    */

    protected $hidden = [
        'user', // Note! getChefAttribute() inadvertently exposed 'user'. Thus, we need to hide 'user' 
    ];

    protected $casts = [ 
        'toppings' => 'array', // Note! array in the frontend but serialized to json in the backend/db
    ];

    // Note! These represent computed properties
    protected $appends = [
       'chef',  // getChefAttribute()
       'last_updated',  // getLastUpdatedAttribute
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getChefAttribute()
    {
        return $this->user->name;
    }

    public function getLastUpdatedAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }
}
