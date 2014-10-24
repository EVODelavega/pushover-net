<?php

namespace PushOver;

use PushOver\Model\User;

class Validate extends Api
{
    const API_SECTION = 'users/validate';

    /**
     * @param User $data
     * @return Model\Response
     */
    public function validateUserGroup(User $data)
    {
        return $this->doCurl($data);
    }
}