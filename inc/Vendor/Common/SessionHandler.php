<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/21/13
 * Time: 10:56 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\Common;

class SessionHandler implements \Vendor\Common\IHandler
{
    protected $type = 'nps_sess';

    // default config with support for multiple servers
    // (helpful for sharding and replication setups)
    public static $_config = array(
        // cookie related vars
        'cookie_path'   => '/',
        'cookie_domain' => '', //
        'lifetime'      => 3600,        // session lifetime in seconds
    );

    public function init(){
        $this->setHandlers();

        // set some important session vars
        ini_set('session.auto_start',               0);//specifies whether the session module starts a session automatically on request startup
        ini_set('session.gc_probability',           1);//The probability is calculated by using gc_probability/gc_divisor, e.g. 1/100 means there is a 1% chance that the GC process starts on each request. session.gc_divisor defaults to 100.
        ini_set('session.gc_divisor',               100);//The probability is calculated by using gc_probability/gc_divisor, e.g. 1/100 means there is a 1% chance that the GC process starts on each request. session.gc_divisor defaults to 100.
        ini_set('session.gc_maxlifetime',           self::$_config['lifetime']);//specifies the number of seconds after which data will be seen as 'garbage' and potentially cleaned up.
        ini_set('session.referer_check',            '');//contains the substring you want to check each HTTP Referer for.
        ini_set('session.entropy_file',             '/dev/urandom');//ives a path to an external resource (file) which will be used as an additional entropy source in the session id creation process.
        ini_set('session.entropy_length',           16);// specifies the number of bytes which will be read from the file specified above.
        ini_set('session.use_cookies',              1);// specifies whether the module will use cookies to store the session id on the client side. Defaults to 1 (enabled).
        ini_set('session.use_only_cookies',         1);//specifies whether the module will only use cookies to store the session id on the client side. Enabling this setting prevents attacks involved passing session ids in URLs.
        ini_set('session.use_trans_sid',            0);//whether transparent sid support is enabled or not. Defaults to 0 (disabled).
        ini_set('session.hash_function',            1);//allows you to specify the hash algorithm used to generate the session IDs. '0' means MD5 (128 bits) and '1' means SHA-1 (160 bits).
        ini_set('session.hash_bits_per_character',  5);//allows you to define how many bits are stored in each character when converting the binary hash data to something readable.

        // disable client/proxy caching
        session_cache_limiter('nocache');

        // set the cookie parameters
        session_set_cookie_params(
            self::$_config['lifetime'],
            self::$_config['cookie_path'],
            self::$_config['cookie_domain']
        );
        // name the session
        session_name($this->type);
        // the following prevents unexpected effects when using objects as save handlers
        register_shutdown_function('session_write_close');
        // start it up
        session_start();
    }

    function setHandlers(){
        //var_dump(ini_get('session.save_handler')); - session.save_handler automatically set to "user" fater custom session handle initializing
        //here session.save_handler == 'files'
        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );
        //here session.save_handler == 'user'
    }
}

