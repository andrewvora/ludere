<?php

use Jenssegers\Mongodb\Model as Eloquent;

class UDQueue extends Eloquent {
	protected $collection = 'user_data_queue';
}

?>