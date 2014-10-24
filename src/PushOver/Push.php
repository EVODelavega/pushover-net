<?php

namespace PushOver;

use PushOver\Model\Message;

class Push extends Api
{
	const API_SECTION = 'messages';

    /**
     * @param Message $msg
     * @return Model\Response
     */
    public function pushMessage(Message $msg)
    {
        return $this->doCurl($msg);
    }
}
