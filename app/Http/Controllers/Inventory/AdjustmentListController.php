<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Department;
use App\Models\References\Product;
use App\Models\Inventory\AdjustmentListMain;
use App\Models\Inventory\AdjustmentListDetails;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class AdjustmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {
            $data['adjustmentlists'] = AdjustmentListMain::select(
                                    'inv_adjustment_main.*',
                                    'rd.department_name'
        
            )
                                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_adjustment_main.department_id')
                                    ->where('inv_adjustment_main.is_deleted', 0)
                                    ->get();
    
            $data['products'] = Product::leftJoin('refunit', 'refunit.unit_id', 'refproduct.unit_id')
                                    ->leftJoin('refcategory', 'refcategory.category_id', 'refproduct.category_id')
                                    ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'refproduct.supplier_id')
                                    ->where('refproduct.is_deleted', 0)
                                    ->orderBy('refproduct.product_id')
                                    ->get();
            
            $data['departments'] = Department::where('is_deleted', 0)->orderBy('department_id')->get();
    
            return $data;
        }
        // {
        //     $adjustment =  AdjustmentListMain::leftJoin('refdepartment', 'refdepartment.department_id', 'inv_adjustment_main.department_id')
        //     ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'inv_adjustment_main.supplier_id')
        //     ->where('inv_adjustment_main.is_deleted', 0)
        //     ->orderBy('inv_adjustment_main.adjustment_id')
        //     ->get()  ;
        //     return Reference::collection($adjustment);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Validator::make($request->all(),
        [
            'department_id' => 'required',
            'adjustment_datetime' => 'required',
            'adjustment_type' => 'required',
           
        ]
    )->validate();

    $adjustment = new AdjustmentListMain();
    $adjustment->adjustment_no = DB::raw('CreateAdjustmentNo()');
    $adjustment->department_id = $request->input('department_id');
    $adjustment->adjustment_type = $request->input('adjustment_type');
    $adjustment->adjustment_datetime = date('Y-m-d H:i:s', strtotime($request->input('adjustment_datetime')));
    $adjustment->adjustment_remarks = $request->input('adjustment_remarks');
    $adjustment->total_amount = $request->input('total_amount');
    $adjustment->created_datetime = Carbon::now();
    $adjustment->created_by = Auth::user()->user_id;
 
    $adjustment->save();
    
    $items = $request->input('items');
    
    // // //first way
    // foreach($items as $item)
    // {
    //     $purchase_item = new PurchaseOrderItems;
    //     $purchase_item->adjustment_id = $adjustment->adjustment_id;
    //     $purchase_item->product_id = $item['product_id'];
    //     $purchase_item->product_cost = $item['product_cost'];
    //     $purchase_item->save();
    // }

    //second way
    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'adjustment_id'=>$adjustment->adjustment_id,
            'product_id'=>$item['product_id'],
            'product_cost'=>$item['product_cost'],
            'product_quantity'=>$item['product_quantity'],
            'total_cost'=>$item['total_cost']

        ];
    }

    DB::table('inv_adjustment_details')->insert($items_dataset);

    //return json based from the resource data
    $data = AdjustmentListMain::select(
        'inv_adjustment_main.*',
        'rd.department_name'
    )
        ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_adjustment_main.department_id')
        ->findOrFail($adjustment->adjustment_id);

    return ( new Reference( $data ) )
        ->response()
        ->setStatusCode(200);
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['adjustmentlists'] = AdjustmentListMain::select(
                            'inv_adjustment_main.*',
                            'rd.department_name'
        )
                            ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_adjustment_main.department_id')
                            ->findOrFail($id);
        
        $data['adjustmentitems'] = AdjustmentListDetails::select(
            'inv_adjustment_details.*',
            'rp.product_code',
            'rp.product_name',
            'ru.unit_name'
        )
                            ->leftJoin('refproduct as rp', 'rp.product_id', '=', 'inv_adjustment_details.product_id')
                            ->leftJoin('refunit as ru', 'ru.unit_id', 'rp.unit_id')
                            ->where('rp.is_deleted', 0)
                            ->where('adjustment_id', $id)
                            ->get();

        
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(),
        [
            'department_id' => 'required',
            'adjustment_datetime' => 'required',
            'adjustment_type' => 'required',
           
        ]
    )->validate();

    $adjustment = AdjustmentListMain::findOrFail($id);
    $adjustment->adjustment_no = $request->input('adjustment_no');
    $adjustment->department_id = $request->input('department_id');
    $adjustment->adjustment_type = $request->input('adjustment_type');
    $adjustment->adjustment_datetime = date('Y-m-d H:i:s', strtotime($request->input('adjustment_datetime')));
    $adjustment->adjustment_remarks = $request->input('adjustment_remarks');
    $adjustment->total_amount = $request->input('total_amount');
    $adjustment->created_datetime = Carbon::now();
    $adjustment->created_by = Auth::user()->user_id;
 
    $adjustment->save();
    
    $items = $request->input('items');
    $olditems = AdjustmentListDetails :: where ('adjustment_id', $adjustment->adjustment_id);
    $olditems->delete();

    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'adjustment_id'=>$adjustment->adjustment_id,
            'product_id'=>$item['product_id'],
            'product_cost'=>$item['product_cost'],
            'product_quantity'=>$item['product_quantity'],
            'total_cost'=>$item['total_cost']
        ];
    }

    DB::table('inv_adjustment_details')->insert($items_dataset);

        //update  based on the http json body that is sent
        $adjustment = AdjustmentListMain::select(
            'inv_adjustment_main.*',
             'rd.department_name'         
        )
            ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_adjustment_main.department_id')
            ->findOrFail($id);

        return ( new Reference( $adjustment ) )
            ->response()
            ->setStatusCode(200);
    }

    public function delete($id)
    {   
        $adjustment = AdjustmentListMain::findOrFail($id);

        $adjustment->is_deleted = 1;
        $adjustment->deleted_datetime = Carbon::now();
        $adjustment->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $adjustment->save();

        return ( new Reference( $adjustment ) )
            ->response()
            ->setStatusCode(200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function checkIfUsed($id)
    {
        $exists = 'false';

        // if(ContractInfo::where('department_id', '=', $id)
        //     ->where('is_deleted', 0)
        //     ->exists()) {
        //     $exists = 'true';
        // }
        return $exists;
    }
}
