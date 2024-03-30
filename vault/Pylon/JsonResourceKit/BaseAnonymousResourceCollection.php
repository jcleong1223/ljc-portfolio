<?php

namespace Pylon\JsonResourceKit;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Pylon\Resources\Traits\BaseJsonResource;

class BaseAnonymousResourceCollection extends AnonymousResourceCollection
{
	use BaseJsonResource;
}
