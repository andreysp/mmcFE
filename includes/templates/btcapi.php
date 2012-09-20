 <?
 ini_set("display_errors", 1);
    function btc_query($method, array $req = array()) {
    
            $req['method'] = $method;
            $mt = explode(' ', microtime());
            $req['nonce'] = $mt[1];
           
            // generate the POST data string
            $post_data = http_build_query($req, '', '&');
     
     
            // our curl handle (initialize if required)
            static $ch = null;
            if (is_null($ch)) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; BTCE PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
            }
            curl_setopt($ch, CURLOPT_URL, 'https://btc-e.com/api/2/ltc_usd/ticker');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
     
            // run the query
            $res = curl_exec($ch);
            if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
            $dec = json_decode($res, true);
            if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
            return $dec;
    }
     
    $result = btc_query("getInfo");     
    $ltcusd = $result["ticker"]["avg"];


?>