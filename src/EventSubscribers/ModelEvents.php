<?php
declare(strict_types=1);


namespace Cratia\Rest\EventSubscribers;


use Cratia\ORM\Model\Events\Events;
use Cratia\Rest\Dependencies\DebugBag;
use Cratia\Rest\Dependencies\ErrorBag;
use Doctrine\Common\EventSubscriber;
use stdClass;

/**
 * Class ActiveRecord
 * @package Cratia\Rest\EventSubscribers
 */
class ModelEvents implements EventSubscriber
{
    /**
     * @var DebugBag
     */
    private $debugBag;

    /**
     * @var ErrorBag
     */
    private $errorBag;

    /**
     * EventSubscriberAdapter constructor.
     * @param DebugBag $debugBag
     * @param ErrorBag $errorBag
     */
    public function __construct(DebugBag $debugBag, ErrorBag $errorBag)
    {
        $this->debugBag = $debugBag;
        $this->errorBag = $errorBag;
    }

    public function __call($name, $arguments)
    {
        $attach = new stdClass();
        $attach->event = $name;
        $attach->payload = $arguments;
        $this->debugBag->attach($attach);
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return
            [
                Events::ON_MODEL_CREATED,
                Events::ON_MODEL_UPDATED,
                Events::ON_MODEL_DELETED,
                Events::ON_MODEL_LOADED,
                Events::ON_MODEL_READ,
            ];
    }
}