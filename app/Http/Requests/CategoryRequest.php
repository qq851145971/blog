<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        switch ($this->method()) {
            // CREATE
            case 'POST':
                {
                    return [
                        'name' => 'required|unique:categories,name',
                        'keywords' => 'required',
                        'description' => 'required',
                    ];
                }
            // UPDATE
            case 'PUT':
                {
                    return [
                        'name' => 'required|unique:categories,name,' . $this->route()->id,
                        'keywords' => 'required',
                        'description' => 'required',
                    ];
                }
            case 'PATCH':
                {
                    return [
                        // UPDATE ROLES
                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                }
        }
    }
}
