<?php

namespace Btw\Core\Interfaces;

use CodeIgniter\HTTP\IncomingRequest;
use Btw\Core\Entities\Activity;

interface Transformer
{
    /**
     * Returns the updated Visit, or `null` to cancel recording.
     */
    public static function transform(Activity $activity, IncomingRequest $request): ?Activity;
}