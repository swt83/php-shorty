<?php

namespace Travis;

class Shorty {

    /**
     * Return a shorter URL.
     *
     * @param   string  $url
     * @return  string
     */
    public static function run($url)
    {
        // endpoint
        $endpoint = 'https://www.googleapis.com/urlshortener/v1/url';

        // arguments
        $payload = array(
            'longUrl' => $url
        );

        // zip
        $payload = json_encode($payload);

        // curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $response = curl_exec($ch);

        // close
        curl_close($ch);

        // capture
        $response = @json_decode($response);

        // catch error...
        if (ex($response, 'error')) return false;

        // return
        return ex($response, 'id');
    }

}