<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Product;
use App\Models\References\Supplier;
use App\Models\References\Department;
use App\Models\Inventory\PurchaseOrderMain;
use App\Models\Inventory\PurchaseOrderDetails;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class PurchaseOrderListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['purchaseorderlists'] = PurchaseOrderMain::select(
                                'inv_purchase_order_main.*',
                                'rd.department_name',
                                'rs.supplier_name'
        )
                                ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_purchase_order_main.department_id')
                                ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_purchase_order_main.supplier_id')
                                ->where('inv_purchase_order_main.is_deleted', 0)
                                ->get();

        $data['products'] = Product::leftJoin('refunit', 'refunit.unit_id', 'refproduct.unit_id')
                                ->leftJoin('refcategory', 'refcategory.category_id', 'refproduct.category_id')
                                ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'refproduct.supplier_id')
                                ->where('refproduct.is_deleted', 0)
                                ->orderBy('refproduct.product_id')
                                ->get();
        
        $data['departments'] = Department::where('is_deleted', 0)->orderBy('department_id')->get();
        $data['suppliers'] = Supplier::where('is_deleted', 0)->orderBy('supplier_id')->get();

        return $data;
    }
    // {
    //     $purchase =  PurchaseOrderMain::leftJoin('refdepartment', 'refdepartment.department_id', 'inv_purchase_order_main.department_id')
    //     ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'inv_purchase_order_main.supplier_id')
    //     ->where('inv_purchase_order_main.is_deleted', 0)
    //     ->orderBy('inv_purchase_order_main.purchase_order_id')
    //     ->get()  ;
    //     return Reference::collection($purchase);
    // }

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
            'supplier_id' => 'required',
            'purchase_order_datetime' => 'required',
            
           
        ]
    )->validate();

    $purchase = new PurchaseOrderMain();
    $purchase->purchase_order_no = DB::raw('CreatePurchaseOrderNo()');
    $purchase->department_id = $request->input('department_id');
    $purchase->supplier_id = $request->input('supplier_id');
    $purchase->purchase_order_datetime = date('Y-m-d H:i:s', strtotime($request->input('purchase_order_datetime')));
    $purchase->is_received = $request->input('is_received');
    $purchase->purchase_order_remarks = $request->input('purchase_order_remarks');
    $purchase->total_amount = $request->input('total_amount');
    $purchase->created_datetime = Carbon::now();
    $purchase->created_by = Auth::user()->user_id;
 
    $purchase->save();
    
    $items = $request->input('items');
    
    // // //first way
    // foreach($items as $item)
    // {
    //     $purchase_item = new PurchaseOrderItems;
    //     $purchase_item->purchase_order_id = $purchase->purchase_order_id;
    //     $purchase_item->product_id = $item['product_id'];
    //     $purchase_item->product_cost = $item['product_cost'];
    //     $purchase_item->save();
    // }

    //second way
    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'purchase_order_id'=>$purchase->purchase_order_id,
            'product_id'=>$item['product_id'],
            'product_cost'=>$item['product_cost'],
            'product_quantity'=>$item['product_quantity'],
            'total_cost'=>$item['total_cost']

        ];
    }

    DB::table('inv_purchase_order_details')->insert($items_dataset);

    //return json based from the resource data
    $data = PurchaseOrderMain::select(
        'inv_purchase_order_main.*',
        'rd.department_name',
        'rs.supplier_name'
    )
        ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_purchase_order_main.department_id')
        ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_purchase_order_main.supplier_id')
        ->findOrFail($purchase->purchase_order_id);

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
        $data['purchaseorderlists'] = PurchaseOrderMain::select(
                            'inv_purchase_order_main.*',
                            'rd.department_name'
        )
                            ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_purchase_order_main.department_id')
                            ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_purchase_order_main.supplier_id')
                            ->findOrFail($id);
        
        $data['purchaseorderitems'] = PurchaseOrderDetails::select(
            'inv_purchase_order_details.*',
            'rp.product_code',
            'rp.product_name',
            'ru.unit_name'
        )
                            ->leftJoin('refproduct as rp', 'rp.product_id', '=', 'inv_purchase_order_details.product_id')
                            ->leftJoin('refunit as ru', 'ru.unit_id', 'rp.unit_id')
                            ->where('rp.is_deleted', 0)
                            ->where('purchase_order_id', $id)
                            ->get();

        
        return $data;
    }
    
    
    
    
    
    // {
    //     $purchase = PurchaseOrderList::leftJoin('refdepartment', 'refdepartment.department_id', 'inv_purchase_order_main.department_id')
    //     ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'inv_purchase_order_main.supplier_id')
    //     ->findOrFail($id);
        
    //     return ( new Reference( $purchase ) )
    //         ->response()
    //         ->setStatusCode(200);
    // }

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
                'supplier_id' => 'required',
                'created_datetime' => 'required',
            ]
        )->validate();

        
    
    $purchase = PurchaseOrderMain::findOrFail($id);
    $purchase->purchase_order_id = $request->input('purchase_order_id');
    $purchase->department_id = $request->input('department_id');
    $purchase->supplier_id = $request->input('supplier_id');
    $purchase->purchase_order_datetime = date('Y-m-d H:i:s', strtotime($request->input('purchase_order_datetime')));
    $purchase->contact_person = $request->input('contact_person');
    $purchase->contact_num = $request->input('contact_num');
    $purchase->email_address = $request->input('email_address');
    $purchase->deliver_to = $request->input('deliver_to');
    $purchase->requested_by = $request->input('requested_by');
    $purchase->purchase_order_remarks = $request->input('purchase_order_remarks');
    $purchase->total_amount = $request->input('total_amount');
    $purchase->modified_datetime = Carbon::now();
    $purchase->modified_by = Auth::user()->user_id;

    $purchase->save();

    $items = $request->input('items');
    $olditems = PurchaseOrderDetails :: where ('purchase_order_id', $purchase->purchase_order_id);
    $olditems->delete();

    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'purchase_order_id'=>$purchase->purchase_order_id,
            'product_id'=>$item['product_id'],
            'product_cost'=>$item['product_cost'],
            'product_quantity'=>$item['product_quantity'],
            'total_cost'=>$item['total_cost']
        ];
    }

    DB::table('inv_purchase_order_details')->insert($items_dataset);

        //update  based on the http json body that is sent
        $purchase = PurchaseOrderMain::select(
            'inv_purchase_order_main.*',
             'rd.department_name',
             'rs.supplier_name'               
        )
            ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_purchase_order_main.department_id')
            ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_purchase_order_main.supplier_id')
            ->findOrFail($id);

        return ( new Reference( $purchase ) )
            ->response()
            ->setStatusCode(200);
    }

    //     return ( new Reference( $purchase ) )
    //         ->response()
    //         ->setStatusCode(200);
    // }
      /**has
     * Update the specified resource in storage for deleting.
     * preventing force delete rather update the is_deleted = true
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {   
        $purchase = PurchaseOrderMain::findOrFail($id);

        $purchase->is_deleted = 1;
        $purchase->deleted_datetime = Carbon::now();
        $purchase->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $purchase->save();

        return ( new Reference( $purchase ) )
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
