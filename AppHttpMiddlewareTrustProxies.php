<?php
use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    protected $proxies = '*'; // Trust all proxies or specify IPs
    protected $headers = Request::HEADER_X_FORWARDED_ALL; // Use all forwarded headers
}

