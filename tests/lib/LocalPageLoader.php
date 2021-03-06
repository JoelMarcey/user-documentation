<?hh

namespace HHVM\UserDocumentation\Tests;

use \Zend\Diactoros\ServerRequest;
use \Psr\Http\Message\ResponseInterface;

final class LocalPageLoader extends PageLoader {
  protected function __construct() {}

  protected async function getPageImpl(
    string $url,
  ): Awaitable<ResponseInterface> {
    $query_params = [];
    parse_str(parse_url($url, PHP_URL_QUERY), $query_params);

    /* HH_IGNORE_ERROR[2049] no HHI for diactoros */
    $request = (new ServerRequest(
      /* server = */ [],
      /* file = */ [],
      $url,
      'GET',
      /* body = */ '/dev/null',
      /* headers = */ [],
    ))->withQueryParams($query_params);

    return await \HHVMDocumentationSite::getResponseForRequest($request);
  }
}
