<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DepartmentController extends Controller
{
    
    public function index()
    {
        $employee = auth()->user();
        $query = Department::with('head')->latest();
        if( $employee->super_admin ||
            $employee->hasAbility('departments.view')){
        }else if($employee->hasAbility('departments.view_own')){
            $query->where('head_id' , $employee->id);
        }else{
            abort(403);
        }

        $request = request();
        $name = $request->input('name');
        $status = $request->input('status');
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }
        $departments = $query->paginate(10)->withQueryString();

        return view('departments.index' , compact('departments'));
    }
    public function create()
    {
        $this->authorize('create', Department::class);
        return view('departments.create');
    }

    public function store(DepartmentRequest $request)
    {
        $this->authorize('create', Department::class);
        // Department::create($request->validated());
        $department = new Department();
        $department->name =$request->name_en ?? $request->name_ar ;
        $department->description = $request->description_en ?? $request->description_ar ;
        $department->status = $request->status;
        $department->head_id = $request->head_id;
        $department->slug = Str::slug($request->name_en ?? $request->name_ar);
        $department->save();

        $locales = config('app.available_locales',['en' , 'ar']);
        foreach($locales as $locale){
            $translations = [
                'name' => $request->input("name_{$locale}"),
                'description' => $request->input("description_{$locale}")
            ];

            if($translations['name'] || $translations['description']){
                $department->saveTranslations($translations,$locale);
            }
        }
        return redirect()->route('departments.index')->with('success', __('Created successfully.'));
    }
    public function edit(Department $department)
    {
        $this->authorize('update', $department);
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $this->authorize('update', $department);
        // $department->update($request->validated());
        
        $department->name =$request->name_en ?? $request->name_ar ;
        $department->description = $request->description_en ?? $request->description_ar ;
        $department->status = $request->status;
        $department->head_id = $request->head_id;
        $department->slug = Str::slug($request->name_en ?? $request->name_ar);
        $department->save();

        $locales = config('app.available_locales',['en' , 'ar']);
        foreach($locales as $locale){
            $translations = [
                'name' => $request->input("name_{$locale}"),
                'description' => $request->input("description_{$locale}")
            ];

            if($translations['name'] || $translations['description']){
                $department->saveTranslations($translations,$locale);
            }
        } 
        return redirect()->route('departments.show', $department)->with('update', __('Updated successfully.'));
    }

    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);
        $department->delete();
        return redirect()->route('departments.index')->with('delete', __('Deleted successfully.'));
    }

    public function show(Department $department)
    {
        $this->authorize('view', $department);
        return view('departments.show', compact('department'));
    }
}
