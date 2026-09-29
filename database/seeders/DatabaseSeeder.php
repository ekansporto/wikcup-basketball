<?php

namespace Database\Seeders;

use App\Models\MatchModel;
use App\Models\Team;
use App\Models\Player;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@wikcup.com'],
            [
                'name'     => 'Administrator WikCup',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // 1. Exact 9 Teams from reference
        $t1 = Team::updateOrCreate(['nama_tim' => 'SMA Kesatuan', 'nickname' => 'Knights'], [
            'singkatan' => 'SK',
            'warna'     => '#0F172A',
            'kategori'  => 'Putra',
        ]);

        $t2 = Team::updateOrCreate(['nama_tim' => 'SMA Kesatuan', 'nickname' => 'Sparks'], [
            'singkatan' => 'SS',
            'warna'     => '#0F172A',
            'kategori'  => 'Putri',
        ]);

        $t3 = Team::updateOrCreate(['nama_tim' => 'SMA Regina Pacis', 'nickname' => 'Warriors'], [
            'singkatan' => 'SW',
            'warna'     => '#0F172A',
            'kategori'  => 'Putra',
        ]);

        $t4 = Team::updateOrCreate(['nama_tim' => 'SMAN 1 Bogor', 'nickname' => 'Eagles'], [
            'singkatan' => 'SE',
            'warna'     => '#0F172A',
            'kategori'  => 'Putra',
        ]);

        $t5 = Team::updateOrCreate(['nama_tim' => 'SMAN 1 Bogor', 'nickname' => 'Sirens'], [
            'singkatan' => 'SS',
            'warna'     => '#0F172A',
            'kategori'  => 'Putri',
        ]);

        $t6 = Team::updateOrCreate(['nama_tim' => 'SMK Wikrama', 'nickname' => 'Hawks'], [
            'singkatan' => 'SH',
            'warna'     => '#0F172A',
            'kategori'  => 'Putra',
        ]);

        $t7 = Team::updateOrCreate(['nama_tim' => 'SMK Wikrama', 'nickname' => 'Queens'], [
            'singkatan' => 'SQ',
            'warna'     => '#0F172A',
            'kategori'  => 'Putri',
        ]);

        $t8 = Team::updateOrCreate(['nama_tim' => 'SMK Wikrama', 'nickname' => 'Thunder'], [
            'singkatan' => 'ST',
            'warna'     => '#0F172A',
            'kategori'  => 'Putra',
        ]);

        $t9 = Team::updateOrCreate(['nama_tim' => 'SMP Negeri 2 Ciawi', 'nickname' => ''], [
            'singkatan' => 'S2',
            'warna'     => '#F1F5F9',
            'kategori'  => 'Putra',
        ]);

        // Clean redundant dummy teams if any
        Team::whereNotIn('id_team', [$t1->id_team, $t2->id_team, $t3->id_team, $t4->id_team, $t5->id_team, $t6->id_team, $t7->id_team, $t8->id_team, $t9->id_team])->delete();

        Statistic::query()->delete();
        Player::query()->delete();
        MatchModel::query()->delete();

        // 2. Upcoming matches (Jadwal)
        MatchModel::create([
            'team_a_id' => $t6->id_team,
            'team_b_id' => $t3->id_team,
            'tanggal'   => '2026-09-25',
            'jam'       => '15:30:00',
            'lokasi'    => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
        ]);

        MatchModel::create([
            'team_a_id' => $t8->id_team,
            'team_b_id' => $t1->id_team,
            'tanggal'   => '2026-09-26',
            'jam'       => '22:30:00',
            'lokasi'    => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
        ]);

        MatchModel::create([
            'team_a_id' => $t7->id_team,
            'team_b_id' => $t2->id_team,
            'tanggal'   => '2026-09-27',
            'jam'       => '14:00:00',
            'lokasi'    => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
        ]);

        MatchModel::create([
            'team_a_id' => $t4->id_team,
            'team_b_id' => $t8->id_team,
            'tanggal'   => '2026-09-28',
            'jam'       => '16:30:00',
            'lokasi'    => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
        ]);

        // 3. Completed matches (Hasil)
        $m1 = MatchModel::create([
            'team_a_id'  => $t7->id_team, // SMK Wikrama Queens
            'team_b_id'  => $t2->id_team, // SMA Kesatuan Sparks
            'tanggal'    => '2026-09-22',
            'jam'        => '16:00:00',
            'lokasi'     => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
            'skor_tim_a' => 52,
            'skor_tim_b' => 50,
        ]);

        $m2 = MatchModel::create([
            'team_a_id'  => $t1->id_team, // SMA Kesatuan Knights
            'team_b_id'  => $t8->id_team, // SMK Wikrama Thunder
            'tanggal'    => '2026-09-22',
            'jam'        => '18:30:00',
            'lokasi'     => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
            'skor_tim_a' => 66,
            'skor_tim_b' => 70,
        ]);

        $m3 = MatchModel::create([
            'team_a_id'  => $t7->id_team, // SMK Wikrama Queens
            'team_b_id'  => $t5->id_team, // SMAN 1 Bogor Sirens
            'tanggal'    => '2026-09-21',
            'jam'        => '15:30:00',
            'lokasi'     => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
            'skor_tim_a' => 48,
            'skor_tim_b' => 44,
        ]);

        $m4 = MatchModel::create([
            'team_a_id'  => $t4->id_team, // SMAN 1 Bogor Eagles
            'team_b_id'  => $t3->id_team, // SMA Regina Pacis Warriors
            'tanggal'    => '2026-09-20',
            'jam'        => '17:00:00',
            'lokasi'     => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
            'skor_tim_a' => 58,
            'skor_tim_b' => 62,
        ]);

        $m5 = MatchModel::create([
            'team_a_id'  => $t8->id_team, // SMK Wikrama Thunder
            'team_b_id'  => $t6->id_team, // SMK Wikrama Hawks
            'tanggal'    => '2026-09-19',
            'jam'        => '16:30:00',
            'lokasi'     => 'Lapangan Utama SMK Wikrama',
            'fase'      => 'Fase Grup & Penyisihan',
            'skor_tim_a' => 72,
            'skor_tim_b' => 65,
        ]);

        // 4. Exact 23 Players & Stats records
        $statsRows = [
            // Row 1
            [
                'team' => $t2, 'match' => $m1, 'nama' => 'Nadine Samantha', 'no' => 15, 'posisi' => 'Center',
                'min' => '00:30:00', 'pts' => 15, 'reb' => 14, 'ast' => 2, 'stl' => 1, 'blk' => 2, 'to' => 2, 'fgm' => 6, 'fga' => 11, '3pm' => 0, '3pa' => 0
            ],
            // Row 2
            [
                'team' => $t2, 'match' => $m1, 'nama' => 'Valerie Michelle', 'no' => 10, 'posisi' => 'Shooting Guard',
                'min' => '00:33:00', 'pts' => 21, 'reb' => 4, 'ast' => 4, 'stl' => 3, 'blk' => 1, 'to' => 3, 'fgm' => 8, 'fga' => 15, '3pm' => 3, '3pa' => 7
            ],
            // Row 3
            [
                'team' => $t7, 'match' => $m1, 'nama' => 'Siti Nurhaliza', 'no' => 5, 'posisi' => 'Point Guard',
                'min' => '00:31:30', 'pts' => 20, 'reb' => 6, 'ast' => 7, 'stl' => 3, 'blk' => 0, 'to' => 2, 'fgm' => 7, 'fga' => 13, '3pm' => 2, '3pa' => 4
            ],
            // Row 4
            [
                'team' => $t8, 'match' => $m2, 'nama' => 'Dimas Saputra', 'no' => 11, 'posisi' => 'Small Forward',
                'min' => '00:29:00', 'pts' => 16, 'reb' => 5, 'ast' => 8, 'stl' => 3, 'blk' => 0, 'to' => 2, 'fgm' => 6, 'fga' => 12, '3pm' => 2, '3pa' => 5
            ],
            // Row 5
            [
                'team' => $t3, 'match' => $m4, 'nama' => 'Rama Pratama', 'no' => 9, 'posisi' => 'Point Guard',
                'min' => '00:34:45', 'pts' => 20, 'reb' => 5, 'ast' => 4, 'stl' => 2, 'blk' => 0, 'to' => 1, 'fgm' => 7, 'fga' => 14, '3pm' => 3, '3pa' => 6
            ],
            // Row 6
            [
                'team' => $t3, 'match' => $m4, 'nama' => 'Reza Ardiansyah', 'no' => 3, 'posisi' => 'Shooting Guard',
                'min' => '00:33:10', 'pts' => 26, 'reb' => 6, 'ast' => 10, 'stl' => 5, 'blk' => 1, 'to' => 2, 'fgm' => 9, 'fga' => 15, '3pm' => 3, '3pa' => 5
            ],
            // Row 7
            [
                'team' => $t4, 'match' => $m4, 'nama' => 'Galih Sanjaya', 'no' => 4, 'posisi' => 'Point Guard',
                'min' => '00:28:00', 'pts' => 15, 'reb' => 5, 'ast' => 3, 'stl' => 2, 'blk' => 0, 'to' => 2, 'fgm' => 6, 'fga' => 13, '3pm' => 2, '3pa' => 5
            ],
            // Row 8
            [
                'team' => $t4, 'match' => $m4, 'nama' => 'Aldy Reyhan', 'no' => 10, 'posisi' => 'Center',
                'min' => '00:35:00', 'pts' => 31, 'reb' => 8, 'ast' => 4, 'stl' => 4, 'blk' => 2, 'to' => 3, 'fgm' => 11, 'fga' => 21, '3pm' => 5, '3pa' => 9
            ],
            // Rows 9 to 23 for full 23 records:
            [
                'team' => $t7, 'match' => $m1, 'nama' => 'Aulia Zahra', 'no' => 23, 'posisi' => 'Small Forward',
                'min' => '00:27:00', 'pts' => 14, 'reb' => 7, 'ast' => 3, 'stl' => 2, 'blk' => 1, 'to' => 1, 'fgm' => 5, 'fga' => 10, '3pm' => 1, '3pa' => 3
            ],
            [
                'team' => $t7, 'match' => $m1, 'nama' => 'Dinda Maharani', 'no' => 34, 'posisi' => 'Power Forward',
                'min' => '00:24:00', 'pts' => 10, 'reb' => 9, 'ast' => 1, 'stl' => 1, 'blk' => 2, 'to' => 2, 'fgm' => 4, 'fga' => 8, '3pm' => 0, '3pa' => 1
            ],
            [
                'team' => $t7, 'match' => $m1, 'nama' => 'Kayla Anindya', 'no' => 15, 'posisi' => 'Center',
                'min' => '00:26:00', 'pts' => 8, 'reb' => 11, 'ast' => 1, 'stl' => 0, 'blk' => 3, 'to' => 1, 'fgm' => 3, 'fga' => 6, '3pm' => 0, '3pa' => 0
            ],
            [
                'team' => $t1, 'match' => $m2, 'nama' => 'Michael Chen', 'no' => 7, 'posisi' => 'Point Guard',
                'min' => '00:32:00', 'pts' => 24, 'reb' => 4, 'ast' => 7, 'stl' => 3, 'blk' => 0, 'to' => 3, 'fgm' => 9, 'fga' => 18, '3pm' => 3, '3pa' => 8
            ],
            [
                'team' => $t8, 'match' => $m2, 'nama' => 'Rizky Pratama', 'no' => 10, 'posisi' => 'Point Guard',
                'min' => '00:34:00', 'pts' => 25, 'reb' => 5, 'ast' => 9, 'stl' => 4, 'blk' => 1, 'to' => 2, 'fgm' => 9, 'fga' => 17, '3pm' => 4, '3pa' => 8
            ],
            [
                'team' => $t8, 'match' => $m2, 'nama' => 'Bintang Ramadhan', 'no' => 24, 'posisi' => 'Shooting Guard',
                'min' => '00:30:00', 'pts' => 18, 'reb' => 6, 'ast' => 3, 'stl' => 2, 'blk' => 0, 'to' => 1, 'fgm' => 7, 'fga' => 14, '3pm' => 3, '3pa' => 6
            ],
            [
                'team' => $t8, 'match' => $m2, 'nama' => 'Kevin Sanjaya', 'no' => 55, 'posisi' => 'Center',
                'min' => '00:28:00', 'pts' => 11, 'reb' => 13, 'ast' => 2, 'stl' => 1, 'blk' => 4, 'to' => 2, 'fgm' => 5, 'fga' => 9, '3pm' => 0, '3pa' => 0
            ],
            [
                'team' => $t5, 'match' => $m3, 'nama' => 'Clarissa Aurelia', 'no' => 9, 'posisi' => 'Point Guard',
                'min' => '00:31:00', 'pts' => 19, 'reb' => 3, 'ast' => 6, 'stl' => 3, 'blk' => 0, 'to' => 2, 'fgm' => 7, 'fga' => 14, '3pm' => 2, '3pa' => 5
            ],
            [
                'team' => $t5, 'match' => $m3, 'nama' => 'Amanda Putri', 'no' => 17, 'posisi' => 'Small Forward',
                'min' => '00:29:00', 'pts' => 15, 'reb' => 6, 'ast' => 2, 'stl' => 2, 'blk' => 1, 'to' => 3, 'fgm' => 6, 'fga' => 13, '3pm' => 1, '3pa' => 4
            ],
            [
                'team' => $t5, 'match' => $m3, 'nama' => 'Tiara Maharani', 'no' => 25, 'posisi' => 'Center',
                'min' => '00:26:00', 'pts' => 10, 'reb' => 10, 'ast' => 1, 'stl' => 1, 'blk' => 2, 'to' => 1, 'fgm' => 4, 'fga' => 8, '3pm' => 0, '3pa' => 0
            ],
            [
                'team' => $t6, 'match' => $m5, 'nama' => 'Farhan Nugraha', 'no' => 4, 'posisi' => 'Point Guard',
                'min' => '00:33:00', 'pts' => 22, 'reb' => 4, 'ast' => 8, 'stl' => 3, 'blk' => 0, 'to' => 2, 'fgm' => 8, 'fga' => 16, '3pm' => 3, '3pa' => 7
            ],
            [
                'team' => $t6, 'match' => $m5, 'nama' => 'Bima Sakti', 'no' => 15, 'posisi' => 'Shooting Guard',
                'min' => '00:30:00', 'pts' => 20, 'reb' => 5, 'ast' => 3, 'stl' => 2, 'blk' => 0, 'to' => 2, 'fgm' => 7, 'fga' => 14, '3pm' => 3, '3pa' => 6
            ],
            [
                'team' => $t6, 'match' => $m5, 'nama' => 'Eka Nurfitria', 'no' => 21, 'posisi' => 'Small Forward',
                'min' => '00:27:00', 'pts' => 14, 'reb' => 7, 'ast' => 2, 'stl' => 1, 'blk' => 1, 'to' => 1, 'fgm' => 5, 'fga' => 11, '3pm' => 1, '3pa' => 3
            ],
            [
                'team' => $t8, 'match' => $m5, 'nama' => 'Fajar Santoso', 'no' => 11, 'posisi' => 'Small Forward',
                'min' => '00:29:00', 'pts' => 17, 'reb' => 7, 'ast' => 4, 'stl' => 2, 'blk' => 1, 'to' => 2, 'fgm' => 6, 'fga' => 12, '3pm' => 2, '3pa' => 4
            ],
            [
                'team' => $t8, 'match' => $m5, 'nama' => 'Dimas Arya', 'no' => 33, 'posisi' => 'Power Forward',
                'min' => '00:25:00', 'pts' => 12, 'reb' => 10, 'ast' => 1, 'stl' => 1, 'blk' => 2, 'to' => 1, 'fgm' => 5, 'fga' => 9, '3pm' => 0, '3pa' => 1
            ],
        ];

        foreach ($statsRows as $sr) {
            $player = Player::firstOrCreate([
                'id_team'     => $sr['team']->id_team,
                'nama'        => $sr['nama'],
            ], [
                'no_punggung' => $sr['no'],
                'posisi'      => $sr['posisi'],
                'tinggi_badan'=> 180,
                'berat_badan' => 70,
                'kelas_program'=> 'PPLG',
            ]);

            Statistic::create([
                'id_player'              => $player->id_player,
                'id_match'               => $sr['match']->id_match,
                'minutes'                => $sr['min'],
                'poin'                   => $sr['pts'],
                'rebound'                => $sr['reb'],
                'assist'                 => $sr['ast'],
                'steal'                  => $sr['stl'],
                'block'                  => $sr['blk'],
                'turnover'               => $sr['to'],
                'fgm'                    => $sr['fgm'],
                'fga'                    => $sr['fga'],
                'three_point_made'       => $sr['3pm'],
                'three_point_attempted'  => $sr['3pa'],
                'two_point_made'         => $sr['fgm'] - $sr['3pm'],
                'two_point_attempted'    => $sr['fga'] - $sr['3pa'],
            ]);
        }

        // 5. Gallery Documentation Photos
        \App\Models\Gallery::query()->delete();

        $galleries = [
            [
                'foto'       => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&auto=format&fit=crop&q=80',
                'caption'    => 'Duel sengit divisi putri antara SMK Wikrama Queens vs SMAN 1 Bogor Sirens.',
                'kategori'   => 'Pertandingan',
                'badge_text' => 'Divisi Putri',
                'tag_text'   => '• SMK Wikrama Queens..',
                'tanggal'    => '2026-09-21',
            ],
            [
                'foto'       => 'https://images.unsplash.com/photo-1519766304817-4f37bda74a29?w=800&auto=format&fit=crop&q=80',
                'caption'    => 'Fastbreak kilat dan selebrasi kemenangan dramatis SMA Regina Pacis Warriors.',
                'kategori'   => 'Selebrasi',
                'badge_text' => 'Selebrasi',
                'tag_text'   => '• SMAN 1 Bogor Eagles v..',
                'tanggal'    => '2026-09-20',
            ],
            [
                'foto'       => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&auto=format&fit=crop&q=80',
                'caption'    => 'Defense ketat dan rebound agresif di bawah ring pada laga pembuka turnamen WikCup.',
                'kategori'   => 'Pertandingan',
                'badge_text' => 'Laga Pembuka',
                'tag_text'   => '• SMK Wikrama Thunder..',
                'tanggal'    => '2026-09-19',
            ],
            [
                'foto'       => 'https://images.unsplash.com/photo-1505666287040-745e4ab4c06b?w=800&auto=format&fit=crop&q=80',
                'caption'    => 'Aksi shooting buzzer beater menegangkan di kuarter ke-4 antara SMK Wikrama Thunder vs...',
                'kategori'   => 'Pertandingan',
                'badge_text' => 'Buzzer Beater',
                'tag_text'   => '• SMK Wikrama Thunder..',
                'tanggal'    => '2026-09-19',
            ],
            [
                'foto'       => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=800&auto=format&fit=crop&q=80',
                'caption'    => 'Trofi bergengsi Juara WikCup Basketball Tournament siap diperebutkan oleh tim-tim...',
                'kategori'   => 'Awarding',
                'badge_text' => 'Trofi & Penghargaan',
                'tag_text'   => 'Event WikCup',
                'tanggal'    => '2026-09-18',
            ],
            [
                'foto'       => 'https://images.unsplash.com/photo-1471295253337-3ceaaedca402?w=800&auto=format&fit=crop&q=80',
                'caption'    => 'Suasana meriah upacara pembukaan Wikrama Cup Basketball di Lapangan Utama SMK...',
                'kategori'   => 'Suporter & Pembukaan',
                'badge_text' => 'Opening Ceremony',
                'tag_text'   => 'Event WikCup',
                'tanggal'    => '2026-09-18',
            ],
        ];

        foreach ($galleries as $g) {
            \App\Models\Gallery::create($g);
        }
    }
}
