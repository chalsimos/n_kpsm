<?php

namespace App\Http\Controllers;

use App\Mail\CustomEmail as MailCustomEmail;
use App\Models\CustomEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomEmails extends Controller
{

    public function send_email(Request $request, $id)
{
    try {
        $emailRequest = CustomEmail::findOrFail($id);
        $toEmail = $emailRequest->email;
        $toName = $emailRequest->name;
        $toAcronym = $emailRequest->acronym;
        $subject = $request->input('subject');
        $emailmessage = $request->input('message');
        $info = [
            'name' => $toName,
            'acronym' => $toAcronym,
            'subject' => $subject,
            'emailmessage' => $emailmessage,
        ];
        $email = new MailCustomEmail($info['name'], $info['acronym'], $info['subject'], $info['emailmessage']);
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $email->attach($file->getRealPath(), [
                    'as' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                ]);
            }
        }
        Mail::to($toEmail)->send($email);
        return response()->json(['data' => 'Email sent successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 404);
    }
}

    /**
     * Display a listing of the resource.
     */
    public function Emailindex()
    {
        try {
            $emails = CustomEmail::orderBy('status', 'asc')->get();
            return response()->json($emails, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function activeEmail(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $Email = CustomEmail::findOrFail($id);
            $Email->status = 'active';
            $Email->save();
            DB::commit();
            return response()->json(['message' => 'Email updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deactivateEmail(string $id)
    {
        try {
            DB::beginTransaction();
            $Email = CustomEmail::findOrFail($id);
            $Email->status = 'inactive';
            $Email->save();
            DB::commit();
            return response()->json(['message' => 'Email updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteEmail(Request $request, $id)
    {
        try {
            $email = CustomEmail::findOrFail($id);
            if ($email->status === 'active') {
                return response()->json(['error' => 'Cannot delete active Email'], 400);
            }
            $email->delete();
            return response()->json(['message' => 'Email deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'acronym' => 'nullable|string|max:255',
            'email' => 'required|string|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = new CustomEmail();
            $data->name = $request->input('name');
            $data->acronym = $request->input('acronym');
            $data->email = $request->input('email');
            $data->status = 'active';
            $data->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
