<?php

/**
 * Description of MailHelper
 *
 * @author cubiascaceres@gmail.com
 */
class MailHelper {

    public function sendMail($sSubject, $aTo, $sBody, $aAttachment = array()) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "e4cc.eval@gmail.com";
        $mail->Password = "Engl!sh4CallCenter$";
        $mail->setFrom('e4cc.eval@gmail.com', 'Evaluation System - E4CC');
        foreach ($aTo as $sMail => $sName) {
            $mail->addAddress($sMail, $sName);
        }
        foreach ($aAttachment as $sAttachment) {
            $mail->addAttachment($sAttachment);
        }
        $mail->Subject = $sSubject;
        $mail->msgHTML($sBody);
        $mail->AltBody = 'This is a plain-text message body';
        return $mail->send();
    }

}
