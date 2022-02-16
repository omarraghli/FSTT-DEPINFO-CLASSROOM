<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\AffectedAssignement;
use App\Models\AffectedProject;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Specify the middleware for this controller
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's profile
     * 
     * @return Response
     */

    public function show($user_id = NULL)
    {
        $user = NULL;
        $score = Null;

        if ($user_id) {
            $user = User::find($user_id);
        } else {

            $user = Auth::user();

            $id =  $user->id;
            if ($user->role == 'student') {

                $projetNote = 0;
                $inc = 0;
                $AssignmentNote = 0;
                $inc2 = 0;
                $user = User::find($id);
                $affected_project = AffectedProject::where(
                    [
                        ['student_id', '=', $id],
                    ]
                )->get();

                foreach ($affected_project as $Aprojet) {
                    if ($Aprojet->note != null) {
                        $projetNote = $Aprojet->note + $projetNote;
                        $inc++;
                    }
                }

                if ($inc == 0) {
                    $projetScore = 0;
                } else {
                    $projetScore =  $projetNote / $inc;
                }



                $affected_assignment = AffectedAssignement::where(
                    [
                        ['id_student', '=', $id],
                    ]
                )->get();

                foreach ($affected_assignment as $Assignment) {
                    if ($Assignment->note != null) {
                        $AssignmentNote = $Assignment->note + $AssignmentNote;
                        $inc2++;
                    }
                }

                if ($inc2 == 0) {
                    $AssignmentScore = 0;
                } else {
                    $AssignmentScore =  $AssignmentNote / $inc2;
                }

                $score = ($projetScore + $AssignmentScore) / 2;
            }
        }



        return view('pages.user.profile', [
            'user' => $user,
            'score' => $score,
        ]);

        // return $user_id;
    }

    /**
     * Updates the user's profile
     * 
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255'
        ]);

        $user = Auth::user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        if ($user->save()) {
            return redirect('/profile')->with('status', 'Profile updated successfully!');
        }
    }

    /**
     * Display all users that are students
     * 
     * @return Response 
     */
    public function showAll($course_id)
    {
        return view('pages.user.students/show_all', [
            'users' => User::all(),
            'course' => $course_id
        ]);
    }

    public function ShowAvatar()
    {
        $score= Null;
        $users =  User::all();
        $temparray = array();




        foreach ($users as $user) {


            $id =  $user->id;
            if ($user->role == 'student') {

                $projetNote = 0;
                $inc = 0;
                $AssignmentNote = 0;
                $inc2 = 0;
                $user = User::find($id);
                $affected_project = AffectedProject::where(
                    [
                        ['student_id', '=', $id],
                    ]
                )->get();

                foreach ($affected_project as $Aprojet) {
                    if ($Aprojet->note != null) {
                        $projetNote = $Aprojet->note + $projetNote;
                        $inc++;
                    }
                }

                if ($inc == 0) {
                    $projetScore = 0;
                } else {
                    $projetScore =  $projetNote / $inc;
                }



                $affected_assignment = AffectedAssignement::where(
                    [
                        ['id_student', '=', $id],
                    ]
                )->get();

                foreach ($affected_assignment as $Assignment) {
                    if ($Assignment->note != null) {
                        $AssignmentNote = $Assignment->note + $AssignmentNote;
                        $inc2++;
                    }
                }

                if ($inc2 == 0) {
                    $AssignmentScore = 0;
                } else {
                    $AssignmentScore =  $AssignmentNote / $inc2;
                }

                $score = ($projetScore + $AssignmentScore) / 2;
            }


            array_push($temparray, (object)[
                'first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'password' => $user->password, 'role' => $user->role, 'filier' => $user->filier, 'semestre' => $user->semestre, 'score' => $score
            ]);
        }
        return view('pages.user.students/show_avatar', [
            'users' => $temparray,
        ]);
    }


    public function CalculScore($student_id)
    {

        $projetNote = 0;
        $inc = 0;
        $AssignmentNote = 0;
        $inc2 = 0;
        $user = User::find($student_id);
        $affected_project = AffectedProject::where(
            [
                ['student_id', '=', $student_id],
            ]
        )->get();

        foreach ($affected_project as $Aprojet) {
            $projetNote = $Aprojet->note + $projetNote;
            $inc++;
        }

        $projetScore =  $projetNote / $inc;


        $affected_assignment = AffectedAssignement::where(
            [
                ['student_id', '=', $student_id],
            ]
        )->get();

        foreach ($affected_assignment as $Assignment) {
            $AssignmentNote = $Assignment->note + $AssignmentNote;
            $inc2++;
        }

        $AssignmentScore =  $projetNote / $inc2;

        $score = ($projetScore + $AssignmentScore) / 2;

        return view('pages.user.students/show_avatar', [
            'student_id' => $student_id,
            'score' => $score
        ]);
    }
}
