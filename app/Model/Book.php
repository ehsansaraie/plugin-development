<?php

namespace FalconBaseServices\Model;

class Book extends BaseModel
{
    protected $table = 'books_info';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'isbn'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'ID');
    }
}
