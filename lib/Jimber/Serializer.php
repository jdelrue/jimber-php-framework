<?php
/**
 * This serializer will not only serialize an object but also encode and decode to base64, making it more suitable for passing along.
 *
 * @author delrue
 */
class Serializer {
    static function serialize($object){
        return base64_encode(serialize($object));
    }
    static function deserialize($serString){
        return unserialize(base64_decode($serString));
    }
    static function serializeArray($array){
        $newArray = Array();
        foreach($array as $object){
            array_push($newArray, Serializer::serialize($object));
        }
        return $newArray;
    }
      static function deSerializeArray($array){
        $newArray = Array();
        foreach($array as $string){
            array_push($newArray, Serializer::deserialize($string));
        }
        return $newArray;
    }
}
interface iSerializable{
     function serialize();
}

?>
