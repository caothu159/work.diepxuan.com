<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App;

use App\Models\SalaryUser as Model;
use App\Services\SalaryServiceInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Salary công tháng
 * @package App
 */
class SalaryUser extends Model
{
    /**
     * Undocumented variable
     *
     * @var App\Services\SalaryService
     */
    private $salaryService;

    public function __construct(array $attributes = [])
    {
        $this->salaryService = app(SalaryServiceInterface::class);
        parent::__construct($attributes);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('salary.user', function (Builder $builder) {
            $builder->where('ngay', null);
        });
    }
}
