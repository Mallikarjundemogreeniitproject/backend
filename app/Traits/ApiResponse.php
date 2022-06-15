<?php

namespace App\Traits;

use Illuminate\Http\Response as Response;
use Illuminate\Http\JsonResponse;

trait ApiResponse 
{

  /**
   * Build a success response
   * @param string|array $data
   * @param int $code
   * @return Illuminate\Http\Response
   */
  public function successResponse($data, $statue = true, $code = Response::HTTP_OK):JsonResponse
  {
    return response()->json(['success' =>$statue,'data' => $data], $code)->header('Content-type', 'application/json');
  }

  /**
   * Build a valid response
   * @param string|array $data
   * @param int $code
   * @return Illuminate\Http\JsonResponse
   */
  public function validResponse($data,$statue, $code = Response::HTTP_OK):JsonResponse
  {
    return response()->json(['success' =>$statue,'data' => $data], $code);
  }


  /**
   * Build a error response
   * @param string $message
   * @param int $code
   * @return Illuminate\Http\JsonResponse
   */
  public function errorResponse($message,$statue, $code)
  {
    return response()->json(['success' =>$statue,'error' => $message, 'code' => $code], $code);
  }

  /**
   * Return an error in JSON format
   * @param string $message
   * @param int $code
   * @return Illuminate\Http\Response
   */
  public function errorMessage($message,$statue= false, $code)
  {
    return response()->json(['success' =>$statue,'error' => $message, 'code' => $code], $code)->header('Content-type', 'application/json');
  }

}