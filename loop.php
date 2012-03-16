<?php
    function test()
    {
        //extract data from the post
        //extract($_POST);

        //set POST variables
		set_time_limit(10000); 
        $url = 'localhost/ProjectX/api/snippets';
        tourl($url);
        
    }

    function tourl($url)
    {
		for ($i = 1; $i <= 3000; $i++) {
			$data = array('userid' => '2', 'code' => 'Special ' . $i, 'desc' => 'Oh Yes! This is Yes dishwashertabletter with superextraordinary POWERS! ' . $i, 'title' => 'DjSlim'. $i . ' with HoodyShirt and Boxing Gloves', 'languageid' => '1', 'apikey' => '5435gdfhghdghdf');
		
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
		}
    }
    
    test();