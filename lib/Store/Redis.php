<?php
class sspmod_redis_Store_Redis extends SimpleSAML_Store
{
    protected function __construct()
    {
        $config      = SimpleSAML_Configuration::getConfig('module_redis.php');
        $host        = $config->getString('host', 'localhost');
        $this->redis = new Predis\Client($host);
        $this->lifeTime = $globalConfig->getInteger('session.duration', 28800); // Default 8 hours
    }

    /**
     * Retrieve a value from Redis
     *
     * @param string $type The datatype
     * @param string $key  The key
     * @return mixed|NULL  The value
     */
    public function get($type, $key)
    {
        $redisKey = "simpleSAMLphp.$type.$key";
        $value = $this->redis->get($redisKey);

        return unserialize($value);
    }

    /**
     * Save a value to Redis
     *
     * If no expiration time is given, then the expiration time is set to the
     * session duration.
     *
     * @param string $type     The datatype
     * @param string $key      The key
     * @param mixed $value     The value
     * @param int|NULL $expire The expiration time (unix timestamp), or NULL if it never expires
     */
    public function set($type, $key, $value, $expire = null)
    {
        $redisKey = "simpleSAMLphp.$type.$key";
        $this->redis->set($redisKey, serialize($value));

        if (is_null($expire)) {
            $expire = $this->lifeTime;
        }
        $this->redis->expire($redisKey, $expire);
    }

    /**
     * Delete a value from Redis
     *
     * @param string $type The datatype
     * @param string $key  The key
     */
    public function delete($type, $key)
    {
        $redisKey = "simpleSAMLphp.$type.$key";
        $this->redis->del($redisKey);
    }
}