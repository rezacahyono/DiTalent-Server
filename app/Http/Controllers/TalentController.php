<?php

namespace App\Http\Controllers;

use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Throwable;

class TalentController extends Controller
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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|unique:talent',
            'full_name' => 'required|string',
            'age' => 'nullable|string',
            'region' => 'nullable|string',
            'gender' => 'nullable|string',
            'rate' => 'nullable|integer'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->all()[0];
            return response()
                ->json([
                    'message' => $error,
                ], 422);
        }
        try {
            $username = User::find($request->user_id)->username;
            $slug = SlugService::createSlug(Talent::class, 'slug', $username);
            Talent::create([
                'user_id' => $request->user_id,
                'slug' => $slug,
                'full_name' => $request->full_name,
                'age' => $request->age,
                'region' => $request->region,
                'gender' => $request->gender,
                'rate' => $request->rate
            ]);

            return response()
                ->json([
                    'message' => "Talent created successfully"
                ], 200);
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
     * @param  \App\Models\Talent  $talent
     * @return \Illuminate\Http\Response
     */
    public function show(Talent $talent)
    {
        return response()
            ->json([
                'message' => "Success",
                'data' => $talent
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Talent  $talent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Talent $talent)
    {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'age' => 'nullable|string',
            'region' => 'nullable|string',
            'gender' => 'nullable|string',
            'rate' => 'nullable|integer'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->all()[0];
            return response()
                ->json([
                    'message' => $error,
                ], 422);
        }
        try {
            $talent = Talent::find('user_id', $talent->user_id);
            $talent->full_name = $request->full_name;
            $talent->age = $request->age;
            $talent->region = $request->region;
            $talent->gender = $request->gender;
            $talent->rate = $request->rate;
            $talent->update();

            return response()
                ->json([
                    'message' => "Talent successfull updated",
                    'data' => $talent
                ], 200);
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
     * @param  \App\Models\Talent  $talent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Talent $talent)
    {
        //
    }
}
