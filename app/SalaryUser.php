<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App;

use App\Models\SalaryUser as Model;
use App\Services\SalaryServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Awobaz\Compoships\Compoships as ExtraRelationShip;

/**
 * Class Salary công tháng.
 */
class SalaryUser extends Model
{
    use ExtraRelationShip;

    /**
     * Undocumented variable.
     *
     * @var App\Services\SalaryService
     */
    private $salaryService;

    private $congduthang = [
        "30" => 30,
        "28" => 28,
        "28+2" => 30,
    ];

    public function __construct(array $attributes = [])
    {
        $this->salaryService = app(SalaryServiceInterface::class);
        parent::__construct($attributes);
    }

    public function getChamcongAttribute($nangsuat)
    {
        return $this->salaries->sum("chamcong");
    }

    public function getDoanhsoAttribute($nangsuat)
    {
        return $this->salaries->sum("doanhso");
    }

    public function getNangsuatAttribute($nangsuat)
    {
        return $this->salaries->sum("nangsuat");
    }

    public function getCongtinhluongAttribute($congtinhluong)
    {
        switch ($this->congthang) {
            case "30":
                $congtinhluong = $this->chamcong;
                break;

            case "28":
                $congtinhluong = $this->chamcong;
                break;

            case "28+2":
                $congtinhluong =
                    $this->chamcong > 28
                        ? $this->chamcong + 2
                        : $this->chamcong;
                break;

            default:
                $congtinhluong = 30;
                break;
        }
        return $congtinhluong;
    }

    public function getLuongAttribute($luong)
    {
        $congduthang = $this->congduthang[$this->congthang];
        $luongcoban = ($this->luongcoban / $congduthang) * $this->congtinhluong;
        $chitieu = ($this->chitieu / $congduthang) * $this->congtinhluong;

        /** chi tieu */
        if ($this->chitieu > 0) {
            $luong = ($this->nangsuat - $chitieu) * $this->heso;
            $luong += $luongcoban;
            return $luong;
        }

        /** nang suat */
        if ($this->chitieu == -1) {
            $luong = $this->nangsuat * $this->heso;
            $luong += $luongcoban;
            return $luong;
        }

        /** cong nhat */
        if ($this->chitieu == 0) {
            $luong = $luongcoban;
            return $luong;
        }

        return $luongcoban;
    }

    public function getBaohiemmucnopAttribute($bhmn)
    {
        $bhmn = $this->baohiem * 0.32;
        return $bhmn;
    }

    public function getBaohiemtrocapAttribute($bhtc)
    {
        $bhtc = $this->salaries->sum("baohiem");
        return $bhtc;
    }

    public function getBaohiemphainopAttribute($bhpn)
    {
        $bhpn = $this->baohiemmucnop - $this->baohiemtrocap;
        return $bhpn;
    }

    public function salaries()
    {
        /** without compoships */
        // return $this->hasMany(\App\Salary::class, "ten", "ten")
        //     ->where("nam", $this->nam)
        //     ->where("thang", $this->thang)
        //     ->where("nam", $this->nam);

        /** with compoships */
        return $this->hasMany(
            \App\Salary::class,
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
            $builder->where("ngay", null);
        });
    }
}
