<?php
namespace Helpers;

use Core\Session;

function flash(string $index){

    return Session::get('__flash')[$index] ?? null;

}