<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestmentStoreRequest extends FormRequest
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
            'commodity_id'      => 'required|exists:commodities,id',
            'title'             => 'required|string|min:10|max:200',
            'intervention_id'   => 'required|exists:interventions,id',
            'description'       => 'sometimes|max:200',
            'quantity'          => 'required|min:0',
            'cost'              => 'required|min:0',
            'proponent'         => 'required|string|max:200',
            'beneficiaries'     => 'required|string|max:200',
            'justification'     => 'required|string|max:200',
            'location_map'      => 'required|string'
        ];
    }
}
