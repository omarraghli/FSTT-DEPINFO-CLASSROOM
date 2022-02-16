<?php

namespace App\Http\Controllers;

use App\Models\AffectedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\Projet;
use App\Models\User;

use DB;

class ProjetController extends Controller
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
   * Show details about a particular class - GET
   * 
   * @return Response 
   */

  public function showform()
  {
    return view('pages.projet.addProjet', ['users' => User::all()]);
  }


  public function store(Request $request)
  {
    $this->validate($request, [
      'due_date' => 'required|date|after:' . date('Y-m-d H:i:s')
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


    $project = new Projet();
    $project->type = $request->input('type');
    $project->fichier = $nom_fichier;
    $project->teacher_id = $teacher_id;
    $project->user_id = $request->get('Student');
    $project->due_date = $due_date;

    if ($project->save()) {
      if ($request->hasFile('fichier')) {
        $this->cleanDirectory('/fichiers/projet/' . $project->id .  '/teacher/' . $teacher_id . '/');
        $fichier = $request->file('fichier');
        $nom_fichier = $fichier->getClientOriginalName();
        $fichier->move(public_path() . '/fichiers/projet/' . $project->id .  '/teacher/' . $teacher_id . '/', $nom_fichier);
      }

      return redirect('/')->with('status', 'project added successfully!');
    }
  }

  public function AddNote(Request $request, $id, $student_id)
  {
    $note = $request->input('note');
    $affas = AffectedProject::where([['student_id', '=', $student_id], ['projet_id', '=', $id]])->first();
    AffectedProject::where([
      ['projet_id', '=', $id],
      ['student_id', '=', $student_id]
    ])->update(array('note' => $note));
    $noteEtu = AffectedProject::where([['projet_id', '=', $id], ['student_id', '=', $student_id]])->first()->note;
    $projet = Projet::find($id);
    $student = User::find($student_id);
    $fichier = null;

    $affected_project = AffectedProject::where(
      [
        ['student_id', '=', $student_id],
        ['projet_id', '=', $id]
      ]
    )->first();

    if ($affected_project != null) {
      $fichier = $affected_project->fichier;
    }
    return view('pages.projet.showForProf', [
      'affas' => $affas,
      'noteactuelle' => $noteEtu,
      'student_id' => $student_id,
      'student' => $student,
      'teacher' => Auth::user()->id,
      'affected_project' => $fichier,
      'projet_id' => $id,
      'Projet' => $projet,

    ]);
  }

  public function show($id, $teacher_id)
  {
    $projet = Projet::find($id);
    $teacher = User::find($teacher_id);
    $affas = AffectedProject::where([['student_id', '=', Auth::user()->id], ['projet_id', '=', $id]])->first();
    $fichier = null;
    $noteEtu = null;

    $affected_project = AffectedProject::where(
      [
        ['student_id', '=', Auth::user()->id],
        ['projet_id', '=', $id]
      ]
    )->first();

    if ($affected_project != null) {
      $fichier = $affected_project->fichier;
      $noteEtu = AffectedProject::where([['projet_id', '=', $id], ['student_id', '=', Auth::user()->id]])->first()->note;
    }

    return view('pages.projet.show', [
      'affas' => $affas,
      'noteactuelle' => $noteEtu,
      'teacher_id' => $teacher_id,
      'teacher' => $teacher,
      'affected_project' => $fichier,
      'projet_id' => $id,
      'Projet' => $projet,

    ]);
  }

  public function showForProf($id, $student_id)
  {
    $projet = Projet::find($id);
    $student = User::find($student_id);
    $affas = AffectedProject::where([['student_id', '=', $student_id], ['projet_id', '=', $id]])->first();
    $fichier = null;
    $noteEtu = null;


    $affected_project = AffectedProject::where(
      [
        ['student_id', '=', $student_id],
        ['projet_id', '=', $id]
      ]
    )->first();

    if ($affected_project != null) {
      $noteEtu = AffectedProject::where([['projet_id', '=', $id], ['student_id', '=', $student_id]])->first()->note;
      $fichier = $affected_project->fichier;
    }

    return view('pages.projet.showForProf', [
      'affas' => $affas,
      'noteactuelle' => $noteEtu,
      'student_id' => $student_id,
      'student' => $student,
      'teacher' => Auth::user()->id,
      'affected_project' => $fichier,
      'projet_id' => $id,
      'Projet' => $projet,

    ]);
  }



  function cleanDirectory($path)
  {
    $path = public_path() . $path;
    $files = File::files($path);
    foreach ($files as $file) {
      File::delete($file);
    }
  }


  public function rendreProjet(Request $request, $projet_id, $student_id, $teacher_id)
  {
    $teacher = User::find($teacher_id);
    $nom_fichier = "";
    $noteEtu = null;

    if ($request->hasFile('fichier')) {
      $this->cleanDirectory('/fichiers/projet/' . $projet_id .  '/student/' . $student_id . '/');
      $fichier = $request->file('fichier');
      $nom_fichier = $fichier->getClientOriginalName();
      $fichier->move('fichiers/projet/' . $projet_id . '/student/' . $student_id . "/", $nom_fichier);
    }
    /* ------------------------------------------------- */
    $affected_project = AffectedProject::where(
      [
        ['student_id', '=', Auth::user()->id],
        ['projet_id', '=', $projet_id]
      ]
    )->first();
    $etudiant = AffectedProject::where([['projet_id', '=', $projet_id], ['student_id', '=', $student_id]])->first();
    if ($etudiant != null)
      $noteEtu = $etudiant->note;
    if ($affected_project == null) {
      $affected_project = new AffectedProject;
      $affected_project->fichier = $nom_fichier;
      $affected_project->projet_id = $projet_id;
      $affected_project->student_id = $student_id;
    } else {
      $affected_project->fichier = $nom_fichier;
      $affected_project->projet_id = $projet_id;
      $affected_project->student_id = $student_id;
    }
    $affas = AffectedProject::where([['student_id', '=', $student_id], ['projet_id', '=', $projet_id]])->first();
    /* ------------------------------------------ */
    if ($affected_project->save()) {
      $projet = Projet::find($projet_id);

      return view('pages.projet.show', [
        'affas' => $affas ,
        'noteactuelle' => $noteEtu,
        'teacher_id' => $teacher_id,
        'teacher' => $teacher,
        'affected_project' => $nom_fichier,
        'projet_id' => $projet_id,
        'Projet' => $projet,

      ]);
    }
  }


  public function downlaodProjet($projet_id, $teacher_id, $file_name)
  {

    $file = public_path() . '/fichiers/projet/' . $projet_id . '/teacher/' . $teacher_id . '/' . $file_name;

    $headers = array(
      'Content-Type: application/pdf',
    );

    return Response::download($file, $file_name, $headers);
  }

  public function downlaodStuProjet($projet_id, $student_id, $file_name)
  {

    $file = public_path() . '/fichiers/projet/' . $projet_id . '/student/' . $student_id . '/' . $file_name;

    $headers = array(
      'Content-Type: application/pdf',
    );

    return Response::download($file, $file_name, $headers);
  }
  // public function downlaodProfProjet($projet_id,$teacher_id, $file_name)
  // {

  //    $file = public_path() . '/fichiers/projet/' . $projet_id . '/teacher/' . $teacher_id . '/downlaodProjet/' . $file_name;

  //   $headers = array(
  //     'Content-Type: application/pdf',
  //   );

  //   return Response::download($file, $file_name, $headers);
  // }



}
