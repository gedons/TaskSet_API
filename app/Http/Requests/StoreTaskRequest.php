<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:1000',                       
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:high,medium,low',
            'status' => 'nullable|in:finished,pending',
            'user_id' => 'exists:users,id',
        ];

        // 'title' => 'required|string',
        // 'description' => 'required|string',
        // 'due_date' => 'required|date',
        // 'priority' => 'required|in:high,medium,low',
        // 'status' => 'required|in:finished,pending',
        // 'user_id' => 'required|exists:users,id',
    }
}
