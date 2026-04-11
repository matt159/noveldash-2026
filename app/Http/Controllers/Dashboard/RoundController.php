<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\EntryRound;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\View\View;

class RoundController extends Controller
{
    /**
     * @var array<string, EntryRound>
     */
    private array $rounds = [
        'round1' => EntryRound::Round1,
        'top100' => EntryRound::Top100,
        'longlist' => EntryRound::Longlist,
        'shortlist' => EntryRound::Shortlist,
    ];

    public function show(string $round): View
    {
        abort_unless(isset($this->rounds[$round]), 404);

        $currentRound = $this->rounds[$round];
        $order = [EntryRound::Round1, EntryRound::Top100, EntryRound::Longlist, EntryRound::Shortlist];
        $roundIndex = array_search($currentRound, $order);

        // Entries that have reached this round or higher
        $eligibleRounds = array_slice($order, $roundIndex);
        $eligibleRoundValues = array_map(fn (EntryRound $r) => $r->value, $eligibleRounds);

        $entries = Entry::with('sponsorshipCode')
            ->whereIn('current_round', $eligibleRoundValues)
            ->latest()
            ->get();

        return view('dashboard.rounds.show', compact('entries', 'currentRound'));
    }
}
