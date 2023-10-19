<?php

$tunnel = \Octopy\Flaravel\Api\Tunnel\Tunnel::make(new \Octopy\Flaravel\Auth\APIKey(
    'foo@bar.baz', '123456789'
));

