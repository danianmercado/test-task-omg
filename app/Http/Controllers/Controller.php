<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OAT;

#[OAT\OpenApi(openapi: '3.1.0')]
#[OAT\Info(version: '1.0.0', title: 'Test API')]
abstract class Controller
{
    //
}
