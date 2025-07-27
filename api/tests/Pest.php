<?php

declare(strict_types=1);

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\ViteManifestNotFoundException;
use Illuminate\Http\Request;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\ServerBag;
use Tests\DuskTestCase;
use Tests\TestCase;

uses(
    DuskTestCase::class,
    DatabaseMigrations::class,
)->beforeAll(function (): void {
    if (!file_exists('public/hot') && !file_exists('public/build/manifest.json')) {
        throw new ViteManifestNotFoundException('You should run dev env or build application');
    }
})->in('Browser');

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    TestCase::class,
    RefreshDatabase::class,
)->in('Feature', 'Unit', 'Base');

function createDefaultRequestMock(?string $method = 'GET'): (MockInterface&Request)|LegacyMockInterface
{
    $mockRequest = Mockery::mock(Request::class)->makePartial();

    $mockRequest->query = new InputBag;
    $mockRequest->request = new InputBag;
    $mockRequest->attributes = new ParameterBag;
    $mockRequest->cookies = new InputBag;
    $mockRequest->files = new FileBag;
    $mockRequest->server = new ServerBag([
        'method' => $method,
    ]);
    $mockRequest->headers = new HeaderBag;

    return $mockRequest;
}

function createBaseRequestMock(?string $method = 'GET'): (MockInterface&BaseRequest)|LegacyMockInterface
{
    $mockRequest = Mockery::mock(BaseRequest::class)->makePartial();

    $mockRequest->query = new InputBag;
    $mockRequest->request = new InputBag;
    $mockRequest->attributes = new ParameterBag;
    $mockRequest->cookies = new InputBag;
    $mockRequest->files = new FileBag;
    $mockRequest->server = new ServerBag([
        'method' => $method,
    ]);
    $mockRequest->headers = new HeaderBag;

    return $mockRequest;
}
