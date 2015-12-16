<?php

namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;

class AuthenticationAdapterFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config         = $serviceLocator->get('Config');
		$authConfig     = $config['book_app']['auth_adapter'];
		$authAdapter    = new HttpAdapter($authConfig['config']);
		$basicResolver  = new FileResolver();
		$digestResolver = new FileResolver();

		$basicResolver->setFile($authConfig['basic_passwd_file']);
		$digestResolver->setFile($authConfig['digest_passwd_file']);
		$authAdapter->setBasicResolver($basicResolver);
		$authAdapter->setDigestResolver($digestResolver);

		return $authAdapter;
	}
}