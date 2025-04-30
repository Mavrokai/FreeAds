<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;



    protected $fillable = [
        'chemin',
        'is_principale',
        'ordre',
        'annonce_id'
    ];



    protected $casts = [
        'is_principale' => 'boolean',
    ];



    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}
