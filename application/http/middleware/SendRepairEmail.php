<?php

namespace app\http\middleware;



use app\common\lib\AuditCode;
use my\Email;

class SendRepairEmail
{
    function handle( $request, \Closure $next)
    {
        $res = $next($request);
        $email = new Email();
        $email->setContent(file_get_contents('static/view/repair_email.html'))
            ->setTitle('报修通知')
            ->setTo(config('email.to_repair'))
            ->setVars([
                'handled_url' => AuditCode::auditUrl('api/repair/handled',$res->getData()['data']['id']),
                'phone' => input('phone'),
                'address' => input('address'),
                'content' => input('content'),
                'create_time' => date('Y-m-d h:i:s')
            ])->send();

        return $res;
    }
}
