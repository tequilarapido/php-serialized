<?php
use Codeception\Util\Stub;
use Tequilarapido\PHPSerialized\SearchReplace;

class SearchReplaceTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    public function test_replace_on_simple_string()
    {
        $sr = new SearchReplace();
        $result = $sr->run('NOT OK', 'OK', 'It is NOT OK.');

        $this->assertEquals($result, 'It is OK.');
    }

    public function test_replace_on_stdClass_object()
    {
        $user = new stdClass();
        $user->email = 'email@example.com';

        $serialized = serialize($user);
        $sr = new SearchReplace();
        $result = $sr->run('email@example.com', 'email@anotherdomain.com', $serialized);
        $object = unserialize($result);

        $this->assertEquals($object->email, 'email@anotherdomain.com');
    }

    public function test_replace_on_unknown_object()
    {
        $serialized = 'O:22:"Mock_StdClass_unkown__":4:{s:50:" Mock_StdClass_unknown____phpunit_invocationMocker";N;s:8:"username";s:8:"username";s:5:"email";s:17:"email@example.com";s:8:"__mocked";s:8:"StdClass";}';
        $sr = new SearchReplace();
        $result = $sr->run('email@example.com', 'email@anotherdomain.com', $serialized);
        $unusableObject = (array)unserialize($result);
        $this->assertEquals($unusableObject['email'], 'email@example.com');

    }


}