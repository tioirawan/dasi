<?php
function uuid_gen($length) {

    $fp = @fopen('/dev/urandom','rb');

    if ($fp !== FALSE) {
        $result .= @fread($fp, $length);
        @fclose($fp);
    } else {
        trigger_error('Can not open /dev/urandom.');
    }

    return $result;
}

$key = uuid_gen((256 / 8));

echo $key;