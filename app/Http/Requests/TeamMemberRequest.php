<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TeamMemberRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'player_name.*' => ['nullable', 'required_if:player_email.*,!=,', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'player_email.*' => [
                'nullable', 'string', 'email', 'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $duplicates = array_filter($request->input('player_email'), function ($email) use ($value) {
                        return $email === $value;
                    });
                    if (count($duplicates) > 1) {
                        $fail('The email field must be unique.');
                    }
                },
            ],
            'jersey_size.*' => ['nullable', 'required_if:player_email.*,!=,', 'numeric', 'exists:variants,id'],
            'uuid.*' => ['nullable', 'required_if:player_email.*,!=,', 'string', 'exists:team_members,uuid'],
            'profile_link.*' => ['nullable', 'string', 'url'],
        ];
    }
    public function messages()
    {
        return [
            'player_name.*.required' => 'Name is required.',
            'player_email.*.required' => 'Email is required.',
            'player_email.*.email' => 'Invalid email address.',
            'uuid.*.required' => 'UUID is required.',
            'jersey_size.*.required' => 'Jersey Size is required.',
            'profile_link.*.url' => 'Profile link in invalid.',
        ];
    }
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         if ($validator->fails()) {
    //             Session::flash('alert-class', 'alert-warning');
    //             Session::flash('alert-extra-class', 'setup-team-alert');
    //             Session::flash('alert-title', 'All Fields are required.');
    //             Session::flash('message', 'Please fill in all required fields.');
    //         }
    //     });
    // }
}
