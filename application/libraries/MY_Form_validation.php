<?php

class MY_Form_validation extends CI_Form_validation {

	function error_count()
	{
	    return count($this->_error_array); 
	}
	
}