<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'tr_galleries';
    protected $primaryKey = 'id_gallery';

    protected $fillable = [
        'id_match',
        'foto',
        'caption',
        'kategori',
        'badge_text',
        'tag_text',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Kolom yang digunakan untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'id_gallery';
    }

    // =====================
    // Relationships
    // =====================

    /**
     * Foto galeri ini terkait satu pertandingan (nullable).
     */
    public function match()
    {
        return $this->belongsTo(MatchModel::class, 'id_match', 'id_match');
    }
}
