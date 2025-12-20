<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\ZoteroCache;

class ZoteroService
{
    protected string $groupId;

    public function __construct()
    {
        $this->groupId = config('services.zotero.group_id');
    }

    public function getCitation(string $itemKey): string
    {
        // Check cache first
        $cached = ZoteroCache::find($itemKey);
        if ($cached) {
            return $cached->citation;
        }

        // Fetch from API
        $response = Http::get(
            "https://api.zotero.org/groups/{$this->groupId}/items/{$itemKey}"
        );

        if ($response->failed()) {
            return $itemKey; // Fallback to ID
        }

        $data = $response->json()['data'] ?? [];
        $citation = $this->formatCitation($data);

        // Cache with full data
        ZoteroCache::create([
            'item_key' => $itemKey,
            'authors' => $this->extractAuthors($data),
            'year' => $this->extractYear($data),
            'citation' => $citation,
            'title' => $data['title'] ?? null,
            'publication' => $data['publicationTitle'] ?? $data['bookTitle'] ?? null,
            'volume' => $data['volume'] ?? null,
            'issue' => $data['issue'] ?? null,
            'pages' => $data['pages'] ?? null,
            'publisher' => $data['publisher'] ?? null,
            'place' => $data['place'] ?? null,
            'doi' => $data['DOI'] ?? null,
            'url' => $data['url'] ?? null,
            'item_type' => $data['itemType'] ?? null,
        ]);

        return $citation;
    }

    public function getHarvardCitation(string $itemKey): string
    {
        $cached = ZoteroCache::find($itemKey);

        if (!$cached) {
            $this->getCitation($itemKey);
            $cached = ZoteroCache::find($itemKey);
        }

        if (!$cached) {
            return $itemKey;
        }

        return $this->formatHarvardCitation($cached);
    }

    protected function formatHarvardCitation(ZoteroCache $item): string
    {
        $parts = [];

        // Authors (Year)
        $authorYear = $item->authors ?? 'Unknown';
        $authorYear .= ' (' . ($item->year ?? 'n.d.') . ')';
        $parts[] = $authorYear;

        // Title
        if ($item->title) {
            if (in_array($item->item_type, ['book', 'thesis'])) {
                $parts[] = '<em>' . $item->title . '</em>';
            } else {
                $parts[] = "'" . $item->title . "'";
            }
        }

        // Publication/Book title
        if ($item->publication) {
            $parts[] = '<em>' . $item->publication . '</em>';
        }

        // Volume and Issue
        if ($item->volume) {
            $volIssue = $item->volume;
            if ($item->issue) {
                $volIssue .= '(' . $item->issue . ')';
            }
            $parts[] = $volIssue;
        }

        // Pages
        if ($item->pages) {
            $parts[] = 'pp. ' . $item->pages;
        }

        // Publisher and Place (for books)
        if ($item->publisher) {
            $pubPlace = '';
            if ($item->place) {
                $pubPlace = $item->place . ': ';
            }
            $pubPlace .= $item->publisher;
            $parts[] = $pubPlace;
        }

        $citation = implode(', ', $parts) . '.';

        // DOI or URL as clickable link
        if ($item->doi) {
            $doiUrl = 'https://doi.org/' . $item->doi;
            $citation .= ' <a href="' . $doiUrl . '" target="_blank" class="text-blue-600 hover:underline">' . $doiUrl . '</a>';
        } elseif ($item->url) {
            $citation .= ' <a href="' . $item->url . '" target="_blank" class="text-blue-600 hover:underline">' . $item->url . '</a>';
        }

        return $citation;
    }

    protected function formatCitation(array $data): string
    {
        $authors = $this->extractAuthors($data);
        $year = $this->extractYear($data);

        return trim("{$authors} ({$year})") ?: 'Unbekannt';
    }

    protected function extractAuthors(array $data): string
    {
        $creators = collect($data['creators'] ?? [])
            ->filter(fn($c) => ($c['creatorType'] ?? '') === 'author')
            ->map(fn($c) => $c['lastName'] ?? $c['name'] ?? '');

        return match($creators->count()) {
            0 => 'N.N.',
            1 => $creators->first(),
            2 => $creators->join(' und '),
            default => $creators->first() . ' et al.',
        };
    }

    protected function extractYear(array $data): string
    {
        $date = $data['date'] ?? '';
        preg_match('/\d{4}/', $date, $matches);
        return $matches[0] ?? 'o.J.';
    }
}
