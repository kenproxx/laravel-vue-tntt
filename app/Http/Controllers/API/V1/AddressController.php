<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends BaseController
{
    protected $address = '';

    public function __construct(Address $address)
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
        // Câu truy vấn CTE
        $cteQuery = "
        WITH RECURSIVE AddressHierarchy AS (
            SELECT id, dien_giai, parent_code, CAST(dien_giai AS CHAR(1000)) AS Path
            FROM addresses
            WHERE parent_code = ''
            UNION ALL
            SELECT a.id, a.dien_giai, a.parent_code, CONCAT(a.dien_giai, ' > ', h.Path)
            FROM AddressHierarchy h
            JOIN addresses a ON h.id = a.parent_code
        )
        SELECT id, dien_giai, Path
        FROM AddressHierarchy;
    ";

        // Thực thi câu truy vấn và lấy kết quả
        $result = DB::select($cteQuery);

        dd($result);

        // Trả về kết quả thông qua sendResponse
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
        $address = $this->address->create([
            'dien_giai' => $request->get('dien_giai'),
            'code' => $this->genCodeAddress($request->get('code')),
            'cap' => $request->get('cap'),
            'created_by' => Auth::user()->id
        ]);

        return $this->sendResponse($address, 'Tag Created Successfully');
    }

    public function genCodeAddress($input)
    {
        $randomNumber = rand(10, 99);

        if ($input) {
            $code = $input . "!" . $randomNumber;
        } else {
            $code = $randomNumber;
        }

        $isStop = true;
        while ($isStop){
            if (Address::where('code', $code)->first()) {
                $code = $input . "!" . $randomNumber;
            } else {
                $isStop = false;
            }
        }
        return $code;
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
