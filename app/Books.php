<?php
/**
 * Created by PhpStorm.
 * User: njaiyo
 * Date: 3/12/18
 * Time: 5:16 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{

    /**
     * mass assignment
     * @var array
     */
    protected  $fillable = ['title','ISBN_number','author','description'];

    /**
     * @var string
     */
    protected $table = "books";
}