<?php

namespace App\Http\Controllers;

use App\Services\ZoteroService;
use Illuminate\Support\Facades\Http;

class BibliographyController extends Controller
{
    // Manuell definierte Collections (Name => Collection-ID)
    protected $collections = [
        'Research on Archaeogaming' => 'ZHFP2TQS',
        'The study of archaeology within video games' => 'FUXVPQEY',
        'Teaching with Archaeogaming' => 'L25QMPPT',
        'The study of physical video games' => 'WC2PJE39',
        'Orientalism' => 'I5ZLTVF9',
        'Perception' => '2M56D3XC',
        'Cultural Aspects' => '3EC6U2PM',
        'Related Fields' => 'FY6YE833',
    ];

    public function index(ZoteroService $zoteroService)
    {
        $groupId = config('services.zotero.group_id');
        $bibliography = [];

        foreach ($this->collections as $name => $collectionId) {
            // Hole alle Items aus der Collection
            $response = Http::get("https://api.zotero.org/groups/{$groupId}/collections/{$collectionId}/items", [
                'format' => 'json',
                'limit' => 100,
                'itemType' => '-attachment || note', // Keine Attachments oder Notizen
            ]);

            if ($response->successful()) {
                $items = collect($response->json())
                    ->filter(function ($item) {
                        // Nur echte Literatur-Items (keine Attachments, Notes, etc.)
                        $type = $item['data']['itemType'] ?? '';
                        return !in_array($type, ['attachment', 'note']);
                    })
                    ->map(function ($item) use ($zoteroService) {
                        $key = $item['key'];

                        // Cache das Item falls noch nicht vorhanden
                        $zoteroService->getCitation($key);

                        return [
                            'key' => $key,
                            'citation' => $zoteroService->getHarvardCitation($key),
                        ];
                    })
                    ->sortBy(function ($item) {
                        // Sortiere alphabetisch nach Zitat
                        return strip_tags($item['citation']);
                    })
                    ->values()
                    ->all();

                $bibliography[$name] = $items;
            } else {
                $bibliography[$name] = [];
            }
        }

        return view('bibliography', compact('bibliography'));
    }
}
