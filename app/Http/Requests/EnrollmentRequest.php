<?php

namespace App\Http\Requests;

use App\Models\ScholarEnrollment;
use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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

    public function rules()
    {
        $data = ScholarEnrollment::where('scholar_id',$this->scholar_id)->where('is_clear',0)->count();
        if($data > 0){
            return '';
        }
        
        return [
            'academic_year' => 'sometimes|required|string',
            'level_id' => 'sometimes|required|integer',
            'semester_id' => 'sometimes|required|integer|unique:scholar_enrollments,semester_id,NULL,'.$this->id.',level_id,'.$this->level_id.',scholar_id,'.$this->scholar_id,
            'scholar_id' => 'sometimes|required|integer',
            'start_at' => 'sometimes|required|date',
            'end_at' => 'sometimes|required|date',
            'subcourse' => 'sometimes|required|integer',
            'lists' => 'sometimes|required|array|min:1',
            'is_locked' => 'sometimes|required|integer'
        ];
    }

    public function messages()
    {
        $message = [
            'semester_id.unique' => 'Already Submitted',
        ];

        return $message;
    }
}
