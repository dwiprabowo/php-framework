<?php
defined('BASEPATH') OR exit('No direct access script allowed');

class MY_Migration extends CI_Migration{

    const MIGRATION_ACTIONTYPE = 0;
    const MIGRATION_TABLENAME = 1;

    private static $tableName = false;
    private static $actionType = false;

    function __construct($config = []){
        parent::__construct($config);
    }

    protected function _get_migration_name($migration){
        d($migration);
        $name = parent::_get_migration_name($migration);
        $this->parseName($name);
        return $name;
    }

    public static function actionType($value = false){
        if($value){
            self::$actionType = $value;
        }
        return self::$actionType;
    }

    public static function tableName($value = false){
        if($value){
            self::$tableName = $value;
        }
        return self::$tableName;
    }

    public function up(){
        $this->migrate('Up');
    }

    public function down(){
        $this->migrate('Down');
    }

    function migrate($direction){
        $method = self::actionType().$direction;
        $this->$method();
    }

    function parseName($name){
        $items = explode('_', $name);
        try {
            self::actionType($items[self::MIGRATION_ACTIONTYPE]);
            self::tableName($items[self::MIGRATION_TABLENAME]);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    function addUp($fields = false){
        $this->dbforge->add_field('id');
        if($fields){
            $this->dbforge->add_field($fields);
        }
        $this->dbforge->create_table(self::tableName());
    }

    function addDown(){
        $this->dbforge->drop_table(self::tableName());
    }

}