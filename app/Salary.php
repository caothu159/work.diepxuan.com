<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App;

use App\Model\Salary as Model;
use App\Services\SalaryServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class Salary công tháng
 * @package App
 */
class Salary extends Model
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

    public function getThoigianAttribute()
    {
        $thoigian = array(
            $this->ngay,
            $this->thang,
            $this->nam
        );
        $thoigian = implode('/', $thoigian);
        return $thoigian;
    }

    public function getHesoAttribute($heso = null)
    {
        if ($heso !== null) {
            return $heso;
        }
        if ($user = $this->salaryService->getUser($this->ten))
            return $user->heso;
    }

    public function getLuongcobanAttribute($luongcoban = null)
    {
        if ($luongcoban !== null) {
            return $luongcoban;
        }
        if ($user = $this->salaryService->getUser($this->ten))
            return $user->luongcoban;
    }

    public function getChitieuAttribute($chitieu = null)
    {
        if ($chitieu !== null) {
            return $chitieu;
        }
        if ($user = $this->salaryService->getUser($this->ten))
            return $user->chitieu;
    }

    public function getBaohiemAttribute($baohiem = null)
    {
        if ($baohiem !== null) {
            return $baohiem;
        }
        if ($user = $this->salaryService->getUser($this->ten))
            return $user->baohiem;
    }

    public function getNangsuatAttribute($nangsuat)
    {
        $nangsuat = $this->doanhso;
        $nangsuat += $this->chono * 0.7;
        $nangsuat -= $this->thuno * 0.7;
        $nangsuat *= $this->tile;
        return $nangsuat;
    }

    public function getLuongAttribute($luong)
    {
        if (in_array($this->diadiem, ['kho', 'nha', 'dang kiem'])) {
            $luong = $this->luongcoban / 30 * $this->chamcong;
        } elseif (in_array($this->diadiem, ['nghi khong phep'])) {
            $chitieu = $this->chitieu / 30;
            $luong = ($this->nangsuat - $chitieu) * $this->heso;
        } else {
            $chitieu = $this->chitieu / 30;
            $luong = $this->luongcoban / 30 * $this->chamcong;
            $luong += ($this->nangsuat - $chitieu) * $this->heso;
        }
        return $luong;
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
            $builder->where('ngay', '<>', null);
        });
    }
}
