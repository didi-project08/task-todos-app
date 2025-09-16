<?php

namespace App\Extensions;

use Illuminate\Session\DatabaseSessionHandler;

class CustomDatabaseSessionHandler extends DatabaseSessionHandler
{
    protected function addUserInformation(&$payload)
    {
        if ($this->container->bound('auth')) {
            $user = $this->container->make('auth')->user();
            
            $payload['user_id'] = $user ? $user->getAuthIdentifier() : null;
        }

        return $this;
    }
    
    public function write($sessionId, $data)
    {
        $payload = $this->getDefaultPayload($data);
        
        if (isset($payload['user_id']) && $payload['user_id'] == 0) {
            $payload['user_id'] = null;
        }
        
        if (!$this->exists) {
            $this->getQuery()->insert($payload);
        } else {
            $this->getQuery()->where('id', $sessionId)->update($payload);
        }

        $this->exists = true;
    }
}