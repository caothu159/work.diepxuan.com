<?php

namespace App\Model\Work;

use App\Model\Sync;
use Illuminate\Database\Eloquent\Builder;

class Ctumuahang extends AbstractModel {

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
    protected $table = 'PoPh3';

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

    /**
     * Lay danh sach vat tu.
     */
    public function vattus() {
        return $this->hasMany( Ctumuahangvt::class, 'stt_rec', 'stt_rec' );
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsDestination( $query ) {
        $syncCty = Sync::where( 'type', 'ma_cty' )->first();
        $syncKh  = Sync::where( 'type', 'ma_kh' )->first();

        return $query->where( [
            [ $syncCty->type, '=', $syncCty->to ],
            [ $syncKh->type, '=', $syncKh->to ],
        ] );
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::addGlobalScope( 'PO3', function ( Builder $builder ) {
            $builder->where( 'ma_ct', '=', 'PO3' );
        } );
    }

}
