<?php

namespace App\Http\Integrations\Cars;

use Illuminate\Support\Arr;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\OffsetPaginator;
use Saloon\Traits\Plugins\AcceptsJson;

class CarsConnector extends Connector implements HasPagination
{
    use AcceptsJson;

    protected function defaultQuery(): array
    {
        return [
            'where' => 'year>2010',
            'order_by' => 'id ASC, make ASC',
        ];
    }

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/all-vehicles-model/records';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }

    public function paginate(Request $request): OffsetPaginator
    {
        return new class(connector: $this, request: $request) extends OffsetPaginator
        {
            protected ?int $perPageLimit = 100;

            protected ?int $maxPages = 2;

            public function isLastPage(Response $response): bool
            {
                return empty($response->array('results'));
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $response->array('results');
            }

            public function getTotalPages(Response $response): int
            {
                if (Arr::exists($response->array(), 'total_count')) {
                    return ceil($response->array('total_count') / $this->perPageLimit);
                }

                return 98;
            }
        };
    }
}
