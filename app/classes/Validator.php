<?php
class Validator
{
    protected ErrorHandler $errorHandler;

    protected Database $database;

    protected $rules = [
        'required',
        'minlength',
        'maxlength',
        'email',
        'unique'
    ];

    protected $messages = [
        'required' => 'The :field field is required',
        'minlength' => 'The :field field must be maximum of :satisfier character',
        'minlength' => 'The :field field must be minimum of :satisfier character',
        'email' => 'That is not a valid email address',
        'unique' => 'That :field is already taken!'

    ];

    public function __construct(Database $database, ErrorHandler $errorHandler)
    {
        $this->database = $database;
        $this->errorHandler = $errorHandler;
    }

    public function errors(): ErrorHandler
    {
        return $this->errorHandler;
    }

    public function fails(): bool
    {
        return $this->errorHandler->hasErrors();
    }

    public function check($data, $rules)
    {
        foreach($data as $item => $value){
            if(in_array($item, array_keys($rules))){
                $this->validate($item, $value, $rules[$item]);
            }
        }
    }

    public function validate($field, $value, $rules)
    {
        foreach($rules as $rule => $satisfier){
            if(in_array($rule,$this->rules)){
                if(!call_user_func_array([$this,$rule],[$field,$value,$satisfier])){
                    $this->errorHandler->addError(
                        str_replace([':field',':satisfier'], [$field,$satisfier], $this->messages[$rule]),
                        $field
                    );
                }
            }
        }
    }
    
    protected function required($field, $value, $satisfier): bool
    {
        return !empty(trim($value));
    }
    protected function minlength($field, $value, $satisfier): bool
    {
        return mb_strlen(trim($value)) >= $satisfier;
    }
    protected function maxlength($field, $value, $satisfier): bool
    {
        return mb_strlen(trim($value)) <= $satisfier;
    }
    protected function email($field, $value, $satisfier): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    protected function unique($field, $value, $satisfier): bool
    {
        return ! $this->database
                     ->table($satisfier)
                     ->exists([$field=>$value]);
    }
}