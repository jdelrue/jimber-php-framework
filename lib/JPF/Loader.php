<?
/*
 * Will show loading logo when site is being loaded and remove it if done is called.
 * Seems a bit overkill to use templates
 * This is really not HTML correct. Maybe fix it?
 */
        
class Loader {
    public static function Load() { // Another option is to pass html code? Maybe both? Maybe the image?
        ob_implicit_flush(true);
        ob_end_flush();
        echo str_repeat("<!-- Agent Smith -->", 1000);
        echo "<div class=\"loader\" style=\"width:100%; text-align:center\"><img src=\"images/loading.gif\" /> </div>";
    }
    public static function Done(){
         echo "   <style type=\"text/css\">  .loader, .loadertext { visibility: hidden; height: 0px; width: 0px;};  </style>";
        
    }
      public static function WriteLoadText($text){
            echo " <div class=\"loadertext\"> $text </div>";
      }
}

?>
