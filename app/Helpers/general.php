<?php


define('PAGENATION_COUNT',10);
function getFile(){
    return app()->getLocale() ==='ar'?'css-rtl':'css';
}

function uploadImage($folder,$image){

    //$image->store('/', $folder);
    //$fileName = $image->hashName();
    return $folder." ".$image;

}
