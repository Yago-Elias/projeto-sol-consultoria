<?php

namespace App;

enum Permissions: int
{
    const NONE             = 0;
    const CREATE           = 1 << 0;
    const EDIT             = 1 << 1;
    const REMOVE           = 1 << 2;
    const LIST             = 1 << 3;
    const APPROVE_TASKS    = 1 << 4;
    const MANAGE_PROJECTS  = 1 << 5;
    const FINANCIAL_ACCESS = 1 << 6;

    const LIST_ALL_PROJECTS    = 1 << 7;
    const FINANCIAL_ACCESS_ALL = 1 << 8;
}
