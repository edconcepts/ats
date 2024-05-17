<?php

namespace App\Traits;

use App\Scopes\OrderScope;
use App\Settings\OrderOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

trait HasOrder
{
    public static function bootHasOrder()
    {
        static::addGlobalScope(new OrderScope());

        static::creating(function (Model $model) {
            $orderOptions = $model->getOrderOptions();
            if ($orderOptions->shouldOrderOnCreate()) {
                $orderColumn = $orderOptions->getOrderColumn();

                if (empty($model->{$orderColumn}) && ! is_numeric($model->{$orderColumn})) {
                    $query = DB::table($model->getTable());

                    if ($orderOptions->hasParentColumn()) {
                        $column = $orderOptions->getParentColumn();
                        $query->where($column, $model->{$column});
                    }

                    if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
                        // We don't want to care about deleted stuff
                        $query->whereNull('deleted_at');
                    }

                    // If no rows exist, order === null, therefore we apply -1. We use -1 so we can be lazy and just
                    // always increment one.
                    $baseOrder = $orderOptions->startOrderFrom() - 1;

                    $max = $query->max($orderColumn) ?? $baseOrder;
                    $model->{$orderColumn} = $max + 1;
                }
            }
        });

        static::deleting(function (Model $model) {
            $orderOptions = $model->getOrderOptions();
            if ($orderOptions->shouldFixOrderOnDelete()) {
                $orderColumn = $orderOptions->getOrderColumn();
                $currentOrder = $model->{$orderColumn};

                $query = DB::table($model->getTable())->where($orderColumn, '>', $currentOrder);

                if ($orderOptions->hasParentColumn()) {
                    $column = $orderOptions->getParentColumn();
                    $query->where($column, $model->{$column});
                }

                if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
                    // We don't want to care about deleted stuff
                    $query->whereNull('deleted_at');
                }

                $query->decrement($orderColumn);
            }
        });
    }

    /**
     * Can be overridden if default settings don't apply.
     */
    public function getOrderOptions(): OrderOptions
    {
        return new OrderOptions;
    }

    public function scopeUnordered(Builder $query): Builder
    {
        return $query->withoutGlobalScope(OrderScope::class);
    }
}
