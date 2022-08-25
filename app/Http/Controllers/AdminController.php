<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use App\Models\Optout;
use App\Models\User;
use App\Models\Practice;
use Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function optouts(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            return view('admin.optouts.index');
        } else {
            return view('admin.optouts.user_index');
        }
    }
    public function cases()
    {
        return view('admin.cases.index');
    }

    public function getCases(Request $request)
    {
        $users = User::all();
        $select = '';
        $nestedData['assigntouser']='';
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'phone',
            3 => 'address'
        );

        $totalData = Practice::whereNull('assign')->count();

        $totalFiltered = $totalData;
        if ($request->input('length') == -1) {
            $limit =  $totalData;
        } else {
            $limit = $request->input('length');
        }
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = Practice::whereNull('assign')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = Practice::where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%{$search}%")
                    ->orwhere('practice', 'LIKE', "%{$search}%")
                    ->orwhere('email', 'LIKE', "%{$search}%")
                    ->orwhere('address', 'LIKE', "%{$search}%")
                    ->orwhere('phone', 'LIKE', "%{$search}%")
                    ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%']);
            })
                ->whereNull('assign')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Practice::where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%{$search}%")
                    ->orwhere('practice', 'LIKE', "%{$search}%")
                    ->orwhere('email', 'LIKE', "%{$search}%")
                    ->orwhere('address', 'LIKE', "%{$search}%")
                    ->orwhere('phone', 'LIKE', "%{$search}%")
                    ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%']);
            })
                ->whereNull('assign')
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                // $show =  route('cat.show', $post->id);
                $edit =  route('case.edit', $post->id);

                $nestedData['id'] = $post->id;
                $nestedData['practice'] = $post->practice;
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                $nestedData['phone'] = $post->phone;
                $nestedData['address'] = $post->address;

                $nestedData['options'] = "
                <a    data-id='{$post->id}' class='btn btn-white rounded-circle m-1 shadow-sm edit'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                    <polygon points='16 3 21 8 8 21 3 21 3 16 16 3'></polygon>
                </svg>
                </a>
                <a   data-id='{$post->id}'  data-email='{$post->email}'  class='btn btn-white rounded-circle m-1 shadow-sm delete'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                    <polyline points='3 6 5 6 21 6'></polyline>
                    <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                    <line x1='10' y1='11' x2='10' y2='17'></line>
                    <line x1='14' y1='11' x2='14' y2='17'></line>
                </svg>
            </a>
               

                ";

                $nestedData['decline'] =  $post->decline == 0 ? "
                <button  data-id='{$post->id}'  data-email='{$post->email}' type='button' class='btn btn-default email'>
                  Send Email
                </button>
                
               

                " : "<button  type='button' class='btn btn-default'>
                   Sent
                </button>";

                $nestedData['assign'] = "
                <button  data-id='{$post->id}'  type='button' class='btn btn-default assignhimself'>
                  Assign himself
                </button>";

                $nestedData['assigntouser'] = "<select data-id='{$post->id}'   onchange='functionstatus(this);'  class='form-control assign'>";

                foreach($users as $user){
                    $nestedData['assigntouser'] .= "<option value=".$user->id.">".$user->name."</option>";
                }

                $nestedData['assigntouser'] .= '</select>';





                // $nestedData['note'] = "<input   data-id='{$post->id}'  class='form-control comment' type='text' value='" . $post->comments . "'> ";
                $nestedData['l_isview'] = $post->l_isview;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

    public function adminsendemail(Request $request)
    {

        try {
            $details = [

                'email' => $request->email

            ];

            \Mail::to($request->email)->send(new \App\Mail\SendEmail($details));

            Practice::where('id', $request->id)->update([
                'decline' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email has sent'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'sql_error' => $th->getMessage(),
                'message' => 'Somrthing Wrong'
            ]);
        }
    }

    public function assigntouser(Request $request){
      try {
        Practice::where('id',$request->practice)->update([
            'assign' => $request->user
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Case has assigned successfully'
        ]);
      } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Something Wrong'
        ]);
      }
    }

    public function updatecomment(Request $request)
    {
        try {
            Practice::where('id', $request->id)->update([
                'comments' => $request->val
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Note has updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'sql_error' => $th->getMessage(),
                'message' => 'Something wrong'
            ]);
        }
    }

    public function MyCase()
    {
        return view('admin.cases.mycase');
    }

    public function markseen(Request $request)
    {
        try {
            Practice::where('id', $request->id)->update([
                'l_isview' => 1
            ]);

            return response()->json([
                'success' => true,

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => true,

            ]);
        }
    }

    public function MyAllCases(Request $request)
    {
        $users = User::all();
        $select = '';
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'phone',
            3 => 'address'
        );

        $totalData = Practice::where('assign', Auth::user()->id)->count();

        $totalFiltered = $totalData;
        if ($request->input('length') == -1) {
            $limit =  $totalData;
        } else {
            $limit = $request->input('length');
        }
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = Practice::where('assign', Auth::user()->id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = Practice::where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%{$search}%")
                    ->orwhere('practice', 'LIKE', "%{$search}%")
                    ->orwhere('email', 'LIKE', "%{$search}%")
                    ->orwhere('address', 'LIKE', "%{$search}%")
                    ->orwhere('phone', 'LIKE', "%{$search}%")
                    ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%']);
            })
                ->where('assign', Auth::user()->id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Practice::where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%{$search}%")
                    ->orwhere('practice', 'LIKE', "%{$search}%")
                    ->orwhere('email', 'LIKE', "%{$search}%")
                    ->orwhere('address', 'LIKE', "%{$search}%")
                    ->orwhere('phone', 'LIKE', "%{$search}%")
                    ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%']);
            })
                ->where('assign', Auth::user()->id)
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                //$show =  route('case.show', $post->id);
                //$edit =  route('case.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['practice'] = $post->practice;
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                $nestedData['phone'] = $post->phone;
                $nestedData['address'] = $post->address;
                $nestedData['options'] = "
                <a   data-id='{$post->id}' class='btn btn-white rounded-circle m-1 shadow-sm edit'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                    <polygon points='16 3 21 8 8 21 3 21 3 16 16 3'></polygon>
                </svg>
                </a>
                <a   data-id='{$post->id}' class='btn btn-white rounded-circle m-1 shadow-sm seen'>
                 Mark As Seen
                </a>";
                $nestedData['l_isview'] = $post->l_isview;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

    public function CaseDetail($id)
    {
        $case = Practice::find($id);
        return view('admin.cases.show', compact('case'));
    }

    public function assignhimself(Request $request)
    {
        try {
            Practice::where('id', $request->id)->update([
                'assign' => Auth::user()->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Case assigned successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'sql_error' => $th->getMessage(),
                'message' => 'Something wrong'
            ]);
        }
    }

    public function addCase()
    {

        return view('admin.cases.add');
    }

    public function saveCase(Request $request)
    {

        $validated = $request->validate([
            'practice' => 'required',
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'npi' => 'required',
            'tin' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'address2' => 'required',
            'fax' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'county' => 'required',
            'min_age_seen' => 'required|numeric',
            'max_age_seen' => 'required|numeric',
            'health_plan' => 'required'
        ]);
        $data = [];
        $case = new Practice();
        $case->practice = $request->practice;
        $case->name = $request->name;
        $case->email = $request->email;
        $case->contact = $request->contact;
        $case->npi = $request->npi;
        $case->tin = $request->tin;
        $case->phone = $request->phone;
        $case->fax = $request->fax;
        // $case->decline = $request->decline;
        $case->address = $request->address;
        $case->address2 = $request->address2;
        $case->city = $request->city;
        $case->state = $request->state;
        $case->zip = $request->zip;
        $case->county = $request->county;
        if (!empty($request->bussiness_line)) {
            foreach ($request->bussiness_line as $check) {
                $data[] = $check; //echoes the value set in the HTML form for each checked checkbox.
                //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                //in your case, it would echo whatever $row['Report ID'] is equivalent to.
            }
        }
        $string = implode(",", $data);
        $case->bussiness_line = isset($string) ? $string : '';
        $case->min_age_seen = $request->min_age_seen;
        $case->max_age_seen = $request->max_age_seen;
        $case->health_plan = $request->health_plan;
        $case->comments = $request->comments;
        $case->save();

        $details = [
            'practice' => $request->practice,
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'npi' => $request->npi,
            'tin' => $request->tin,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'address' => $request->address,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'county' => $request->county,
            'bussiness_line' => $string,
            'min_age_seen' => $request->min_age_seen,
            'max_age_seen' => $request->max_age_seen,
            'health_plan' => $request->health_plan,
            'comments' => $request->comments,


        ];

        \Mail::to(env('PRIMARY_EMAIL'))->send(new \App\Mail\SendData($details));

        for ($i = 0; $i < 2; $i++) {
            \Mail::to(env('EMAIL_' . $i + 1))->send(new \App\Mail\SendData($details));
        }
        return redirect()->back()->with('message', 'Case Added Successfully');
    }

    public function caseedit($id)
    {
        $case = Practice::find($id);
        $bussiness_line = explode(',', $case->bussiness_line);
        return view('admin.cases.edit', compact('case', 'bussiness_line'));
    }

    public function updateCase(Request $request)
    {
       
        $data = [];
        $input = $request->except(['_token', 'confirm_password']);
        if ($request->has('practice')) {
            $input['practice'] = $request->practice;
        }

        if ($request->has('name')) {
            $input['name'] = $request->name;
        }

        if ($request->has('other')) {
            $input['other'] = $request->other;
        }

        if ($request->has('email')) {
            $input['email'] = $request->email;
        }

        if ($request->has('contact')) {
            $input['contact'] = $request->contact;
        }

        if ($request->has('npi')) {
            $input['npi'] = $request->npi;
        }

        if ($request->has('tin')) {
            $input['tin'] = $request->tin;
        }

        if ($request->has('email')) {
            $input['email'] = $request->email;
        }

        if ($request->has('phone')) {
            $input['phone'] = $request->phone;
        }
        if ($request->has('fax')) {
            $input['fax'] = $request->fax;
        }
        if ($request->has('address')) {
            $input['address'] = $request->address;
        }
        if ($request->has('address2')) {
            $input['address2'] = $request->address2;
        }
        if ($request->has('city')) {
            $input['city'] = $request->city;
        }
        if ($request->has('state')) {
            $input['state'] = $request->state;
        }
        if ($request->has('zip')) {
            $input['zip'] = $request->zip;
        }
        if ($request->has('country')) {
            $input['country'] = $request->country;
        }

        
        if (!empty($request->bussiness_line)) {

          
            foreach ($request->bussiness_line as $check) {
                $data[] = $check; //echoes the value set in the HTML form for each checked checkbox.
                //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                //in your case, it would echo whatever $row['Report ID'] is equivalent to.
            }
            $string = implode(",", $data);
            $input['bussiness_line'] = isset($string) ? $string : '';
        }else{
            Practice::where('id', $input['id'])->update([
                'bussiness_line' => ''
            ]);
        }



        if ($request->has('min_age_seen')) {
            $input['min_age_seen'] = $request->min_age_seen;
        }
        if ($request->has('max_age_seen')) {
            $input['max_age_seen'] = $request->max_age_seen;
        }
        if ($request->has('health_plan')) {
            $input['health_plan'] = $request->health_plan;
        }
        if ($request->has('comments')) {
            $input['comments'] = $request->comments;
        }

        Practice::where('id', $request->id)->update($input);
        return redirect()->back()->with('message', 'Practice Updated Successfully');
    }

    public function deletecase(Request $request)
    {
        try {
            Practice::where('id', $request->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Deleted'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    public function getoptouts(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'ufax',
            2 => 'uphone',
            3 => 'ip_address',
        );

        $totalData = Optout::count();

        $totalFiltered = $totalData;
        if ($request->input('length') == -1) {
            $limit =  $totalData;
        } else {
            $limit = $request->input('length');
        }
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = Optout::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = Optout::where('ufax', 'LIKE', "%{$search}%")
                ->orwhere('uphone', 'LIKE', "%{$search}%")
                ->orwhere('ip_address', 'LIKE', "%{$search}%")
                ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%'])
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Optout::where('ufax', 'LIKE', "%{$search}%")
                ->orwhere('uphone', 'LIKE', "%{$search}%")
                ->orwhere('ip_address', 'LIKE', "%{$search}%")
                ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%'])
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                // $show =  route('cat.show', $post->id);
                //$edit =  route('posts.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['ufax'] = $post->ufax;
                $nestedData['uphone'] = $post->uphone;
                $nestedData['ip_address'] = $post->ip_address;
                $nestedData['date'] = date('m-d-Y H:i:s', strtotime($post->created_at));
                if (Auth::user()->role_id == 1) {
                    $nestedData['options'] = "
                <button  data-id='{$post->id}'  type='button' class='btn btn-white rounded-circle m-1 shadow-sm edit'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                    <polygon points='16 3 21 8 8 21 3 21 3 16 16 3'></polygon>
                </svg>
                </button>
                <a   data-id='{$post->id}' class='btn btn-white rounded-circle m-1 shadow-sm delete'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                    <polyline points='3 6 5 6 21 6'></polyline>
                    <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                    <line x1='10' y1='11' x2='10' y2='17'></line>
                    <line x1='14' y1='11' x2='14' y2='17'></line>
                </svg>
            </a>
               

                ";
                }

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }
    public function delete_optouts(Request $request)
    {
        try {
            Optout::find($request->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Optout deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something Wrong',
                'sql_error' => $th->getMessage()
            ]);
        }
    }
    public function users(Request $request)
    {
        return view('admin.users.index');
    }
    public function getusers(Request $request)
    {
        $columns = array(
            0 => 'id',
            2 => 'name',
            3 => 'email',
            6 => 'status',
        );

        $totalData = User::count();

        $totalFiltered = $totalData;
        if ($request->input('length') == -1) {
            $limit =  $totalData;
        } else {
            $limit = $request->input('length');
        }
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = User::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = User::where('name', 'LIKE', "%{$search}%")
                ->orwhere('email', 'LIKE', "%{$search}%")
                ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%'])
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::where('name', 'LIKE', "%{$search}%")
                ->where('role_id', '<>', 1)
                ->orwhere('email', 'LIKE', "%{$search}%")
                ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%'])
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                // $show =  route('cat.show', $post->id);
                //$edit =  route('posts.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                if ($post->role_id == 1) {
                    $nestedData['role'] = '<p><span>Admin</span></p>';
                } else {
                    $nestedData['role'] = '<p><span">User</span></p>';
                }
                if ($post->status == 1) {
                    $nestedData['status'] = '<p><span class="badge bg-success">Active</span></p>';
                } else {
                    $nestedData['status'] = '<p><span class="badge bg-danger">Pending</span></p>';
                }
                $nestedData['ban'] = "
                <select class='form-control m-select2 photoStatus' name='status' data-id='{$post->id}' onchange='functionstatus(this);'>
                                                    <option value=''>Select</option>
                                                    <option value='0'>Pending</option>
                                                    <option value='1'>Active</option>
                                                </select>
                ";
                $nestedData['options'] = "
                <button  data-id='{$post->id}'  type='button' class='btn btn-white rounded-circle m-1 shadow-sm edituser'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                    <polygon points='16 3 21 8 8 21 3 21 3 16 16 3'></polygon>
                </svg>
                </button>
                <a   data-id='{$post->id}' class='btn btn-white rounded-circle m-1 shadow-sm delete'>
												<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
													<polyline points='3 6 5 6 21 6'></polyline>
													<path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
													<line x1='10' y1='11' x2='10' y2='17'></line>
													<line x1='14' y1='11' x2='14' y2='17'></line>
												</svg>
											</a>
                ";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }
    public function delete_users(Request $request)
    {
        try {
            User::find($request->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something Wrong',
                'sql_error' => $th->getMessage()
            ]);
        }
    }
    public function user_status(Request $request)

    {
        $id = $request->id;
        $status = $request->status;
        $user = User::find($id);
        User::where('id', $id)
            ->update([
                'status' => $status
            ]);
        $email = $user->email;
        $details = [
            'template'  => 'status',
            'subject'   => 'Account info!',
            'email'     =>  $user->email,
            'user_name'      => $user->name,
        ];
        if ($request->status == 0) {

            Mail::to($email)->send(new  \App\Mail\StatusMail($details));
        }
        if ($request->status == 1) {
            Mail::to($email)->send(new  \App\Mail\ApproveMail($details));
        }
        return 1;
    }

    public function history()
    {

        return view('admin.history.index');
    }

    public function gethistory(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'ip_adress',
            3 => 'download_date',
        );

        $totalData = History::count();

        $totalFiltered = $totalData;
        if ($request->input('length') == -1) {
            $limit =  $totalData;
        } else {
            $limit = $request->input('length');
        }
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = History::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = History::where('name', 'LIKE', "%{$search}%")

                ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%'])
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = History::where('name', 'LIKE', "%{$search}%")
                ->orWhereRaw('DATE_FORMAT(`created_at`, "%d-%m-%Y") LIKE ? ', [$search . '%'])
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                // $show =  route('cat.show', $post->id);
                //$edit =  route('posts.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['date'] = $post->download_date;
                $nestedData['options'] = "
                <a   data-id='{$post->id}' class='btn btn-white rounded-circle m-1 shadow-sm delete'>
												<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#175ad3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
													<polyline points='3 6 5 6 21 6'></polyline>
													<path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
													<line x1='10' y1='11' x2='10' y2='17'></line>
													<line x1='14' y1='11' x2='14' y2='17'></line>
												</svg>
											</a>
                ";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

    public function getOptout(Request $request)
    {
        try {
            $optout =  Optout::find($request->id);
            return response()->json([
                'success' => true,
                'data' => $optout
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateOptout(Request $request)
    {
        try {
            Optout::where('id', $request->id)->update([
                'uphone' => $request->phone,
                'ip_address' => $request->ip,
                'ufax' => $request->fax,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Optout Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getUser(Request $request)
    {
        try {
            $user = User::find($request->id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something Wrong',
                'sql_error' => $th->getMessage()
            ]);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            User::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'User Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function DeleteHistory(Request $request)
    {
        try {
            History::find($request->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'History Deleted'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
