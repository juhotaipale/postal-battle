<?php

namespace App\Http\Controllers;

use App\Card;
use App\DistributionCentre;
use App\Events\GameListUpdated;
use App\Game;
use App\Helpers\Address;
use App\Http\Resources\GameResource;
use App\Package;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    protected $game = null;

    public function index(Request $request)
    {
        $games = Game::query()
            ->with('players')
            ->without('cards')
            ->where('finished_at', null)
            ->orderBy('created_at')
            ->get();

        broadcast(new GameListUpdated([]))->toOthers();

        if ($request->is('api/*')) {
            $collection = GameResource::collection($games);
            broadcast(new GameListUpdated($collection))->toOthers();

            return response()->json(GameResource::collection($collection));
        }

        return view('index', compact('games'));
    }

    public function show(Request $request, Game $game)
    {
        $game->loadMissing('players', 'cards');

        if ($request->is('api/*')) {
            return response()->json(new GameResource($game));
        }

        return view('index', compact('game'));
    }

    public function create(Request $request)
    {
        $this->game = Game::create();
        $this->generateCards();

        Auth::user()->game()->associate($this->game);
        Auth::user()->save();

        return $this->index($request);
    }

    public function join(Request $request, Game $game)
    {
        Auth::user()->game()->associate($game);
        Auth::user()->save();

        return $this->index($request);
    }

    public function begin(Game $game)
    {
        $cards = $game->cards->shuffle();
        $players = $game->players;
        $i = 0;

        foreach ($cards as $card)
        {
            $card->player()->associate($players[$i]);
            $card->save();

            $i = ($i + 1 >= count($players) ? 0 : $i + 1);
        }
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
                    'type' => weightedRand(['economy' => 70, 'priority' => 30]),
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
