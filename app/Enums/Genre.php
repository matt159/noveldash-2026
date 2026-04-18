<?php

namespace App\Enums;

enum Genre: string
{
    case CrimeThriller = 'Crime/Thriller';
    case CozyMystery = 'Cozy Mystery';
    case HistoricalFiction = 'Historical Fiction';
    case GhostStory = 'Ghost Story';
    case Horror = 'Horror';
    case Ya = 'YA';
    case Romance = 'Romance';
    case ScienceFiction = 'Science Fiction';
    case Fantasy = 'Fantasy';
    case LiteraryFiction = 'Literary Fiction';
    case TimeTravel = 'Time Travel';
    case Dystopia = 'Dystopia';
    case MagicalRealism = 'Magical Realism';
    case Memoir = 'Memoir';
    case FictionalMemoir = 'Fictional Memoir';
    case BookClub = 'Book Club';
    case CommercialFiction = 'Commercial Fiction';
    case Uplit = 'Uplit';
    case Other = 'Other';

    public function badgeClass(): string
    {
        return match ($this) {
            self::CrimeThriller => 'bg-red-100 text-red-800',
            self::CozyMystery => 'bg-orange-100 text-orange-800',
            self::HistoricalFiction => 'bg-amber-100 text-amber-800',
            self::GhostStory => 'bg-purple-100 text-purple-800',
            self::Horror => 'bg-rose-100 text-rose-800',
            self::Ya => 'bg-pink-100 text-pink-800',
            self::Romance => 'bg-fuchsia-100 text-fuchsia-800',
            self::ScienceFiction => 'bg-blue-100 text-blue-800',
            self::Fantasy => 'bg-indigo-100 text-indigo-800',
            self::LiteraryFiction => 'bg-teal-100 text-teal-800',
            self::TimeTravel => 'bg-sky-100 text-sky-800',
            self::Dystopia => 'bg-slate-100 text-slate-800',
            self::MagicalRealism => 'bg-violet-100 text-violet-800',
            self::Memoir => 'bg-green-100 text-green-800',
            self::FictionalMemoir => 'bg-emerald-100 text-emerald-800',
            self::BookClub => 'bg-lime-100 text-lime-800',
            self::CommercialFiction => 'bg-yellow-100 text-yellow-800',
            self::Uplit => 'bg-cyan-100 text-cyan-800',
            self::Other => 'bg-gray-100 text-gray-700',
        };
    }
}
