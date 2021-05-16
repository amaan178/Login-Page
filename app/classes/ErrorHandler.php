<?php
class ErrorHandler
{
    protected $error;
    public function addError(string $error, $key = null) 
    {
        if($key) {
            $this->errors[$key][] = $error;
        } else {
            $this->errors[] = $error;
        }
    }
    public function hasErrors(): bool
    {
        return isset($this->errors) ? count($this->errors) > 0 : false;
    }
    public function has($key): bool
    {
        return isset($this->errors[$key]);
    }
    public function all($key = null) 
    {
        return isset($this->errors[$key]) ? $this->errors[$key] : $this->errors;
    }
    public function first($key)
    {
        return isset($this->all($key)[0]) ? $this->all($key)[0] : false;
    }
}