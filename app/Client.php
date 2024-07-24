<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
    ];

    /**
     * Attributes to append to the model.
     *
     * @var string[]
     */
    protected $appends = [
        'url',
        'bookings_count'
    ];

    /**
     * Get Bookings relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get Journals relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * Relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookings count.
     *
     * @return int
     */
    public function getBookingsCountAttribute(): int
    {
        return $this->bookings()
            ->count();
    }

    /**
     * Get the url attribute.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return "/clients/".$this->id;
    }
}
