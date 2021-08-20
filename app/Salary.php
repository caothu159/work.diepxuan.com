<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App;

use App\Models\Salary as Model;
use App\Services\SalaryServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Awobaz\Compoships\Compoships as ExtraRelationShip;

/**
 * Class Salary công tháng.
 */
class Salary extends Model
{
    use ExtraRelationShip;
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
        return implode("/", [$this->ngay, $this->thang, $this->nam]);
    }

    public function getNangsuatAttribute($nangsuat)
    {
        $nangsuat = $this->doanhso;
        $nangsuat += $this->chono * 0.7;
        $nangsuat -= $this->thuno * 0.7;
        $nangsuat *= $this->tile;

        return $nangsuat;
    }

    public function getLuongnangsuatAttribute()
    {
        if (in_array($this->diadiem, ["01593", "05605", "03166", "12827"])) {
            return 0;
        }
    }

    public function getLuongAttribute($luong)
    {
        $chitieu = ($this->chitieu / 30) * $this->chamcong;
        // $isLaixe = in_array($this->diadiem, [
        //     "01593",
        //     "05605",
        //     "03166",
        //     "12827",
        // ]);

        // if ($chitieu > 0 && $isLaixe) {
        //     $luong = ($this->nangsuat - $chitieu) * $this->heso;
        //     $luong += ($this->luongcoban / 30) * $this->chamcong;
        // }

        if (in_array($this->diadiem, ["01593", "05605", "03166", "12827"])) {
            /** luong nang suat co chi tieu */
            $luong = ($this->nangsuat - $chitieu) * $this->heso;
            $luong += ($this->luongcoban / 30) * $this->chamcong;
        } elseif (0 == $this->doanhso) {
            /** luong cong nhat */
            $luong = ($this->luongcoban / 30) * $this->chamcong;
        } elseif (
            in_array($this->diadiem, ["cua hang", "showroom"]) &&
            (0 == $this->chitieu || null == $this->chitieu)
        ) {
            /** luong nang suat khong chi tieu  */
            $luong = ($this->nangsuat - $chitieu) * ($this->heso ?: 0.01);
            $luong += ($this->luongcoban / 30) * $this->chamcong;
        } else {
            $luong = ($this->luongcoban / 30) * $this->chamcong;
        }

        return $luong;
    }

    public function getHesoStrAttribute($heso)
    {
        $heso = $this->heso * 100;

        return $heso ? "$heso %" : "-";
    }

    public function getBaohiemAttribute($baohiem)
    {
        return (($baohiem * 0.215) / 30) * $this->chamcong;
    }

    /**
     * @return mixed
     */
    public function salaryuser()
    {
        return $this->belongsTo(
            \App\SalaryUser::class,
            ["nam", "thang", "ten"],
            ["nam", "thang", "ten"]
        );
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("salary.user", function (Builder $builder) {
            if (!$builder->getQuery()->groups) {
                $builder->addSelect(
                    DB::raw('*,
                    (select `luongcoban` from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaryuser`.ngay is null
                        and `salaries`.ten = `salaryuser`.ten
                        limit 1) as `luongcoban`,
                    (select `congthang` from `salaries` as `salaryuser`
                        where `salaries`.nam = `salaryuser`.nam
                        and `salaries`.thang = `salaryuser`.thang
                        and `salaryuser`.ngay is null
                        and `salaries`.ten = `salaryuser`.ten
                        limit 1) as `congthang`,
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
                        and `salaries`.diadiem = `salaryuser`.diadiem
                        and `salaries`.doanhso = `salaryuser`.doanhso
                        )) as `tile`,
                    (select (if(`salaries`.doanhso IS null,0,`salaries`.doanhso)
                            + if(`salaries`.chono IS null,0,`salaries`.chono) * 0.7
                            - if(`salaries`.thuno IS null,0,`salaries`.thuno) * 0.7
                        ) * `tile`) as `nangsuat`')
                );
            }
            $builder->where("ngay", "<>", null);
        });
    }
}
