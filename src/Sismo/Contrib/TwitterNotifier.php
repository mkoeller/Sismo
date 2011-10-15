<?php

/*
 * This file is part of the Sismo utility.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sismo\Contrib;

use Sismo\Notifier;
use Sismo\Commit;

// @codeCoverageIgnoreStart
/**
 * Notifies builds via a twitter.
 *
 * This notifier needs the Andy Smis's OAuth library to be required in your configuration.
 *
 *    require '/path/to/OAuth/OAuth.php';
 *
 * Download it at http://oauth.googlecode.com/svn/code/php/
 *
 * And this notifier needs curl module.
 * http://www.php.net/manual/en/book.curl.php
 *
 * @author Shogo Kawahara <kawahara@bucyou.net>
 */
class TwitterNotifier extends Notifier
{
    private $accessToken;
    private $accessSecret;
    private $format;

    public function __construct($consumerKey, $consumerSecret, $accessToken, $accessSecret, $format = null)
    {
        $defaultFormat = '[%STATUS%] %name% %short_sha% -- %message% by %author%';
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->accessToken = $accessToken;
        $this->accessSecret = $accessSecret;
        $this->format = $format ?: $defaultFormat;
    }

    public function notify(Commit $commit)
    {
        if (!is_callable("curl_init"))
        {
            throw new RuntimeException("curl module is not installed.");
        }

        if (!class_exists("\OAuthConsumer"))
        {
            throw new RuntimeException("OAuth library by Andy Smith is not loaded.");
        }

        $url = "http://api.twitter.com/1/statuses/update.json";

        $consumer = new \OAuthConsumer($this->consumerKey, $this->consumerSecret);
        $token = new \OAuthConsumer($this->accessToken, $this->accessSecret);
        $request = \OAuthRequest::from_consumer_and_token($consumer, $token, "POST", $url, array(
            'status' => $this->format($this->format, $commit)
        ));
        $request->sign_request(new \OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request->get_normalized_http_url());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request->to_postdata());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        @curl_exec($ch);
    }
}
// @codeCoverageIgnoreEnd
