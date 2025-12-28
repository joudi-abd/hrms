<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait Translatable
{
    
    // Get the translatable attributes for the model.
     
    abstract public function getTranslatableAttributes(): array;

    
    // Boot the trait
     
    protected static function bootTranslatable()
    {
        // Override getAttribute to intercept translatable fields
        static::retrieved(function ($model) {
            foreach ($model->getTranslatableAttributes() as $field) {
                $model->appendTranslation($field);
            }
        });
    }

    // Save translations to JSON file
     
    public function saveTranslations(array $data, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $translatableFields = $this->getTranslatableAttributes();
        
        foreach ($translatableFields as $field) {
            if (isset($data[$field])) {
                $this->setTranslation($field, $data[$field], $locale);
            }
        }
    }

    // Set translation for a specific field
    public function setTranslation(string $field, string $value, string $locale)
    {
        $key = $this->getTranslationKey($field);
        $filePath = $this->getTranslationFilePath($locale);
        
        // Load existing translations
        $translations = $this->loadTranslations($locale);
        
        // Set the new translation
        $translations[$key] = $value;
        
        // Save to file
        $this->saveToFile($filePath, $translations);
    }
    
    //  Get translation for a specific field
    
    public function getTranslation(string $field, string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $key = $this->getTranslationKey($field);
        
        $translations = $this->loadTranslations($locale);
        
        return $translations[$key] ?? null;
    }

    //   Append translation to attribute
     
    protected function appendTranslation(string $field)
    {
        $translation = $this->getTranslation($field);
        
        if ($translation) {
            $this->attributes[$field] = $translation;
        }
    }
    
    //  Get translation key
     
    protected function getTranslationKey(string $field): string
    {
        $modelName = strtolower(class_basename($this));
        return "models.{$modelName}.{$this->id}.{$field}";
    }
    
    //  Get translation file path
     
    protected function getTranslationFilePath(string $locale): string
    {
        return lang_path("{$locale}/models.json");
    }
    
    
    //   Load translations from file
    
    protected function loadTranslations(string $locale): array
    {
        $filePath = $this->getTranslationFilePath($locale);
        
        if (!File::exists($filePath)) {
            File::ensureDirectoryExists(dirname($filePath));
            return [];
        }
        
        $content = File::get($filePath);
        return json_decode($content, true) ?? [];
    }

    //  Save translations to file
     
    protected function saveToFile(string $filePath, array $translations)
    {
        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    // Override getAttribute to return translated value
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        // Check if this is a translatable attribute
        if (in_array($key, $this->getTranslatableAttributes()) && $this->exists) {
            $translation = $this->getTranslation($key);
            return $translation ?? $value;
        }
        
        return $value;
    }
}