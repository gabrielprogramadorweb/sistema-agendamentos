<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Make sure to return true to allow form submission
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'nullable|max:30',
            'coordinator' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'starttime' => 'nullable|date_format:H:i',
            'endtime' => 'nullable|date_format:H:i',
            'servicetime' => 'nullable|numeric',
            'active' => 'nullable' // Not directly validating as boolean
        ];
    }

    public function validated()
    {
        $data = parent::validated();
        $data['active'] = $this->has('active') ? 1 : 0;
        return $data;
    }


}
