<?php

namespace App\Http\Controllers;

use App\Models\Member;
use DB;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function runValidation($request)
    {
        $validation_rule = [
            'firstname' => 'required|max:50',
            'middlename' => 'required|max:50',
            'lastname' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'civil_status' => 'required|in:single,married,widow,widower',
            'citizenship' => 'required|max:50',
            'contact' => 'required',
            'email' => 'required|email',
            'id_type' => 'required|max:50',
            'id_number' => 'required|max:50',
            'emergency_person' => 'required|max:100',
            'emergency_contact' => 'required|max:50',
            'emergency_relationship' => 'required|max:50',
            'date_started' => 'required|date',
            'referrer' => 'nullable',
            'date_restarted' => 'nullable',
            'image' => 'nullable',
        ];
        $validation = $request->validate($validation_rule);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all();
        return view('theme.views.dashboards.members.members-list', ['members' => $members]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('theme.views.dashboards.members.member-form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->runValidation($request);
        $excepts = [
            '_token',
            'billing_is_current_address',
            'home_address1',
            'home_address2',
            'home_barangay',
            'home_city',
            'home_province',
            'home_postal',
            'billing_address1',
            'billing_address2',
            'billing_barangay',
            'billing_city',
            'billing_province',
            'billing_postal',
        ];
        $home_address = [
            'address1' => $request->input('home_address1'),
            'address2' => $request->input('home_address2'),
            'barangay' => $request->input('home_barangay'),
            'city' => $request->input('home_city'),
            'province' => $request->input('home_province'),
            'postal' => $request->input('home_postal'),
        ];
        $billing_address = [];
        if ($request->input('billing_is_current_address'))
        {
            $billing_address = $home_address;
        }
        else
        {
            $billing_address = [
                'address1' => $request->input('billing_address1'),
                'address2' => $request->input('billing_address2'),
                'barangay' => $request->input('billing_barangay'),
                'city' => $request->input('billing_city'),
                'province' => $request->input('billing_province'),
                'postal' => $request->input('billing_postal'),
            ];
        }
        $member_info = $request->except($excepts);
        $member_info['home_address'] = json_encode($home_address);
        $member_info['billing_address'] = json_encode($billing_address);
        $builder = Member::create($member_info);
        if (isset($builder->id))
        {
            $data = [
                'success' => true,
                'title' => 'Success!',
                'message' => 'Successfully Added',
            ];
        }
        else
        {
            $errors = $builder->messages()->messages();
            $data = [
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'Please check form for input errors.',
                'errors' => $errors,
            ];
        }
        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $member_info = $member;
        $home_address = json_decode($member->home_address, true);
        $billing_address = json_decode($member->billing_address, true);
        $member_info['home_address'] = $home_address;
        $member_info['billing_address'] = $billing_address;

        return view('theme.views.dashboards.members.member-detail', ['member' => $member_info]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $member_info = $member;
        $home_address = json_decode($member->home_address, true);
        $billing_address = json_decode($member->billing_address, true);
        $member_info['home_address'] = $home_address;
        $member_info['billing_address'] = $billing_address;

        return view('theme.views.dashboards.members.member-form', ['member' => $member_info]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $this->runValidation($request);
        $excepts = [
            '_token',
            'billing_is_current_address',
            'home_address1',
            'home_address2',
            'home_barangay',
            'home_city',
            'home_province',
            'home_postal',
            'billing_address1',
            'billing_address2',
            'billing_barangay',
            'billing_city',
            'billing_province',
            'billing_postal',
        ];
        $home_address = [
            'address1' => $request->input('home_address1'),
            'address2' => $request->input('home_address2'),
            'barangay' => $request->input('home_barangay'),
            'city' => $request->input('home_city'),
            'province' => $request->input('home_province'),
            'postal' => $request->input('home_postal'),
        ];
        $billing_address = [];
        if ($request->input('billing_is_current_address'))
        {
            $billing_address = $home_address;
        }
        else
        {
            $billing_address = [
                'address1' => $request->input('billing_address1'),
                'address2' => $request->input('billing_address2'),
                'barangay' => $request->input('billing_barangay'),
                'city' => $request->input('billing_city'),
                'province' => $request->input('billing_province'),
                'postal' => $request->input('billing_postal'),
            ];
        }
        $member_info = $request->except($excepts);
        $member_info['home_address'] = json_encode($home_address);
        $member_info['billing_address'] = json_encode($billing_address);

        $builder = $member->update($member_info);
        if ($builder)
        {
            $data = [
                'success' => true,
                'title' => 'Success!',
                'message' => 'Successfully Added',
            ];
        }
        else
        {
            $errors = $builder->messages()->messages();
            $data = [
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'Please check form for input errors.',
                'errors' => $errors,
            ];
        }
        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        $data = [
            'success' => true,
            'title' => 'Success!',
            'message' => 'Successfully archive member.',
        ];
        return json_encode($data);
    }

    /**
     * Upload image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        $this->validate($request, [

            'webcam' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $image = $request->file('webcam');
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);

        return json_encode([
            'success' => 'Image Upload successful',
            'image' => $input['imagename'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function attendanceUpdate($id)
    {
        $member = Member::find($id);
        $attendance = $member->attendance()->whereDate('created_at', DB::raw('CURDATE()'))->orderBy('created_at', 'desc')->first();
        if ($attendance && !$attendance->time_out)
        {
            $attendance->time_out = date('Y-m-d H:i:s', strtotime('now'));
            $attendance->save();
        }
        else
        {
            $attendance = $member->attendance()->create(['time_in' => date('Y-m-d H:i:s', strtotime('now'))]);
        }

        if ($attendance)
        {
            return ['success' => true, 'message' => 'Success!', 'data' => (array) $attendance];
        }
        else
        {
            return ['success' => false, 'message' => 'Oops! Something went wrong.'];
        }

    }
}