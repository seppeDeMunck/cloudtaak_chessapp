<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import the DB facade

use App\Models\Game;
use Carbon\Carbon;

class GamesTableSeeder extends Seeder
{   
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->truncate();

        Game::create([
            'black' => 'seppe',
            'white' => 'jan',
            'winner' => 'seppe',
            'moves' => '1.e4c52.Nf3d63.Bb5+Bd74.Bxd7+Nxd75.O-ONgf66.Re1e67.d4cxd48.Qxd4Qc79.c4Ne510.Nbd2Be711.b3Nfg412.Nxe5dxe513.Qd3Bc514.Re2Bd415.Rb1O-O-O16.Qg3f517.Nf3Bxf2+18.Rxf2Rd1+0-1',
        ]);

        Game::create([
            'black' => 'seppe',
            'white' => 'bert',
            'winner' => 'seppe',
            'moves' => '1.d4Nf62.c4g63.Nc3Bg74.e4d65.Be2O-O6.f4c57.Nf3cxd48.Nxd4Nc69.Be3Ng410.Bxg4Bxd411.Bxd4Bxg412.Qxg4Nxd413.Qd1Nc614.O-OQa515.Kh1Qb416.Qe2Na517.Nd5Qxc418.Nxe7+Kg719.Qd2Nc620.f5Nxe721.f6+Kh822.Qh6Rg823.Rf3g524.fxe7Rae825.Qf6+Rg726.e5d527.e6fxe628.Qe5Qc829.Rf71-0',
        ]);

        Game::create([
            'black' => 'jeff',
            'white' => 'seppe',
            'winner' => 'jeff',
            'moves' => '1.d4Nf62.c4g63.',
            ]);
    }
}