<?php

require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class AppCache extends HttpCache
{
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $mc = new \Memcache();
        $mc->addserver('memcached', 11211);
        $session = new MemcachedSessionHandler($mc, ['prefix' => 'sess', 'expiretime' => 3600 ]);
        $data = $session->read($_COOKIE['PHPSESSID']);
        if (strpos($data, '_security_user') !== false) {
            $request->headers->set('expect', 'no-cache');
        }

        return parent::handle($request, $type, $catch);
    }

    public function getOptions()
    {
       return [
           'allow_reload' => true,
       ];
    }
}
