<?php

class modSociety{
    
    protected $debug = true;
    
    public $modx;
    
    public $config;


    function __construct(modX &$modx, $params= array ()) {
        $this->modx= & $modx;
        
        $this->getConfig();
    }
    
    public function getDebug(){
        return (bool)$this->debug;
    }


    protected function getCorePath(){
        return dirname(dirname(dirname(__FILE__))).'/';
    }

    protected function getConfig(){
        $core_path = $this->getCorePath();
        $processors_path = $core_path."processors/";
        $this->config = array(
            'core_path' => $core_path,
            'processors_path'   => $processors_path,
        );
    }

    public function runProcessor($action = '', $scriptProperties = array(), $options = array()){
        $options = array_merge($options, array(
            'processors_path'   => $this->config['processors_path'],
        ));
        return $this->modx->runProcessor($action, $scriptProperties, $options);
    }
    
    
    /*
     * return instance of SocietyBlog
     */
    public function getBlog($criteria= null, $cacheFlag= true){
        return $this->getObject('SocietyBlog', $criteria, $cacheFlag);
    }
    
    
    /*
     * return collection of SocietyBlog instance
     */
    public function getBlogs($criteria= null, $cacheFlag= true){
        return $this->getCollection('SocietyBlog', $criteria, $cacheFlag);
    }    
    
    /*
     * return instance of SocietyBlog
     */
    public function getTopic($criteria= null, $cacheFlag= true){
        return $this->getObject('SocietyTopic', $criteria, $cacheFlag);
    }
    
    
    /*
     * return collection of SocietyBlog instance
     */
    public function getTopics($criteria= null, $cacheFlag= true){
        return $this->getCollection('SocietyTopic', $criteria, $cacheFlag);
    }    
    
    
    
    
    /*
     * return collection
     */
    
    public function getObject($className, $criteria= null, $cacheFlag= true) {
        $instance= null;
        if ($criteria !== null) {
            $instance = $this->_load($className, $criteria, $cacheFlag);
        }
        return $instance;
    }
    
    
    /*
     * load instance of object
     */
    protected function _load($className, $criteria, $cacheFlag= true) {
        $xpdo = & $this->modx;
        $instance= null;
        $fromCache= false;
        if ($className= $xpdo->loadClass($className)) {
            if (!is_object($criteria)) {
                $criteria= $xpdo->getCriteria($className, $criteria, $cacheFlag);
            }
            if (is_object($criteria)) {
                if (!$criteria = $this->addDerivativeCriteria($className, $criteria)){
                    return $instance;
                }
                $row= null;
                if ($xpdo->_cacheEnabled && $criteria->cacheFlag && $cacheFlag) {
                    $row= $xpdo->fromCache($criteria, $className);
                }
                if ($row === null || !is_array($row)) {
                    if ($rows= xPDOObject :: _loadRows($xpdo, $className, $criteria)) {
                        $row= $rows->fetch(PDO::FETCH_ASSOC);
                        $rows->closeCursor();
                    }
                } else {
                    $fromCache= true;
                }
                if (!is_array($row)) {
                    if ($xpdo->getDebug() === true) $xpdo->log(xPDO::LOG_LEVEL_DEBUG, "Fetched empty result set from statement: " . print_r($criteria->sql, true) . " with bindings: " . print_r($criteria->bindings, true));
                } else {
                    $instance= xPDOObject :: _loadInstance($xpdo, $className, $criteria, $row);
                    if (is_object($instance)) {
                        if (!$fromCache && $cacheFlag && $xpdo->_cacheEnabled) {
                            $xpdo->toCache($criteria, $instance, $cacheFlag);
                            if ($xpdo->getOption(xPDO::OPT_CACHE_DB_OBJECTS_BY_PK) && ($cacheKey= $instance->getPrimaryKey()) && !$instance->isLazy()) {
                                $pkCriteria = $xpdo->newQuery($className, $cacheKey, $cacheFlag);
                                $xpdo->toCache($pkCriteria, $instance, $cacheFlag);
                            }
                        }
                        if ($xpdo->getDebug() === true) $xpdo->log(xPDO::LOG_LEVEL_DEBUG, "Loaded object instance: " . print_r($instance->toArray('', true), true));
                    }
                }
            } else {
                $xpdo->log(xPDO::LOG_LEVEL_ERROR, 'No valid statement could be found in or generated from the given criteria.');
            }
        } else {
            $xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Invalid class specified: ' . $className);
        }
        return $instance;
    }
    
    
    /*
     * return collection of objects
     */
    public function getCollection($className, $criteria= null, $cacheFlag= true){
        return $this->_loadCollection($className, $criteria, $cacheFlag);
    }
    
    
    /*
     * 
     */
    protected function _loadCollection($className, $criteria= null, $cacheFlag= true) {
        $xpdo = & $this->modx;
        $objCollection= array ();
        $fromCache = false;
        if (!$className= $xpdo->loadClass($className)) return $objCollection;
        $rows= false;
        $fromCache= false;
        $collectionCaching = (integer) $xpdo->getOption(xPDO::OPT_CACHE_DB_COLLECTIONS, array(), 1);
        if (!is_object($criteria)) {
            $criteria= $xpdo->getCriteria($className, $criteria, $cacheFlag);
        }
        
        if (!is_object($criteria) || !$criteria = $this->addDerivativeCriteria($className, $criteria)) {
            return $objCollection;
        }
        if ($collectionCaching > 0 && $xpdo->_cacheEnabled && $cacheFlag) {
            $rows= $xpdo->fromCache($criteria);
            $fromCache = (is_array($rows) && !empty($rows));
        }
        if (!$fromCache && is_object($criteria)) {
            $rows= xPDOObject :: _loadRows($xpdo, $className, $criteria);
        }
        if (is_array ($rows)) {
            foreach ($rows as $row) {
                xPDOObject :: _loadCollectionInstance($xpdo, $objCollection, $className, $criteria, $row, $fromCache, $cacheFlag);
            }
        } elseif (is_object($rows)) {
            $cacheRows = array();
            while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
                xPDOObject :: _loadCollectionInstance($xpdo, $objCollection, $className, $criteria, $row, $fromCache, $cacheFlag);
                if ($collectionCaching > 0 && $xpdo->_cacheEnabled && $cacheFlag && !$fromCache) $cacheRows[] = $row;
            }
            if ($collectionCaching > 0 && $xpdo->_cacheEnabled && $cacheFlag && !$fromCache) $rows =& $cacheRows;
        }
        if (!$fromCache && $xpdo->_cacheEnabled && $collectionCaching > 0 && $cacheFlag && !empty($rows)) {
            $xpdo->toCache($criteria, $rows, $cacheFlag);
        }
        return $objCollection;
    }
    
    
    /*
     * Add actual class_key for criteria
     */
    public function addDerivativeCriteria($className, $criteria) {
        if ($criteria instanceof xPDOQuery) {
            switch($className){
                case 'SocietyBlog':
                case 'SocietyTopic':
                    break;
                default: 
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, "Wrong className '{$className}'");
                    return false;
            }
        }
        else{
            return null;
        }
        
        $criteria->where(array('class_key' => $className));
        $this->log(xPDO::LOG_LEVEL_DEBUG, "#1: Automatically adding class_key criteria for derivative query of class {$className}");

        return $criteria;
    }
    
    
    /*
     * log
     */
    public function log($level, $msg){
        if(!$this->getDebug()){return;}
        $this->modx->setLogLevel('HTML');
        $this->modx->log($level, $msg);
    }
    
    
    /*
     * sendErrorPage
     */
    public function sendErrorPage($options = null){
        $this->modx->sendForward($this->modx->getOption('error_page', $options, '404'), $options);
    }
    
    
    /*
     * Forward
     */
    public function prepareResponse($options = array()) {
        if(!isset($this->modx->resource) || !is_object($this->modx->resource)){
            $this->sendErrorPage();
            return false;
        }
        $this->modx->request->prepareResponse($options);
        exit();
    }
}
?>
