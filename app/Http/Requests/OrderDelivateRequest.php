<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDelivateRequest extends FormRequest
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
            'express_company'      => 'required',
            'express_no'          => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'express_company'      => '物流公司',
            'express_no'          => '物流单号',
        ];
    }
}
