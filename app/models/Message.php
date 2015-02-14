<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Message extends Eloquent {
	protected $collection = 'messages';
}

?>