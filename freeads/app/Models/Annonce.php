<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{

    use HasFactory;



    protected $fillable = [
        'titre',
        'description',
        'photo',
        'prix',
        'user_id',
    ];


    protected $casts = [
        'prix' => 'decimal:2',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }



    public function photoPrincipale()
    {
        return $this->photos()->where('is_principale', true)->first()
            ?? $this->photos()->orderBy('ordre', 'asc')->first();
    }



    public function getPhotoPrincipaleAttribute()
    {
        $photo = $this->photoPrincipale();
        if ($photo) {
            return $photo->chemin;
        }


        return $this->photo;
    }
}
