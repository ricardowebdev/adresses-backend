<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJsonResponse()
    {
        $data = $this->jsonSerialize();
        $http_code = $data['http_code'];
        unset( $data['http_code']);
        if(empty($data['message']))
            unset($data['message']);

        return response()->json($data, $http_code);
    }
}
