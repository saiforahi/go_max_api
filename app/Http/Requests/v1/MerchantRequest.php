<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
        return [
            "name"=>"required|string|max:255",
            "contact_person"=>"required|string|max:255",
            "company_email"=>"required|email|max:255",
            "distributor"=>"required|string|max:255",
            "country"=>"required|string|max:255",
            "city"=>"required|string|max:255",
            "district"=>"required|string|max:255",
            "thana"=>"required|string|max:255",
            "father_name"=>"required|string|max:255",
            "mother_name"=>"required|string|max:255",
            "spouse_name"=>"required|string|max:255",
            "spouse_phone"=>"required|string|max:11|min:11",
            "birth_date"=>"required|date|before:today",
            "sms_phone"=>"required|string|max:11|min:11",
            "mobile"=>"required|string|max:11|min:11",
            "nid"=>"required|string|max:15|min:10",
            "passport"=>"required|string|max:20|min:5",
            "present_address"=>"required|string|max:2055",
            "permanent_address"=>"required|string|max:2055",
            "billing_address"=>"required|string|max:2055",
        ];
    }
}
