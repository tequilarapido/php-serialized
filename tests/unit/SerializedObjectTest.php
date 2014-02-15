<?php
use Codeception\Util\Stub;
use Tequilarapido\PHPSerialized\SerializedObject;

class SerializedObjectTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    public function test_unserialize_real_serialized_object()
    {
        $user = Stub::make('StdClass', array(
                'username' => 'username',
                'email' => 'email@example.com')
        );

        $so = new SerializedObject(serialize($user));
        $result = $so->unserialize();

        $this->assertEquals($result->username, 'username');
        $this->assertEquals($result->email, 'email@example.com');
    }

    public function test_unserialize_wrong_serialized_object()
    {

        $so = new SerializedObject('a:4:{i:0;i:1;i:1;i:2;i:2;i:3;}');
        $result = $so->unserialize();
        $this->assertFalse($result);
    }


}