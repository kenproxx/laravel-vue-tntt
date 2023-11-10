<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Address;
use App\Models\Addresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends BaseController
{
    protected $address = '';

    public function __construct(Addresses $address)
    {
        $this->middleware('auth:api');
        $this->address = $address;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->address->all()->toHierarchy();
        return $this->sendResponse($result, 'Address list with hierarchy');
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
        $root = Addresses::where('id', $request->input('parent_id'))->first();
        $address = $this->address->create([
            'data' => $request->get('name'),
            'code' => generateRandomString(),
            'cap' => $request->get('cap'),
            'created_by' => Auth::user()->name,
        ]);
        if ($root == null) {
            $address->makeRoot();
        } else {
            $address->makeChildOf($root);
        }
        return $this->sendResponse($address, 'Tag Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
