<?php

class Tools {

    public static function random_string($l = 10) {
        $s = "";
        $c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxwz0123456789";
        for (; $l > 0; $l--)
            $s .= $c{rand(0, strlen($c) - 1)};
        return str_shuffle($s);
    }
    public static function random_int($max){
        return rand(0, $max);
    }
    /* public static function AreYouSure($redirect) {
      $tpl = new Template("lib/Jimber/templates/AreYouSure.tpl");
      $tpl->DefineBlock("SUREBLOCK");
      $tpl->SetVars("SUREBLOCK", "REDIRECT", $redirect);
      $htm = $tpl->ParseBlock("SUREBLOCK");
      $tpl->Show($htm);
      } */

    public static function AreYouSure($redirect) {
        return GlobalVars::$JPFPATH . "AreYouSure.php?redirect=" . URLEncrypter::Encrypt($redirect);
    }

    public static function curPageURL() {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    
        public static function curPageURLEnc() {
       return URLEncrypter::Encrypt(Tools::curPageURL());
    }

    public static function addParam($curPage, $param, $value) {
        $query = parse_url($curPage);
        $params = array();
        if (isset($query["query"])) {
            parse_str($query["query"], $params);
        }

        $params[$param] = $value;
        // $host = $query["host"];
        $path = $query["path"];

        $newUrl = http_build_query($params);


        return $path . "?" . $newUrl; //rebuild full url
    }

    public static function deleteParam($curPage, $param) {
        $query = parse_url($curPage);
        $params = array();
        if (isset($query["query"])) {
            parse_str($query["query"], $params);
        }

        unset($params[$param]);
        // $host = $query["host"];
        $path = $query["path"];

        $newUrl = http_build_query($params);


        return $path . "?" . $newUrl; //rebuild full url
    }

    /*
      public static function FilterDataArray($array, $filter) {
      foreach ($array as $key => $value) {

      if (is_array($value)) {
      SearchDataArray($value, $filter);
      } else if (is_object($value)) {
      SearchDataArray(get_object_vars($value), $filter);
      } else if ( is_string($value)){
      if(strpos($value,$search) === false){
      return false;
      }else{
      return true;
      }
      }
      }
      } */

    public static function FilterDataArray($array, $filter) {

        var_dump($array);
        echo "######";
        $newArr = Array();
        foreach ($array as $key => $value) {
            $occured = false;
            $objArr = get_object_vars($value);
            foreach ($objArr as $member => $memberval) {

                if (is_string($memberval)) {
                    echo "**" . $memberval . "**";
                    if (strpos($memberval, $filter) !== false) {
                        $occured = true;
                    }
                }
            } echo "<br>";

            if ($occured) {

                array_push($newArr, $value);
            }
        }
        return $newArr;
    }

    public static function ArrayCopy(array $array) {

        $result = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $result[$key] = arrayCopy($val);
            } elseif (is_object($val)) {
                $result[$key] = clone $val;
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
    }

    function js_redirect($url, $seconds = 1) {
        echo "<script language=\"JavaScript\">\n";
        echo "<!-- hide from old browser\n\n";
        echo "function redirect() {\n";
        echo "window.location = \"" . $url . "\";\n";
        echo "}\n\n";
        echo "timer = setTimeout('redirect()', '" . ($seconds * 1000) . "');\n\n";
        echo "-->\n";
        echo "</script>\n";
        return true;
    }

}

?>
