<?php
namespace SocialBundle\Services;

class YoutubeService

{
    private $query;
    private $youtubeAPIKey;
    
    public function __construct ($youtubeAPIKey)
    {
        $this->youtubeAPIKey = $youtubeAPIKey;
    }
    
    public function search ($query)
    {
        $this->query = $query;
        return json_encode(['result' => $this->getAPIResult()], true);
    }
    
    private function getAPIResult()
    {
        $videoArray = [];
        $arrContextOptions=[
            "ssl"=>[
                "verify_peer"=> false,
                "verify_peer_name"=> false,
            ],
        ];
        $youtubeData = json_decode(
            file_get_contents(
                "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=6&q=".urlencode($this->query)."&key=".$this->youtubeAPIKey,
                false, 
                stream_context_create($arrContextOptions)
            ), true
        );
        foreach($youtubeData['items'] as $oneResult) {
            if($oneResult['id']['kind'] == "youtube#video") {
                $videoArray[] = [
                    'id' => $oneResult['id']['videoId'],
                    'title' => $oneResult['snippet']['title'],
                    'description' => $oneResult['snippet']['description'],
                    'channelTitle' => $oneResult['snippet']['channelTitle']
                ];
            }
           /* */
        }
        return $videoArray;
    }
}
