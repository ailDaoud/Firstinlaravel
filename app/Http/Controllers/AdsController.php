<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Img;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class AdsController extends Controller
{

    public function index()
    {
        $img = Img::with('ads')->get();
        $ads = Ads::with('images')->get();
        try {
            if ($ads) {
                return response()->json([
                    'success' => 1,
                    'result' => $ads,
                    'message' => "",
                ], 200);
            } else {
                return response()->json([
                    'success' => 0,
                    'result' => null,
                    'message' =>  __('res.a_message'),
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $e
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'describtion'=>'required|string',
            'amount'=>'required|integer',
            'price'=>'required|integer',
            'note'=>'required|string',
            'user_id'=>'required|integer',
            'img_id' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $validator->errors(),
            ], 200);
        }
        try{
            $ads=new Ads();
            $data=$request->all();
            $ads=$ads->create($data);
            if($request->hasFile('img_id')){
                $imgs=$request->file('img_id');
                foreach($imgs as $img){
                    $img_url=time().'.'.$img->getClientOriginalName();
                    $img->move('ads_images',$img_url);
                    $ads->images()->create(['image_path'=>$img_url]);
                }
            }
            return response()->json([
                'success' => 1,
                'result' => __('res.a_store'),
                'message' => ''
            ], 200);

        }

    catch(Exception $e){
        return response()->json([
            'success' => 0,
            'result' => null,
            'message' => $e
        ], 200);
    }
    }
    public function show($id)
    {
        $ads = Ads::findOrFail($id)->with('images')->get();;
        if (!$ads) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => __('res.a_show')
            ], 200);
        } else {
            return response()->json([
                'success' => 1,
                'result' => $ads,
                'message' => ''
            ], 200);
        }
    }


    public function destroy($id)
    {
        $ads = Ads::findOrFail($id);
        if ($ads) {
            $ads->images()->delete();
            $ads->delete();
            return response()->json([
                'success' => 1,
                'result' => null,
                'message' => __('res.a_delete')
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => __('res.a_show')
            ], 200);
        }
    }
}
