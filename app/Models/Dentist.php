<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dentist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(AppointmentSlot::class);
    }

    public function getNameAttribute(): string
    {
        return $this->user->name ?? 'Doctor';
    }
}
