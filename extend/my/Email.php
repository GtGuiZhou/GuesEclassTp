<?php

namespace my;

use app\common\lib\AuditCode;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Email
{
    private $contentType = 'text/html';
    private $content = '';
    private $vars = [];
    private $to = [];
    private $title = '';

    public function getConfig(){
        $conetnt = $this->content;
        // 渲染内容
        if (count($this->vars) > 0){
            $conetnt = $this->view($this->content,$this->vars);
        }
        return [
          'content' => $conetnt,
          'to_email' => $this->to,
          'title' => $this->title,
          'content_type' => $this->contentType
        ];
    }

    public function send()
    {
        $conetnt = $this->content;
        // 渲染内容
        if (count($this->vars) > 0){
            $conetnt = $this->view($this->content,$this->vars);
        }
        // 发送邮件
        $transport = (new Swift_SmtpTransport(config('email.host'), config('email.port')))
            ->setUsername(config('email.username'))
            ->setPassword(config('email.password'));
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($this->title))
            ->setFrom([config('email.username') => config('email.name')])
            ->setTo($this->to)
            ->setBody($conetnt, $this->contentType);
        return $mailer->send($message);

    }



    public function view ($content,$vars) {
        foreach ($vars as $key => $var){
            $content = str_replace('${'.$key.'}',$var,$content);
        }

        return $content;
    }




    /**
     * @param string $contentType
     * @return Email
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @param array $vars
     * @return Email
     */
    public function setVars($vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * 发送列表
     * @param array $to
     * @return Email
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param string $title
     * @return Email
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $content
     * @return Email
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


}
