<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Person extends Eloquent {
	protected $collection = 'people';
}

?>