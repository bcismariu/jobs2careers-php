<?PHP

namespace Bcismariu\Jobs2Careers\Tests;

use Bcismariu\Jobs2Careers\Jobs2Careers;
use Bcismariu\Jobs2Careers\Exception;
use GuzzleHttp\Client;
use Mockery as m;

class ApiTest extends TestCase
{
    protected $provider;
    protected $mock;

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->mock();
        $this->provider = $this->provider();
    }

    public function tearDown()
    {
        m::close();
        unset($this->provider);
        parent::tearDown();
    }

    /** @test */
    public function it_can_set_limit()
    {
        $this->mock->shouldReceive('request')->once()->andReturn(
            new Stubs\ResponseStub('{"jobs": ["test"]}')
        );
        $this->provider->get(3);

        $this->assertArraySubset(['limit' => 3], $this->provider->getQueryParameters());
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function it_can_detect_invalid_results()
    {
        $this->mock->shouldReceive('request')->once()->andReturn(
            new Stubs\ResponseStub('{"test": ["test"]}')
        );
        $this->provider->get();
    }

    /**
     * instantiates the job provider
     * @return Jobs2Careers
     */
    protected function provider()
    {
        return new Jobs2Careers([
            'id'    => 'test',
            'pass'  => 'test',
            'ip'    => 'test'
        ], $this->mock);
    }

    protected function mock()
    {
        return m::mock(Client::class);
    }
}
