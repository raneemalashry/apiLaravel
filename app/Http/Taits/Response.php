<?php
namespace App\Http\Traits;

trait ResponseTrait {
public function jsonResponse($sucess, $msg, $data = null){
    return response([
        'success' => $sucess,
        'message' => $msg,
        'data' => $data,
    ]);

} 
}
?>