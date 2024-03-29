<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopItems extends FormRequest
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
            'artist_id' => 'nullable|int',
            'item_title' => 'required|min:3',
            'item_short_description' => 'min:10',
            'item_description' => 'required|min:10',
            'item_filename' => 'required|mimes:jpg,png,jpeg,gif|max:10240',
            'item_price' => 'required|int',
            'status' => 'required',
        ];

        if ($this->routeIs('admin.shop.update')) {
            $rules['item_filename'] = 'mimes:jpg,png,jpeg,gif|max:10240';
        }

        return $rules;
    }
}
