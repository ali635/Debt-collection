<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Auth;
use App\Http\Resources\Section as SectionResource;
use App\Http\Controllers\API\BaseController as BaseController;

use App\sections;

class SectionsController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        return $this->sendResponse(SectionResource::collection($sections),
          'تم ارسال جميع القسمات');
    }

    public function store(Request $request)
    {
       $input = $request->all();
       $validator = Validator::make($input , [
        'section_name' => 'required|max:255|unique:sections',
        'description' => 'required',
       ]);

       if ($validator->fails()) {
        return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $section = sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name),

        ]);
    
    
    return $this->sendResponse(new SectionResource($section) ,'تم اضافة القسم بنجاح ' );

    }


    public function show($id)
    {
        $section = sections::find($id);
        if ( is_null($section) ) {
            return $this->sendError('Product not found'  );
              }
              return $this->sendResponse(new SectionResource($section) ,'Sectioى found successfully' );

    }

    public function update(Request $request, sections $section)
    {
        $id = $request->id;
        $input = $request->all();
        $validator = Validator::make($input , [
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ]  );

        if ($validator->fails()) {
         return $this->sendError('Please validate error' ,$validator->errors() );
           }
     $section->section_name = $input['section_name'];
     $section->description = $input['description'];
     
     $section->save();
     return $this->sendResponse(new SectionResource($section) ,'تم تعديل القسم بنجاح' );

    }


    public function destroy(sections $section)
    {
        $section->delete();
        return $this->sendResponse(new SectionResource($section) ,'تم حذف القسم بنجاح' );

    }
}
