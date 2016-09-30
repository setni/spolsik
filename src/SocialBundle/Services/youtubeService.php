<?php
namespace SocialBundle\Services;

class youtubeService

{
    private query;
    
    public function __construct ()
    {
        
    }
    
    public function search ($query)
    {
        $this->query = $query;
        return json_decode($this->getAPIResult());
    }
    
    private function getAPIResult()
    {
        $videoArray = [];
        $youtubeData = json_decode(
            file_get_contents(
                "https://www.googleapis.com/youtube/v3/search?part=snippet&q=".urlencode($this->query)."&key={YOUR_API_KEY}"
            ), true
        );
        foreach($youtubeData[0]['items'] as $oneResult) {
            $videoArray['id'][] = $oneResult['id']['videoId'];
            $videoArray['title'][] = $oneResult['titre'];
            $videoArray['description'][] = $oneResult['description'];
            $videoArray['channelTitle'][] = $oneResult['channelTitle'];
        }
        return $videoArray;
    }
}