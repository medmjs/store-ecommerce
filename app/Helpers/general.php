<?php

function getFile(){
    return app()->getLocale() ==='ar'?'css-rtl':'css';
}
