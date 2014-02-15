<?php namespace Tequilarapido\PHPSerialized;


class SerializedObject
{
    protected $serialized;

    public function __construct($string = '')
    {
        if (!empty($string)) {
            $this->setSerialized($string);
        }
    }

    public function setSerialized($serlialized)
    {
        $this->serialized = $serlialized;
    }

    /**
     * Check value to find if it was serialized.
     *
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     * @since 2.0.5
     * @from wordpress / is_serialized function
     *       https://github.com/WordPress/WordPress/blob/5f0981788d7adbd25b71addbc415f700eb1c71b5/wp-includes/functions.php
     *
     * @param mixed $data Value to check to see if was serialized.
     * @return bool False if not serialized and true if it was.
     */
    public function isSerialized()
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($this->serialized)) {
            return false;
        }
        $this->serialized = trim($this->serialized);
        if ('N;' == $this->serialized) {
            return true;
        }
        $length = strlen($this->serialized);
        if ($length < 4) {
            return false;
        }
        if (':' !== $this->serialized[1]) {
            return false;
        }
        $lastc = $this->serialized[$length - 1];
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
        $token = $this->serialized[0];
        switch ($token) {
            case 's' :
                if ('"' !== $this->serialized[$length - 2]) {
                    return false;
                }
            case 'a' :
            case 'O' :
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $this->serialized);
            case 'b' :
            case 'i' :
            case 'd' :
                return (bool)preg_match("/^{$token}:[0-9.E-]+;\$/", $this->serialized);
        }
        return false;
    }

    public function unserialize($base64 = true)
    {
        $string = $this->serialized;

        if ($base64) {
            $string = base64_decode(base64_encode($string));
        }

        return @unserialize($string);
    }


}