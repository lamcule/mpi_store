<?php

namespace Modules\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|unique:apps',
            'iOS_version' => 'required|max:255|regex:/^[0-9.]+$/i',
            'android_version' => 'required|max:255|regex:/^[0-9.]+$/i',
        ];
    }

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
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Tên ứng dụng không được để trống.',
            'title.max' => 'Tên ứng dụng không được dài quá 255 ký tự.',
            'title.unique' => 'Ứng dụng đã tồn tại.',
            'iOS_version.required' => 'Tên phiên bản iOS không được để trống.',
            'iOS_version.regex' => 'Tên phiên bản iOS không đúng định dạng.',
            'android_version.required' => 'Tên phiên bản android không được để trống.',
            'android_version.regex' => 'Tên phiên bản android không đúng định dạng.',
        ];
    }
}
