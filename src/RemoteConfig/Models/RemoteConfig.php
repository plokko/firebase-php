<?php

namespace Plokko\Firebase\RemoteConfig\Models;

use JsonSerializable;

class RemoteConfig implements JsonSerializable
{
    private
        $conditions,
        $parameters;

    public function jsonSerialize(): mixed
    {
        return [
            'conditions' => $this->conditions,
            'parameters' =>  $this->parameters,
        ];
    }
}
