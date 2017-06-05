<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/4
 * Time: 17:35
 * Description:
 */

namespace app\lib\tools;


use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use think\Exception;

class SendMail
{
    protected $to;
    protected $replyTo;
    protected $fromName;

    /**
     * SendMail constructor.
     * @param string $to
     * @param string $replyTo
     * @param string $fromName
     */
    public function __construct($to,$replyTo='wht@blskye.com', $fromName='Blskye')
    {
        $this->to = $to;
        $this->replyTo = $replyTo;
        $this->fromName = $fromName;
    }

    /**
     * 发送邮件
     * @param $subject
     * @param $body
     * @return int|string
     */
    public function send($subject, $body){
        $transport = Swift_SmtpTransport::newInstance(config('config.mail_host'), 25);
        $transport->setUsername(config('config.mail_username'));
        $transport->setPassword(config('config.mail_password'));

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance();
        $message->setFrom(array(config('config.mail_username') => $this->fromName));
        $message->setTo(array($this->to => $this->to));
        $message->setSubject($subject);
        $message->setBody($body, 'text/html', 'utf-8');
        //$message->attach(Swift_Attachment::fromPath('pic.jpg', 'image/jpeg')->setFilename('rename_pic.jpg'));
        try {
           return $mailer->send($message);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * 发送验证码邮件
     * @param string $subject
     * @return mixed
     */
    public function sendCaptchaMail( $subject='来自Blskye的验证码'){
        $rand_char=strtoupper(getRandChar(4));
        $body='
            <h3>您的验证码是 <b>'.$rand_char.'</b></h3>
        ';
        $this->send($subject,$body);
        $result = cache($this->to, $rand_char,config('setting.captcha_expire_in'));
        return $result;
    }
}