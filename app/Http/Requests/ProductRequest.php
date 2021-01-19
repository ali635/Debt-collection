<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Product_name'  => 'required|max:255',
            'section_id'    => 'nullable|exists:sections,id',
            'description'   => 'required',
        ];
    }
    public function messages()
    {
        return [
            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'Product_name.unique'   =>'اسم المنتج مسجل مسبقا',
            
            'description.required'  => 'يرجي ادخال وصف المنتج',
            'section_id.exists'     => 'يجب ان يكون القسم موجود في جدول الاقسام',
        ];
    }
}
