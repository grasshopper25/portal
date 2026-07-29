<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect & sanitize form data
    $name       = htmlspecialchars(trim($_POST["name"]));
    $score    = htmlspecialchars(trim($_POST["score"]));
    $contact_no = preg_replace('/[^0-9]/', '', $_POST["contact_no"]);
    $email      = trim($_POST["email"]);
    $college    = htmlspecialchars(trim($_POST["college"]));
    $email      = filter_var($email, FILTER_SANITIZE_EMAIL);
    $captcha    = htmlspecialchars(trim($_POST["captcha"]));

    // -----------------------------
    // CAPTCHA VALIDATION
    // -----------------------------
    if (
        !isset($_SESSION['captcha_code']) ||
        strtolower($captcha) !== strtolower($_SESSION['captcha_code'])
    ) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid captcha. Please try again.'
        ]);

        exit;
    }

    // -----------------------------
    // REQUIRED FIELD VALIDATION
    // -----------------------------
    if (
        empty($name) ||
        empty($score) ||
        empty($contact_no) ||
        empty($email) ||
        empty($college) ||
    ) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Please fill all required fields.'
        ]);

        exit;
    }

    // -----------------------------
    // EMAIL VALIDATION
    // -----------------------------
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Please enter a valid email address.'
        ]);

        exit;
    }

    // -----------------------------
    // MOBILE VALIDATION
    // -----------------------------
    if (!preg_match('/^[0-9]{10}$/', $contact_no)) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Please enter a valid 10 digit mobile number.'
        ]);

        exit;
    }

    // -----------------------------
    // EMAIL DETAILS
    // -----------------------------
    $to      = "subrataporia137@gmail.com";
    $cc      = "web.tl@turaingrp.com";
    $subject = "New Enquiry For Admission";

    // -----------------------------
    // HTML EMAIL BODY (For Admin)
    // -----------------------------
    $body = "
    <html>
    <head>
        <style>
            body{ font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:20px; }
            .container{ max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e5e5e5; }
            .header{ background:#0d6efd; color:#ffffff; padding:20px; text-align:center; }
            .content{ padding:20px; }
            table{ width:100%; border-collapse:collapse; }
            table td{ border:1px solid #dddddd; padding:12px; font-size:14px; }
            .label{ background:#f8f8f8; font-weight:bold; width:35%; }
            .footer{ text-align:center; padding:15px; font-size:12px; color:#777777; background:#fafafa; }
            a{ color:#0d6efd; text-decoration:none; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Enquiry Received</h2>
            </div>
            <div class='content'>
                <table>
                    <tr>
                        <td class='label'>Name</td>
                        <td>$name</td>
                    </tr>
                    <tr>
                        <td class='label'>Score</td>
                        <td>$score</td>
                    </tr>
                    <tr>
                        <td class='label'>Email Address</td>
                        <td><a href='mailto:$email'>$email</a></td>
                    </tr>
                    <tr>
                        <td class='label'>Phone Number</td>
                        <td><a href='tel:$contact_no'>$contact_no</a></td>
                    </tr>
                    <tr>
                        <td class='label'>Prefered College</td>
                        <td><a href='mailto:$college'>$college</a></td>
                    </tr>
                </table>
            </div>
            <div class='footer'>
                This enquiry was submitted from Grasshopper.
            </div>
        </div>
    </body>
    </html>
    ";

    // -----------------------------
    // SEND THANK YOU MAIL TO USER
    // -----------------------------
    $userSubject = "Thank You For Your Enquiry";

    $userBody = "
    <html>
    <body style='font-family:Arial,sans-serif;line-height:1.6;color:#333;'>
        <h2>Thank You, {$name}!</h2>

        <p>We have received your enquiry successfully.</p>

        <p>Our team will contact you shortly.</p>

        <br>

        <p>
            Regards,<br>
            <strong>Grasshopper</strong>
        </p>
    </body>
    </html>
    ";

    $userHeaders  = "From: Grasshopper Website <info@grasshopperedu.net>\r\n";
    $userHeaders .= "MIME-Version: 1.0\r\n";
    $userHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send simple HTML mail
    mail($email, $userSubject, $userBody, $userHeaders);

    // -----------------------------
    // ADMIN EMAIL HEADERS & MESSAGE 
    // -----------------------------
    $headers  = "From: Grasshopper Website <info@grasshopperedu.net>\r\n";
    $headers .= "Cc: " . $cc . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $message = $body; // 


    // -----------------------------
    // SEND MAIL TO ADMIN
    // -----------------------------
    if (mail($to, $subject, $message, $headers)) {

        unset($_SESSION['captcha_code']);

        echo json_encode([
            'status'  => 'success',
            'message' => 'Thank you for your enquiry. We will contact you shortly.'
        ]);

    } else {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Mail sending failed. Please try again later.'
        ]);

    }

} else {

    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request.'
    ]);

}
?>