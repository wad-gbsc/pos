<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Checktype;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class ChecktypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checktype = Checktype::where('is_deleted', 0)->orderBy('check_type_id')->get();
        return Reference::collection($checktype);
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
            'check_type_code' => 'required',
            'check_type_name' => 'required'
        ]
    )->validate();

    $checktype = new Checktype();
    $checktype->check_type_code = $request->input('check_type_code');
    $checktype->check_type_name = $request->input('check_type_name');
    $checktype->check_type_desc = $request->input('check_type_desc');
    $checktype->sort_key = $request->input('sort_key');
    $checktype->created_datetime = Carbon::now();
    $checktype->created_by = Auth::user()->user_id;

    $checktype->save();

    //return json based from the resource data
    return ( new Reference( $checktype ))
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
        $checktype = Checktype::findOrFail($id);

        return ( new Reference( $checktype ) )
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
        $checktype = Checktype::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'check_type_code' => 'required',
                'check_type_name' => 'required'
            ]
        )->validate();

        
        $checktype->check_type_code = $request->input('check_type_code');
        $checktype->check_type_name = $request->input('check_type_name');
        $checktype->check_type_desc = $request->input('check_type_desc');
        $checktype->sort_key = $request->input('sort_key');
        $checktype->modified_datetime = Carbon::now();
        $checktype->modified_by = Auth::user()->user_id;


        //update  based on the http json body that is sent
        $checktype->save();

        return ( new Reference( $checktype ) )
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
        $checktype = Checktype::findOrFail($id);

        $checktype->is_deleted = 1;
        $checktype->deleted_datetime = Carbon::now();
        $checktype->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $checktype->save();

        return ( new Reference( $checktype ) )
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
