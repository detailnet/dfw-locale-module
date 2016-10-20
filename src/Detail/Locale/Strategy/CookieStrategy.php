<?php

namespace Detail\Locale\Strategy;

use Zend\Http\Header\Cookie as CookieHeader;
use Zend\Http\Header\SetCookie as SetCookieHeader;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\Stdlib\ResponseInterface;

use SlmLocale\LocaleEvent;
use SlmLocale\Strategy\CookieStrategy as BaseCookieStrategy;

class CookieStrategy extends BaseCookieStrategy
{
    const OPTION_COOKIE_NAME       = 'cookie_name';
    const OPTION_COOKIE_EXPIRATION = 'cookie_expiration';

    /**
     * @var string|null
     */
    protected $cookieExpiration = null;

    /**
     * @return string|null
     */
    public function getCookieExpiration()
    {
        return $this->cookieExpiration;
    }

    /**
     * @param string|null $cookieExpiration
     */
    public function setCookieExpiration($cookieExpiration)
    {
        $this->cookieExpiration = $cookieExpiration;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options = array())
    {
        parent::setOptions($options);

        if (array_key_exists(self::OPTION_COOKIE_EXPIRATION, $options)) {
            $this->setCookieExpiration($options[self::OPTION_COOKIE_EXPIRATION]);
        }
    }

    /**
     * @param LocaleEvent $event
     * @return ResponseInterface|void
     */
    public function found(LocaleEvent $event)
    {
        $locale = $event->getLocale();
        $request = $event->getRequest();

        if (!$this->isHttpRequest($request)) {
            return;
        }

        /** @var HttpRequest $request */

        $cookie = $request->getCookie();
        $cookieName = $this->getCookieName();

        // Omit Set-Cookie header when cookie is present
        // and Expires does not need renewing...
        if ($this->getCookieExpiration() === null
            && $cookie instanceof CookieHeader
            && $cookie->offsetExists($cookieName)
            && $locale === $cookie->offsetGet($cookieName)
        ) {
            return;
        }

        $cookiePath = '/';

        if (method_exists($request, 'getBasePath')) {
            $cookiePath = rtrim($request->getBasePath(), '/') . '/';
        }

        $setCookie = new SetCookieHeader($cookieName, $locale, $this->getCookieExpiration(), $cookiePath);

        /** @var HttpResponse $response */
        $response  = $event->getResponse();
        $response->getHeaders()->addHeader($setCookie);
    }
}
