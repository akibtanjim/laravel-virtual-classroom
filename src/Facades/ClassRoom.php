<?php

namespace AkibTanjim\VirtualClassRoom\Facades;

use Illuminate\Support\Facades\Facade;

class ClassRoom extends Facade {
	protected static function getFacadeAccessor(){
		return 'virtual-classroom';
	}
}