<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App;

use App\Models\Salary as Model;
use App\Services\SalaryServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class Salary công tháng.
 */
class Salary extends Model
{
    /**
     * Undocumented variable.
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
        $thoigian = [
            $this->ngay,
            $this->thang,
            $this->nam,
        ];
        $thoigian = implode('/', $thoigian);

        return $thoigian;
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
        $chitieu = $this->chitieu / 30 * $this->chamcong;
        $luong   = ($this->nangsuat - $chitieu) * $this->heso;

        if (in_array($this->diadiem, ['01593', '05605', '03166'])) {
            $luong += $this->luongcoban / 30 * $this->chamcong;
        } elseif (0 == $this->doanhso) {
            $luong = $this->luongcoban / 30 * $this->chamcong;
        }

        return $luong;
    }

    public function getHesoStrAttribute($heso)
    {
        $heso = $this->heso * 100;

        return $heso ? "$heso %" : '-';
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
            if (!$builder->getQuery()->groups) {
                $builder->addSelect(DB::raw('*,
                    (select `luongcoban` from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaryuser`.ngay is null
                        and `salaries`.ten = `salaryuser`.ten
                        limit 1) as `luongcoban`,
                    (select `heso` from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaryuser`.ngay is null
                        and `salaries`.ten = `salaryuser`.ten
                        limit 1) as `heso`,
                    (select `chitieu` from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaryuser`.ngay is null
                        and `salaries`.ten = `salaryuser`.ten
                        limit 1) as `chitieu`,
                    (select `baohiem` from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaryuser`.ngay is null
                        and `salaries`.ten = `salaryuser`.ten
                        limit 1) as `baohiem`,
                    IF(`tile` > 0, `tile`, (SELECT 1/COUNT(*) from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaries`.ngay = `salaryuser`.ngay
                        and `salaries`.doanhso = `salaryuser`.doanhso
                        )) as `tile`,
                    (select (if(`salaries`.doanhso IS null,0,`salaries`.doanhso)
                            + if(`salaries`.chono IS null,0,`salaries`.chono) * 0.7
                            - if(`salaries`.thuno IS null,0,`salaries`.thuno) * 0.7
                        )*1/COUNT(*) from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaryuser`.ngay = `salaryuser`.ngay
                        and `salaries`.diadiem = `salaryuser`.diadiem
                        and `salaries`.doanhso = `salaryuser`.doanhso
                        limit 1) as `nangsuat`'));
            }
            $builder->where('ngay', '<>', null);
        });
    }
}
