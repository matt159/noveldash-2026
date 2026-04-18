<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\EntryRound;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;
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

    public function show(Request $request, string $round): View
    {
        abort_unless(isset($this->rounds[$round]), 404);

        $currentRound = $this->rounds[$round];
        $order = [EntryRound::Round1, EntryRound::Top100, EntryRound::Longlist, EntryRound::Shortlist];
        $roundIndex = array_search($currentRound, $order);

        $eligibleRounds = array_slice($order, $roundIndex);
        $eligibleRoundValues = array_map(fn (EntryRound $r) => $r->value, $eligibleRounds);

        $search = $request->query('search');

        $entries = Entry::with('sponsorshipCode')
            ->whereIn('current_round', $eligibleRoundValues)
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%'.strtolower($search).'%'])
                    ->orWhereRaw('LOWER(email) LIKE ?', ['%'.strtolower($search).'%'])
                    ->orWhereRaw('LOWER(novel_title) LIKE ?', ['%'.strtolower($search).'%'])
                    ->orWhereRaw('LOWER(genre) LIKE ?', ['%'.strtolower($search).'%']);
            }))
            ->latest()
            ->get();

        return view('dashboard.rounds.show', compact('entries', 'currentRound', 'search'));
    }
}
