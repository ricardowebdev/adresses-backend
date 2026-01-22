<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\Answerable;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, Answerable;

    public function unauthorizedResponse()
    {
        return self::answer(self::$ANSWER_WARNING, trans('forms.unauthorized_action'), Response::HTTP_UNAUTHORIZED, ['data' => []]);
    }
}
