<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOpenCallForm extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules =  [
            'field_label' => 'required|min:3|max:20',
            'field_type' => 'required',
            'field_name' => 'required|min:3|max:20|unique:App\Models\OpenCallFormField,field_name',
            'field_description' => 'min:3|max:70',
            'field_is_required' => 'required|boolean',
            'status' => 'required',
        ];

        if ($this->method() != "POST") {
            $rules['field_name'] = [
                'required',
                'min:3',
                'max:20',
                Rule::unique('open_call_form_fields', 'field_name')->ignore($this->route('opencall_form'))
            ];
        }

        return $rules;
    }
}
