<?php

class API
{
    private $_url = "";

    public function __construct()
    {
        $this->_url = "http://tmpn.se.preview.binero.se/api/";
    }

    /**
     * return API url
     * @return string
     */
    public function GetURL()
    {
        return $this->_url;
    }

    /**
     * check the response code and content type
     * @return TRUE if okej
     */
    public function checkApiUrl($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_NOBODY, true);

        if(!curl_exec($curl)) {
            curl_close($curl);
            Log::apiError('page does not exist', $url);
            return false;
        } else {
            $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode == 200 && $contentType == 'application/json') {
                return true; 
            }
        }
        Log::apiError('404 or wrong content type', $url);
        return false;
    }
}