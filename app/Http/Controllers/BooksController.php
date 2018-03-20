<?php
/**
 * Created by PhpStorm.
 * User: njaiyo
 * Date: 3/12/18
 * Time: 5:39 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Books;


class BooksController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(){
        return response()->json(DB::table('books')->orderBy('title','desc')->get(),201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBook($id){
        return response()->json(Books::find($id),201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $Books = Books::create($request->all());

        return response()->json($Books,201);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($id){
        Books::findOrFail($id)->delete();
        return response('Deleted successfully',200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id,Request $request){
        $Books = Books::findOrFail($id);
        $Books->update($request->all());

        return response()->json($Books,200);
    }

    /**
     * @param $isbn
     * @param $sort
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchBooksISBN($isbn,$sort){
         $results = DB::table('books')->where('ISBN_number',$isbn)->orderBy($sort)->get();

        if(empty($results) || $results == ""){
            return response()->json('No records',204);
        }
        return response()->json($results,200);
    }

    /**
     * @param $name
     * @param $sort
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchBooksAuthor($name,$sort){
        $results = DB::table('books')->where('author',$name)->orderBy($sort)->get();

        if(empty($results) || $results == ""){
            return response()->json('No records',204);
        }
        return response()->json($results,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploaded_csv(Request $request){
        $file = $request->file('file');
        $destinationPath = 'uploads';
        //$file_path = $file->move($destinationPath,$file->getClientOriginalName());
        $filename = $file->getFilename();

        $handle_file = fopen (  $file->getPath().'/'.$filename, 'r' );

        $header = null;
        $file_rows = [];
        $dataset = [];
        if ($handle_file !== FALSE) {
            while(!feof($handle_file)){
                $file_rows[] = fgetcsv($handle_file,1000, ',');
            }

            //removing first rows in file
            $file_rows[] = array_shift($file_rows);

            /* remove any emty columns in file*/
            $data = [];
            for($i=0; $i<=5; $i++){
                $data[] =[
                    'title' => $file_rows[$i][0],
                    'ISBN_number' => $file_rows[$i][1],
                    'author' => $file_rows[$i][2],
                    'description' => $file_rows[$i][3],
                ];

                unset($file_rows[$i][4]);
            }


            foreach ($data as  $val){
                $dataset[] = [
                    'title' => $val['title'],
                    'ISBN_number' => $val['ISBN_number'],
                    'author' => $val['author'],
                    'description' => $val['description'],
                ];
            }

            $file->move($destinationPath,$file->getClientOriginalName());
            DB::table('books')->insert($dataset);

            fclose($handle_file);
        }else{
            return response()->json('file cannot be found',405);
        }

        return response()->json('Extracted successfully',201);
    }
}