<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for creating or updating a quiz by an admin.
 *
 * @package App\Http\Requests\Admin
 */
class QuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Only allow admins to create/update quizzes.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'timer' => ['nullable', 'integer'],
            'is_posted' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom validation error messages for this request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The quiz title is required.',
            'title.string' => 'The quiz title must be a string.',
            'timer.integer' => 'The timer must be a number.',
            'is_posted.boolean' => 'The posted status must be true or false.',
        ];
    }

    /**
     * Get the validated data from the request, with is_posted as boolean.
     *
     * @param string|null $key
     * @param mixed $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data['is_posted'] = $this->has('is_posted');
        return $data;
    }
}
