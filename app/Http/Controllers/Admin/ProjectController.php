<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $projects = Project::orderBy('updated_at', 'DESC')->get();
        $projects = Project::orderBy('id')->paginate(5);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::orderBy('label')->get();
        $technologies = Technology::select('id', 'label')->orderBy('id')->get();
        return view('admin.projects.create', compact('project', 'types', 'technologies'));
        dd($types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|unique:projects|max:100',
            'description' => 'required|string',
            'imag' => 'nullable|image|mimes:jpeg,jpg,png',
            'url' => 'nullable|url',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id',
        ], [
            'title.required' => 'The title is mandatory',
            'title.unique' => "The name $request->title is already present",
            'title.max' => 'Exceeded the maximum number of characters :max',
            'description.required' => 'Description is required',
            'image.mimes' => 'accepted extensions are :mimes',
            'type_id' => 'categoria non valida',
            'technologies' => 'campo inserito errato',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        
        $project = new Project();

        if(array_key_exists('image', $data)){
            $img_url = Storage::put('projects', $data['image'] );
            $data['image'] = $img_url;
        }

        $data['is_published'] = Arr::exists($data, 'is_published');


        $project->fill($data);

        $project->save();

        //relazione tra project con le technologies
        if(Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);
        // $project->technologies()->attach($data['technologies']);
        
        return to_route('admin.projects.show', $project->id)
            ->with('type', 'success')
            ->with('message', "project $project->title created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // dd($project); 
        $types = Type::orderBy('label')->get();
        $technologies = Technology::select('id', 'label')->orderBy('id')->get();
        $project_technologies = $project->technologies->pluck('id')->toArray();
        // dd($project_technologies);
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // dd($project);

        $request->validate([
            'title' => ['required','string', Rule::unique('projects')->ignore($project->id) ,'max:100'],
            'description' => 'required|string',
            'imag' => 'nullable|image|mimes:jpeg,jpg,png',
            'url' => 'nullable|url',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id',

        ], [
            'title.required' => 'The title is mandatory',
            'title.unique' => "The name $request->title is already present",
            'title.max' => 'Exceeded the maximum number of characters :max',
            'description.required' => 'Description is required',
            'image.mimes' => 'accepted extensions are :mimes',
            'type_id' => 'categoria non valida',
            'technologies' => 'campo inserito errato',

        ]);
        
        $data = $request->all();

        $project->slug = Str::slug($data['title'], '-');

        if (array_key_exists('image', $data)) {
            //se c'è gia un url lo sostituisce con quello che mandiamo
            if ($project->image) {
                Storage::delete($project->image);
            }
            $img_url = Storage::put('projects', $data['image']);
            $data['image'] = $img_url;
        }

        $data['is_published'] = Arr::exists($data, 'is_published');

        $project->update($data);


        //assegno le technologies
        if(Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else if(count($project->technologies)) $project->technologies()->detach();

        return to_route('admin.projects.show', $project->id)
            ->with('type', 'success')
            ->with('message', 'Change made successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if($project->image) Storage::delete($project->image);
        
        if(count($project->technologies)) $project->technologies()->detach();

        $project->delete();

        return to_route('admin.projects.index')
            ->with('message', "The project $project->title was deleted successfully")
            ->with('type', 'success');
    }

    /**
     * Change param of the toggle.
     */
    public function toggle(Project $project){
        $project->is_published = !$project->is_published;
     
        $action = $project->is_published ? 'pubblicato con successo' : 'salvato come bozza';
        $type = $project->is_published ? 'success' : 'info';
     
        $project->save();
        return redirect()->back()
           ->with('type', $type )
           ->with('message', "il progetto è stato $action");
    }
}
