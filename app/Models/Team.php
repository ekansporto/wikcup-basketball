<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'ms_teams';
    protected $primaryKey = 'id_team';

    protected $fillable = [
        'nama_tim',
        'nickname',
        'singkatan',
        'warna',
        'kategori',
        'logo',
    ];

    /**
     * Kolom yang digunakan untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'id_team';
    }

    // =====================
    // Relationships
    // =====================

    /**
     * Tim memiliki banyak pemain.
     */
    public function players()
    {
        return $this->hasMany(Player::class, 'id_team', 'id_team');
    }

    /**
     * Pertandingan di mana tim ini sebagai Tim A.
     */
    public function matchesAsTeamA()
    {
        return $this->hasMany(MatchModel::class, 'team_a_id', 'id_team');
    }

    /**
     * Pertandingan di mana tim ini sebagai Tim B.
     */
    public function matchesAsTeamB()
    {
        return $this->hasMany(MatchModel::class, 'team_b_id', 'id_team');
    }
}
