<?php

namespace App\Model\Work;

use Illuminate\Database\Eloquent\Model;

class Ctumuahang extends Model {

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
    protected $table = 'PoCt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        "ma_cty"          => "001",
//        "stt_rec"         => "001wPO30000013856280",
//        "stt_rec0"        => "001",
//        "stt_rec_pdn"     => "",
//        "stt_rec0_pdn"    => "",
//        "stt_rec_dh"      => "",
//        "stt_rec0_dh"     => "",
//        "stt_rec_pn"      => "",
//        "stt_rec0_pn"     => "",
//        "stt_rec_hd"      => "",
//        "stt_rec0_hd"     => "",
//        "so_pdn"          => "",
//        "so_dh"           => "",
//        "so_pn"           => "",
//        "so_hd"           => "",
//        "ngay_ct"         => "2019-10-01 00:00:00",
//        "so_ct"           => "HDMH00096",
//        "thang"           => "10",
//        "nam"             => "2019",
//        "ma_ct"           => "PO3",
//        "ma_vt"           => "RNK9F1419",
//        "ten_vt"          => "Ruột nệm korea 9F 14 19",
//        "ma_kho"          => "KKCN",
//        "ma_vitri"        => "",
//        "ma_lo"           => "",
//        "so_luong"        => "44.0000",
//        "dvt"             => "Cái",
//        "so_luong_qd"     => "44.0000",
//        "gia_nt0"         => ".0000",
//        "gia0"            => "440000.0000",
//        "tien_nt0"        => ".0000",
//        "tien0"           => "19360000.0000",
//        "ts_nk"           => ".0000",
//        "thue_nk_nt"      => ".0000",
//        "thue_nk"         => ".0000",
//        "ts_ttdb"         => ".0000",
//        "thue_ttdb_nt"    => ".0000",
//        "thue_ttdb"       => ".0000",
//        "cp_nt"           => ".0000",
//        "cp"              => ".0000",
//        "gia_nt"          => ".0000",
//        "gia"             => "440000.0000",
//        "tien_nt"         => ".0000",
//        "tien"            => "19360000.0000",
//        "ts_gtgt"         => ".0000",
//        "thue_gtgt_nt"    => ".0000",
//        "thue_gtgt"       => ".0000",
//        "tt_nt"           => ".0000",
//        "tt"              => "19360000.0000",
//        "tk_thue_nk"      => "",
//        "tk_thue_ttdb"    => "",
//        "tk_thue_gtgt_no" => "",
//        "tk_thue_gtgt_co" => "",
//        "ma_gd"           => "",
//        "ma_kh"           => "CCVINA",
//        "nguoi_gd"        => "",
//        "nguoi_giao"      => "",
//        "trang_thai"      => "",
//        "ma_hd"           => "",
//        "ma_bp"           => "",
//        "ma_phi"          => "",
//        "ma_spct"         => "",
//        "ma_tt_po"        => "",
//        "ma_httt"         => "331",
//        "dien_giai"       => "mua 1/10 vina",
//        "ma_nt"           => "VND",
//        "ty_gia"          => "1.0000",
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
    public $timestamps = false;

}
