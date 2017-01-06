<?php


namespace Cake\ElasticSearch\TestSuite\Fixture;


use Cake\TestSuite\Fixture\FixtureManager;

class ElasticFixtureManager extends FixtureManager
{

    protected function _loadFixtures($test)
    {
        parent::_loadFixtures($test);

        $createIndex = function ($db, $fixtures) {

            $index = $db->getIndex();
            if (!$index->exists()) {
                $index->create();
            }
        };
        $this->_runOperation($test->fixtures, $createIndex);
    }

    public function shutdown()
    {
        parent::shutDown();

        // Now drop the index
        $deleteIndex = function ($db, $fixtures) {

            $index = $db->getIndex();
            if ($index->exists()) {
                $index->delete();
            }
        };
        $this->_runOperation(array_keys($this->_loaded), $deleteIndex);


    }
}