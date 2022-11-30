<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
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
                'user_id' => 'required|string',
                'name' => 'required|string',
                'username' => 'required|string',
                'followers' => 'required|string',
                'insight' => 'required|string',
                'url_link' => 'required|string'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()
                    ->json([
                        'message' => $error,
                    ], 422);
            }

            SocialMedia::created([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'username' => $request->username,
                'followers' => $request->followers,
                'insight' => $request->insight,
                'url_link' => $request->url_link
            ]);

            return response()->json([
                'message' => 'Social media created successfully'
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
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function show(SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialMedia $socialMedia)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'username' => 'required|string',
                'followers' => 'required|string',
                'insight' => 'required|string',
                'url_link' => 'required|string'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()
                    ->json([
                        'message' => $error,
                    ], 422);
            }

            $socialMedia->name = $request->name;
            $socialMedia->username = $request->username;
            $socialMedia->followers = $request->followers;
            $socialMedia->insigth = $request->insight;
            $socialMedia->url_link = $request->url_link;

            $socialMedia->update();

            return response()->json([
                'message' => 'Social media updated successfully'
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
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialMedia $socialMedia)
    {
        //
    }
}
