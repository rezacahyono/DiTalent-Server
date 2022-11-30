<?php

namespace App\Http\Controllers;

use App\Models\Influence;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfluenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        try {
            $validator = Validator::make($request->all(), [
                'talent_id' => 'required|string',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()
                    ->json([
                        'message' => $error,
                    ], 422);
            }

            Influence::create([
                'talent_id' => $request->talent_id,
                'name' => $request->name,
            ]);

            return response()->json([
                'message' => 'Influence created successfully'
            ]);
        } catch (Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Influence  $influence
     * @return \Illuminate\Http\Response
     */
    public function show(Influence $influence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Influence  $influence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Influence $influence)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()
                    ->json([
                        'message' => $error,
                    ], 422);
            }

            $influence->name = $request->name;
            $influence->update();
            return response()->json([
                'message' => 'Influence created successfully'
            ]);
        } catch (Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Influence  $influence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Influence $influence)
    {
        //
    }
}
