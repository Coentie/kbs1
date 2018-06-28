<?php


namespace KBS\Request\Validator;


use KBS\Request\Errors\Error;

class Validator
{

    /**
     * @var \Psr\Http\Message\RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var bool
     */
    protected $validated = true;

    /**
     * Validator constructor.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Set the rule set for the validator.
     *
     * @param array $rules
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Validates the post request.
     */
    public function validate()
    {
        foreach ($this->rules as $post => $rule)
        {
            $this->callRuleOnPost($post, $rule);
        }

        return $this;
    }

    /**
     * Returns if the validation succeeded or not.
     *
     * @return bool
     */
    public function validationPassed()
    {
        return $this->validated;
    }

    /**
     * Calls all rules on a post entry.
     *
     * @param $post
     * @param $rule
     */
    public function callRuleOnPost($post, $rule)
    {
        foreach ($this->extractCallables($rule) as $callable)
        {
            if ($this->hasExtraParameter($callable) !== false)
            {
                $splittedRule = preg_split('([\:])', $callable);

                $this->{$splittedRule[0]}($post, $splittedRule[1]);
            } else
            {
                $this->$callable($post);
            }
        }
    }

    /**
     * Splits the rule string into callable functions.
     *
     * @param $rule
     *
     * @return array[]|false|string[]
     */
    protected function extractCallables($rule)
    {
        return preg_split('([\|])', $rule);
    }

    /**
     * Checks if the rule has an extra parameter.
     *
     * @param $callable
     *
     * @return bool|int
     */
    protected function hasExtraParameter($callable)
    {
        return strpos($callable, ':');
    }

    /**
     * Checks if the required parameter is in the post.
     *
     * @param $post
     */
    protected function required($post)
    {
        if ( ! array_key_exists($post, $this->request->getParsedBody())
            ||  strlen(trim($this->request->getParsedBody()[$post])) <= 0)
        {
            Error::add($post, $post . ' is een verplicht veld');

            $this->validationFailed();
        }
    }

    /**
     * Checks the size of a post.
     *
     * @param $post
     * @param $size
     */
    protected function max($post, $size)
    {
        if(strlen($post) > $size) {
            Error::add($post, $post . ' mag niet meer dan ' . $size . ' karakters lang zijn');

            $this->validationFailed();
        }
    }

    /**
     * Checks if a value is less then an other value.
     *
     * @param $post
     * @param $otherValue
     */
    protected function lessthendate($post, $otherValue)
    {
        if(strtotime($post) < strtotime($this->request->getParsedBody()[$otherValue])) {
            Error::add($post, $post . ' mag niet groter zijn dan '. $otherValue);

            $this->validationFailed();
        }
    }

    /**
     * Sets the validation to false
     */
    protected function validationFailed()
    {
        $this->validated = false;
    }
}