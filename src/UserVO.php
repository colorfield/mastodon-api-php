<?php

namespace Colorfield\Mastodon;

/**
 * Class User Value Object.
 *
 * @todo this is a bare minimal implementation.
 * @see https://github.com/r-daneelolivaw/mastodon-api-php/issues/5
 *
 * User information used by the MastodonAPI class.
 */
class UserVO
{

    private function createProperty($name, $value)
    {
        $this->{$name} = $value;
    }

    public function __construct(array $user) 
    {
        foreach($user as $key => $value) {
            $this->createProperty($key, $value);
        }
    }
}
