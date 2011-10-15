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
 * Notifies builds via a email.
 *
 * @author Shogo Kawahara <kawahara@bucyou.net>
 */
class MailNotifier extends Notifier
{
    private $to;
    private $subjectFormat;
    private $bodyFormat;
    private $from;

    public function __construct($to, $from, $subjectFormat = null, $bodyFormat = null)
    {
        $defaultFormat = '[%STATUS%] %name% %short_sha% -- %message% by %author%';

        $this->to = $to;
        $this->from = $from;
        $this->subjectFormat = $subjectFormat ?: $defaultFormat;
        $this->bodyFormat = $bodyFormat ?: $defaultFormat;
    }

    public function notify(Commit $commit)
    {
        $subject = $this->format($this->subjectFormat, $commit);
        $body = $this->format($this->bodyFormat, $commit);
        @mail($this->to, $subject, $body, "From: ".$this->from);
    }
}
// @codeCoverageIgnoreEnd
