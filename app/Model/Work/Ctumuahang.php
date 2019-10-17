<?php

namespace App\Model\Work;

use Illuminate\Database\Eloquent\Model;

class Ctumuahang extends Model {

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
    protected $table = 'ApTt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "ma_kh"     => "CCVINA",
        "tk_pt"     => "331",
        "dien_giai" => "mua 1/10 vina",
        "so_ct"     => "HDMH00096",
        "t_tt"      => "19360000.0000",
        "du_hd"     => "19360000.0000",
        "ldate"     => "2019-10-01 07:28:00",
        "luser"     => "XUANPHAN",

//        "ma_cty"     => "001",
//        "stt_rec"    => "001wPO30000013856280",
//        "stt_rec_hd" => "",
//        "stt_rec_dh" => "",
//        "thang"      => "10",
//        "nam"        => "2019",
//        "loai_tt"    => "1",
//        "ma_gd"      => "",
//        "ma_ct"      => "PO3",
//        "ma_kh"      => "CCVINA",
//        "nguoi_gd"   => "",
//        "ma_hd"      => "",
//        "tk_pt"      => "331",
//        "ma_tt_po"   => "",
//        "han_ck"     => "0",
//        "ngay_ck"    => "2019-10-01 00:00:00",
//        "tl_ck"      => ".0000",
//        "han_tt"     => "0",
//        "ngay_tt"    => "2019-10-01 00:00:00",
//        "ls_qh"      => ".0000",
//        "dien_giai"  => "mua 1/10 vina",
//        "so_ct"      => "HDMH00096",
//        "ngay_ct"    => "2019-10-01 00:00:00",
//        "ma_nt"      => "VND",
//        "ty_gia"     => "1.0000",
//        "t_tien0"    => ".0000",
//        "t_tien_nt0" => ".0000",
//        "t_thue"     => ".0000",
//        "t_thue_nt"  => ".0000",
//        "t_tt"       => "19360000.0000",
//        "t_tt_nt"    => "19360000.0000",
//        "tien_tt"    => ".0000",
//        "tien_tt_nt" => ".0000",
//        "tien_tt_qd" => ".0000",
//        "t_tien"     => ".0000",
//        "t_tien_nt"  => ".0000",
//        "tien_pb"    => ".0000",
//        "tien_pb_nt" => ".0000",
//        "du_hd"      => "19360000.0000",
//        "du_hd_nt"   => "19360000.0000",
//        "du_pc"      => ".0000",
//        "du_pc_nt"   => ".0000",
//        "du_tt"      => ".0000",
//        "du_tt_nt"   => ".0000",
//        "chenh_lech" => ".0000",
//        "tat_toan"   => "",
//        "cdate"      => "2019-10-01 07:28:00",
//        "cuser"      => "XUANPHAN",
//        "ldate"      => "2019-10-01 07:28:00",
//        "luser"      => "XUANPHAN",
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

}
