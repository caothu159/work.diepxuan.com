<?php

namespace App\Models\Work;

use Illuminate\Support\Facades\DB;
use App\Models\Abstract\AbstractModel;
use App\Models\Traits\HasCompositePrimaryKey;

class Ctubanhangvt extends AbstractModel
{
    use HasCompositePrimaryKey;

    const CREATED_AT = 'cdate';
    const UPDATED_AT = 'ldate';

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'sqlsrv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'SoCt3';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = [ 'stt_rec', 'stt_rec0' ];

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    // protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public static $groupKhachhang = [
        'ma_kho',
        'ma_kh',
    ];

    public static $groupDonhang = [
        'ngay_ct',
        'ma_kh',
        'ma_kho',
        'ma_bp',
        'ten_kh',
        'dien_giai',
        'ma_kho',
        'luser',
        'so_ct',
        'ma_ct',
    ];

    /**
     * @return mixed
     */
    public function khachhang()
    {
        return $this->belongsTo(\App\Model\Work\Khachhang::class, 'ma_kh', 'ma_kh');
    }

    /**
     * @return mixed
     */
    public function khohang()
    {
        return $this->belongsTo(\App\Model\Work\Khohang::class, 'ma_kho', 'ma_kho');
    }

    /**
     * @return mixed
     */
    public function ctubanhang()
    {
        return $this->belongsTo(\App\Model\Work\Ctubanhang::class, 'stt_rec', 'stt_rec');
    }

    /**
     * @return mixed
     */
    public function getSimilarAttribute()
    {
        similar_text($this->ma_kho, $this->ma_bp, $similar);

        return $similar;
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNhomkhachhang($query)
    {
        return $query->groupBy(Ctubanhang::$groupKhachhang)
                     ->addSelect(Ctubanhang::$groupKhachhang)
                     ->addSelect(DB::raw('sum(tien2) as tien2'))
                     ->orderBy('ma_kh', 'asc');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNhomdonhang($query)
    {
        return $query->groupBy(Ctubanhang::$groupDonhang)
                     ->addSelect(Ctubanhang::$groupDonhang)
                     ->addSelect(DB::raw('sum(tien2) as tien2'));
    }

    /**
     * @param $query
     * @param $kho
     *
     * @return mixed
     */
    public function scopeNhomkhohang($query, $kho)
    {
        if ('all' == $kho) {
            return $query;
        }

        return $query->where('ma_kho', $kho);
    }
}
