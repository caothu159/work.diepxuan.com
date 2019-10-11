<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    protected $table = 'SoCt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ngay_ct',
        'ngay_ck',
        'ngay_tt',
        'so_ct',
        'ma_kh',
        'dien_giai',
        'ten_kh',
        'ma_vt',
        'ma_kho',
        'ten_vt',
        'dvt',
        'so_luong',
        'gia2',
        'tien2',
        'tt',
        'ma_bp',
        'ldate',
        'luser',

//        "ma_cty"       => "001",
//        "stt_rec"      => "001wSO30000013854330",
//        "stt_rec0"     => "001",
//        "stt_rec_dh"   => "",
//        "stt_rec0_dh"  => "",
//        "stt_rec_px"   => "",
//        "stt_rec0_px"  => "",
//        "stt_rec_hd"   => "",
//        "stt_rec0_hd"  => "",
//        "thang"        => "9",
//        "nam"          => "2019",
//        "ma_ct"        => "SO3",
//        "ngay_ct"      => "2019-09-01 00:00:00",
//        "so_ct"        => "HDBH6068",
//        "so_hd"        => "",
//        "so_px"        => "",
//        "so_dh"        => "",
//        "ma_nt"        => "VND",
//        "ty_gia"       => "1.0000",
//        "dien_giai"    => "mua hàng xe 05605",
//        "ma_kho"       => "KXE05605",
//        "ma_vitri"     => "",
//        "ma_vt"        => "VO GOI HQ",
//        "ten_vt"       => "vỏ gối hq",
//        "dvt"          => "Bộ",
//        "so_luong"     => "7.0000",
//        "so_luong_qd"  => "7.0000",
//        "gia_nt2"      => "70000.0000",
//        "gia2"         => "70000.0000",
//        "tien_nt2"     => "490000.0000",
//        "tien2"        => "490000.0000",
//        "tl_ck"        => ".0000",
//        "tien_ck_nt"   => ".0000",
//        "tien_ck"      => ".0000",
//        "ck_ds"        => "1792.0000",
//        "ck_ds_nt"     => "1792.0000",
//        "ts_gtgt"      => ".0000",
//        "thue_gtgt_nt" => ".0000",
//        "thue_gtgt"    => ".0000",
//        "tt_nt"        => "488208.0000",
//        "tt"           => "488208.0000",
//        "gia_nt"       => ".0000",
//        "gia"          => "14337.0000",
//        "tien_nt"      => ".0000",
//        "tien"         => "100359.0000",
//        "ma_tt"        => "",
//        "han_ck"       => ".0000",
//        "ngay_ck"      => "2019-09-01 00:00:00",
//        "tl_cktt"      => ".0000",
//        "han_tt"       => ".0000",
//        "ngay_tt"      => "2019-09-01 00:00:00",
//        "ls_qh"        => ".0000",
//        "ma_kh"        => "3LUONGTHANG",
//        "ten_kh"       => "Lương Thắng",
//        "nguoi_gd"     => "",
//        "ma_lo"        => "",
//        "ma_httt"      => "131",
//        "ma_nvkd"      => "",
//        "ma_bp"        => "XE05605",
//        "ma_phi"       => "",
//        "ma_spct"      => "",
//        "ma_nvt"       => "",
//        "ma_pt"        => "",
//        "bien_so"      => "",
//        "nguoi_lai"    => "",
//        "ma_hd"        => "",
//        "ma_td"        => "",
//        "ten_td"       => "",
//        "km"           => ".0000",
//        "khuyen_mai"   => "0",
//        "tra_lai"      => "0",
//        "tra_ck"       => "0",
//        "ma_nx"        => "",
//        "tk_pt"        => "",
//        "tk_dt"        => "5111",
//        "tk_gv"        => "632",
//        "tk_vt"        => "1561",
//        "tk_thue"      => "",
//        "tk_ck"        => "5211",
//        "trang_thai"   => "",
//        "cdate"        => "2019-09-05 08:34:00",
//        "cuser"        => "THUKHOTRANG",
//        "ldate"        => "2019-09-05 08:34:00",
//        "luser"        => "THUKHOTRANG",
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

    public function getSimilarAttribute() {
        similar_text( $this->ma_kho, $this->ma_bp, $similar );

        return $similar;
    }
}
