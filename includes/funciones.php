<?php

function vd($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function sanitize($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
