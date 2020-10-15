<?php 

namespace App\Youtube;

use DateInterval;
use Illuminate\Support\Facades\Http;

class YoutubeServices
{
    private $key = null;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function handleYoutubeVideoDuration(string $video_url)
    {
        // https://www.youtube.com/embed/wnhvanMdx4s -> je veux uniquement l'id en fin d'URL
        // Récupérer l'id à partir de $video_url
        preg_match('/embed\/(.+)/', $video_url, $matches);
        $id = $matches[1];
        
        // appel de l'api de youtube pour récupérer la durée
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?key={$this->key}&id={$id}&part=contentDetails");
        $decoded = json_decode($response);
        $duration = $decoded->items[0]->contentDetails->duration;
        
        // convertir en seconde
        $interval = new DateInterval($duration);
        // dd($interval);
        return $interval->s + $interval->i * 60 + $interval->h * 3600;
    }
}