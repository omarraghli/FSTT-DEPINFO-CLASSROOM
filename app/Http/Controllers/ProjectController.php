<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Project;
use App\Models\User;
use App\Models\Affected;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
class ProjectController extends Controller
{
    public function showform()
  {
    return view('pages.projet.addProject', ['users' => User::all()]);
  }

  
  public function store(Request $request)
  {

    $teacher_id = Auth::user()->id;
    $nom_fichier = "";
    if ($request->hasFile('fichier')) {
      $fichier = $request->file('fichier');
      $nom_fichier = $fichier->getClientOriginalName();
    }
   


    $project = new Project();
    $project->titre = $request->input('titre');
    $project->description = $request->input('description');
    $project->remise = $request->input('remise');
    $project->fichier = $nom_fichier;
    $project->entreprise_id = $teacher_id;
    $project->user_id = $request->get('Student');


    if ($project->save()) {
      if ($request->hasFile('fichier')) {
        $this->cleanDirectory('/fichiers/project/' . $project->id .  '/entreprise/' . $teacher_id . '/');
        $fichier = $request->file('fichier');
        $nom_fichier = $fichier->getClientOriginalName();
        $fichier->move(public_path() . '/fichiers/project/' . $project->id .  '/entreprise/' . $teacher_id . '/', $nom_fichier);
      }

      return redirect('/')->with('status', 'project added successfully!');
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
  public function showForProf($id, $student_id)
  {
    $projet = Project::find($id);
    $student = User::find($student_id);
  //  $affas = AffectedProject::where([['student_id', '=', $student_id], ['projet_id', '=', $id]])->first();
    $fichier = null;
    $noteEtu = null;


    $affected_project = Affected::where(
      [
        ['project_id', '=', $id]
      ]
    )->first();
  
    if ($affected_project != null) {
    //  $noteEtu = AffectedProject::where([['projet_id', '=', $id], ['student_id', '=', $student_id]])->first()->note;
      $fichier = $affected_project->fichier;
   //   $user_id=$affected_project->user_id;
    }

    return view('pages.projet.showForEntreprise', [
      'affas' => null,
      'noteactuelle' => $noteEtu,
      'student_id' => $student_id,
      'user_id' =>  $student->id,
      'student' => $student,
      'teacher' => Auth::user()->id,
      'affected_project' => $fichier,
      'projet_id' => $id,
      'Projet' => $projet,

    ]);
  }
  public function downlaodProjet($projet_id, $teacher_id, $file_name)
  {

    $file = public_path() . '/fichiers/project/' . $projet_id . '/entreprise/' . $teacher_id . '/' . $file_name;

    $headers = array(
      'Content-Type: application/pdf',
    );

    return Response::download($file, $file_name, $headers);
  }
  public function show($id, $teacher_id)
  {
    $projet = Project::find($id);
    $teacher = User::find($teacher_id);
 //   $affas = AffectedProject::where([['student_id', '=', Auth::user()->id], ['projet_id', '=', $id]])->first();
    $fichier = null;
    $noteEtu = null;

    $affected_project = Affected::where(
      [
        ['user_id', '=', Auth::user()->id],
        ['project_id', '=', $id]
      ]
    )->first();

    if ($affected_project != null) {
      $fichier = $affected_project->fichier;
   //   $noteEtu = AffectedProject::where([['projet_id', '=', $id], ['student_id', '=', Auth::user()->id]])->first()->note;
    }

    return view('pages.projet.showEt', [
      'affas' => null,
      'noteactuelle' => $noteEtu,
      'teacher_id' => $teacher_id,
      'teacher' => $teacher,
      'affected_project' => $fichier,
      'projet_id' => $id,
      'user_id'=> Auth::user()->id,
      'Projet' => $projet,

    ]);
  }
  public function rendreProjet(Request $request, $projet_id, $student_id, $teacher_id)
  { ;
    $teacher = User::find($student_id);
    $nom_fichier = "";
    $noteEtu = null;

    if ($request->hasFile('fichier')) {
      $this->cleanDirectory('/fichiers/project/' . $projet_id .  '/student/' . $student_id . '/');
      $fichier = $request->file('fichier');
      $nom_fichier = $fichier->getClientOriginalName();
      $fichier->move('fichiers/project/' . $projet_id . '/student/' . $student_id . "/", $nom_fichier);
    }
    /* ------------------------------------------------- */
    $affected_project = Affected::where(
      
      
        'project_id', '=', $projet_id
      
    )->first();
    if ($affected_project == null) {
      $affected_project = new Affected;
      $affected_project->fichier = $nom_fichier;
      $affected_project->project_id = $projet_id;
      $affected_project->user_id = $student_id;
    } else {
      $affected_project->fichier = $nom_fichier;
      $affected_project->project_id = $projet_id;
      $affected_project->user_id = $student_id;
    }
  //  $affas = AffectedProject::where([['student_id', '=', $student_id], ['projet_id', '=', $projet_id]])->first();
    /* ------------------------------------------ */
    if ($affected_project->save()) {
      $projet = Project::find($projet_id);

      return view('pages.projet.showEt', [
        'affas' => null ,
        'noteactuelle' => $noteEtu,
        'teacher_id' => $student_id,
        'user_id' => $student_id,
        'teacher' => $teacher,
        'affected_project' => $nom_fichier,
        'projet_id' => $projet_id,
        'Projet' => $projet,

      ]);
    }
  }
  public function downlaodStuProjet($projet_id, $student_id, $file_name)
  {

    $file = public_path() . '/fichiers/project/' . $projet_id . '/student/' . $student_id . '/' . $file_name;

    $headers = array(
      'Content-Type: application/pdf',
    );

    return Response::download($file, $file_name, $headers);
  }
}
