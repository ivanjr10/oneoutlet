<?php

/*
 * This file is part of asm89/stack-cors.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89Stack;

use SymfonyComponentHttpFoundationResponse;
use SymfonyComponentHttpKernelHttpKernelInterface;
use SymfonyComponentHttpFoundationRequest;

class Cors implements HttpKernelInterface
{
    /**
     * @var SymfonyComponentHttpKernelHttpKernelInterface
     */
    private $app;

    /**
     * @var Asm89StackCorsService
     */
    private $cors;

    private $defaultOptions = [
        'allowedHeaders'         => [],
        'allowedMethods'         => [],
        'allowedOrigins'         => [],
        'allowedOriginsPatterns' => [],
        'exposedHeaders'         => [],
        'maxAge'                 => 0,
        'supportsCredentials'    => false,
    ];

    public function __construct(HttpKernelInterface $app, array $options = [])
    {
        $this->app  = $app;
        $this->cors = new CorsService(array_merge($this->defaultOptions, $options));
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true): Response
    {
        if ($this->cors->isPreflightRequest($request)) {
            $response = $this->cors->handlePreflightRequest($request);
            return $this->cors->varyHeader($response, 'Access-Control-Request-Method');
        }

        $response = $this->app->handle($request, $type, $catch);

        if ($request->getMethod() === 'OPTIONS') {
            $this->cors->varyHeader($response, 'Access-Control-Request-Method');
        }

        return $this->cors->addActualRequestHeaders($response, $request);
    }
}
