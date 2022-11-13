<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;
    use CamelCasing;

    protected $fillable = [
        'companyId',
        'price',
        'weight',
        'description',
    ];

    protected $casts = [
        'price' => 'float',
        'weight' => 'float',
    ];

    protected $appends = [
        'deliveryCost'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return mixed
     */
    public function getDeliveryCostAttribute()
    {
        $formula = str_replace(
            Company::FORMULA_VAR,
            $this->weight,
            $this->company->formula
        );

        return eval($formula);
    }
}
