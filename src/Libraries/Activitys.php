<?php

namespace Btw\Core\Libraries;

use Btw\Core\Config\Activitys as ActivitysConfig;
use Btw\Core\Models\ActivityModel;

// CLASS
class Activitys
{
    /**
     * Our configuration instance.
     *
     * @var ActivitysConfig
     */
    protected $config;

    /**
     * Audit rows waiting to add to the database.
     *
     * @var array
     */
    protected $queue = [];

    /**
     * Store the configuration
     *
     * @param ActivitysConfig $config The Activitys configuration to use
     */
    public function __construct(ActivitysConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Checks the session for a logged in user based on config
     *
     * @return int The current user ID, 0 for "not logged in", -1 for CLI
     *
     * @deprecated This will be removed in the next major release; use codeigniter4/authentication-implementation
     */
    public function sessionUserId(): int
    {
        if (is_cli()) {
            return 0;
        }

        return session($this->config->sessionUserId) ?? 0;
    }

    /**
     * Return the current queue (mostly for testing)
     */
    public function getQueue(): array
    {
        return $this->queue;
    }

    /**
     * Add an audit row to the queue
     *
     * @param array|null $audit The row to cache for insert
     */
    public function add(?array $audit = null)
    {
        if (empty($audit)) {
            return false;
        }

        // Add common data
        $audit['user_id'] = Auth()->User()->id ?? null;
        $audit['created_at'] = date('Y-m-d H:i:s');

        $this->queue[] = $audit;
    }

    /**
     * Batch insert all audits from the queue
     *
     * @return $this
     */
    public function save(): self
    {
        $audits = new ActivityModel();
        // Look in Admin
        $current = (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token');
        if (in_array((string) $current, [ADMIN_AREA])) {
            if (!preg_match('/(logs|sessions|visits|activity_log|css|js)/i', uri_string())) {
                $audits->insert([
                    'event_type' => 'access',
                    'event_access' => uri_string(),
                    'event_method' => request()->getMethod(),
                    'properties' => json_encode([
                        'host' => site_url('/', false),
                        'path' => uri_string(true),
                        'query' => request()->getUri()->getQuery(),
                        'ip' => request()->getIPAddress(),
                        'platform' => request()->getUserAgent()->getPlatform(),
                        'browser' => request()->getUserAgent()->getBrowser(),
                        'is_mobile' => request()->getUserAgent()->isMobile(),
                    ]),
                    'source_id' => 0,
                    'source' => service('router')->controllerName(),
                    'event' => 'access',
                    'summary' => 0,
                    'user_id' => Auth()->User()->id ?? null,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        if (!empty($this->queue)) {

            $audits->insertBatch($this->queue);
        }

        return $this;
    }
}
