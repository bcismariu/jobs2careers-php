<?PHP

namespace Bcismariu\Jobs2Careers\Tests\Stubs;

/**
 * A stub for Http requests;
 */
class ResponseStub
{
    protected $contents;

    public function __construct($contents = '')
    {
        $this->contents = $contents;
    }

    public function getBody()
    {
        return $this;
    }

    public function getContents()
    {
        return $this->contents;
    }
}
