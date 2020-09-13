<?php


define('PAGENATION_COUNT',10);
function getFile(){
    return app()->getLocale() ==='ar'?'css-rtl':'css';
}
