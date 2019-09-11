<?php namespace App\Http\Requests;

use GUMP;
use \WP_Error as Error;

class BaseRequest
{    
    protected $rules = [];
    private   $valid = null;
    private   $msg   = null;

    public function __construct($request = null)
    {
        if($request != null)
        {
            $_POST = $request;
        }

        $this->msg = $this->is_valid();

        if( $this->msg  !== true )
        {
            $this->valid = false;
            
        }else{
            $this->valid = true;
        }


    }

    protected function is_valid()
    {

        return GUMP::is_valid(array_merge($_POST,$_FILES),$this->rules);
    }

    public function getRequest()
    {
        if($this->valid == false)
        {
            return new Error( 400,'Validation Error',$this->msg );
        }
        
        $request = [];

        foreach ($this->rules as $key => $rule) {
            $request[$key] = $_POST[$key] ?? $_FILES[$key];
        }

        return (object) $request;
    }
}
