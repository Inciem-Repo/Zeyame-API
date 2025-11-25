<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FontFiles extends Model
{
    protected $table="json_font";
    protected $fillable = [
        'post_name','user_email','post_tags','user_email','image_path'
    ];
        /**
     * Accessor to convert the comma-separated string into an array.
     * Filters out empty values to handle leading/trailing commas.
     */
   public function getPostTagsArrayAttribute()
    {
        return $this->post_tags 
            ? array_map('strtolower', array_filter(explode(',', $this->post_tags))) 
            : [];
    }

    /**
     * Mutator to convert an array into a comma-separated string.
     * Ensures only non-empty values are stored and normalizes to lowercase.
     */
    public function setPostTagsAttribute($value)
    {
        $cleanedTags = array_filter($value, function ($tag) {
            return !empty($tag);
        });

        
    $this->attributes['post_tags'] = $cleanedTags 
        ? ',' . implode(',', array_map('strtolower', $cleanedTags)) . ',' 
        : null;

    }
}
