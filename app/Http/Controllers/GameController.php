<?php

namespace App\Http\Controllers;

use App\DistributionCentre;
use App\Game;
use App\Package;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function create()
    {
        $game = Game::create();
        $this->generateCards($game);

        return response()->json($game);
    }

    private function generateCards(?Game $game = null)
    {
        $cards = [];

        foreach (DistributionCentre::listAll() as $key => $value) {
            $distributionCentre = DistributionCentre::create([
                'code' => $key,
                'name' => $value,
            ]);

            $previous = null;

            for ($i = 100; $i <= 600; $i += 100) {
                $package = Package::create([
                    'distribution_centre_id' => $distributionCentre->id,
                    'parent' => $previous,
                    //'address' => $this->generateAddress(substr($distributionCentre->code, 0, 2).$i),
                ]);

                $cards[] = null;
            }
        }

        return response()->json($cards);
    }

    private function generateAddress(string $postalCode)
    {

    }
}
