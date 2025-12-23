<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Salary;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    //

    public function store(Request $request)
    {
        $fields = $request->validate([
            'salary' => 'required|numeric|min:0',
            'savings' => 'nullable|numeric|min:0',
            'rent_or_emi' => 'nullable|numeric|min:0',
            'food_and_groceries' => 'nullable|numeric|min:0',
            'transportation' => 'nullable|numeric|min:0',
            'utilities' => 'nullable|numeric|min:0',
            'internet_and_mobile' => 'nullable|numeric|min:0',
            'insurance' => 'nullable|numeric|min:0',
            'entertainment' => 'nullable|numeric|min:0',
            'personal_care' => 'nullable|numeric|min:0',
            'miscellaneous' => 'nullable|numeric|min:0',
        ]);

        // Checks if optional inputs are greater than salary

        $validator = Validator::make($request->all(), []);

        $validator->after(function ($validator) use ($request) {

            $salary = $request->salary;

            $sum = collect([
                'savings',
                'rent_or_emi',
                'food_and_groceries',
                'transportation',
                'utilities',
                'internet_and_mobile',
                'insurance',
                'entertainment',
                'personal_care',
                'miscellaneous',
            ])->sum(fn($field) => (float) $request->input($field, 0));

            if ($sum > $salary) {
                $validator->errors()->add(
                    'salary',
                    'The total of all expense fields cannot exceed salary.'
                );
            }
        });

        $validator->validate(); // throws validation exception if invalid

        $user = $request->user();
        $year = now()->year;
        $month = now()->month;

        // Get existing record for this month
        $salary = Salary::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($salary) {
            // Update only fields provided (not empty)
            foreach ($fields as $key => $value) {

                if ($request->has($key) && $value !== null) {
                    $salary->$key = $value;
                }
            }
            $salary->save();
        } else {
            // Create new record with all validated fields
            $fields['user_id'] = $user->id;
            $fields['year'] = $year;
            $fields['month'] = $month;



            $salary = Salary::create($fields);
        }

        return response()->json([
            'message' => 'Salary saved successfully.',
            'data' => $salary
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $year = now()->year;
        $month = now()->month;

        // Get existing record for this month
        $salary = Salary::select('salary', 'user_id', 'year', 'month', 'savings', 'rent_or_emi', 'food_and_groceries', 'transportation', 'utilities', 'internet_and_mobile', 'insurance', 'entertainment', 'personal_care', 'miscellaneous')
            ->where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        return response()->json([
            'message' => 'Salary fetched successfully.',
            'data' => $salary
        ]);
    }
}
