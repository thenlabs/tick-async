<?php
declare(strict_types=1);

namespace ThenLabs\TickTask;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class TickTask
{
    /**
     * @var boolean
     */
    protected $started = false;

    /**
     * @var boolean
     */
    protected $completed = false;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var mixed
     */
    protected $result;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;

        $this->_tickHandler = function () {
            if ($this->completed) {
                return;
            }

            call_user_func($this->callback, $this);
        };
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function isStarted(): bool
    {
        return $this->started;
    }

    public function start(): void
    {
        $this->started = true;

        register_tick_function($this->_tickHandler);
    }

    public function terminate($result = null): void
    {
        $this->started = false;
        $this->completed = true;
        $this->result = $result;

        /**
         * It's not possible call to "unregister_tick_function($this->_tickHandler)" because that
         * cause the error "Unable to delete tick function executed at the moment.".
         *
         * The alternative consists in to use another tick which do it.
         */

         // register the auxiliar tick handler.
        register_tick_function($auxTickHandler = function () {
            unregister_tick_function($this->_tickHandler);
        });

        $aux = null; // invoke the recently auxiliar tick handler.

        // unregister the auxiliar tick handler.
        unregister_tick_function($auxTickHandler);
    }

    public function getResult()
    {
        return $this->result;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }
}