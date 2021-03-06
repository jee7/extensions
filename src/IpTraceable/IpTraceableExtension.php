<?php

namespace LaravelDoctrine\Extensions\IpTraceable;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\IpTraceable\IpTraceableListener;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Extensions\Extension;

class IpTraceableExtension implements Extension
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param EventManager           $manager
     * @param EntityManagerInterface $em
     * @param Reader                 $reader
     */
    public function addSubscribers(EventManager $manager, EntityManagerInterface $em, Reader $reader = null)
    {
        $subscriber = new IpTraceableListener();
        $subscriber->setAnnotationReader($reader);
        $subscriber->setIpValue($this->request->getClientIp());
        $manager->addEventSubscriber($subscriber);
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [];
    }
}
