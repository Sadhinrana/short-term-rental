<?php

namespace App\Http\Controllers;

use App\MasterProperty;
use App\MatchProperty;
use App\User;
use App\UserCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function UserList(){
        $users = User::with('match_vote','missmatch_vote','unsure_vote')->paginate(10);
        $masterProperty = MasterProperty::groupBy('name')->get();
        return view('page.user.user-list',[
            'users'=>$users,
            'masterProperty'=>$masterProperty
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // Get the communities
        $masterProperty = MasterProperty::groupBy('name')->get();

        return view('page.user.create', compact('masterProperty'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city.*' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'role' => (int)$request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Check if city provided and if so insert
        if (isset($request->city) && is_array($request->city)) {
            foreach ($request->city as $city) {
                $data[] = [
                    'user_id' => $user->id,
                    'community' => $city,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            UserCommunity::insert($data); // Insert here
        }

        return redirect()->back()->with('success', 'User Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // Get the user & communities
        $masterProperty = MasterProperty::groupBy('name')->get();
        $user = User::findOrfail($id);

        return view('page.user.edit', compact('masterProperty', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate form data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city.*' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer'],
            'email' => "required|string|email|max:255|unique:users,email,$id",
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Update the user
        $user = User::findOrfail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;

        if(isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Check if city provided and if so insert
        UserCommunity::whereNotIn('community', $request->city)->where('user_id', $user->id)->delete();

        if (isset($request->city) && is_array($request->city)) {
            foreach ($request->city as $city) {
                if (!$user->communities->contains('community', $city)) {
                    $data[] = [
                        'user_id' => $user->id,
                        'community' => $city,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (isset($data)) {
                UserCommunity::insert($data);// Insert here
            }
        }

        return redirect()->back()->with('success', 'User Updated Successfully');
    }

    public function UserDetails($id){
        $VoteDate = MatchProperty::where('user_id',$id)
            ->orderBy('created_at','DESC')
            ->select(DB::raw('DATE(created_at) as date,user_id'))
            ->groupBy('date')
            ->get(2);
        $userDetails = User::find($id);
        return view('page.user.user-details',[
            'voteDate'=>$VoteDate,
            'userDetails'=>$userDetails,
            'id'=>$id,
        ]);
    }

    public function UserPropertyMap($id){
        $MatchProperty = MatchProperty::where('user_id',$id)->get();
        $lat = 0;
        $lng = 0;
        $count = 0;
        foreach ($MatchProperty as $row){
            $count++;
            $lat +=$row->masterPropertylat;
            $lng +=$row->masterPropertylng;
            if($row->vote==3){
                $modeID = 2;
            }else{
                $modeID = 1;
            }
            $data[] = array(
                'type' => 'Feature',
                'pId' => $row->id,
                'geometry' => array(
                    'type' => "Point",
                    'coordinates' => [$row->masterPropertylng, $row->masterPropertylat]
                ),
                'properties' => array(
                    'modelId' => $modeID,
                    'title' => $row->masterPropertyTitle
                ),
            );
        }
        $avgLat = $lat/$count;
        $avglng = $lng/$count;
        return response()->json(['data'=>$data,'avglat'=>$avgLat,'avglng'=>$avglng]);
    }

    public function AssignUserCommunity(Request $request){
        // Check if city provided and if so insert
        if (isset($request->city) && is_array($request->city)) {
            foreach ($request->city as $city) {
                $data[] = [
                    'user_id' => $request->user_id,
                    'community' => $city,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            UserCommunity::insert($data); // Insert here
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->back()->with('success', 'User Deleted Successfully.');
    }
}
