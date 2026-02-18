<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $book = $this->route('book'); // Book model   
        $supported_extensions = config('image.supported_extensions');
        $max_file_size =  config('image.max_file_size_small');
        return [
            'ISBN' => ['required', 'digits:13', Rule::unique('books', 'ISBN')->ignore($book?->id)],
            'title' => 'required|string|max:70',
            'price' => 'required|decimal:0,2|min:0|max:99.99',
            'mortgage' => 'required|decimal:0,2|min:0|max:9999.99',
            'authorship_date' => 'nullable|date',            
            'pages' => 'nullable|integer|min:0',
            'borrow_duration' => 'nullable|integer|min:1', // Assuming borrow duration must be at least 1 day
            'cover' => "nullable|image|mimes:$supported_extensions|max:$max_file_size", //(in K) => 2M

            'category_id' => 'required|exists:categories,id',
            
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id',
        ];
    }
}
