<?php
require_once 'Serializer.php';

class Error implements iSerializable{

    var $errorMessage;
    var $redirect;
    
    public function Error($errorMessage, $redirect ) {
        $this->errorMessage = $errorMessage;
        $this->redirect = $redirect;
    }

    public function show() {
        echo "<script type='text/javascript'>
                  alert('" . $this->errorMessage . "');
                    </script>";
    }

    public function serialize() {
        return Serializer::serialize($this);
    }
}

?>
