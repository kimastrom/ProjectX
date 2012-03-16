<?php
    function test()
    {
        //extract data from the post
        //extract($_POST);

        //set POST variables
        $url = 'localhost/ProjectX/api/ratings';
        $fields = array('snippetid' => '20009', 'userid' => '1', 'rating' => '1', 'apikey' => '23434jdkfdjfkfdslfds');

        tourl($url, $fields);
        
    }

    function tourl($url, $data)
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');

        $post = curl_init();

        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($post);

        curl_close($post);
        
        echo $result;
    }
    
    test();