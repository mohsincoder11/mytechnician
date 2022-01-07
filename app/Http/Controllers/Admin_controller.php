<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin_user;
use App\Models\Appliance_master;
use App\Models\Accessory_master;
use App\Models\Technician_rating;
use Hash, DB, File;
use App\Models\Installation_request;
use App\Models\Extend_warranty;
use App\Models\Only_accessory;
use App\Models\Service_request;
use App\Models\Resell_product;
use App\Models\Resell_product_request;

class Admin_controller extends Controller
{
    public function check_login(Request $request)
    {
        $user = Admin_user::where('username', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $request->session()->put('userdata', $user['username']);
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }
    public function dashboard()
    {      

        $this->data = [
            'resell_product_request' => DB::table('resell_product_requests')->count(),
            'total_user' => DB::table('usermanages')->where('user_type', 1)->count(),
            'installation_requests' => DB::table('installation_requests')->count(),
            'service_requests' => DB::table('service_requests')->count(),
            'extend_warranties' => DB::table('extend_warranties')->count(),
            'accessory_order' => DB::table('only_accessories')->count(),
            'feedback' => DB::table('feedback')->count(),
            'avg_rating' => DB::table('technician_ratings')->avg('rating'),
        ];
        return view('dashboard', $this->data);
    }


    public function get_app_user()
    {
        return response()->json(DB::table('usermanages')->where('user_type', 1)->get());
    }

    public function disable_user(Request $request)
    {
        DB::table('usermanages')->where('id', $request->id)->update(['status' => $request->value]);

        return 1;
    }


    public function get_service_request(Request $request)
    {
        $data = DB::table('service_requests')
            ->Join('usermanages', 'usermanages.id', 'service_requests.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'service_requests.appliance_id')
            ->leftjoin("accessory_masters", DB::raw("FIND_IN_SET(accessory_masters.id,service_requests.accessory)"), ">", DB::raw("'0'"))
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'service_requests.id')
                    ->where('technician_ratings.rating_for', '=', 'service_request');
            })
            ->select('service_requests.*', 'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', DB::raw("GROUP_CONCAT(accessory_masters.accessory_name) as accessory_name"), 'technician_ratings.rating', 'technician_ratings.review')
            ->groupBy("service_requests.id")
            ->get();
        return response()->json($data);
    }

    public function get_service_request_api(Request $request)
    {
        $data = DB::table('service_requests')
            ->Join('usermanages', 'usermanages.id', 'service_requests.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'service_requests.appliance_id')
            ->leftjoin("accessory_masters", DB::raw("FIND_IN_SET(accessory_masters.id,service_requests.accessory)"), ">", DB::raw("'0'"))
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'service_requests.id')
                    ->where('technician_ratings.rating_for', '=', 'service_request');
            })
            ->select('service_requests.*', 'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', DB::raw("GROUP_CONCAT(accessory_masters.accessory_name) as accessory_name"), 'technician_ratings.rating', 'technician_ratings.review')
            ->skip($request->skip_limit)
            ->take(8)
            ->groupBy("service_requests.id")
            ->get();
        return response()->json($data);
    }


    public function get_installation_request(Request $request)
    {
        $data = DB::table('installation_requests')
            ->Join('usermanages', 'usermanages.id', 'installation_requests.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'installation_requests.appliance_id')
            ->leftjoin("accessory_masters", DB::raw("FIND_IN_SET(accessory_masters.id,installation_requests.accessory)"), ">", DB::raw("'0'"))
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'installation_requests.id')
                    ->where('technician_ratings.rating_for', '=', 'installation_request');
            })
            ->select('installation_requests.*', 'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', DB::raw("GROUP_CONCAT(accessory_masters.accessory_name) as accessory_name"), 'technician_ratings.rating', 'technician_ratings.review')

            ->groupBy("installation_requests.id")
            ->get();
        return response()->json($data);
    }

    public function get_installation_request_api(Request $request)
    {
        $data = DB::table('installation_requests')
            ->Join('usermanages', 'usermanages.id', 'installation_requests.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'installation_requests.appliance_id')
            ->leftjoin("accessory_masters", DB::raw("FIND_IN_SET(accessory_masters.id,installation_requests.accessory)"), ">", DB::raw("'0'"))
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'installation_requests.id')
                    ->where('technician_ratings.rating_for', '=', 'installation_request');
            })
            ->select('installation_requests.*', 'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', DB::raw("GROUP_CONCAT(accessory_masters.accessory_name) as accessory_name"), 'technician_ratings.rating', 'technician_ratings.review')
            ->skip($request->skip_limit)
            ->take(8)
            ->groupBy("installation_requests.id")
            ->get();
        return response()->json($data);
    }


    public function get_feedback(Request $request)
    {
        $data = DB::table('feedback as f')
            ->Join('usermanages', 'usermanages.id', 'f.user_id')
            ->select('f.id', 'f.feedback', 'f.created_at', 'f.category', 'usermanages.full_name')
            ->get();
        return response()->json($data);
    }

    public function get_accessory_req(Request $request)
    {
        $data = DB::table('only_accessories')
            ->Join('usermanages', 'usermanages.id', 'only_accessories.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'only_accessories.appliance_id')
            ->Join('accessory_masters', 'accessory_masters.id', 'only_accessories.accessory_id')
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'only_accessories.id')
                    ->where('technician_ratings.rating_for', '=', 'accessory_request');
            })
            ->select('only_accessories.*',  'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', 'accessory_masters.accessory_name', 'technician_ratings.rating', 'technician_ratings.review')

            ->get();
        return response()->json($data);
    }

    public function get_accessory_req_api(Request $request)
    {
        $data = DB::table('only_accessories')
            ->Join('usermanages', 'usermanages.id', 'only_accessories.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'only_accessories.appliance_id')
            ->Join('accessory_masters', 'accessory_masters.id', 'only_accessories.accessory_id')
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'only_accessories.id')
                    ->where('technician_ratings.rating_for', '=', 'accessory_request');
            })
            ->select('only_accessories.*',  'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', 'accessory_masters.accessory_name', 'technician_ratings.rating', 'technician_ratings.review')
            ->skip($request->skip_limit)
            ->take(8)
            ->get();
        return response()->json($data);
    }



    public function get_extend_warrenty(Request $request)
    {
        $data = DB::table('extend_warranties')
            ->Join('usermanages', 'usermanages.id', 'extend_warranties.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'extend_warranties.appliance_id')
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'extend_warranties.id')
                    ->where('technician_ratings.rating_for', '=', 'extend_warranty_request');
            })
            ->select('extend_warranties.*', 'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', 'technician_ratings.rating', 'technician_ratings.review')
            ->groupBy("extend_warranties.id")

            ->get();
        return response()->json($data);
    }

    public function get_extend_warrenty_api(Request $request)
    {
        $data = DB::table('extend_warranties')
            ->Join('usermanages', 'usermanages.id', 'extend_warranties.user_id')
            ->Join('appliance_masters', 'appliance_masters.id', 'extend_warranties.appliance_id')
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'extend_warranties.id')
                    ->where('technician_ratings.rating_for', '=', 'extend_warranty_request');
            })
            ->select('extend_warranties.*', 'appliance_masters.appliance_name', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', 'technician_ratings.rating', 'technician_ratings.review')
            ->groupBy("extend_warranties.id")
            ->skip($request->skip_limit)
            ->take(8)
            ->get();
        return response()->json($data);
    }

    public function log_out()
    {
        session()->forget('userdata');
        return redirect()->route('log_in');
    }


    //Master
    public function appliance_accessory_master()
    {
        $this->data['appliance_data'] = DB::table('appliance_masters')->orderby('appliance_name', 'asc')->get();
        $this->data['accessory_data'] = DB::table('accessory_masters as acc')
            ->join('appliance_masters', 'acc.appliance_id', '=', 'appliance_masters.id')->select('acc.id', 'acc.accessory_name', 'appliance_masters.appliance_name')->orderby('acc.id', 'asc')->get();
        return view('appliance_accessory_master', $this->data);
    }
    public function add_appliance(Request $request)
    {
        if ($request->edit_id) {
            $insert = Appliance_master::where('id', $request->edit_id)->update([
                'appliance_name' => ucwords($request->appliance_name)
            ]);
            return response()->json(0);
        } else {
            $insert = Appliance_master::create([
                'appliance_name' => ucwords($request->appliance_name)
            ]);
            return response()->json($insert->id);
        }
    }
    public function delete_appliance(Request $request)
    {
        $delete = Appliance_master::where('id', $request->id)->delete();
        $delete = Accessory_master::where('appliance_id', $request->id)->delete();
        return response()->json(1);
    }

    public function edit_appliance(Request $request)
    {
        $get = Appliance_master::select('appliance_name', 'id')->where('id', $request->id)->first();
        return response()->json($get);
    }
    public function update_appliance(Request $request)
    {
        $get = Appliance_master::where('id', $request->id)->update(['appliance_name' => $request->appliance_name]);
        return response()->json(1);
    }


    public function add_accessory(Request $request)
    {
        if ($request->accessory_edit_id) {
            $insert = Accessory_master::where('id', $request->accessory_edit_id)->update([
                'accessory_name' => ucwords($request->accessory_name),
                'appliance_id' => $request->appliance_id
            ]);
            return response()->json(0);
        } else {
            $insert = Accessory_master::create([
                'accessory_name' => ucwords($request->accessory_name),
                'appliance_id' => $request->appliance_id
            ]);
            return response()->json($insert->id);
        }
    }
    public function delete_accessory(Request $request)
    {
        $delete = Accessory_master::where('id', $request->id)->delete();
        return response()->json(1);
    }

    public function edit_accessory(Request $request)
    {
        $get = Accessory_master::select('accessory_name', 'appliance_id', 'id')->where('id', $request->id)->first();
        return response()->json($get);
    }
    public function update_accessory(Request $request)
    {
        $get = Accessory_master::where('id', $request->id)->update(['accessory_name' => $request->accessory_name]);
        return response()->json(1);
    }
    public function rate_technician(Request $request)
    {
        $rate = Technician_rating::create([
            'user_id' => $request->user_id,
            'technician_id' => $request->technician_id,
            'rating' => $request->rating,
            'review' => $request->review,
            'rating_for' => $request->rating_for
        ]);
        return response()->json($rate->id);
    }


    public function change_status(Request $request)
    {
        if ($request->type == 'service_request') {
            Service_request::where('id', $request->id)->update(['status' => $request->value]);
        }
        if ($request->type == 'installation_request') {
            Installation_request::where('id', $request->id)->update(['status' => $request->value]);
        }
        if ($request->type == 'extend_warranty_request') {
            Extend_warranty::where('id', $request->id)->update(['status' => $request->value]);
        }
        if ($request->type == 'accessory_request') {
            Only_accessory::where('id', $request->id)->update(['status' => $request->value]);
        }
        if ($request->type == 'resell_request') {
            $first = Resell_product_request::find($request->id);
            Resell_product_request::where('id', $request->id)->update(['status' => $request->value]);
            if ($request->value == 0)
                Resell_product::where('id', $first->resell_product_id)->update(['status' => 1]);
            else
                Resell_product::where('id', $first->resell_product_id)->update(['status' => $request->value]);
        }
        return response()->json(1);
    }

    public function  resell_master()
    {
        $this->data['appliance'] = Appliance_master::select('appliance_name', 'id')->get();
        return view('resell_master', $this->data);
    }

    public function get_resell_data()
    {
        $data = DB::table('resell_products as rs')
            ->Join('appliance_masters as am', 'am.id', 'rs.appliance_id')
            ->select('am.appliance_name', 'rs.*')->get();
        return response()->json($data);
    }

    public function insert_resell_master(Request $request)
    {

        $data = null;
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $file) {
                $name = rand(001, 999) . time() . '.' . $file->extension();
                $file->move(public_path('assets/images/resell_product'), $name);
                $data[] = $name;
            }
            $data = trim(json_encode($data), '[],');
            if ($request->edit_id) {
                $image = str_replace('"', "", $request->exist_image);
                $image = explode(",", $image);
                foreach ($image as $i) {
                    if ($i != 'noimage.jpg')
                        File::delete(public_path('assets/images/resell_product/' . $i));
                }
            }
        } else if ($request->edit_id && $data == null) {
            $data = $request->exist_image;
        } else {
            $data = 'noimage.jpg';
        }
        Resell_product::updateOrCreate(
            ['id' => $request->edit_id],
            [
                'product_name' => $request->product_name,
                'appliance_id' => $request->appliance_id,
                'purchase_date' => date('Y-m-d'),
                'brand_name' => $request->brand_name,
                'description' => $request->description,
                'price' => $request->price,
                'warranty' => $request->warranty,
                'images' => $data,
            ]
        );
        return response()->json(1);
    }


    public function delete_resell(Request $request)
    {
        $get = Resell_product::select('images')->where('id', $request->id)->first();
        $image = str_replace('"', "", $get['images']);
        $image = explode(",", $image);

        foreach ($image as $i) {
            if ($i != 'noimage.jpg')
                File::delete(public_path('assets/images/resell_product/' . $i));
        }
        Resell_product::where('id', $request->id)->delete();
        return response()->json(1);
    }

    public function edit_resell_item(Request $request)
    {
        $data = Resell_product::find($request->id);
        return response()->json($data);
    }



    public function get_resell_order(Request $request)
    {
        $data = DB::table('resell_product_requests as rpr')
            ->Join('usermanages', 'usermanages.id', 'rpr.user_id')
            ->Join('resell_products as r_p', 'r_p.id', 'rpr.resell_product_id')
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'rpr.id')
                    ->where('technician_ratings.rating_for', '=', 'resell_product_request');
            })
            ->select('rpr.*', 'r_p.product_name', 'r_p.price', 'r_p.brand_name', 'r_p.warranty', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', 'technician_ratings.rating', 'technician_ratings.review')
            ->orderby('rpr.id', 'desc')

            ->groupBy("rpr.id")
            ->get();
        return response()->json($data);
    }

    public function get_resell_order_api(Request $request)
    {
        $data = DB::table('resell_product_requests as rpr')
            ->Join('usermanages', 'usermanages.id', 'rpr.user_id')
            ->Join('resell_products as r_p', 'r_p.id', 'rpr.resell_product_id')
            ->leftjoin('technician_ratings', function ($join) use ($request) {
                $join->on('technician_ratings.service_id', '=', 'rpr.id')
                    ->where('technician_ratings.rating_for', '=', 'resell_product_request');
            })
            ->select('rpr.*', 'r_p.product_name', 'r_p.price', 'r_p.brand_name', 'r_p.warranty', 'usermanages.full_name', 'usermanages.pincode', 'usermanages.mobile', 'usermanages.address', 'technician_ratings.rating', 'technician_ratings.review')
            ->orderby('rpr.id', 'desc')
            ->skip($request->skip_limit)
            ->take(8)
            ->groupBy("rpr.id")
            ->get();
        return response()->json($data);
    }
}
