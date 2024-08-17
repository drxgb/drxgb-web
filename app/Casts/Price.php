<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;


/**
 * Formata o atributo para preços.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class Price implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes) : mixed
    {
        return number_format(num: floatval($value), decimals: 2);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes) : mixed
    {
        return floatval($value);
    }
}
