<?php

namespace Core\Flame\Orm\Enums;

enum JoinTypesEnum: string {
     case INNER = 'inner';
     case LEFT = 'left';
     case RIGHT = 'right';
     case CROSS = 'cross';
}