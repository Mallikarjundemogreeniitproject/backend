<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use DB;

class OrderRepository implements OrderRepositoryInterface 
{

    /**
     *  Get Order list
     *
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return array
     *
     */
    public function getAllOrders() 
    {
        $file = base_path().'/public/data.csv';
        if(file_exists($file)){
            return $this->readCSVToArray($file);
        }else{
            return Order::all();
        }
    }


    /**
     *  Get Order list by $orderId value
     *  based on given orderId
     *
     *  @params:  orderId
     *
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return array
     *
     */
    public function getOrderById($orderId)
    {
        return Order::find($orderId);
    }


    /**
     *  Create Order array $orderDetails values
     *
     *  @params:  name, state, zip, amount, qty, item
     *
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return array
     *
     */
    public function createOrder(array $orderDetails) 
    {
    	$status = false;
    	DB::beginTransaction();
        try {
         	$status = Order::create($orderDetails);
         	DB::commit();
            OrderRepository::createCSVFile();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $status;
    }

    /**
     *  Update Order array $orderDetails values
     *  based on given orderId
     *
     *  @params:  name, state, zip, amount, qty, item
     *
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return array
     *
     */
    public function updateOrder($orderId, array $orderDetails)
    {
        $status = false;
    	DB::beginTransaction();
        try {
         	$status = Order::whereId($orderId)->update($orderDetails);
         	DB::commit();
            $this->createCSVFile();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $status;
    }

    /**
     *  Delete Order list by $orderId value
     *  based on given orderId
     *
     *  @params:  orderId
     *
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return array
     *
     */
    public function deleteOrder($orderId)
    {
    	$status = false;
    	DB::beginTransaction();
        try {
        	$status = Order::destroy($orderId);
        	DB::commit();
            $this->createCSVFile();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $status;
    }

    /**
     *  createing a csv file and writing all the data to file
     *  
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return void
     *
     */
    public function readWrite($data){
        // delete previous file
        $file = base_path().'/public/data.csv';
        if(file_exists($file)){
            unlink($file);
        }
        // Create an array of elements 
        // Open a file in write mode ('w')
        $fp = fopen($file, 'w');
        // Loop through file pointer and a line
        foreach ($data as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }


    /**
     *  Get Order list values and pass to readWrite function for createing a csv file
     *  
     * readWrite() --> \App\Repositories\
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return array
     *
     */
    public function createCSVFile(){
    	$getAllOrders = Order::all();
    	$status = false;
    	$data[] = ['id', 'name','state','zip','amount','qty','item'];
    	foreach ($getAllOrders as $fields) {
    		 $data[] = array($fields['id'],$fields['name'],$fields['state'],$fields['zip'], $fields['amount'],$fields['qty'],$fields['item']);
        }
        try {
        	$this->readWrite($data);
        	$status = true;
        } catch (\Exception $e) {
           
        }
        return $status;
    }

    /**
     *  Get Order list values and
     *  
     * @params filename, delimiter
     *
     *  Author: Mallikarjun<mmallikarjun@hcl.com>
     *  DATE  : 15-Jun-2022
     *  @var Illuminate\Http\Request $request
     *
     *  @return array
     *
     */
    public function readCSVToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
    
}

