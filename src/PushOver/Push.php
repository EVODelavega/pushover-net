<?php

namespace PushOver;

use PushOver\Model\Message;

class Push extends Api
{
	const API_SECTION = 'messages';

    /**
     * @param Message $msg
     * @return Model\Response
     * @throws \InvalidArgumentException
     */
    public function pushMessage(Message $msg)
    {
        if ($msg->getCredentials() === null)
        {
            throw new \InvalidArgumentException(
                'No credentials set on message, cannot push message'
            );
        }
        return $this->doCurl($msg);
    }
}
