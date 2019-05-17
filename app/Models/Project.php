<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Uploadedfile;
use App\Models\Type;
/* use Illuminate\Http\File; */
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'type_id','organisation_id','manager','init_date','end_date',
    ];

    /* ===================================================== Beziehungen ===================================================== */

    /**
    * Get the Tags for the project
    */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

        /**
     * Get the files for the project.
     */
    public function files()
    {
        return $this->hasMany('App\Models\Uploadedfile');
    }

    /* ===================================================== Erstellung ===================================================== */

    /**
    * Get the Tags for the project
    * @return Response
    */
    public static function createProject(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type_id' => 'required',
            'init_date' => 'required',
            'end_date' => 'required',
            'manager' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        // Pflichtfelder
        $input = $request->all();
        $input['init_date'] = Carbon::parse($input['init_date']);
        $input['end_date'] = Carbon::parse($input['end_date']);
        $project = new Project();
        $project->init_date = $input['init_date'];
        $project->end_date = $input['end_date'];
        $project->title = $input['title'];
        $project->manager = $input['manager'];
               
        // / Bestehender Typ oder neuer Typ
        if ($input['type_id'] != 2000000000) {
            $project->type_id = $input['type_id'];
        } else {
            $type = new Type();
            $type->name = $input['newtype'];
            $type->save();
            $project->type_id = $type->id;
        }

        // Optionale Felder 
        if ($request->has('picture')) {
            $project->picture = $input['picture'];
        }
        if ($request->has('description')) {
            $project->description = $input['description'];
        }

        $project->save();

        // Tags erstellen
        if ($request->has('tags')) {
            $tagsassignment =  array();
            $json = request('tags');
            for ($x = 0; $x <= count($json)-1; $x++) {
                if (Tag::where('tagname', $json[$x])->first() === null) {
                    $tag = new Tag();
                    $tag->tagname = $json[$x];
                    // $tagsassignment[] = $tag->id;
                    $tag->save();
                    $project->tags()->attach($tag);
                } else {
                    $existingtag = Tag::where('tagname', $json[$x])->first();
                    $project->tags()->attach($existingtag);
                    // $tagsassignment[] = $existingtag->id;
                }
            }
        }
        
        // Antwort
        return response()->json(['Projekt-ID:'=>$project->id], 200);
    }

        /**
    * Get the Tags for the project
    * @return Response
    */
    public static function createTags(Request $request)
    {
        $json = $request->all();
        for ($x = 0; $x <= count($json)-1; $x++) {
            if (Tag::where('tagname', $json[$x])->first() === null) {
                $tag = new Tag();
                $tag->tagname = $json[$x];
                $tag->save();
            }
        }
        return response()->json(['success'=> $json], 200);
    }



    /**
     * Upload a File.
     *
     * @return Response
     */
    public static function uploadFile(Request $request)
    {
        try {
            // Existiert der Dateimame bereits?
            if (!Storage::exists('/pdfs/'.$request->name)) {
                $path = $request->file('pdf')->storeAs(
                        'PDFs',
                        $request->name
                    ); 
            /* Hier Dateien mit Projekt verknüpfen */
            $uploadedfile = new Uploadedfile(); 
            $uploadedfile->project_id=$request['id'];
            $uploadedfile->filename = $request->name;
            /* Alles was nach dem punkt kommt als Dateityp speichern */
            $uploadedfile->filetype =substr( $request->name,stripos($request->name,".")+1,strlen($request->name)-(strlen($request->name)-(stripos($request->name,".")+1)));            
            $uploadedfile->save();
/*             $project = Project::find($request['id']);
            $project->files()->attach($uploadedfile);
            $project->save(); */

             } else {
                return response()->json(['Error:'=>'Filename already exists']);
            } 
        } catch (\Exception $e) {
            return response()->json(['Error:'=> $e->getMessage()]);
        }
        return response()->json(['Path:'=>$path]);
    }

   

    /**
     * Upload a Projectpicture.
     *
     * @return Response
     */
    public static function uploadPic(Request $request)
    {
        try {
            // Existiert für das Project bereits ein Bilderordner ? 
        /*     $path = '/storage/app/projectpic/' .$request->id;
            if(!File::exists($path)) {
                File::makeDirectory($path);
            }       */             
            // Existiert der Dateimame bereits?
            if (!Storage::exists('/projectpic/' .$request->id .'_' .$request->name)) {
                $path = $request->file('pic')->storeAs(
                        '/projectpic/',
                        $request->id.'_'.$request->name
                    ); 
            /* Hier Bild mit Projekt verknüpfen */
            if (Project::find($request['id']) != null) {    
                $project = Project::find($request['id']);
                $project->picture = $request->name;
                $project->save();
            }
            } else {
            return response()->json(['Error:'=>'Filename already exists']);
            } 
        
        } catch (\Exception $e) {
            return response()->json(['Error:'=> $e->getMessage()]);
        }
        return response()->json(['Path:'=>$path]);
    }

    /* ===================================================== Löschung ===================================================== */
    /**
     * Delete File
     *
     * @return Response
     */
    public static function deletefile($id)
    {
        if (Uploadedfile::where('project_id' , $id)->first() != null) {                
            $filetodelete = Uploadedfile::where('project_id' , $id)->first();            
            Storage::delete('/pdfs/' . $filetodelete->filename);
            $filetodelete->delete();
            return response()->json(['Message:'=>"File was succesfully deleted from storage."]);
         
            
        }else {
            return response()->json(['Message:'=>"No File is attached to this project at the moment."]);
        }
    }



    /**
     * Delete Project
     *
     * @return Response
     */
    public static function deleteProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        } elseif (Project::find($request['id']) == null) {
            return response("No Project found related to this ID");
        }
        // $deletetags = Tag::where('project_id', $request['id'])->delete();
        $deletecomments = Comment::where('project_id', $request['id'])->delete();
        $project = Project::find($request['id']);
        $project->tags()->detach();
        try {
            Project::destroy($request['id']);
            return response()->json(['success'=>'succesful']);
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    /* ===================================================== Returnen ===================================================== */

    /**
     * Show all Projects.
     *
     * @return Response
     */
    public static function showProjects()
    {
/*         $projects = DB::table('projects')
            ->join('organisations', 'projects.organisation_id', '=', 'organisations.id')
            ->join('types', 'projects.type_id', '=', 'types.id')
            ->join('uploadedfiles', 'projects.id', '=', 'uploadedfiles.project_id')
            ->select('projects.*', 'organisations.name as organisation_name', 'types.name as type_name', 'uploadedfiles.filename as file')
            ->orderBy('projects.id', 'asc')
            ->get();
        return $projects; */


            $projects = DB::table('projects')
            ->join('organisations', 'projects.organisation_id', '=', 'organisations.id')
            ->join('types', 'projects.type_id', '=', 'types.id')
            ->select('projects.*', 'organisations.name as organisation_name', 'types.name as type_name')
            ->orderBy('projects.id', 'asc')
            ->get();
        return $projects;
    }

    /**
     * Show single Project
     *
     * @return Response
     */
    public static function showSingleProject($id)
    {   
        /* Überpüfen ob Projekt dateien hat oder nicht und je nachdem sql query  */
        if (Uploadedfile::where('project_id' , $id)->first() != null) {
            $projects = DB::table('projects')
            ->where('projects.id', '=', $id)
            ->join('organisations', 'projects.organisation_id', '=', 'organisations.id')
            ->join('types', 'projects.type_id', '=', 'types.id')
            ->join('uploadedfiles', 'projects.id', '=', 'uploadedfiles.project_id')
            ->select('projects.*', 'organisations.name as organisation_name', 'types.name as type_name', 'uploadedfiles.filename as file')            
            ->get();
            return $projects;
        }
        else {
            $projects = DB::table('projects')
            ->where('projects.id', '=', $id)
            ->join('organisations', 'projects.organisation_id', '=', 'organisations.id')
            ->join('types', 'projects.type_id', '=', 'types.id')
            ->select('projects.*', 'organisations.name as organisation_name', 'types.name as type_name')            
            ->get();
            return $projects;
        }       
    }

       /**
     * Show Project Picture
     *
     * @return Response 
     */
    public static function showProjectPicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        } elseif (Project::find($request['id']) == null) {
            return response("No Project found related to this ID");
        }
        $project = Project::find($request['id']);
        $path = storage_path('app/projectpic/' .$request['id'].'_'.Project::where('id' , $request['id'])->first()->picture);
        return response()->file($path);

    }

    /**
     * Return Tags for a Project
     *
     * @return Response
     */
    public static function showTagsForProject($id)
    {
        $tags = DB::table('project_tag')
            ->join('tags', 'project_tag.tag_id', '=', 'tags.id')
            ->select('tags.tagname as tag')
            ->where('project_tag.project_id', '=', $id)
            ->get();
        return $tags;
    }


    /**
     * Return Files for a Project
     *
     * @return Response
     */
    public static function showFilesForProject($id)
    {
        /* =================================================== File zurückgeben als datenbankzeile =================================================== */
        /* $files = DB::table('uploadedfiles')
            ->where('project_id', '=', $id)
            ->select('uploadedfiles.filename as filename', 'uploadedfiles.filetype as type')
            ->get();
        return $files; */

        /* =================================================== File zurückgeben als URL =================================================== */
         $path = storage_path('app/pdfs/' . Uploadedfile::where('project_id' , $id)->first()->filename);
         return response()->file($path);



        /* =================================================== Alter Code =================================================== */

        /*$filetosend = (File) Storage::download('pdfs/' .$file->filename);
        return $filetosend; */
       /*  return Storage::download('pdfs/' .$file->filename);  */
      /*   return response()->download(storage_path('app/pdfs/' . $file)); */

               /* $url = Storage::url('app/pdfs/' . $file);
         return $url; */

         /* return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$file.'"'
        ]);*/
        
    }




}
