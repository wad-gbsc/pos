<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Product;
use App\Models\References\Supplier;
use App\Models\References\Department;
use App\Models\Inventory\ReceivingListMain;
use App\Models\Inventory\PurchaseOrderMain;
use App\Models\Inventory\PurchaseOrderDetails;
use App\Models\Inventory\ReceivingListDetails;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class ReceivingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['receivinglists'] = ReceivingListMain::select(
                                'inv_receiving_main.*',
                                'rd.department_name',
                                'rs.supplier_name'
        )
                                ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_receiving_main.department_id')
                                ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_receiving_main.supplier_id')
                                ->where('inv_receiving_main.is_deleted', 0)
                                ->get();

        $data['products'] = Product::leftJoin('refunit', 'refunit.unit_id', 'refproduct.unit_id')
                                ->leftJoin('refcategory', 'refcategory.category_id', 'refproduct.category_id')
                                ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'refproduct.supplier_id')
                                ->where('refproduct.is_deleted', 0)
                                ->orderBy('refproduct.product_id')
                                ->get();
        
        $data['departments'] = Department::where('is_deleted', 0)->orderBy('department_id')->get();
        $data['suppliers'] = Supplier::where('is_deleted', 0)->orderBy('supplier_id')->get();


        $data['purchaseorderlists'] = PurchaseOrderMain::where('is_deleted', 0) -> where ('is_received', 0)->get();

        return $data;
    }

    // {
    //     $receiving =  ReceivingList
    //     ::leftJoin('refdepartment', 'refdepartment.department_id', 'inv_receiving_main.department_id')
    //     ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'inv_receiving_main.supplier_id')
    //     ->where('inv_receiving_main.is_deleted', 0)
    //     ->orderBy('inv_receiving_main.purchase_order_id')
    //     ->get();
    //     return Reference::collection($receiving);
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
            'receiving_no' => 'required',
            'department_id' => 'required',
            'supplier_id' => 'required',
            'receiving_datetime' => 'required',
            
           
        ]
    )->validate();

    $receiving = new ReceivingListMain();
    $receiving->receiving_no = $request->input('receiving_no');
    $receiving->purchase_order_no = $request->input('purchase_order_no');
    $receiving->purchase_order_id = $request->input('purchase_order_id');
    $receiving->department_id = $request->input('department_id');
    $receiving->supplier_id = $request->input('supplier_id');
    $receiving->receiving_datetime = date('Y-m-d H:i:s', strtotime($request->input('receiving_datetime')));
    $receiving->receiving_remarks = $request->input('receiving_remarks');
    $receiving->total_amount = $request->input('total_amount');
    $receiving->created_datetime = Carbon::now();
    $receiving->created_by = Auth::user()->user_id;

    $receiving->save();

    if ($request->input('purchase_order_id') !=null )
    {
        $po = PurchaseOrderMain::findOrFail($request->input('purchase_order_id'));
        $po->is_received=1;
        $po->save();
    }
    
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
            'receiving_id'=>$receiving->receiving_id,
            'product_id'=>$item['product_id'],
            'product_cost'=>$item['product_cost'],
            'product_quantity'=>$item['product_quantity'],
            'total_cost'=>$item['total_cost'],
    
        ];
    }

    DB::table('inv_receiving_details')->insert($items_dataset);

    //return json based from the resource data
    $data = ReceivingListMain::select(
        'inv_receiving_main.*',
        'rd.department_name',
        'rs.supplier_name'
    )
        ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_receiving_main.department_id')
        ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_receiving_main.supplier_id')
        ->findOrFail($receiving->receiving_id);

    return ( new Reference( $data ) )
        ->response()
        ->setStatusCode(200);
}
//    return $this->show($receiving->purchase_order_id);
//     }


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
        $data['receivinglists'] = ReceivingListMain::select(
                            'inv_receiving_main.*',
                            'rd.department_name',
                            'rs.supplier_name'
        )
                            ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_receiving_main.department_id')
                            ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_receiving_main.supplier_id')
                            ->findOrFail($id);
        
        $data['receivinglistitems'] = ReceivingListDetails::select(
            'inv_receiving_details.*',
            'rp.product_code',
            'rp.product_name',
            'ru.unit_name'
        )
                            ->leftJoin('refproduct as rp', 'rp.product_id', '=', 'inv_receiving_details.product_id')
                            ->leftJoin('refunit as ru', 'ru.unit_id', 'rp.unit_id')
                            ->where('rp.is_deleted', 0)
                            ->where('receiving_id', $id)
                            ->get();

        
        return $data;
    }
    
    
    
    
    // {
    //     $purchase = ReceivingList::leftJoin('refdepartment', 'refdepartment.department_id', 'inv_receiving_main.department_id')
    //     ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'inv_receiving_main.supplier_id')
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
                'receiving_no' => 'required',
                'department_id' => 'required',
                'supplier_id' => 'required',
                'created_datetime' => 'required',
              

            ]
        )->validate();

        
        
    $receiving = ReceivingListMain::findOrFail($id);
    $receiving->receiving_no = $request->input('receiving_no');
    $receiving->department_id = $request->input('department_id');
    $receiving->supplier_id = $request->input('supplier_id');
    $receiving->receiving_datetime = date('Y-m-d H:i:s', strtotime($request->input('receiving_datetime')));
    $receiving->receiving_remarks = $request->input('receiving_remarks');
    $receiving->total_amount = $request->input('total_amount');
    $receiving->created_datetime = Carbon::now();
    $receiving->created_by = Auth::user()->user_id;


        //update  based on the http json body that is sent
        $receiving->save();

    $items = $request->input('items');
    $olditems = ReceivingListDetails :: where ('receiving_id', $receiving->receiving_id);
    $olditems->delete();

    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'receiving_id'=>$receiving->receiving_id,
            'product_id'=>$item['product_id'],
            'product_cost'=>$item['product_cost'],
            'product_quantity'=>$item['product_quantity'],
            'total_cost'=>$item['total_cost']
        ];
    }

    DB::table('inv_receiving_details')->insert($items_dataset);

        //update  based on the http json body that is sent
        $receiving = ReceivingListMain::select(
            'inv_receiving_main.*',
             'rd.department_name',
             'rs.supplier_name'               
        )
            ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'inv_receiving_main.department_id')
            ->leftJoin('refsupplier as rs', 'rs.supplier_id', '=', 'inv_receiving_main.supplier_id')
            ->findOrFail($id);

        return ( new Reference( $receiving ) )
            ->response()
            ->setStatusCode(200);
    }




        // return ( new Reference( $purchase ) )
        //     ->response()
        //     ->setStatusCode(200);
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
        $receiving = ReceivingListMain::findOrFail($id);
        $receiving->is_deleted = 1;
        $receiving->deleted_datetime = Carbon::now();
        $receiving->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $receiving->save();

        return ( new Reference( $receiving ) )
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
    public function getPoItems($id)
    {
        $poitems = PurchaseOrderDetails::select(
            'inv_purchase_order_details.*',
            'rp.product_code',
            'rp.product_name',
            'ru.unit_name'
        )
                            ->leftJoin('refproduct as rp', 'rp.product_id', '=', 'inv_purchase_order_details.product_id')
                            ->leftJoin('refunit as ru', 'ru.unit_id', 'rp.unit_id')
                            ->where('purchase_order_id', $id)
                            ->get();

        
        return $poitems;
    }
}


