<?php

use Jenssegers\Mongodb\Model as Eloquent;

class UserDataQueue extends Eloquent {
	protected $collection = 'user_data_queue';
}

?>