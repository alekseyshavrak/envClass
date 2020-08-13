<?php include 'Classes/Env.php';

use Classes\Env;

$file = $_SERVER['DOCUMENT_ROOT'] . '.env';

try {
    print_r((new Env($file))->get());
} catch (Exception $e) {
    print_r($e);
}
