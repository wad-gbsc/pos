<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Product;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::leftJoin('refunit', 'refunit.unit_id', 'refproduct.unit_id')
        ->leftJoin('refcategory', 'refcategory.category_id', 'refproduct.category_id')
        ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'refproduct.supplier_id')
        ->where('refproduct.is_deleted', 0)
        ->orderBy('refproduct.product_id')
        ->get();
        return Reference::collection($product);

        // $product = DB::table('refproduct')
        //     ->leftJoin('refcategory', 'refcategory.category_id', 'refproduct.category_id')
        //     ->leftJoin('refunit', 'refunit.unit_id', 'refunit.unit_id')
        //     ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'refsupplier.supplier_id')
        //     ->select('refproduct.*','refcategory.*')
        //     ->get();
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
            'product_code' => 'required',
            'product_name' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'unit_id' => 'required',
          
          
           
        ]
    )->validate();

    $product = new Product();
    $product->product_code = $request->input('product_code');
    $product->product_name = $request->input('product_name');
    $product->product_desc = $request->input('product_desc');
    $product->product_cost = $request->input('product_cost');
    $product->product_rate = $request->input('product_rate');
    $product->vat_percent = $request->input('vat_percent');
    $product->sort_key = $request->input('sort_key');
    $product->created_datetime = Carbon::now();
    $product->created_by = Auth::user()->user_id;

    $product->save();

    //return json based from the resource data
    return ( new Reference( $product ))
            ->response()
            ->setStatusCode(201);
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
        $product = Product::findOrFail($id);

        return ( new Reference( $product ) )
            ->response()
            ->setStatusCode(200);
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
        $product = Product::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'product_code' => 'required',
                'product_name' => 'required',
                'category_id' => 'required',
                'supplier_id' => 'required',
                'unit_id' => 'required',

            ]
        )->validate();

        
        $product->product_code = $request->input('product_code');
        $product->product_name = $request->input('product_name');
        $product->product_desc = $request->input('product_desc');
        $product->product_cost = $request->input('product_cost');
        $product->product_rate = $request->input('product_rate');
        $product->vat_percent = $request->input('vat_percent');
        $product->sort_key = $request->input('sort_key');
        $product->sort_key = $request->input('sort_key');
        $product->modified_datetime = Carbon::now();
        $product->modified_by = Auth::user()->user_id;


        //update  based on the http json body that is sent
        $product->save();

        return ( new Reference( $product ) )
            ->response()
            ->setStatusCode(200);
    }
     /**
     * Update the specified resource in storage for deleting.
     * preventing force delete rather update the is_deleted = true
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {   
        $product = Product::findOrFail($id);

        $product->is_deleted = 1;
        $product->deleted_datetime = Carbon::now();
        $product->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $product->save();

        return ( new Reference( $product ) )
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
