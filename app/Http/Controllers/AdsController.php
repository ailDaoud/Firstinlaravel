<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Img;
use App\Models\User;
use Faker\Provider\Image;
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
            'name' => 'required|string',
            'describtion' => 'required|string',
            'amount' => 'required|integer',
            'price' => 'required|integer',
            'note' => 'required|string',
            'user_id' => 'required|integer',
            'img_id' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $validator->errors(),
            ], 200);
        }
        try {
            $ads = new Ads();
            $data = $request->all();
            $ads = $ads->create($data);
            $imge = new Img();
            if ($request->hasFile('img_id')) {
                $imgs = $request->file('img_id');
                foreach ($imgs as $img) {
                    $img_url = time() . '.' . $img->getClientOriginalName();
                    $img->store('ads_images');
                    $imge->create(['image_path' => $img_url]); //['image_path'=> $img_url]
                }
            }
            return response()->json([
                'success' => 1,
                'result' => __('res.a_store'),
                'message' => ''
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $e
            ], 200);
        }
    }
    public function show($id)
    {
        $ads = Ads::findOrFail($id)->with('images')->get();
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

    public function update(Request $request, $id)
    {
      /*  $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'describtion' => 'required|string',
            'amount' => 'required|integer',
            'price' => 'required|integer',
            'note' => 'required|string',
            'img_id' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $validator->errors(),
            ], 200);
        }*/
        try {

            $ads = Ads::findOrFail($id);
            $imge = new Img();
            if ($ads) {
                $ads->name = $request->name;
                $ads->describtion = $request->describtion;
                $ads->amount = $request->amount;
                $ads->price = $request->price;
                $ads->note = $request->note;
                $ads->save();
              /*  if ($request->has('name')) {
                    $ads->name = $request->name;
                }
                if ($request->has('describtion')) {
                    $ads->describtion = $request->describtion;
                }
                if ($request->has('amount')) {
                    $ads->amount = $request->amount;

                }
                if ($request->has('price')) {
                    $ads->price = $request->price;

                }
                if ($request->has('note')) {
                    $ads->note = $request->note;
                }
                if ($request->hasFile('img_id')) {
                    $imgs = $request->file('img_id');
                    foreach ($imgs as $img) {
                        $img_url = time() . '.' . $img->getClientOriginalName();
                        $img->store('ads_images');
                    }*/
                    //  $ads->save();
                }

                return response()->json([
                    'success' => 1,
                    'result' => $ads,
                    'message' => __('res.update'),
                ], 200);
            }
        /*  else{
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => __('res.show'),
            ], 200);
          }*/
         catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $e
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
