<?PHP

namespace Bcismariu\Jobs2Careers\Tests;

use Bcismariu\Jobs2Careers\Jobs2Careers;
use Bcismariu\Jobs2Careers\Exception;

class Jobs2CareersTest extends TestCase
{
    protected $provider;

    public function setUp()
    {
        parent::setUp();
        $this->provider = $this->provider();
    }

    public function tearDown()
    {
        unset($this->provider);
        parent::tearDown();
    }

    /** @test */
    public function it_can_instantiate()
    {
        $this->assertInstanceOf(Jobs2Careers::class, $this->provider);
    }

    /** 
     * @test
     * @dataProvider methodProvider
     */
    public function it_can_map_methods($method, $field, $value)
    {
        $this->provider->$method($value);
        $this->assertArraySubset([$field => $value], $this->provider->getQueryParameters());
    }

    /** 
     * @test
     * @dataProvider methodProvider
     */
    public function it_can_chain_methods($method, $field, $value)
    {
        $this->assertInstanceOf(Jobs2Careers::class, $this->provider->$method($value));
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function it_throws_exception_on_unknown_method()
    {
        $this->provider->unknownMethod('some-value');
    }

    /**
     * @test
     * @dataProvider limitProvider
     */
    public function it_can_set_limit($value, $expected_value)
    {
        $this->provider->setLimit($value);
        $this->assertArraySubset(['limit' => $expected_value], $this->provider->getQueryParameters());
    }

    /** @test */
    public function it_can_set_email()
    {
        $email = 'user@example.com';
        $this->provider->setEmail($email);

        $parameters = $this->provider->getQueryParameters();

        $this->assertArraySubset([
            'pid'   => $email,
            'uid'   => md5($email)
        ], $parameters);
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function it_does_not_set_invalid_email()
    {
        $this->provider->setEmail('invalid.email');
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
        ]);
    }

    /**
     * sets method and value
     * @return array
     */
    public function methodProvider()
    {
        return [
            ['setId',   'id',   'id-value'],
            ['setPass', 'pass', 'pass-value'],
            ['setIP',   'ip',   'ip-value'],
            ['setQuery',    'q',    'q-value'],
            ['setLocation', 'l',    'l-value'],
            ['setStart',    'start',    'start-value'],
            ['setSort', 'sort', 'sort-value'],
            ['setIndustry', 'industry', 'industry-value'],
            ['setIndustryEx',   'industryEx',   'industryEx-value'],
            ['setFormat',   'format',   'format-value'],
            ['setMobile',   'm',    'm-value'],
            ['setLink', 'link', 'link-value'],
            ['setFullDescription',  'full_desc',    'full_desc-value'],
            ['setJobId',    'jobid',    'jobid-value'],
            ['setJobType',  'jobtype',  'jobtype-value'],
            ['setUid',  'uid',  'uid-value'],
            ['setPid',  'pid',   'pid-value'],
        ];
    }

    /**
     * returns pair of user values and valid values
     * @return array
     */
    public function limitProvider()
    {
        return [
            [0, 1],
            [1, 1],
            [20, 20],
            ['25a', 25],
            [200, 200],
            [201, 200],
        ];
    }
}
