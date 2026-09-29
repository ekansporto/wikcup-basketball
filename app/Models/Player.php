<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'ms_players';
    protected $primaryKey = 'id_player';

    protected $fillable = [
        'id_user',
        'id_team',
        'nama',
        'no_punggung',
        'posisi',
        'foto',
        'tinggi_badan',
        'berat_badan',
        'kelas_program',
        'is_captain',
    ];

    protected $casts = [
        'is_captain'   => 'boolean',
        'tinggi_badan' => 'decimal:2',
        'berat_badan'  => 'decimal:2',
    ];

    /**
     * Kolom yang digunakan untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'id_player';
    }

    // =====================
    // Relationships
    // =====================

    /**
     * Player dimiliki oleh seorang user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Player tergabung dalam satu tim.
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'id_team', 'id_team');
    }

    /**
     * Player memiliki banyak statistik pertandingan.
     */
    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'id_player', 'id_player');
    }
}
