<?php return [
        'comments' => ["","","the name of the task to be performed.","0:active 1:passive","0:notDeleted 1:deleted","","","","","",""],
        'columns' => ["id","item_code","name","status","is_deleted","created_by","updated_by","deleted_by","deleted_at","created_at","updated_at"],
        'indexes' => ["id","item_code","status","is_deleted"],
        'types' => ["integer","integer","string","integer","integer","integer","integer","integer","timestamp","timestamp","timestamp"],
        'required_columns' => ["name"],
        'max_length_columns' => ["name"],
        'max_length_values' => ["255"],
        'boolean_values' => ["status","is_deleted"],
        'default_keys' => ["item_code","status","is_deleted","created_by","updated_by","deleted_by"],
        'default_values' => ["0","1","0","0","0","0"],
        'enum_columns' => [],
        'enum_values' => [],
        ];