# Tequilarapido/PHPSerialized

[![Build Status](https://travis-ci.org/tequilarapido/php-serialized.png?branch=master)](https://travis-ci.org/tequilarapido/php-serialized)
[![Latest Stable Version](https://poser.pugx.org/tequilarapido/php-serialized/v/stable.png)](https://packagist.org/packages/tequilarapido/php-serialized) 
[![Total Downloads](https://poser.pugx.org/tequilarapido/php-serialized/downloads.png)](https://packagist.org/packages/tequilarapido/php-serialized) 
[![License](https://poser.pugx.org/tequilarapido/php-serialized/license.png)](https://packagist.org/packages/tequilarapido/php-serialized)


Can be used to replace strings in PHP serialized strings.
(take a look at the tests)

### Example

            // Serialized stuff
            $user = new stdClass();
            $user->email = 'email@example.com';
            $serialized = serialize($user);

            // Replace mail
            $sr = new SearchReplace();
            $result = $sr->run('email@example.com', 'email@anotherdomain.com', $serialized);



### Credits

Most of the code is from googling around.
If you think it's your code that I'm using, let me know and I'll be happy to mention it.

