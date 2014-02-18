<?php namespace Tequilarapido\PHPSerialized;


class SearchReplace
{
    private $serializedObject;

    public function __construct()
    {

    }

    public function run($search, $replace, $subject)
    {
        $so = new SerializedObject($subject);
        $isSerialized = $so->isSerialized();

        // Subject is not a serialized
        if (!$isSerialized) {
            return str_replace($search, $replace, $subject);
        }

        // Subject is serialized
        try {

            $so = new SerializedObject($subject);
            $unserialized = $so->unserialize();
            $this->replace($search, $replace, $unserialized);
            return serialize($unserialized);

        } catch (\Exception $e) {
            return $subject;
        }
    }

    protected function replace($search, $replace, &$subject)
    {
        // Cannot unserialize incomplete object ?
        if ($this->isIncompleteObject($subject)) {
            throw new \LogicException("Missing class definition : " . current($subject));
        }

        if (is_array($subject) || is_object($subject)) {
            foreach ($subject as $key => $value) {
                // Value is not a string: sends array
                if ((is_object($value) || is_array($value)) && is_array($subject)) {
                    $this->replace($search, $replace, $subject[$key]);
                } else {
                    // Value is not a string: sends object
                    if ((is_object($value) || is_array($value)) && is_object($subject)) {
                        $this->replace($search, $replace, $subject->$key);
                    } else if (is_string($value)) {
                        // Inserts in object
                        if (is_object($subject)) {
                            $subject->$key = str_replace($search, $replace, $value);
                        } // Inserts in array
                        else {
                            $data[$key] = str_replace($search, $replace, $value);
                        }
                    }
                }
            }
        }
    }


    /**
     * Incomplete object ?
     *      The class used to serialize the object, does not exist anymore or not loaded
     *
     * @see http://stackoverflow.com/questions/965611/forcing-access-to-php-incomplete-class-object-properties
     * @param $object
     * @return bool
     */
    public function isIncompleteObject($object)
    {
        return !is_object($object) && gettype($object) == 'object';
    }

}