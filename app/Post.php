<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Post extends Model
{
    use SoftDeletes;
    use RevisionableTrait {
        boot as _unused; // remove the boot method
    }

    protected $casts = [
        'draft' => 'boolean',
    ];

    protected $appends = [
        'author',
    ];

    /**
     * The user who made the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Return the user that published the post from draft status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    /**
     * The comments that a post has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
