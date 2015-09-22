<?php
defined('BASEPATH') OR exit('No direct access script allowed');

class MY_Migration extends CI_Migration{

    const MIGRATION_ACTIONTYPE = 0;
    const MIGRATION_TABLENAME = 1;

    private static $tableName = false;
    private static $actionType = false;
    private static $counterItem = 0;
    private static $startVersion = 0;

    private $keys = [];

    function __construct($config = []){
        parent::__construct($config);
    }

    function start(){
        d("-------------------------------------------");
        d(" start migration");
        d("-------------------------------------------");
        d();
        self::$startVersion = $this->_get_version();
    }

    function end(){
        $finishVersion = $this->_get_version();
        if(self::$counterItem != 0){
            d();
            if(($finishVersion - self::$startVersion) !== self::$counterItem){
                d(" ~ there is something wrong with the counter");
            }else{
                $counter = abs(self::$counterItem);
                $direction = "upgraded";
                if(self::$counterItem < 0){
                    $direction = "downgraded";
                }
                d(" ~ $direction $counter items . . .");
            }
        }else{
            d(" ~ nothing was executed");
        }
        d();
        d("-------------------------------------------");
        d(" finish migration");
        d("-------------------------------------------");
    }

    public function version($target_version){
        $this->start();
        parent::version($target_version);
        $this->end();
    }

    protected function _get_migration_name($migration){
        $name = parent::_get_migration_name($migration);
        $this->parseName($name);
        return $name;
    }

    private static function actionType($value = false){
        if($value){
            self::$actionType = $value;
        }
        return self::$actionType;
    }

    private static function tableName($value = false){
        if($value){
            self::$tableName = $value;
        }
        return self::$tableName;
    }

    public function up(){
        $this->migrate('Up');
        self::$counterItem++;
    }

    public function down(){
        $this->migrate('Down');
        self::$counterItem--;
    }

    function migrate($direction){
        $method = self::actionType().$direction;
        $this->$method();
    }

    function compile_fields(){
        if(
            method_exists($this, 'fields')
            AND
            !empty($this->fields())
        ){
            $fields = $this->fields();
            foreach ($fields as $key => &$value) {
                if(array_key_exists('keys', $value)){
                    if($value['keys']){
                        array_push($this->keys, $key);
                        unset($value['keys']);
                    }
                }
            }
            return $fields;
        }
        return false;
    }

    function parseName($name){
        $items = explode('_', $name, 2);
        try {
            self::actionType($items[self::MIGRATION_ACTIONTYPE]);
            self::tableName($items[self::MIGRATION_TABLENAME]);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    function createUp(){
        $fields = $this->compile_fields();
        $this->dbforge->add_field('id');
        if($fields){
            $this->dbforge->add_field($fields);
        }
        if($this->keys){
            foreach ($this->keys as $k => $v) {
                $this->dbforge->add_key($v);
            }
        }
        $this->dbforge->create_table(self::tableName());
        d(" > table [".self::tableName()."] created");
    }

    function createDown(){
        $this->dbforge->drop_table(self::tableName());
        d(" > table [".self::tableName()."] dropped");
    }

}