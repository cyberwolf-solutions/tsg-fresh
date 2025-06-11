<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;

class EmailController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function sendEbill(Request $request)
    {
        $to = $request->input('email');
        $subject = "Your E-bill";
        $body = "<p>Here is your e-bill.</p>";

        // Call the sendEmail method from the service
        $result = $this->emailService->sendEmail($to, $subject, $body);

        if ($result) {
            return response()->json(['message' => 'E-bill sent successfully']);
        } else {
            return response()->json(['message' => 'Failed to send E-bill'], 500);
        }
    }
}
