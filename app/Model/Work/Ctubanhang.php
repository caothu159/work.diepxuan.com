<?php

namespace App\Model\Work;

use App\Model\Sync;
use Illuminate\Database\Eloquent\Builder;

class Ctubanhang extends AbstractModel {

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

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
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function khachhang() {
        return $this->belongsTo( \App\Model\Work\Khachhang::class, 'ma_kh', 'ma_kh' );
    }

    /**
     * Lay danh sach vat tu.
     */
    public function vattus() {
        return $this->hasMany( Ctubanhangvt::class, 'stt_rec', 'stt_rec' );
    }

    /**
     * @param $query
     * @param $kho
     *
     * @return mixed
     */
    public function scopeNhomkhohang( $query, $kho = null ) {
        if ( 'all' == $kho || is_null( $kho ) ) {
            return $query;
        }

        return $query->where( 'ma_kho', $kho );
    }

    public function scopeIsSource( $query ) {
        $syncCty = Sync::where( 'type', 'ma_cty' )->first();
        $syncKh  = Sync::where( 'type', 'ma_kh' )->first();

        return $query->where( [
            [ $syncCty->type, '=', $syncCty->from ],
            [ $syncKh->type, '=', $syncKh->from ],
        ] );
    }

    static function sync() {
        $sync = Sync::where( 'type', 'ma_kh' )->first();
        $ctbh = Ctubanhang::isSource()->get();
        foreach ( $ctbh as $sp ) {
            $_sp                = $sp;
            $_sp->{$sync->type} = $sync->to;
            $_sp                = Sanpham::updateOrCreate( [
                $sync->type => $_sp->{$sync->type},
                'ma_vt'     => $_sp->ma_vt,
            ], array_filter( $_sp->toArray() ) );
            if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
                echo "\r\e[32mSyncing:\e[0m $_sp->ma_vt - $_sp->ten_vt\033[K";
            }
        }
        if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
            echo "\r\n";
        }
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::addGlobalScope( 'SO3', function ( Builder $builder ) {
            $builder->where( 'ma_ct', '=', 'SO3' );
        } );
    }
}
