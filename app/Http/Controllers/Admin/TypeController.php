<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = new Type();
        return view('admin.types.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|unique:types|max:30',
        ],[
            'label.required' => 'il Type deve avere un label',
            'label.max' => 'il Type deve avere un massimo di :max caratteri',
            'label.unique' => 'esiste già un type con questo nome',
        ]);

        $data = $request->all();

        $type = new Type();

        $type->fill($data);

        $type->save();

        return to_route('admin.types.index')
        ->with('type', 'success')
        ->with('message', 'type creato con successo');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return to_route('admin.types.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        // dd($request->all());
        $request->validate([
            'label' => ['required','string', Rule::unique('types')->ignore($type->id),'max:30'],
        ],[
            'label.required' => 'il Type deve avere un label',
            'label.max' => 'il Type deve avere un massimo di :max caratteri',
            'label.unique' => 'esiste già un type con questo nome',
        ]);

        $data = $request->all();


        $type->update($data);


        return to_route('admin.types.index')
        ->with('type', 'success')
        ->with('message', 'type modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
     
        return to_route('admin.types.index', $type->id)
            ->whit('type', 'success')
            ->whit('message', "Type $type->label eliminato con successo");
    }
}
