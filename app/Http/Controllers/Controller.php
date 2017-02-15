<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @param $message
     * @return Response
     */
    private function responseJson($message)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation error!',
            'errors' => $message,
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param $validator
     * @return Response
     */
    protected function responseWithErrorMessage($validator)
    {
        $messages = [];
        $validatorMessages = $validator->errors()->toArray();
        foreach($validatorMessages as $field => $message) {
            foreach ($message as $error) {
                $messages[] = $error;
            }
        }

        return $this->responseJson($messages);
    }

}