<?php

namespace Faker\Provider\es_MX;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('gmail.com', 'hotmail.com', 'hotmail.es', 'yahoo.com', 'yahoo.es', 'live.com', 'hispavista.com', 'latinmail.com', 'terra.com');
    protected static $tld = array('com', 'com.mx', 'net', 'net.mx', 'org', 'org.mx', 'info.mx', 'co.mx', 'web.mx');
}
