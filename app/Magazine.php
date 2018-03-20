<?php
/**
 * Created by PhpStorm.
 * User: njaiyo
 * Date: 3/12/18
 * Time: 5:18 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    /**
     * mass assignment
     * @var array
     */
    protected  $fillable = ['title','ISBN_umber','author','publication_date'];

    protected $table = 'magazines';

}