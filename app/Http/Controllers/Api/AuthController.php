<?php

namespace App\Http\Controllers\Api;

use App\Mail\ForgotPass;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Uuid;
class AuthController extends Controller
{
    public function registerWeb(Request $request)
    {
        $request->merge([
            'gender' => 1,
            'cc' => [
                'type' => isset($request->cc_type) ? $request->cc_type : null,
                'number' => isset($request->cc_number) ? $request->cc_number : null,
                'expiry' => isset($request->cc_expiry) ? str_replace('/','-', $request->cc_expiry) : null,
            ],
        ]);

        $response = $this->register($request);
        $statusCode = $response->status();
        $body = $response->getData();
        if($statusCode === 200) {
            return redirect()->back()->withErrors([
                "success_message" => "Registration Success",
            ]);
        }
        return redirect()->back()->withErrors($body->errors);
    }

    public function register(Request $request)
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'password', 'password_confirmation', 'role', 'tnc', 'gender', 'dob', 'addresses', 'cc', 'membership']);
        $v = Validator::make($data, [
            'last_name' => 'required|alpha_spaces|min:3',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
            'tnc'  => 'required|accepted',
            'gender'  => 'required|boolean',
            'dob'  => 'date_format:Y-m-d',
            'addresses.*' => 'string|check_address',
            'cc.type' => 'required|in:Visa,Master',
            'cc.number' => 'required|cc_number',
            'cc.expiry' => 'required|date_format:m-y|after:today|cc_expiry',
            'membership' => 'required|in:Silver,Gold,Platinum,Black,VIP,VVIP',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $dt = Carbon::now();
        // dd([$data['dob'], Carbon::createFromFormat('Y-m-d', $data['dob'])]);
        $dob = isset($data['dob']) ? Carbon::createFromFormat('Y-m-d', $data['dob']) : $dt;
        if (isset($data['membership'])){
            switch ($data['membership']) {
                case 'Silver':
                    $data['fee'] = '100000';
                    if (!$data['gender']) {
                        if ($dt->diffInYears($dob) >= 17) $data['vat'] = 0;
                    }
                    break;
                case 'Gold':
                    $data['fee'] = '200000';
                    if (!$data['gender']) {
                        if ($dt->diffInYears($dob) >= 20) $data['vat'] = 0;
                    }
                    break;
                case 'Platinum':
                    $data['fee'] = '300000';
                    if (!$data['gender']) {
                        if ($dt->diffInYears($dob) >= 22) $data['vat'] = 0;
                    }
                    break;
                case 'Black':
                    $data['fee'] = '500000';
                    break;
                case 'VIP':
                    $data['fee'] = '1000000';
                    break;
                case 'VVIP':
                    $data['fee'] = '2000000';
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        // return $data;
        $user = new User($data);
        $user->id = Uuid::generate(4)->string;
        $user->password = bcrypt($user->password);
        $user->password = bcrypt($request->password);
        $user->save();
        if (isset($data['address'])) {
            foreach($request->addresses as $address) {
                $adr = new UserAddress(['address' => $address]);
                $adr->user_id = $user->id;
                $adr->save();
            }
        }
        return response()->json(['status' => 'success'], 200);
    }


    public function loginWeb(Request $request)
    {
        $response = $this->login($request);
        $statusCode = $response->status();
        $body = $response->getData();
        if ($statusCode === 200) {
            session([
                'bearer' => $response->headers->get('authorization')
            ]);
            return redirect()->route('home');
        }
        return redirect()->back()->withErrors($body->errors);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            // return $this->respondWithToken($token);
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json([
            'status' => 'error',
            'errors' => ['message' => 'Unauthorized']
        ], 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function logoutWeb(Request $request)
    {
        $token = session()->get('bearer');
        $request->headers->set('Authorization', "bearer $token");
        $request->headers->set('Accept', "application/json");
        $response = $this->logout($request);
        $statusCode = $response->status();
        if ($statusCode === 200) {
            return redirect()->route('login')->withErrors(["success_message" => $response->getData('data')['msg']]);
        }
        return redirect()->route('login')->withErrors(['message' => 'Unauthorized']);
    }

    public static function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        // return $this->respondWithToken(auth()->refresh());
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            "success"      => true,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Forgot password by user email.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot(Request $request)
    {
        $user = new User;

        $user = $user->where('email', $request->email)->first();
        if ( ! empty($user)) {
            $data    = $user;
            $id      = $data->id;
            $expired = time() + (60 * 60); // one hour expiry
            $link    = url('/')."/auth/reset?token=".urlencode(encrypt($expired.','.$id));

            Mail::to($request->email)->send(new ForgotPass($link, $data));

            return response()->json([
                "success" => true,
                "message" => 'Check email for reset password',
            ], 201);
        } else {
            return response()->json([
                "success" => false,
                "message" => 'Email not found in database',
            ], 201);
        }

    }

    /**
     * Reset password of user.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {

        $data            = [];
        $data["success"] = false;
        $data["reset"]   = false;

        if ($request->token) {
            try {
                $decrypted = decrypt($request->token);
            } catch (DecryptException $e) {
                return view('auth/reset', $data);
            }
            $key = explode(",", $decrypted);

            if ($id = $key[1] && time() <= $key[0]) {

                if ($user = User::find($key[1])) {
                    if ($request->password) {

                        $user->password = Hash::make($request->password);
                        if ($user->save()) {
                            $data["success"] = true;
                        }
                        $data["reset"] = true;
                    } else {
                        $data["success"] = true;
                        $new_reset_token = encrypt($key[0].','.$key[1]);
                        $decrypted       = decrypt($new_reset_token);
                        $keyz            = explode(",", $decrypted);

                        $data["token"] = $new_reset_token;
                        $data["user"]  = $user;
                    }

                    return view('auth/reset', $data);
                }
            } else {
                $data["expired"] = false;
            }
        }

        return view('auth/reset', $data);
    }
}
