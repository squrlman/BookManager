<?php
/**
 * Created by PhpStorm.
 * User: njaiyo
 * Date: 3/12/18
 * Time: 5:23 PM
 */

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuthorsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllAuthors(){
        return response()->json(DB::table('authors')->orderBy('title','desc')->get(),201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthor($id){
        return response()->json(Author::find($id),201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $Author = Author::create($request->all());

        return response()->json($Author, 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($id){
        Author::findOrFail($id)->delete();
        return response('Deleted successfully',200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request){
        $Author = Author::findOrFail($id);
        $Author->update($request->all());

        return response()->json($Author,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploaded_csv(Request $request){
        $file = $request->file('file');
        $destinationPath = 'uploads';
       // $file_path = $file->move($destinationPath,$file->getClientOriginalName());
        $filename = $file->getFilename();

        $handle_file = fopen (  $file->getPath().'/'.$filename, 'r' );

        $header = null;
        $file_rows = [];
        $dataset = [];

        if ($handle_file !== FALSE) {
            while(!feof($handle_file)){
                $file_rows[] = fgetcsv($handle_file,1000, ';');
            }

            //removing first rows in file
            $file_rows[] = array_shift($file_rows);

            /* remove any emty columns in file*/
            $data = [];
           // var_dump($file_rows);die();
            for($i=0; $i<=5; $i++){
                $data[] =[
                    'email_address' => $file_rows[$i][0],
                    'first_name' => $file_rows[$i][1],
                    'last_name' => $file_rows[$i][2],
                ];

                unset($file_rows[$i][4]);
            }

            foreach ($data as  $val){
                $dataset[] = [
                    'email_address' => $val['email_address'],
                    'first_name' => $val['first_name'],
                    'last_name' => $val['last_name'],
                ];
            }
          //  var_dump($file_rows,$data);die();
            $file->move($destinationPath,$file->getClientOriginalName());
            DB::table('authors')->insert($dataset);

            fclose($handle_file);
        }else{
            return response()->json('file cannot be found',405);
        }

        return response()->json('done',201);
    }
}