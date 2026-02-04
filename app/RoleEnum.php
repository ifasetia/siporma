<?php

namespace App;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case INTERN = 'intern';
    case PUBLIC = 'public';
}
