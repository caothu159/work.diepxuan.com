<?php

namespace App\Model\Work;

use App\Model\Sync;

class Sanpham extends AbstractModel {

    const CREATED_AT = 'cDate';
    const UPDATED_AT = 'lDate';

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
    protected $table = 'InDmVt';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = [ 'ma_cty', 'ma_vt' ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
    protected $guarded = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'lDate',
        'cDate',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsEnable( $query ) {
        return $query->where( 'ksd', 0 );
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsSource( $query ) {
        $sync = Sync::where( 'type', 'ma_cty' )->first();

        return $query->where( $sync->type, '=', $sync->from );
    }
}
