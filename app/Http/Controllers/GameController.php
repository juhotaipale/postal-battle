<?php

namespace App\Http\Controllers;

use App\Card;
use App\DistributionCentre;
use App\Events\GameBegun;
use App\Events\GameListUpdated;
use App\Events\GameUpdated;
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

    /**
     * Show all the games.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!$request->is('api/*') && optional(Auth::user())->game) {
            return redirect()->route('game', Auth::user()->game);
        }

        $games = Game::query()
            ->with('players')
            ->without('cards')
            ->where('started_at', null)
            ->orderBy('created_at')
            ->get();

        if ($request->is('api/*')) {
            $collection = GameResource::collection($games);
            broadcast(new GameListUpdated($collection))->toOthers();

            return response()->json(GameResource::collection($collection));
        }

        return view('index', compact('games'));
    }

    /**
     * Show a game.
     *
     * @param Request $request
     * @param Game $game
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show(Request $request, Game $game)
    {
        $game->loadMissing('players', 'cards');

        if ($request->is('api/*')) {
            return response()->json(new GameResource($game));
        }

        return view('index', compact('game'));
    }

    /**
     * Create a new game.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $this->game = Game::create();
        $this->generateCards();

        Auth::user()->game()->associate($this->game);
        Auth::user()->save();

        return $this->index($request);
    }

    /**
     * Join to game.
     *
     * @param Request $request
     * @param Game $game
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function join(Request $request, Game $game)
    {
        Auth::user()->game()->associate($game);
        Auth::user()->save();

        return $this->index($request);
    }


    /**
     * Begin a game.
     *
     * @param Game $game
     */
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

        $game->turn_player_id = $players[0]->id;
        $game->started_at = now();
        $game->save();

        broadcast(new GameBegun($game))->toOthers();
    }

    public function place(Game $game, Card $card)
    {
        $card->player()->associate(null);
        $card->save();

        $game->loadMissing('cards', 'players');

        foreach ($game->players as $player) {
            if (count($player->cards) === 0) $game->finished_at = now();
        }

        if (! $game->finished_at) {
            $next = $game->players()->pluck('id')->search($game->turn_player_id) + 1;
            $next = ($next >= count($game->players) ? 0 : $next);
            $game->turn_player_id = $game->players[$next]->id;
        }

        $game->save();

        broadcast(new GameUpdated($game))->toOthers();
    }

    /**
     * Create a card.
     *
     * @param $cardable
     * @param Card|null $previous
     * @return Card
     */
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

    /**
     * Generate cards.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Generate an address for card.
     *
     * @param DistributionCentre $distributionCentre
     * @param string $postalCode
     * @return string
     */
    protected function generateAddress(DistributionCentre $distributionCentre, string $postalCode)
    {
        $faker = Factory::create('fi_FI');

        return '<b>'.$faker->firstName.' '.$faker->lastName.'</b><br />'
            .Address::rand().'<br />'
            .$postalCode.' '.$distributionCentre->name;
    }

    public function demo(Game $game) {
        $order = [0, 1, 2, 7, 3, 8, 14, 9, 10, 11, 4, 21, 5, 28, 15, 16, 17, 29, 30,
            31, 6, 12, 13, 35, 36, 37, 38, 22, 23, 18, 24, 25, 26, 49, 50, 27, 32,
            33, 39, 40, 34, 41, 51, 52, 53, 54, 42, 43, 55, 19, 20, 44, 45, 46, 47, 48];

        $players = $game->players;
        $i = 0;

        foreach ($order as $index)
        {
            $game->cards[$index]->player()->associate($players[$i]);
            $game->cards[$index]->save();

            $i = ($i + 1 >= count($players) ? 0 : $i + 1);
        }
    }
}
