<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;

class EpisodeController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        $episodes = $this->api->fetchEpisodes();

        return new Response(
            'season',
            [
                'episodes' => $episodes
            ]
        );
    }

    public function show(array $vars): Response
    {
        $id = (int) $vars['id'];

        $episode = $this->api->fetchEpisode($id);

        return new Response('episode', [
            'episode' => $episode
        ]);
    }
}
