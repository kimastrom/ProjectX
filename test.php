<?php
    function test()
    {
        //extract data from the post
        //extract($_POST);

        //set POST variables
        $url = 'localhost/ProjectX/api/snippets';
        $fields = array('userid' => '2', 'code' => 'Unika ord som glänser i solen', 'desc' => 'Blaster mobile IS GOOD TO EAT!', 'title' => 'DjSlim with HoodyShirt and Boxing Gloves', 'languageid' => '1', 'apikey' => '5435gdfhghdghdf');

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