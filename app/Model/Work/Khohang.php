<?php

namespace App\Model\Work;

use Illuminate\Database\Eloquent\Model;

class Khohang extends Model {

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
    protected $table = 'InDmKho';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return mixed
     */
    public function ctubanhangs() {
        return $this->belongsTo( \App\Model\Work\Ctubanhang::class, 'ma_kho', 'ma_kho' );
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsEnable( $query ) {
        return $query->where( 'ksd', 0 );
    }
}
