<?php

namespace App\Modules\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Api\Resources\CtubanhangvtResource;

class CtubanhangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = parent::toArray($request);
        // $resource['vattus'] = CtubanhangvtResource::collection($this->vattus);
        return $resource;
    }
}
