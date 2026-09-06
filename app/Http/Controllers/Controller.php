<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

/** The routing base class gives controllers middleware(); the trait gives authorizeResource(). */
abstract class Controller extends BaseController
{
    use AuthorizesRequests;
}
