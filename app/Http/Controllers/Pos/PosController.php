<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Product;
use App\Models\References\Unit;
use App\Models\References\Cardtype;
use App\Models\References\Checktype;
use App\Models\References\GCtype;
use App\Models\Pos\PosItems;
use App\Models\Pos\PosPayment;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;


class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

                    $data['products'] = Product::leftJoin('refunit', 'refunit.unit_id', 'refproduct.unit_id')
                                    ->where('refproduct.is_deleted', 0)
                                    ->orderBy('refproduct.product_id')
                                    ->get();
            
                                    $data['cardtypes'] = Cardtype::where('is_deleted', 0)->orderBy('card_type_id')->get();
                                    $data['checktypes'] = Checktype::where('is_deleted', 0)->orderBy('check_type_id')->get();
                                    $data['gctypes'] = GCtype::where('is_deleted', 0)->orderBy('gc_type_id')->get();

                                    $data['units'] = Unit::where('is_deleted', 0)->orderBy('unit_id')->get();
            return $data;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }
    public function delete($id)
    {   
        $pos = PosItems::findOrFail($id);

        $pos->is_deleted = 1;
        $pos->deleted_datetime = Carbon::now();
        $pos->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $pos->save();

        return ( new Reference( $pos ) )
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
}
