<?php

namespace App\Model\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ctubanhang extends Model {

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
    public $timestamps = true;

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
    public function khachhang() {
        return $this->belongsTo( \App\Model\Work\Khachhang::class, 'ma_kh', 'ma_kh' );
    }

    /**
     * @return mixed
     */
    public function khohang() {
        return $this->belongsTo( \App\Model\Work\Khohang::class, 'ma_kho', 'ma_kho' );
    }

    /**
     * @return mixed
     */
    public function getSimilarAttribute() {
        similar_text( $this->ma_kho, $this->ma_bp, $similar );

        return $similar;
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNhomkhachhang( $query ) {
        return $query->groupBy( Ctubanhang::$groupKhachhang )
                     ->addSelect( Ctubanhang::$groupKhachhang )
                     ->addSelect( DB::raw( 'sum(tien2) as tien2' ) )
                     ->orderBy( 'ma_kh', 'asc' );
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNhomdonhang( $query ) {
        return $query->groupBy( Ctubanhang::$groupDonhang )
                     ->addSelect( Ctubanhang::$groupDonhang )
                     ->addSelect( DB::raw( 'sum(tien2) as tien2' ) );
    }

    /**
     * @param $query
     * @param $kho
     *
     * @return mixed
     */
    public function scopeNhomkhohang( $query, $kho ) {
        if ( 'all' == $kho ) {
            return $query;
        }

        return $query->where( 'ma_kho', $kho );
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
