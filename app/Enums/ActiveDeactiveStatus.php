<?php

namespace App\Enums;

abstract class ActiveDeactiveStatus
{
    const ACTIVE = 'active';
    const DEACTIVE = 'deactive';

    const ALL_STATUSES = [
        self::ACTIVE,
        self::DEACTIVE
    ];
}
