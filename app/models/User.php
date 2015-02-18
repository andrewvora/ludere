<?php

use Jenssegers\Mongodb\Model as Eloquent;

class User extends Eloquent {
	protected $collection = 'users';
}
?>