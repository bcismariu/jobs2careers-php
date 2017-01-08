<?php

namespace Bcismariu\Jobs2Careers;

use GuzzleHttp;

/**
 * A PHP integration for the Jobs2Careers API
 *
 * Thanks to https://github.com/jobapis/jobs-jobs2careers
 */
class Jobs2Careers
{
    protected $base_url = 'http://api.jobs2careers.com/api/search.php';

    protected $method_map = [
        'setId'     => 'id',
        'setPass'   => 'pass',
        'setIP'     => 'ip',
        'setQuery'  => 'q',
        'setLocation'   => 'l',
        'setStart'  => 'start',
        'setSort'   => 'sort',
        'setIndustry'   => 'industry',
        'setIndustryEx' => 'industryEx',
        'setFormat' => 'format',
        'setMobile' => 'm',
        'setLimit'  => 'limit',
        'setLink'   => 'link',
        'setFullDescription'    => 'full_desc',
        'setJobId'  => 'jobid',
        'setJobType'    => 'jobtype',
        'setUid'    => 'uid',
        'setPid'    => 'pid'
    ];

    protected $query_parameters = [
        'id'        => null,
        'pass'      => null,
        'ip'        => null,
        'q'         => null,
        'l'         => null,
        'start'     => 0,
        'sort'      => null,
        'industry'  => null,
        'industryEx'    => null,
        'format'    => 'json',
        'm'         => 0,
        'limit'     => 5,
        'link'      => 1,
        'full_desc' => 0,
        'jobid'     => null,
        'jobtype'   => null,
        'uid'       => null,
        'pid'       => null,
    ];


    protected $client;

    /**
     * Create new client for Jobs2Careers
     * @param array $parameters
     * @param array $parameters
     */
    public function __construct($parameters = [], GuzzleHttp\ClientInterface $client = null)
    {
        array_walk($parameters, function ($value, $key) {
            $this->setQueryParameter($key, $value);
        });

        if (!$client) {
            $client = new GuzzleHttp\Client();
        }
        $this->client = $client;
    }

    /**
     * magic method to set query parameters
     * @param  string $method     
     * @param  array $parameters 
     * @return self
     */
    public function __call($method, $parameters)
    {
        if (!isset($this->method_map[$method])) {
            throw new Exception('Method not allowed: ' . $method);
        }
        return $this->setQueryParameter($this->method_map[$method], $parameters[0]);
    }

    /**
     * properly sets limit according to J2C specifications
     * @param integer $value 
     * @return  self 
     */
    public function setLimit($value = 1)
    {
        $limit = intval($value);
        $this->query_parameters['limit'] = max(1, min(200, $limit));
        return $this;
    }

    /**
     * sets parameters for the given email
     * @param string $email 
     * @return self
     */
    public function setEmail($email = '')
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email validation failed for ' . $email);
        }
        $this->setPid($email);
        $this->setUid(md5($email));
        return $this;
    }


    /**
     * returns the query parameters
     * @return array 
     */
    public function getQueryParameters()
    {
        return $this->query_parameters;
    }

    /**
     * retrieves the results from the J2C api
     * @return array [JobResult, ...]
     */
    public function get($limit = 0)
    {
        if ($limit) {
            $this->setLimit($limit);
        }
        return $this->getResults();
    }

    /**
     * Calls the Jobs2Careers API and returns the results
     * @return array
     */
    protected function getResults()
    {
        $payload = $this->client->request('GET', $this->base_url, [
            'query' => $this->getQueryParameters(),
        ]);

        $response = utf8_encode(trim($payload->getBody()->getContents()));
        $results = json_decode($response);

        if (!$this->resultsAreValid($results)) {
            throw new Exception('Jobs2Careers Results are not valid: ' . $response);
        }
        return $results;
    }

    /**
     * Validates the results format
     * @param  $results
     * @return boolean
     */
    protected function resultsAreValid($results)
    {
        return is_object($results)
            && isset($results->jobs)
            && is_array($results->jobs)
        ;
    }

    /**
     * Sets a query paramaeter
     * @param string $key
     * @param mixed $value
     * @return  self
     */
    protected function setQueryParameter($key, $value)
    {
        if (array_key_exists($key, $this->query_parameters)) {
            $this->query_parameters[$key] = $value;
        }
        return $this;
    }
}
