<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PeriodsRequest extends FormRequest
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
        $slug = $this->route('period') ? ',' . $this->route('period')->slug . ',slug' : '';
        
        return [
            //
            'title' => 'required',
            'slug' => 'required|unique:periods,slug' . $slug,
            'date_from' => 'date',
            'date_to' => 'date',
            'title_cases' => 'array|nullable'
        ];
    }
}
