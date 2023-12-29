<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\mainCategory;
use App\Models\Pricing;
use App\Models\Profile;

use App\Models\profilesubcategoriesModel;
use App\Models\Rate;
use App\Models\serviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class profileController extends Controller
{

    public function getImage($profileid)
    {
        $profile = Profile::find($profileid);
        $profileimage = $profile['imageurl'];
        $profileimage = $profileimage == null ?  ('http://192.168.186.164:8001/storage/user.png')
            : ('http://192.168.186.164:8001/storage/' . $profileimage);
        return json_encode($profileimage, JSON_UNESCAPED_SLASHES);
    }

    public function getProfile($userid)
    {

        $user = User::where('id', $userid)->first();

        if ($user) {
            $profile = Profile::where('userid', $user->id)->first();
            if ($profile) {
                return json_encode([
                    'status' => 'success',
                    'message' => [
                        'name' => $user->name,
                        'roleid' => $user->roleid,
                        'profiledata' => $profile,
                        'subcategorydata' => $profile->subcategory,
                        'main' => count($profile->subcategory) > 0 ?
                            $profile->subcategory[0]->maincategory : null,
                        // 'rate' => ($profile->rate == null) ? '' : $profile->rate,
                        // 'rateprovider'
                        // => ($profile->rate == null) ? '' : $profile->rate->user,
                    ]
                ]);
            }
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }

    public function addProfile(Request $request)
    {
        $profile = new Profile();
        $profile->teamsize = $request->teamsize;
        $profile->lat = $request->lat;
        $profile->long = $request->long;
        $profile->distance = $request->distance;
        $profile->userid = $request->userid;
        $profile =  $profile->save();
        if ($profile) {
            $profileid = DB::getPdo()->lastInsertId();
            if ($request->subcategories) {
                $subcategories =  $request->subcategories;
                for ($i = 0; $i < count($subcategories); $i++) {
                    $p = new Pricing();
                    $p->profileid = $profileid;
                    $p->subcategoryid = $subcategories[$i];
                    $p = $p->save();
                }
            }

            return json_encode([
                'status' => 'success',
                'profileid' => $profileid
            ]);
        }

        return json_encode([
            'status' => 'failed'
        ]);
    }
    public function updateProfile(Request $request)
    {
        $profile =  Profile::where('id', $request->profileid)->first();

        if ($profile) {

            if ($request->has('lat')) {

                $profile->lat = $request->lat;
                $profile->long = $request->long;
                $profile->save();
            }
            if ($request->has('distance')) {

                $profile->distance = $request->distance;
                $profile->save();
            }
            if ($request->has('bio')) {

                $profile->bio = $request->bio;
                $profile->save();
            }
            if ($request->file('file')) {
                if ($profile->imageurl != null) {
                    Storage::delete('public/' . $profile->imageurl);
                }

                $file = $request->file('file')->store('public');
                // print(url($file));
                $profile->imageurl = basename($file);
                $profile = $profile->save();
                // $url =
                // url('storage/app/' . $file);
                // return json_encode($url);

            }
        }


        if ($profile) {
            return json_encode([
                'status' => 'success',

            ]);
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }
}
