<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    protected $table = 'tr_matches';
    protected $primaryKey = 'id_match';

    protected $fillable = [
        'team_a_id',
        'team_b_id',
        'tanggal',
        'jam',
        'lokasi',
        'fase',
        'skor_tim_a',
        'skor_tim_b',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Kolom yang digunakan untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'id_match';
    }

    // =====================
    // Relationships
    // =====================

    /**
     * Tim A dalam pertandingan ini.
     */
    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id', 'id_team');
    }

    /**
     * Tim B dalam pertandingan ini.
     */
    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id', 'id_team');
    }

    /**
     * Pertandingan memiliki banyak statistik pemain.
     */
    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'id_match', 'id_match');
    }

    /**
     * Pertandingan memiliki banyak foto galeri.
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'id_match', 'id_match');
    }
}
