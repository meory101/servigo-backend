<!-- <?php

// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use App\Models\sellerModel;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;

// class sellerController extends Controller
// {
//     public function addSeller(Request $request)
//     {
       
//         $seller = new sellerModel();
//         $seller->name = $request->name;
//         $seller->email = $request->email;
//         $seller->password = Hash::make($request->password);
//         $seller->save();
//         $sellerid = $seller::where('email',$request->email)->first()->id;
        
//         return [
//             'status' => 'success',
//             'sellerid' => $sellerid
           
//         ];
//     }

// } 
