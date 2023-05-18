<?php

namespace Btw\Core\Traits;

use Btw\Core\Models\ActivityModel;

// CLASS
trait ActivitysTrait
{
    /**
     * Takes an array of model $returnTypes
     * and returns an array of Activity,
     * arranged by object and event.
     * Optionally filter by $events
     * (string or array of strings).
     *
     * @param array|string|null $events
     *
     * @internal Due to a typo this function has never worked in a released version.
     *           It will be refactored soon without announcing a new major release
     *           so do not build on the signature or functionality.
     */
    public function getActivity(array $objects, $events = null): array
    {
        if (empty($objects)) {
            return [];
        }

        // Get the primary keys from the objects
        $objectIds = array_column($objects, $this->primaryKey);

        // Start the query
        $query = model(AuditModel::class)->builder()->where('source', $this->table)->whereIn('source_id', $objectIds);

        if (is_string($events)) {
            $query = $query->where('event', $events);
        } elseif (is_array($events)) {
            $query = $query->whereIn('event', $events);
        }

        // Index by objectId, event
        $array = [];
        // @phpstan-ignore-next-line
        while ($activity = $query->getUnbufferedRow()) {
            if (empty($array[$activity->{$this->primaryKey}])) {
                $array[$activity->{$this->primaryKey}] = [];
            }
            if (empty($array[$activity->{$this->primaryKey}][$activity->event])) {
                $array[$activity->{$this->primaryKey}][$activity->event] = [];
            }

            $array[$activity->{$this->primaryKey}][$activity->event][] = $activity;
        }

        return $array;
    }

    // record successful insert events
    protected function activityInsert(array $data)
    {
        if (!$data['result']) {
            return false;
        }
        $query = db_connect()->getLastQuery()->getQuery();

        if (!preg_match('/(logs|sessions|visits|activity_log)/i', $query)) {
            $data['query'] = [
                'type' => 'query',
                'method' => 'update',
                'query' => $query,
            ];
        }

        $activity = [
            'event_type' => 'query',
            'event_access' => uri_string(),
            'event_method' => request()->getMethod(),
            'source' => '\\' . get_class($this),
            'source_id' => $this->db->insertID(),
            // @phpstan-ignore-line
            'event' => 'insert',
            'summary' => count($data['data']) . ' fields',
            'properties' => json_encode($data),
        ];
        service('activitys')->add($activity);

        return $data;
    }

    // record successful update events
    protected function activityUpdate(array $data)
    {
        foreach ($data['id'] as $sourceId) {
            $data['query'] = db_connect()->getLastQuery()->getQuery();

            if (!preg_match('/(logs|sessions|visits|activity_log)/i', $data['query'])) {
                $data['query'] = [
                    'type' => 'query',
                    'method' => 'update',
                    'query' => $data['query'],
                ];
            }

            $activity = [
                'event_type' => 'query',
                'event_access' => uri_string(),
                'event_method' => request()->getMethod(),
                'source' => '\\' .get_class($this),
                'source_id' => $sourceId,
                'event' => 'update',
                'summary' => count($data['data']) . ' fields',
                'properties' => json_encode($data),
            ];
            service('activitys')->add($activity);
        }

        return $data;
    }

    // record successful delete events
    protected function activityDelete(array $data)
    {
        if (!$data['result']) {
            return false;
        }
        if (empty($data['id'])) {
            return false;
        }

        $activity = [
            'source' => get_class($this),
            'event' => 'delete',
            'summary' => ($data['purge']) ? 'purge' : 'soft',
            'properties' => json_encode($data),
        ];

        // add an entry for each ID
        $activitys = service('activitys');

        foreach ($data['id'] as $id) {
            $activity['source_id'] = $id;
            $activitys->add($activity);
        }

        return $data;
    }
}