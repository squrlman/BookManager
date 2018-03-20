<?php
/**
 * Created by PhpStorm.
 * User: njaiyo
 * Date: 3/12/18
 * Time: 5:12 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;


class Author extends  Model
{

    /**
     * mass assignment
     * @var array
     */
    protected $fillable = ['email_address','first_name','last_name'];

    protected  $table = 'authors';
}