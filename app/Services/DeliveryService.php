<?php

namespace App\Services;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

final class DeliveryService
{
    public function search(array $data): Collection
    {
        $query = Delivery::query()
            ->select('deliveries.*')
            ->leftJoin(
                'companies',
                'deliveries.company_id',
                '=',
                'companies.id'
            );

        $deliveries = $this->filterQuery($query, $data)->get()
            ->filter(function (Delivery $delivery) use ($data) {
                $delivery->applyDeliveryCost();
                if (isset($data['minDeliveryCost'])) {
                    return
                        $delivery->deliveryCost >= $data['minDeliveryCost'] &&
                        $delivery->deliveryCost <= $data['maxDeliveryCost'];
                }
                return true;
            });

        return $deliveries;
    }

    private function filterQuery(Builder $query, array $data)
    {
        return $query
            ->when(
                isset($data['companyId']),
                function (Builder $query) use ($data) {
                    $query->where('companies.id', $data['companyId']);
                }
            )
            ->when(
                isset($data['companyName']),
                function (Builder $query) use ($data) {
                    $this->applyLikeFilter($query, 'name', $data['companyName']);
                }
            )
            ->when(
                isset($data['minWeight']),
                function (Builder $query) use ($data) {
                    $query->whereBetween(
                        'deliveries.weight',
                        Arr::only($data,['minWeight','maxWeight'])
                    );
                }
            )
            ->when(
                isset($data['minPrice']),
                function (Builder $query) use ($data) {
                    $query->whereBetween(
                        'deliveries.price',
                        Arr::only($data,['minPrice','maxPrice'])
                    );
                }
            )
            ->when(
                isset($data['description']),
                function (Builder $query) use ($data) {
                    $this->applyLikeFilter($query, 'description', $data['description']);
                }
            );
    }

    private function applyLikeFilter(Builder $query, string $by, string $value): void
    {
        $keywords = explode(' ', $value);

        foreach ($keywords as $keyword) {
            $query->whereRaw("lower($by) LIKE ?", '%' . strtolower($keyword) . '%');
        }
    }
}
