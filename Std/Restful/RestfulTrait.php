<?php
/**
 * PHP version 7
 * File AbstractRestfulController.php
 *
 * @category Trait
 * @package  Std\Restful
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\Restful;

use Std\Restful\RestfulInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * trait RestfulTrait
 *
 * @category Trait
 * @package  Std\HttpMessageManagerAwareTrait
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait RestfulTrait
{
    private $response;

    private $identifier;

    /**
     * @var array
     */
    protected $contentTypes = [
        RestfulInterface::CONTENT_TYPE_JSON => [
            'application/hal+json',
            'application/json'
        ]
    ];

    /**
     * Name of request or query parameter containing identifier
     *
     * @var string
     */
    protected $identifierName = 'id';

    /**
     * Flag to pass to json_decode and/or Laminas\Json\Json::decode.
     *
     * The flags in Laminas\Json\Json::decode are integers, but when evaluated
     * in a boolean context map to the flag passed as the second parameter
     * to json_decode(). As such, you can specify either the Laminas\Json\Json
     * constant or the boolean value. By default, starting in v3, we use
     * the boolean value, and cast to integer if using Laminas\Json\Json::decode.
     *
     * Default value is boolean true, meaning JSON should be cast to
     * associative arrays (vs objects).
     *
     * Override the value in an extending class to set the default behavior
     * for your class.
     *
     * @var int|bool
     */
    protected $jsonDecodeType = true;

    /**
     * Map of custom HTTP methods and their handlers
     *
     * @var array
     */
    protected $customHttpMethodsMap = [];

    /**
     * Set the route match/query parameter name containing the identifier
     *
     * @param  string $name
     * @return self
     */
    public function setIdentifierName($name)
    {
        $this->identifierName = (string) $name;
        return $this;
    }

    /**
     * Retrieve the route match/query parameter name containing the identifier
     *
     * @return string
     */
    public function getIdentifierName()
    {
        return $this->identifierName;
    }

    /**
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Delete the entire resource collection
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.1.0); instead, raises an exception if not implemented.
     *
     * @return mixed
     */
    public function deleteList($data)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Return single resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function get($id)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Return list of resources
     *
     * @return mixed
     */
    public function getList()
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Retrieve HEAD metadata for the resource
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.1.0); instead, raises an exception if not implemented.
     *
     * @param  null|mixed $id
     * @return mixed
     */
    public function head($id = null)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Respond to the PATCH method
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.1.0); instead, raises an exception if not implemented.
     *
     * @param  $id
     * @param  $data
     * @return array
     */
    public function patch($id, $data)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Replace an entire resource collection
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.1.0); instead, raises an exception if not implemented.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function replaceList($data)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Modify a resource collection without completely replacing it
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.2.0); instead, raises an exception if not implemented.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function patchList($data)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_FORBIDDEN_METHOD);

        return [
            'success' => false,
            'data' => [
                'message' => 'Method Not Allowed'
            ],
        ];
    }

    /**
     * Basic functionality for when a page is not available
     *
     * @return array
     */
    public function notFound()
    {
        $this->withStatus(RestfulInterface::HTTP_STATUS_NOT_FOUND);

        return [
            'success' => false,
            'data' => [
                'message' => 'Page not found'
            ],
        ];
    }

    public function unauthorized()
    {
        $this->withStatus(self::HTTP_STATUS_UNAUTHORIZED);
        return [
            'success' => false,
            'data' => [
                'message' => '401 Unauthorized'
            ],
        ];
    }

    /**
     * Process post data and call create
     *
     * @param Request $request
     * @return mixed
     * @throws \DomainException If a JSON request was made, but no
     *    method for parsing JSON is available.
     */
    public function processPostData(Request $request)
    {
        if ($this->requestHasContentType($request, RestfulInterface::CONTENT_TYPE_JSON)) {
            return $this->create($this->jsonDecode($request->getBody()));
        }

        return $this->create($request->getParsedBody());
    }

    public function getPostData(Request $request)
    {
        if ($this->requestHasContentType($request, RestfulInterface::CONTENT_TYPE_JSON)) {
            return $this->jsonDecode($request->getBody());
        }

        return $request->getParsedBody();
    }

    /**
     * Check if request has certain content type
     *
     * @param  Request $request
     * @param  string|null $contentType
     * @return bool
     */
    public function requestHasContentType(Request $request, $contentType = '')
    {
        $headerContentType = $request->getHeader('content-type');
        if (! $headerContentType) {
            return false;
        }
        $requestedContentType = array_shift($headerContentType);
        $requestedContentType = trim($requestedContentType);
        if (array_key_exists($contentType, $this->contentTypes)) {
            foreach ($this->contentTypes[$contentType] as $contentTypeValue) {
                if (stripos($contentTypeValue, $requestedContentType) === 0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Register a handler for a custom HTTP method
     *
     * This method allows you to handle arbitrary HTTP method types, mapping
     * them to callables. Typically, these will be methods of the controller
     * instance: e.g., array($this, 'foobar'). The typical place to register
     * these is in your constructor.
     *
     * Additionally, as this map is checked prior to testing the standard HTTP
     * methods, this is a way to override what methods will handle the standard
     * HTTP methods. However, if you do this, you will have to retrieve the
     * identifier and any request content manually.
     *
     * Callbacks will be passed the current MvcEvent instance.
     *
     * To retrieve the identifier, you can use "$id =
     * $this->getIdentifier($request)",
     * passing the appropriate objects.
     *
     * To retrieve the body content data, use "$data = $this->processBodyContent($request)";
     * that method will return a string, array, or, in the case of JSON, an object.
     *
     * @param  string $method
     * @param  Callable $handler
     * @return AbstractRestfulController
     */
    public function addHttpMethodHandler($method, /* Callable */ $handler)
    {
        if (! is_callable($handler)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid HTTP method handler: must be a callable; received "%s"',
                (is_object($handler) ? get_class($handler) : gettype($handler))
            ));
        }
        $method = strtolower($method);
        $this->customHttpMethodsMap[$method] = $handler;
        return $this;
    }

    /**
     * Retrieve the identifier, if any
     *
     * Attempts to see if an identifier was passed in either the URI or the
     * query string, returning it if found. Otherwise, returns a boolean false.
     *
     * @param  Request $request
     * @return false|mixed
     */
    public function getIdentifier($request)
    {
        if (null === $this->identifier) {
            $identifier = $this->getIdentifierName();
            $this->identifier = $request->getQueryParams()[$identifier] ?? false;
        }
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Process the raw body content
     *
     * If the content-type indicates a JSON payload, the payload is immediately
     * decoded and the data returned. Otherwise, the data is passed to
     * parse_str(). If that function returns a single-member array with a empty
     * value, the method assumes that we have non-urlencoded content and
     * returns the raw content; otherwise, the array created is returned.
     *
     * @param  mixed $request
     * @return object|string|array
     * @throws \DomainException If a JSON request was made, but no
     *    method for parsing JSON is available.
     */
    protected function processBodyContent($request)
    {
        $content = $request->getBody();

        // JSON content? decode and return it.
        if ($this->requestHasContentType($request, RestfulInterface::CONTENT_TYPE_JSON)) {
            return $this->jsonDecode($request->getBody());
        }

        parse_str((string) $content, $parsedParams);

        // If parse_str fails to decode, or we have a single element with empty value
        if (! is_array($parsedParams) || empty($parsedParams)
            || (1 == count($parsedParams) && '' === reset($parsedParams))
        ) {
            return $content;
        }

        return $parsedParams;
    }

    /**
     * Decode a JSON string.
     *
     * Uses json_decode by default. If that is not available, checks for
     * availability of Laminas\Json\Json, and uses that if present.
     *
     * Otherwise, raises an exception.
     *
     * Marked protected to allow usage from extending classes.
     *
     * @param string
     * @return mixed
     * @throws \DomainException if no JSON decoding functionality is
     *     available.
     */
    protected function jsonDecode($string)
    {
        if (function_exists('json_decode')) {
            return json_decode((string) $string, (bool) $this->jsonDecodeType);
        }

        throw new \DomainException(sprintf(
            'Unable to parse JSON request, due to missing ext/json'
        ));
    }

    /**
     * ステータスコード指定
     *
     * @param int $status
     * @return void
     */
    protected function withStatus(int $status)
    {
        if ($this->response) {
            $this->response = $this->response->withStatus($status);
        }
    }
}
