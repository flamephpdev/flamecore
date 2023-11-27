<?php

/**
 * Flame Core Version 2 Database Model
 * v2 models made for you, and a faster way to develop
 * more complex apps with FlameCore
 * What's New?
 * - Now you don't have to write out all the fields
 *   that your database table has, the app will do it instead, and will know
 *   the types, etc.
 * - Supports a new Builder for better SQL querys, like JOIN, withWhere, etc.
 * - Supports a relation model (BETA, just a few, but now you can use hasOne and belongsTo)
 * - SubQuery Support, so now you could use a where clause with a query result
 */

namespace App\Model\v2;

use Core\Flame\Orm\Model;

class User extends Model {
     protected static ?string $table = 'users';

     protected array $writable = [];

     protected array $hidden = ['password'];
}