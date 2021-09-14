<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Abstract\AbstractModel;

class Ctubanhang extends AbstractModel
{

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
    protected $table = 'SoPh3';

    // protected $primaryKey = [ 'ma_cty', 'ma_nhvt' ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'stt_rec';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return mixed
     */
    public function khachhang()
    {
        return $this->belongsTo(\App\Model\Work\Khachhang::class, 'ma_kh', 'ma_kh');
    }

    /**
     * Lay danh sach vat tu.
     */
    public function vattus()
    {
        return $this->hasMany(Ctubanhangvt::class, 'stt_rec', 'stt_rec');
    }

    /**
     * @param $query
     * @param $kho
     *
     * @return mixed
     */
    public function scopeNhomkhohang($query, $kho = null)
    {
        if ('all' == $kho || is_null($kho)) {
            return $query;
        }

        return $query->where('ma_kho', $kho);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('SO3', function (Builder $builder) {
            $builder->where('ma_ct', '=', 'SO3');
        });
    }
}
