<?php
function __autoload($ClassName)
{
    require $ClassName . '.php';
}


