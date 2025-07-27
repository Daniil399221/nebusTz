<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes\Contact;
use OpenApi\Attributes\Info;

#[Info(
    version: '1.0.0',
    title: 'Swagger Nebus',
    contact: new Contact(name: 'Swagger Nebus'),
)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
