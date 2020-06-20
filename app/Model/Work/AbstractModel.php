<?php


namespace App\Model\Work;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model {
    protected $dateFormat = 'Y-m-d H:i:s';
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
