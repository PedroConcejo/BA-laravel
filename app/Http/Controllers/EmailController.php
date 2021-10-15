<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    static public function sendEmail($data, $file){
        $data['title'] = 'This is your cycling license number';
        $data['file'] = $file;
        $data['view'] = 'emails.myTestMail';

        Mail::to($data['email'])->send(new \App\Mail\MyTestMail($data));
    }

    static public function sendFinalEmail($email){
        $data['title'] = 'All certifications in the CSV have been processed.';
        $data['view'] = 'emails.endProcessMail';

        Mail::to($email)->send(new \App\Mail\MyTestMail($data));
    }
}
