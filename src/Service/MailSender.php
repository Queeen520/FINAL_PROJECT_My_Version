<?php
namespace App\Service;

# needed for mailer
use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;
#use App\Service\Exception;
use Symfony\Component\HttpFoundation\File\Exception;

class MailSender
{
    private $fromEmail;
    public function __construct($fromEmail)
    {
        $this->fromEmail = $fromEmail;

    }
    public function sendMail($toEmail, $subject = "default subject", $htmlBody = "<h1>default html body</h1>", $textBody = "default body")
    {
        # uncomment this line to send mails
        $client = new PostmarkClient("60d5a2eb-a6ec-4fdd-84a1-d549af8f6fd1");

        # uncomment this line for testing without sending mails
        #$client = new PostmarkClient("POSTMARK_API_TEST");

        # set $fromEmail in ./config/services.yaml
        $fromEmail = $this->fromEmail;
        $tag = "";
        $trackOpens = true;
        $trackLinks = "None";
        $messageStream = "outbound";
        $replyTo = NULL;
        $cc = NULL;
        $bcc = NULL;
        $headerArray = NULL;
        $attachmentArray = NULL;
        $metadataArray = NULL;
        try {
            #dd($client);
            $sendResult = $client->sendEmail(
                $fromEmail,
                $toEmail,
                $subject,
                $htmlBody,
                $textBody,
                $tag,
                $trackOpens,
                $replyTo,
                $cc,
                $bcc,
                $headerArray,
                $attachmentArray,
                $trackLinks,
                $metadataArray,
                $messageStream
            );
            return $sendResult->errorcode;
            ;
        } catch (PostmarkException $e) {
            
            return $e->getMessage();
        }
        
    }

}
