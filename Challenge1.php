<?php

function challenge(int $first, int $second) {
    $result = $first ^ $second;
    $initial = 0;

    while($result > 0) {
        $initial += $result & 1;
        $result >>= 1;
    }

    return $initial;
}

?>