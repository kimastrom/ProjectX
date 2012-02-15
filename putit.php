<?php
    function test()
    {
        //extract data from the post
        //extract($_POST);

        //set POST variables
        $url = 'localhost/api/snippets';
        $fields = array('id'=>'76', 'userid' => '2', 'code' => 'Yo! Yo! Yo! Pants is my favourite', 'desc' => 'Cool blue Pants', 'title' => 'Yo! I need new pants!', 'languageid' => '2', 'apikey' => '5435gdfhghdghdf');

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
        curl_setopt($post, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($post);

        curl_close($post);
        
        var_dump($result);
    }
    
    test();