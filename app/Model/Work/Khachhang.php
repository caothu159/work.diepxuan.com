<?php

namespace App\Model\Work;

use Illuminate\Database\Eloquent\Model;

class Khachhang extends Model {

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
    protected $table = 'ArDmKh';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        ma_cty
//      ma_kh
//      loai
//      ten_kh
//      ma_so_thue
//      dia_chi
//      tel
//      fax
//      email
//      home_page
//      nguoi_gd
//      ma_ngh
//      ten_nh
//      cn_nh
//      so_tk_nh
//      tinh_tp_nh
//      tk
//      ma_plkh1
//      ma_plkh2
//      ma_plkh3
//      ma_nhkh
//      ma_tt
//      ma_httt
//      ma_httt_po
//      gh_no
//      han_ck
//      tl_ck
//      han_tt
//      ls_qh
//      ghi_chu
//      tinh_dt_nb
//      isKh
//      isNcc
//      isNv
//      ksd
//      cdate
//      cuser
//      ldate
//      luser
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
        return $this->belongsTo( \App\Model\Work\Ctubanhang::class, 'ma_kh', 'ma_kh' );
    }

}
