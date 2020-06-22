<?php


namespace App\Model\Work;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model {
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'cdate', 'ldate', 'ngay_ct' ];

    /**
     * @param $query
     *
     * @return mixed
     */
    function scopeIsSource( $query ) {
        $sync = Sync::where( 'type', 'ma_cty' )->first();

        return $query->where( $sync->type, '=', $sync->from );
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    function scopeIsDestination( $query ) {
        $syncCty = Sync::where( 'type', 'ma_cty' )->first();

        return $query->where( $syncCty->type, '=', $syncCty->to );
    }

    static public function syncChange() {
        $ctbh   = Ctubanhang::isSource()->get();
        $ctmh   = Ctumuahang::isDestination()->get();
        $return = $ctbh;
        $return->merge( $ctmh );
        $return->sortBy( 'ngay_ct' );
        foreach ( $ctbh as $ct ) {
            $ct->vattus;
        }

        return $ctbh;
    }
}

trait HasCompositePrimaryKey {

    /**
     * Get the primary key value for a save query.
     *
     * @return mixed
     */
    protected function setKeysForSaveQuery( Builder $query ) {
        $keys = $this->getKeyName();
        if ( ! is_array( $keys ) ) {
            return parent::setKeysForSaveQuery( $query );
        }

        foreach ( $keys as $keyName ) {
            $query->where( $keyName, '=', $this->getKeyForSaveQuery( $keyName ) );
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     *
     * @return mixed
     */
    protected function getKeyForSaveQuery( $keyName = null ) {
        if ( is_null( $keyName ) ) {
            $keyName = $this->getKeyName();
        }

        if ( isset( $this->original[ $keyName ] ) ) {
            return $this->original[ $keyName ];
        }

        return $this->getAttribute( $keyName );
    }
}
