<?php
class Validator {
    private $errors = [];

    public function required($field, $value, $fieldName = null) {
        if (empty(trim($value))) {
            $name = $fieldName ?? $field;
            $this->errors[$field] = "The {$name} field is required.";
        }
        return $this;
    }

    public function email($field, $value) {
        if (!empty(trim($value)) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Please enter a valid email address.";
        }
        return $this;
    }

    public function minLength($field, $value, $length, $fieldName = null) {
        if (!empty(trim($value)) && strlen($value) < $length) {
            $name = $fieldName ?? $field;
            $this->errors[$field] = "The {$name} must be at least {$length} characters.";
        }
        return $this;
    }

    public function match($field, $value, $matchField, $matchValue, $fieldName = null) {
        if ($value !== $matchValue) {
            $name = $fieldName ?? $field;
            $this->errors[$field] = "The {$name} does not match.";
        }
        return $this;
    }

    public function unique($field, $value, $table, $column, $fieldName = null) {
        if (empty(trim($value))) return $this;
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = :val");
        $stmt->execute(['val' => $value]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $name = $fieldName ?? $field;
            $this->errors[$field] = "This {$name} is already taken.";
        }
        return $this;
    }

    public function fails() {
        return !empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }
}
