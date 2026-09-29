<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $table = 'tr_statistics';
    protected $primaryKey = 'id_statistic';

    protected $fillable = [
        'id_player',
        'id_match',
        'minutes',
        'poin',
        'rebound',
        'assist',
        'steal',
        'block',
        'turnover',
        'fgm',
        'fga',
        'three_point_made',
        'three_point_attempted',
        'two_point_made',
        'two_point_attempted',
        'free_throw_made',
        'free_throw_attempted',
        'defensive_rebound',
        'foul',
        'plus_minus',
    ];

    /**
     * Kolom yang digunakan untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'id_statistic';
    }

    // =====================
    // Relationships
    // =====================

    /**
     * Statistik ini milik seorang pemain.
     */
    public function player()
    {
        return $this->belongsTo(Player::class, 'id_player', 'id_player');
    }

    /**
     * Statistik ini terkait satu pertandingan.
     */
    public function match()
    {
        return $this->belongsTo(MatchModel::class, 'id_match', 'id_match');
    }
}
