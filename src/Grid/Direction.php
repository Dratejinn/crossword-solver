<?php

declare(strict_types = 1);

namespace Dratejinn\Grid;

enum Direction {
    case NORTH;
    case EAST;
    case SOUTH;
    case WEST;
    case NORTHEAST;
    case SOUTHEAST;
    case SOUTHWEST;
    case NORTHWEST;
}