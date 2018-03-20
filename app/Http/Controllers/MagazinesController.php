<?php
/**
 * Created by PhpStorm.
 * User: njaiyo
 * Date: 3/12/18
 * Time: 5:38 PM
 */

namespace App\Http\Controllers;
use function FastRoute\TestFixtures\empty_options_cached;
use Illuminate\Http\Request;
use App\Magazine;
use Illuminate\Support\Facades\DB;


class MagazinesController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(){
        $all = Magazine::all();

       return response()->json(DB::table('magazines')->orderBy('title','desc')->get(),201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMagazines($id){
        return response()->json(DB::table('magazines')->where('id','=',$id)->orderBy('title','desc')->get());
        //return response()->json(DB::table('magazines')->orderBy('title','desc')->get(),201);
    }

    public function create(Request $request){
       $Magazines = Magazine::create($request->all());

       return response()->json($Magazines, 201);
    }

    public function delete($id){
        Magazine::findOrFail($id)->delete();
        return response('Deleted successfully',200);
    }

    public function update($id, Request $request){
       $Magazines = Magazine::findOrFail($id);
       $Magazines->update($request->all());

       return response()->json($Magazines,200);
    }

    /*
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchISBN($isbn, $sort){
        $results = DB::table('magazines')->where('ISBN_number',$isbn)->orderBy($sort,'desc')->get();

       /* if(empty($results) || $results == ""){
            return response()->json('No records',204);
        }
       */
        return response()->json($results,201);
    }

    /**
     * @param $name
     * @param $sort
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAuthor($name,$sort){
        $results = DB::table('magazines')->where('author','=',$name)->orderBy($sort,'desc')->get();

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
        $file_path = $file->move($destinationPath,$file->getClientOriginalName());
        $filename = $file_path->getFilename();

        $handle_file = fopen (  $file_path->getPath().'/'.$filename, 'r' );

        $header = null;
        $file_rows = [];
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
                    'publication_date' => $file_rows[$i][3],
                ];

               unset($file_rows[$i][4]);
            }
            $dataset = [];
               foreach ($data as  $val){
                   $dataset[] = [
                       'title' => $val['title'],
                       'ISBN_number' => $val['ISBN_number'],
                       'author' => $val['author'],
                       'publication_date' => $val['publication_date'],
                   ];
               }
             DB::table('magazines')->insert($dataset);
            fclose($handle_file);
        }else{
            return response()->json('file cannot be found',405);
        }

        return response()->json($dataset,201);
    }
}