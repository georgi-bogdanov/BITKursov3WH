<?php

class Myvalidation extends \Validation
{

    public static function _validation_unique($val, $options)
    {
        Validation::active()->set_message('unique', 'The field :label must be unique, but :value has already been used.');
        list($table, $field) = explode('.', $options);

        $result = DB::select("\"$field\"")
                        ->where($field, '=', Str::lower($val))
                        ->from($table)->execute();

        return !($result->count() > 0);
    }

}

/* EOF */