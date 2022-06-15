<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     We are using trait for the Response purpose
    **/
    use ApiResponse; 


    /**
     We are using OrderRepositoryInterface for security purpose and using $orderRepository variable, we are able to access all the functions
    **/
    private $orderRepository;

    
    public function __construct(OrderRepositoryInterface $orderRepository) 
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(): JsonResponse 
    {
        $getAllOrders = $this->orderRepository->getAllOrders();
        if (!$getAllOrders) {
            return $this->errorResponse('Sorry, getAllOrders no data be found',false,400);
        }
        return $this->successResponse($getAllOrders,true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request  $request): JsonResponse 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'state' => 'required|string|max:255', 
            'zip' => 'required|numeric|min:4', 
            'amount' => 'required|string|max:255', 
            'qty' => 'required|numeric|min:1', 
            'item' => 'required|string|min:3' 
        ]);

        if($validator->fails()){ 
            return $this->errorMessage($validator->errors()->toJson(),false,401);
        }
        $orderDetails = $request->only([
            'name','state','zip','amount','qty','item'
        ]);
        
        $data = $this->orderRepository->createOrder($orderDetails);
        if($data){
            return $this->successResponse($data,true,201);
        }else{
            return $this->errorResponse('Sorry, Order could not be added',false, 500); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($orderId): JsonResponse
    {
        $getAllOrders = $this->orderRepository->getOrderById($orderId);
        if (!$getAllOrders) {
            return $this->errorResponse('Sorry, getAllOrders no data be found',false,400);
        }
        return $this->successResponse($getAllOrders,true);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$orderId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'state' => 'required|string|max:255', 
            'zip' => 'required|numeric|min:4', 
            'amount' => 'required|string|max:255', 
            'qty' => 'required|numeric|min:1', 
            'item' => 'required|string|min:3' 
        ]);
        if($validator->fails()){ 
            return $this->errorMessage($validator->errors()->toJson(),false,401);
        }
        $orderDetails = $request->only([
            'name','state','zip','amount','qty','item'
        ]);
        $data = $this->orderRepository->updateOrder($orderId, $orderDetails);
        if($data){
            return $this->successResponse($data,true,200);
        }else{
            return $this->errorResponse('Sorry, Order could not be updated',false, 500); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($orderId)
    {
        $data = $this->orderRepository->deleteOrder($orderId);
        if($data){
            return $this->successResponse($data,true,200);
        }else{
            return $this->errorResponse('Sorry, deleteOrder could not be deleted',false,500); 
        }
    }
    public function createCSVFile(){
        $data = $this->orderRepository->createCSVFile();
        if($data){
            return $this->successResponse($data,true,200);
        }else{
            return $this->errorResponse('Sorry, Data could not be dumped to CSV',false, 500); 
        }
    }

}
