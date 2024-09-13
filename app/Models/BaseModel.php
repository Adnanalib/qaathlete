<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setNumberAttributeValue($name, $value)
    {
        if ($value != null && $value != 'null' && $value != 'undefined') {
            $this->attributes[$name] = (string)$value;
        }
        return $this;
    }
    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setAttributeValue($name, $value)
    {
        if ((!empty($value)) && $value !== 'undefined') {
            $this->attributes[$name] = $value;
        }
        return $this;
    }
    public function findBy($key, $value)
    {
        return $this->where($key, $value)->latest()->first();
    }
    public function scopeSaveOrUpdate($query, $object, $request)
    {
        $columns = Schema::getColumnListing($query->from);
        if (count($columns) > 0) {
            unset($columns['id'], $columns['created_at'], $columns['updated_at']);
            foreach ($columns as $key => $column) {
                $object->setAttributeValue($column, $request->input($column));
            }
            $object->save();
        }
        return $object;
    }
    public static function getTableName()
    {
        $className = get_called_class();
        $model = new $className;
        return $model->getTable();
    }
}
