<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AffectedAssignement;
use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AssignmentController extends Controller
{
  public function store(Request $request, $id)
  {
    $today = date('Y-m-d H:i:s');

    $this->validate($request, [
      'title' => 'required',
      'due_date' => 'required|date|after:' . $today,
      'description' => 'required'
    ]);
    $teacher_id = Auth::user()->id;
    $nom_fichier = "";
    if ($request->hasFile('fichier')) {
      $fichier = $request->file('fichier');
      $nom_fichier = $fichier->getClientOriginalName();
    }
    $due_date = $request->input('due_date');
    $due_date = str_replace('T', ' ', $due_date);
    $due_date = $due_date . ':00';

    $assignment = new Assignment;
    $assignment->title = $request->input('title');
    $assignment->due_date = $due_date;
    $assignment->description = $request->input('description');
    $assignment->course_id = $id;
    $assignment->fichier = $nom_fichier;




    if ($assignment->save()) {
      if ($request->hasFile('fichier')) {
        $this->cleanDirectory('/fichiers/course/' . $id . '/assignement/' . $assignment->id . '/teacher/');
        $fichier = $request->file('fichier');
        $nom_fichier = $fichier->getClientOriginalName();
        $fichier->move(public_path() . '/fichiers/course/' . $id . '/assignement/' . $assignment->id . '/teacher/', $nom_fichier);
      }

      return redirect('/course/' . $id)->with('status', 'Assignment added successfully!');
    }
  }

  /**
   * Show details about a particular assignment
   * 
   * @param  integer $course_id     
   * @param  integer $assignment_id 
   * @return Response response             
   */




  public function show($course_id, $assignment_id)
  {
    $assignment = Assignment::find($assignment_id);
    $course = Course::find($course_id);
    $course_name = $course->subject . ' ' . $course->course . '-' . $course->section;
    $course_instructor = $course->user_id;
    $fichier = null;
    $usernote = null;
    $affas = null;
    $affected_assignement = AffectedAssignement::where(
      [
        ['id_student', '=', Auth::user()->id],
        ['id_assignement', '=', $assignment_id]
      ]
    )->first();
    if ($affected_assignement != null) {
      $fichier = $affected_assignement->fichier;
      if (Auth::user()->role == 'student') {
        $affas = AffectedAssignement::where([['id_student', '=', Auth::user()->id], ['id_assignement', '=', $assignment_id]])->first();
        $usernote = $affas->note;
      }
    }
    Session()->put('assignment_id', $assignment_id);

    $affectedassignements = AffectedAssignement::where(
      [
        ['id_assignement', '=', $assignment_id]
      ]
    )->get();

    $affected_assignements = array();
    foreach ($affectedassignements as $val) {
      $assignment = Assignment::where('id', '=', $val->id_assignement)->first();
      if ($assignment != null)
        $tmpstate = (($val->created_at) < ($assignment->due_date)) ? 'In time!!' : 'Too late';
      else
        $tmpstate = 'not assigned';
      $user = User::where("id", "=", $val->id_student)->first();
      array_push($affected_assignements, (object)[
        'AffectedAssignement' => AffectedAssignement::where(
          [
            ['id_student', '=', $val->id_student],
            ['id_assignement', '=', $assignment_id]
          ]
        )->get()[0]->note,
        'state' => $tmpstate,
        'fichier' => $val->fichier,
        'user' => $user,
        'user_id' => $val->id_student
      ]);
    }



    return view('pages.course.assignment.show', [
      'affas' => $affas,
      'usernote' => $usernote,
      'affected_assignements' => $affected_assignements,
      'affected_assignement' => $fichier,
      'course_name' => $course_name,
      'course_id' => $course_id,
      'assignment' => $assignment,
      'course_instructor' => $course_instructor,
      'due_date_formatted' => str_replace(' ', 'T', $assignment->due_date)
    ]);
  }


  public function AddNote(Request $request, $course_id, $assignment_id, $student_id)
  {
    $note = $request->input('note');
    AffectedAssignement::where([
      ['id_assignement', '=', $assignment_id],
      ['id_student', '=', $student_id]
    ])->update(array('note' => $note));

    $assignment = Assignment::find($assignment_id);

    $course = Course::find($course_id);
    $course_name = $course['subject'] . ' ' . $course['course'] . '-' . $course['section'];
    $course_instructor = $course['user_id'];

    $fichier = null;
    $affected_assignement = AffectedAssignement::where(
      [
        ['id_student', '=', Auth::user()->id],
        ['id_assignement', '=', $assignment_id]
      ]
    )->first();
    if ($affected_assignement != null) {
      $fichier = $affected_assignement->fichier;
    }
    Session()->put('assignment_id', $assignment_id);

    $affectedassignements = AffectedAssignement::where(
      [
        ['id_assignement', '=', $assignment_id]
      ]
    )->get();


    $affected_assignements = array();
    foreach ($affectedassignements as $val) {
      if ($assignment != null)
        $tmpstate = (($val->created_at) < ($assignment->due_date)) ? 'In time!!' : 'Too late';
      else
        $tmpstate = 'not assigned';

      $user = User::where("id", "=", $val->id_student)->first();
      array_push($affected_assignements, (object)[
        'AffectedAssignement' => AffectedAssignement::where(
          [
            ['id_student', '=', $val->id_student],
            ['id_assignement', '=', $assignment_id]
          ]
        )->get()[0]->note,
        'state' => $tmpstate,
        'fichier' => $val->fichier,
        'user' => $user,
        'user_id' => $val->id_student
      ]);
    }

    return view('pages.course.assignment.show', [
      'affected_assignements' => $affected_assignements,
      'affected_assignement' => $fichier,
      'course_id' => $course_id,
      'course_instructor' => $course_instructor,
      'assignment' => $assignment,
      'course_name' => $course_name
    ]);
  }

  /**
   * Delete a particular assignment
   * 
   * @param  integer     $course_id    
   * @param  integer    $assignment_id 
   * @return Response response
   */
  public function destroy($course_id, $assignment_id)
  {
    if (Assignment::destroy($assignment_id)) {
      return redirect('/course/' . $course_id)->with('status', 'Assignment deleted successfully!');
    }
  }

  public function update(Request $request, $course_id, $assignment_id)
  {
    $this->validate($request, [
      'title' => 'required',
      'due_date' => 'required|date',
      'description' => 'required'
    ]);

    $due_date = $request->input('due_date');
    $due_date = str_replace('T', ' ', $due_date);
    $due_date = $due_date . ':00';

    $assignment = Assignment::find($assignment_id);
    $assignment->title = $request->input('title');
    $assignment->due_date = $due_date;
    $assignment->description = $request->input('description');

    if ($assignment->save()) {
      return redirect('/course/' . $course_id . '/assignment/' . $assignment_id)->with('status', 'Assignment updated successfully!');
    }
  }
  function cleanDirectory($path)
  {
    $path = public_path() . $path;
    $files = File::files($path);
    foreach ($files as $file) {
      File::delete($file);
    }
  }








  public function rendreAssignment(Request $request, $course_id, $assignment_id, $student_id)
  {
    $nom_fichier = "";
    $noteEtu = null;
    $affas = null;


    if ($request->hasFile('fichier')) {
      $this->cleanDirectory('/fichiers/course/' . $course_id . '/assignement/' . $assignment_id . '/student/' . $student_id . '/');
      $fichier = $request->file('fichier');
      $nom_fichier = $fichier->getClientOriginalName();
      $fichier->move('fichiers/course/' . $course_id . '/assignement/' . $assignment_id . '/student/' . $student_id . "/", $nom_fichier);
    }
    /* ------------------------------------------------- */
    $affected_assignement = AffectedAssignement::where(
      [
        ['id_student', '=', $student_id],
        ['id_assignement', '=', $assignment_id]
      ]
    )->first();
    $affas = AffectedAssignement::where([['id_student', '=', Auth::user()->id], ['id_assignement', '=', $assignment_id]])->first();
    $etudiant = AffectedAssignement::where([['id_assignement', '=', $assignment_id], ['id_student', '=', Auth::user()->id]])->first();
    if ($etudiant != null)
      $noteEtu = $etudiant->note;

    if ($affected_assignement == null) {
      $affected_assignement = new AffectedAssignement;
      $affected_assignement->fichier = $nom_fichier;
      $affected_assignement->id_assignement = $assignment_id;
      $affected_assignement->id_student = $student_id;
    } else {
      $affected_assignement->fichier = $nom_fichier;
      $affected_assignement->id_assignement = $assignment_id;
      $affected_assignement->id_student = $student_id;
    }

    /* ------------------------------------------ */
    if ($affected_assignement->save()) {
      $assignment = Assignment::find($assignment_id);
      $course = Course::find($course_id);
      $course_name = $course->subject . ' ' . $course->course . '-' . $course->section;
      $course_instructor = $course->user_id;

      return view('pages.course.assignment.show', [
        'affas' => $affas,
        'usernote' => $noteEtu,
        'affected_assignement' => $nom_fichier,
        'course_name' => $course_name,
        'course_id' => $course_id,
        'assignment' => $assignment,
        'course_instructor' => $course_instructor,
        'due_date_formatted' => str_replace(' ', 'T', $assignment->due_date)
      ]);
    }
  }

  public function downlaodAssignement($course_id, $assignment_id, $file_name)
  {

    $file = public_path() . '/fichiers/course/' . $course_id . '/assignement/' . $assignment_id . '/teacher/' . $file_name;

    $headers = array(
      'Content-Type: application/pdf',
    );

    return Response::download($file, $file_name, $headers);
  }

  public function downlaodAssignementstu($course_id, $assignment_id, $student_id, $file_name)
  {

    $file = public_path() . '/fichiers/course/' . $course_id . '/assignement/' . $assignment_id . '/student/' . $student_id . '/' . $file_name;

    $headers = array(
      'Content-Type: application/pdf',
    );

    return Response::download($file, $file_name, $headers);
  }
}
