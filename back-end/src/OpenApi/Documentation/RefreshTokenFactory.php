<?php

declare(strict_types=1);

namespace App\OpenApi\Documentation;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenFactory implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @param mixed[] $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $openApi
            ->getPaths()
            ->addPath('/api/token/refresh', (new PathItem())->withPost(
                (new Operation())
                    ->withOperationId('gesdinet_jwt_refresh_token')
                    ->withTags(['Login Check'])
                    ->withResponses([
                        Response::HTTP_NO_CONTENT => [
                            'description' => 'Successfully refreshed tokens',
                        ],
                    ])
                    ->withSummary('Refresh the user tokens.')
                    ->withDescription('Refresh the user tokens.')
            ));

        return $openApi;
    }
}
