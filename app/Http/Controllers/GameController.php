<?php

namespace App\Http\Controllers;

use App\Card;
use App\DistributionCentre;
use App\Game;
use App\Helpers\Address;
use App\Http\Resources\GameResource;
use App\Package;
use Faker\Factory;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected $game = null;

    public function show(Game $game)
    {
        return response()->json(new GameResource($game));
    }

    public function create()
    {
        $this->game = Game::create();
        $this->generateCards();

        return response()->json($this->game);
    }

    protected function createCard($cardable, Card $previous = null): Card
    {
        $card = new Card([
            'game_id' => $this->game->id,
            'parent_id' => optional($previous)->id,
        ]);

        $card->cardable()->associate($cardable);
        $card->save();

        return $card;
    }

    protected function generateCards()
    {
        $previous = null;

        foreach (DistributionCentre::listAll() as $key => $value) {
            $distributionCentre = DistributionCentre::create([
                'code' => $key,
                'name' => $value,
            ]);

            $previous = $this->createCard($distributionCentre, $previous);

            for ($i = 100; $i <= 600; $i += 100) {
                $postalCode = substr($key, 0, 2).$i;
                $package = Package::create([
                    'code' => $postalCode,
                    'type' => ['priority', 'economy', 'economy', 'economy'][rand(0, 3)],
                    'address' => $this->generateAddress($distributionCentre, $postalCode)
                ]);

                $previous = $this->createCard($package, $previous);
            }

            $previous = null;
        }

        return response()->json([]);
    }

    protected function generateAddress(DistributionCentre $distributionCentre, string $postalCode)
    {
        $faker = Factory::create('fi_FI');

        return '<b>'.$faker->firstName.' '.$faker->lastName.'</b><br />'
            .Address::rand().'<br />'
            .$postalCode.' '.$distributionCentre->name;
    }
}
