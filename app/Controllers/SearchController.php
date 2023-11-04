<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;

class SearchController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        $searchPhrase = $_GET['searchPhrase'] ?? '';

        $episodes = $this->api->searchEpisodes($searchPhrase);

        if (empty($episodes->getEpisodes())) {
            return new Response(
                'episodes/index', [
                    'header' => 'No results found!'
                ]
            );
        }

        $foundEpisodes = $episodes->getEpisodes();

        if (count($foundEpisodes) === 1) {
            $episode = $foundEpisodes[0];

            $getCharacters = $episode->getCharacters()->getCharacters();

            $characters = [];

            foreach ($getCharacters as $character) {
                $characters[] = $this->api->fetchCharacter($character);
            }

            return new Response(
                'episodes/show', [
                    'episode' => $episode,
                    'characters' => $characters,
                    'header' => $episode->getName()
                ]
            );
        }

        return new Response(
            'episodes/index', [
                'episodes' => $foundEpisodes,
                'header' => 'Search results for ' . $searchPhrase . ' (' . count($foundEpisodes) . ')'
            ]
        );
    }
}