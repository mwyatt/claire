<?php

namespace OriginalAppName;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Model extends \OriginalAppName\Data
{


    /**
     * the table being read
     * @var string
     */
    public $tableName;


    /**
     * comprehensive list of database fields for use when building queries
     * @var array
     */
    public $fields = [];


    /**
     * used to reduce fields to writable ones
     * for update, create
     * @var array
     */
    public $fieldsNonWriteable = [
        'id'
    ];


    /**
     * after creating a row in the database, the insert id is appended
     * @var array
     */
    public $lastInsertIds;


    /**
     * inject dependencies
     */
    public function __construct($database = null)
    {

        // already added
        if ($database) {
            return $this->setDatabase($database);
        }
        $registry = \OriginalAppName\Registry::getInstance();
        $pathStart = SITE_PATH;

        // if not in registry connect + create
        if (! $database = $registry->get('database')) {
            $database = new \OriginalAppName\Database(include $pathStart . 'credentials' . EXT);
            $registry->set('database', $database);
        }
        $this->setDatabase($database);
    }


    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    
    /**
     * @param string $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }


    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    
    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }


    /**
     * global read for ids
     * extend this if more detail required
     * @param  array $ids
     * @return object
     */
    public function readId($ids, $column = 'id')
    {

        // query
        $sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where {$column} = :id
		");

        $entity = $this->getEntity();

        // mode
        $sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

        // loop prepared statement
        foreach ($ids as $id) {
            $sth->bindValue(':id', $id, \PDO::PARAM_INT);
            $sth->execute();
            while ($result = $sth->fetch()) {
                $this->appendData($result);
            }
        }

        // instance
        return $this;
    }


    /**
     * reads where column == value
     * @param  string $column table column
     * @param  any $value  to match
     * @return object
     */
    public function readColumn($column, $value)
    {

        // query
        $sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where {$column} = :value
		");

        // mode
        $sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        $this->bindValue($sth, ':value', $value);
        $sth->execute();
        $this->setData($sth->fetchAll());

        // instance
        return $this;
    }


    /**
     * @param  array $entities
     * @return array    of insert ids
     */
    public function create(Array $entities)
    {

        // statement
        $statement = [];
        $lastInsertIds = [];
        $statement[] = 'insert into';
        $statement[] = $this->getTableName();
        $statement[] = '(' . $this->getSqlFieldsWriteable() . ')';
        $statement[] = 'values';
        $statement[] = '(' . $this->getSqlPositionalPlaceholdersWriteable() . ')';

        // prepare
        $sth = $this->database->dbh->prepare(implode(' ', $statement));

        // execute
        foreach ($entities as $entity) {
            $sth->execute($this->getSthExecutePositionalWriteable($entity));
            if ($sth->rowCount()) {
                $lastInsertIds[] = intval($this->database->dbh->lastInsertId());
            }
        }

        // return
        $this->setLastInsertIds($lastInsertIds);
        return $this;
    }


    /**
     * reads everything
     * @return object
     */
    public function read()
    {

        // query
        $sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
	        where id != 0
		");

        // mode
        $sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

        // execute
        $sth->execute();

        // fetch
        $this->setData($sth->fetchAll());

        // instance
        return $this;
    }


    /**
     * uses the passed properties to build named prepared statement
     * maintiaining this: public function update($mold, $where = [])
     * @todo how to return a value which can mark success?
     * @param  array  $molds
     * @param  string $by    defines the column to update by
     * @return int
     */
    public function update(Array $entities, $column = 'id')
    {
        $updatedCount = 0;

        // statement
        $statement = [];
        $statement[] = 'update';
        $statement[] = $this->getTableName();
        $statement[] = 'set';

        // must be writable columns
        $named = [];
        foreach ($this->getFields() as $field) {
            if (in_array($field, $this->fieldsNonWriteable)) {
                continue;
            }
            $named[] = $field . ' = :' . $field;
        }
        $statement[] = implode(', ', $named);
        $statement[] = "where $column = :column";

        // prepare
        $sth = $this->database->dbh->prepare(implode(' ', $statement));

        // execute
        foreach ($entities as $entity) {
            foreach ($this->getSthExecuteNamedWriteable($entity) as $key => $value) {
                $this->bindValue($sth, $key, $value);
            }
            $this->bindValue($sth, 'column', $entity->$column);
            $sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
            $sth->execute();
            $updatedCount += $sth->rowCount();
        }
        $this->setRowCount($updatedCount);
        return $this;
    }


    /**
     * polyfill
     * either finds out that they are ids and converts them to
     * basic objects with property of id
     * or just passes back the entities
     * @param  array $entities
     * @return array
     */
    public function deleteTranslate(Array $entities)
    {
        $entity = current($entities);
        if (is_object($entity)) {
            return $entities;
        }
        $ids = $entities;
        $entities = [];
        foreach ($ids as $id) {
            $entities[] = (object) ['id' => $id];
        }
        return $entities;
    }


    /**
     * uses where property to build delete statement
     * improved to allow entities to be passed
     * @param  array  $properties
     * @return int
     */
    public function delete(Array $entities, $column = 'id')
    {

        // build
        $rowCount = 0;
        $statement = [];
        $statement[] = 'delete from';
        $statement[] = $this->getTableName();
        $statement[] = "where $column = ?";

        // prepare
        $sth = $this->database->dbh->prepare(implode(' ', $statement));

        // bind
        foreach ($entities as $entity) {
            $this->bindValue($sth, 1, $entity->$column);
            $sth->execute();
            $rowCount += $sth->rowCount();
        }

        // return
        $this->setRowCount($rowCount);
        return $this;
    }


    /**
     * builds a generic select statement and returns
     * select (column, column) from (table_name)
     * @return string
     */
    public function getSqlSelect()
    {
        $statement = [];
        $statement[] = 'select';
        $statement[] = $this->getSqlFields();
        $statement[] = 'from';
        $statement[] = $this->getTableName();
        return implode(' ', $statement);
    }


    /**
     * implodes list of sql fields
     * column, column, column
     * @return string
     */
    public function getSqlFields()
    {
        return implode(', ', $this->fields);
    }


    /**
     * implodes list of sql fields excluding fields like 'id'
     * column, column, column
     * @return string
     */
    public function getSqlFieldsWriteable($append = '')
    {
        $writeable = [];
        foreach ($this->fields as $field) {
            if (in_array($field, $this->fieldsNonWriteable)) {
                continue;
            }
            $writeable[] = '`' . $field . '`' . $append;
        }
        return implode(', ', $writeable);
    }


    /**
     * @return string ?, ?, ? of all fields
     */
    public function getSqlPositionalPlaceholders()
    {
        $placeholders = [];
        foreach ($this->fields as $field) {
            $placeholders[] = '?';
        }
        return implode(', ', $placeholders);
    }


    /**
     * @return string ?, ?, ? of all writable fields
     */
    public function getSqlPositionalPlaceholdersWriteable()
    {
        $placeholders = [];
        foreach ($this->fields as $field) {
            if (in_array($field, $this->fieldsNonWriteable)) {
                continue;
            }
            $placeholders[] = '?';
        }
        return implode(', ', $placeholders);
    }


    public function isFieldNonWriteable($field)
    {
        return in_array($field, $this->fieldsNonWriteable);
    }


    /**
     * uses a entity to build sth execute data
     * if 'time' involved assume that time needs to be inserted, could be
     * a bad idea
     * @param  object $entity instance of entity
     * @return array
     */
    public function getSthExecutePositional($entity)
    {
        $excecuteData = [];
        foreach ($this->fields as $field) {
            $excecuteData[] = $entity->$field;
        }
        return $excecuteData;
    }


    /**
     * uses a entity to build sth execute data
     * if 'time' involved assume that time needs to be inserted, could be
     * a bad idea
     * @param  object $entity instance of entity
     * @return array
     */
    public function getSthExecutePositionalWriteable($entity)
    {
        $excecuteData = [];
        foreach ($this->fields as $field) {
            if ($this->isFieldNonWriteable($field)) {
                continue;
            }
            $excecuteData[] = $entity->$field;
        }
        return $excecuteData;
    }


    public function getSthExecuteNamedWriteable($mold)
    {
        $excecuteData = [];
        foreach ($this->getFields() as $field) {
            if ($this->isFieldNonWriteable($field)) {
                continue;
            }
            $excecuteData[':' . $field] = $mold->$field;
        }
        return $excecuteData;
    }


    public function getSthExecuteNamed($mold)
    {
        $excecuteData = [];
        foreach ($this->getFields() as $field) {
            $excecuteData[':' . $field] = $mold->$field;
        }
        return $excecuteData;
    }


    /**
     * builds sql where string using and
     * @param  array  $where accepts ('column' => 'value') format
     * @return string
     */
    public function getSqlWhere($where = [])
    {
        $statement = [];
        foreach ($where as $key => $value) {
            $statement[] = ($statement ? 'and' : 'where');

            // array becomes in (1, 2, 3)
            if (is_array($value)) {
                $statement[] = $key . ' in (' . implode(', ', $value) . ')';
                continue;
            }

            // normal key = val
            $statement[] = $key . ' = :where' . ucfirst($key);
        }
        return implode(' ', $statement);
    }


    /**
     * builds sql limit using array
     * @param  array  $limit accepts ('key' => 'value', 'key' => 'value')
     * @return string
     */
    public function getSqlLimit($limit = [])
    {
        $statement = [];
        $limits = [];
        $statement[] = 'limit';
        foreach ($limit as $key => $value) {
            $limits[] = ':limit_' . $key;
        }
        $statement[] = implode(', ', $limits);
        return implode(' ', $statement);
    }


    /**
     * @return string
     */
    public function getTableName()
    {
        if ($this->tableName) {
            return $this->tableName;
        }
    }
    
    
    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }


    /**
     * binds values with unnamed placeholders, 1 2 3 instead of 0 1 2
     * @param  object $sth    the statement to bind to
     * @param  array $values basic array with values
     * @return bool | null         returns false if something goes wrong
     */
    public function bindValues($sth, $values)
    {
        if (! is_object($sth) || ! ($sth instanceof PDOStatement)) {
            return;
        }
        foreach ($values as $key => $value) {
            $correctedKey = $key + 1;
            $this->bindValue($sth, $correctedKey, $value);
        }
    }


    /**
     * binds a single value and guesses the type
     * @param  object $sth
     * @param  int|string $key
     * @param  all $value
     */
    public function bindValue($sth, $key, $value)
    {
        if (is_int($value)) {
            $sth->bindValue($key, $value, \PDO::PARAM_INT);
        } elseif (is_bool($value)) {
            $sth->bindValue($key, $value, \PDO::PARAM_BOOL);
        } elseif (is_null($value)) {
            $sth->bindValue($key, $value, \PDO::PARAM_NULL);
        } elseif (is_string($value)) {
            $sth->bindValue($key, $value, \PDO::PARAM_STR);
        }
    }


    /**
     * attempts to execute, if problem found error code is shown
     * @param  object $sth
     * @param  string $errorCode
     * @return object
     */
    public function tryExecute($errorCode, $sth, $sthData = [])
    {
        try {
            if ($sthData) {
                $sth->execute($sthData);
            } else {
                $sth->execute();
            }
        } catch (Exception $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
            exit;
            
            echo '<pre>';
            print_r($sthData);
            echo '</pre>';
            exit('error trying to execute statement');
            // $this->config->getObject('error')->handle('database', $errorCode, 'model.php', 'na');
            return false;
        }
        return $sth;
    }


    /**
     * @return array
     */
    public function getLastInsertIds()
    {
        return $this->lastInsertIds;
    }
    
    
    /**
     * @param array $lastInsertIds
     */
    public function setLastInsertIds($lastInsertIds)
    {
        $this->lastInsertIds = $lastInsertIds;
        return $this;
    }


    /**
     * @return int
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }
    
    
    /**
     * @param int $rowCount
     */
    public function setRowCount($rowCount)
    {
        $this->rowCount = $rowCount;
        return $this;
    }
}
