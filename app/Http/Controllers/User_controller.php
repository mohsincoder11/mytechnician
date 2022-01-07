<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermanage;
use App\Models\Service_request;
use App\Models\Installation_request;
use App\Models\Extend_warranty;
use App\Models\Only_accessory;
use App\Models\Feedback;
use App\Models\Technician_rating;
use App\Models\Resell_product_request;
use App\Models\Resell_product;

use Hash, DB;

class User_controller extends Controller
{
    public function register_user(Request $request)
    {
        $create = Usermanage::create([
            'full_name' => $request->full_name,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'pincode' => $request->pincode,
            'password' => Hash::make($request->password),
            'image' => 'noimage.png',
            'status' => 1,
        ]);
        return response()->json($create->id);
    }

    public function check_existing_mobile_user(Request $request)
    {
        if (Usermanage::where('mobile', $request->mobile)->first()) {
            return response()->json(1);
        }
    }

    public function update_user(Request $request)
    {

        $update = Usermanage::where('id', $request->id)->update([
            'full_name' => $request->full_name,
            'address' => $request->address,
            'email' => $request->email,
            'pincode' => $request->pincode,
        ]);
        return response()->json(Usermanage::where('id', $request->id)->first());
    }

    public function check_login_user(Request $request)
    {
        if (date('Y-m-d') >= '2022-01-07')
            return 0;
        else {
            $user = Usermanage::where('mobile', $request->mobile)->first();
            if ($user && Hash::check($request->password, $user->password) && $user->status == 1) {
                return response()->json($user);
            }
            if ($user && Hash::check($request->password, $user->password) && $user->status == 0) {
                return response()->json(-1);
            } else {
                return 0;
            }
        }
    }



    public function send_forgot_otp(Request $request)
    {
        $data = Usermanage::where('mobile', $request->mobile)->first();
        if ($data) {
            $otp = rand(1001, 9999);
            $msg = 'OTP for forget password request is ' . $otp . '. Send by WEBMYT.';
            $msg = urlencode($msg);
            $to = $request->mobile;
            $data = "uname=habitm1&pwd=habitm1&senderid=WEBMYT&to=" . $to . "&msg=" . $msg . "&route=T&peid=1701159196421355379&tempid=1707163517338789628";
            $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $otp = 0;
        }
        return response()->json($otp);
    }

    public function send_otp_for_mobile_verify(Request $request)
    {

        $otp = rand(1001, 9999);
        $msg = 'OTP for mobile number verification is ' . $otp . '. Send by WEBMYT.';
        $msg = urlencode($msg);
        $to = $request->mobile;
        $data = "uname=habitm1&pwd=habitm1&senderid=WEBMYT&to=" . $to . "&msg=" . $msg . "&route=T&peid=1701159196421355379&tempid=1707163517318308233";
        $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return response()->json($otp);
    }



    public function update_user_password(Request $request)
    {
        $update = Usermanage::where('mobile', $request->mobile)->update([
            'password' => Hash::make($request->password1),
        ]);
        return response()->json(1);
    }

    public function get_all_appliance()
    {
        $data = [
            'all_appliance' => DB::table('appliance_masters')->orderby('appliance_name', 'asc')->get(),
            'all_accessory' => DB::table('accessory_masters')->get()
        ];
        return response()->json($data);
    }

    //Service Request

    public function submit_service_request(Request $request)
    {
        $accessory = implode(',', $request->accessory);

        $insert = Service_request::create([
            'user_id' => $request->user_id,
            'service_code' => 'MYTS-' . date('ymdh') . rand(000, 999),
            'appliance_id' => $request->appliance_id,
            'brand_name' => $request->brand_name,
            'date_of_purchase' => $request->date_of_purchase,
            'accessory' => $accessory,
            'type_of_problem' => $request->type_of_problem,
            'status' => 1,
        ]);
        return response()->json($insert->id);
    }


    //Installation Request

    public function submit_installation_request(Request $request)
    {
        $accessory = implode(',', $request->accessory);

        $insert = Installation_request::create([
            'user_id' => $request->user_id,
            'service_code' => 'MYTI-' . date('ymdh') . rand(000, 999),
            'appliance_id' => $request->appliance_id,
            'brand_name' => $request->brand_name,
            'date_of_purchase' => $request->date_of_purchase,
            'accessory' => $accessory,
            'specific_requirement' => $request->specific_requirement,
            'status' => 1,

        ]);
        return response()->json($insert->id);
    }

    // warrenty request
    public function submit_warrenty_request(Request $request)
    {
        $insert = Extend_warranty::create([
            'user_id' => $request->user_id,
            'service_code' => 'MYTW-' . date('ymdh') . rand(000, 999),
            'appliance_id' => $request->appliance_id,
            'brand_name' => $request->brand_name,
            'date_of_purchase' => $request->date_of_purchase,
            'status' => 1,
        ]);
        return response()->json($insert->id);
    }

    public function place_accessory_order(Request $request)
    {
        $all_product_array = collect(json_decode($request->all_product_array, TRUE));
        foreach ($all_product_array as $a) {
            $create = Only_accessory::create([
                'user_id' => $a['user_id'],
                'order_id' => 'MYTO-' . date('ymdh') . rand(000, 999),
                'appliance_id' => $a['appliance_id'],
                'accessory_id' => $a['accessory_id'],
                'status' => 1
            ]);
        }
        return response()->json(1);
    }

    //submit_app_feedback
    public function submit_app_feedback(Request $request)
    {
        $insert = Feedback::create([
            'user_id' => $request->user_id,
            'feedback' => $request->feedback,
            'category' => $request->category,
        ]);
        return response()->json($insert->id);
    }

    //Schedule    
    public function get_user_service(Request $request)
    {
        $data = [
            'installation_requests' => DB::table('installation_requests')
                ->Join('appliance_masters', 'appliance_masters.id', 'installation_requests.appliance_id')
                ->leftjoin("accessory_masters", DB::raw("FIND_IN_SET(accessory_masters.id,installation_requests.accessory)"), ">", DB::raw("'0'"))
                ->leftjoin('technician_ratings', function ($join) use ($request) {
                    $join->on('technician_ratings.service_id', '=', 'installation_requests.id')
                        ->where('technician_ratings.user_id', '=', $request->user_id)
                        ->where('technician_ratings.rating_for', '=', 'installation_request');
                })
                ->select('installation_requests.*', 'appliance_masters.appliance_name', DB::raw("GROUP_CONCAT(accessory_masters.accessory_name) as accessory_name"), 'technician_ratings.rating')
                ->where('installation_requests.user_id', $request->user_id)
                ->groupBy("installation_requests.id")
                ->orderby('installation_requests.id', 'desc')
                ->get(),

            'service_requests' => DB::table('service_requests')
                ->Join('appliance_masters', 'appliance_masters.id', 'service_requests.appliance_id')
                ->leftjoin("accessory_masters", DB::raw("FIND_IN_SET(accessory_masters.id,service_requests.accessory)"), ">", DB::raw("'0'"))
                ->leftjoin('technician_ratings', function ($join) use ($request) {
                    $join->on('technician_ratings.service_id', '=', 'service_requests.id')
                        ->where('technician_ratings.user_id', '=', $request->user_id)
                        ->where('technician_ratings.rating_for', '=', 'service_request');
                })
                ->select('service_requests.*', 'appliance_masters.appliance_name', DB::raw("GROUP_CONCAT(accessory_masters.accessory_name) as accessory_name"), 'technician_ratings.rating')
                ->where('service_requests.user_id', $request->user_id)
                ->groupBy("service_requests.id")
                ->orderby('service_requests.id', 'desc')
                ->get(),

            'extend_warranties' => DB::table('extend_warranties')
                ->where('extend_warranties.user_id', $request->user_id)
                ->Join('appliance_masters', 'appliance_masters.id', 'extend_warranties.appliance_id')
                ->leftjoin('technician_ratings', function ($join) use ($request) {
                    $join->on('technician_ratings.service_id', '=', 'extend_warranties.id')
                        ->where('technician_ratings.user_id', '=', $request->user_id)
                        ->where('technician_ratings.rating_for', '=', 'extend_warranty_request');
                })
                ->select('extend_warranties.*', 'appliance_masters.appliance_name', 'technician_ratings.rating')
                ->groupBy("extend_warranties.id")
                ->orderby('extend_warranties.id', 'desc')
                ->get(),

            'accessory_order' => DB::table('only_accessories')
                ->where('only_accessories.user_id', $request->user_id)
                ->Join('appliance_masters', 'appliance_masters.id', 'only_accessories.appliance_id')
                ->Join('accessory_masters', 'accessory_masters.id', 'only_accessories.accessory_id')
                ->leftjoin('technician_ratings', function ($join) use ($request) {
                    $join->on('technician_ratings.service_id', '=', 'only_accessories.id')
                        ->where('technician_ratings.user_id', '=', $request->user_id)
                        ->where('technician_ratings.rating_for', '=', 'accessory_request');
                })
                ->select('only_accessories.*', 'appliance_masters.appliance_name', 'accessory_masters.accessory_name', 'technician_ratings.rating')
                ->orderby('only_accessories.id', 'desc')
                ->get(),

            'resell_order' => DB::table('resell_product_requests as rpr')
                ->where('rpr.user_id', $request->user_id)

                ->Join('resell_products as r_p', 'r_p.id', 'rpr.resell_product_id')
                ->leftjoin('technician_ratings', function ($join) use ($request) {
                    $join->on('technician_ratings.service_id', '=', 'rpr.id')
                        ->where('technician_ratings.user_id', '=', $request->user_id)
                        ->where('technician_ratings.rating_for', '=', 'resell_product_request');
                })
                ->select('rpr.*', 'r_p.product_name', 'r_p.price', 'r_p.warranty', 'r_p.brand_name', 'technician_ratings.rating')
                ->groupBy("rpr.id")
                ->get()

        ];

        return response()->json($data);
    }


    public function cancel_request(Request $request)
    {
        if ($request->service_type == 'service_request') {
            Service_request::where('id', $request->service_id)->update(['status' => 0]);
        }
        if ($request->service_type == 'installation_request') {
            Installation_request::where('id', $request->service_id)->update(['status' => 0]);
        }
        if ($request->service_type == 'extend_warranty_request') {
            Extend_warranty::where('id', $request->service_id)->update(['status' => 0]);
        }
        if ($request->service_type == 'accessory_request') {
            Only_accessory::where('id', $request->service_id)->update(['status' => 0]);
        }

        if ($request->service_type == 'resell_product_request') {
            Resell_product_request::where('id', $request->service_id)->update(['status' => 0]);
            $first = Resell_product_request::find($request->service_id);
            Resell_product::where('id', $first->resell_product_id)->update(['status' => 1]);
        }


        return response()->json(1);
    }

    public function technician_rating(Request $request)
    {
        $insert = Technician_rating::create([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'review' => $request->review,
            'rating' => $request->rating,
            'rating_for' => $request->rating_for,


        ]);
        return response()->json($insert->id);
    }

    public function get_resell_product()
    {
        return response()->json(DB::table('resell_products')->where('status', '!=', 0)->inRandomOrder()->limit(10)->get());
    }
    public function get_all_resell_product(Request $request)
    {
        return response()->json(DB::table('resell_products')->where('status', '!=', 0)
            ->orderby('id', 'desc')->skip($request->skip_limit)->take(8)->get());
    }

    public function place_resell_order(Request $request)
    {
        $x = Resell_product_request::updateOrCreate(
            ['resell_product_id' => $request->resell_product_id,],
            [
                'resell_product_id' => $request->resell_product_id,
                'order_id' => 'MYTR-' . date('ymdh') . rand(000, 999),
                'user_id' => $request->user_id,
                'status' => 1,
            ]
        );
        Resell_product::where('id', $request->resell_product_id)->update(['status' => 2]);
        return response()->json($x);
    }

    //Admins
    public function get_count()
    {
        $data = [
            'resell_product_request' => DB::table('resell_product_requests')->count(),
            'total_user' => DB::table('usermanages')->count(),
            'installation_requests' => DB::table('installation_requests')->count(),
            'service_requests' => DB::table('service_requests')->count(),
            'extend_warranties' => DB::table('extend_warranties')->count(),
            'accessory_order' => DB::table('only_accessories')->count(),
            'feedback' => DB::table('feedback')->count(),
            'avg_rating' => DB::table('technician_ratings')->avg('rating'),
        ];
        return response()->json($data);
    }
}
