<?php

namespace App\Model\Work;

use App\Model\Sync;

class Nhomsanpham extends AbstractModel {
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
    protected $table = 'InDmNhvt';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = [ 'ma_cty', 'ma_nhvt' ];

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
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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

    static function sync() {
        $sync   = Sync::where( 'type', 'ma_cty' )->first();
        $dmnhsp = Nhomsanpham::isSource()->isEnable()->get();
        foreach ( $dmnhsp as $nhsp ) {
            $_nhsp                = $nhsp;
            $_nhsp->{$sync->type} = $sync->to;
            $_nhsp                = Nhomsanpham::updateOrCreate( [
                $sync->type => $_nhsp->{$sync->type},
                'ma_nhvt'   => $_nhsp->ma_nhvt,
            ], array_filter( $_nhsp->toArray() ) );
            if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
                echo "\r\e[32mSyncing:\e[0m $_nhsp->ma_nhvt - $_nhsp->ten_nhvt\033[K";
            }
        }
        if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
            echo "\r\n";
        }
    }
}
