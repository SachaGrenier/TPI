<?php

namespace App\Http\Controllers;

use Request;
use App\Workshop_level_1;
use App\Workshop_level_2;
use App\Workshop_level_3;
use App\Color;
use Illuminate\Support\Facades\Input;

class LevelController extends Controller
{

    /**
    * Get all workshops level 1 from the database and returns it into objects
    *
    * @return Level 1 workshops objects
    */
    static public function getLevel1()
    {
    	return Workshop_level_1::all();
    }
    
 
    static public function getLevel2WithLevel1($id_level_1)
    {
        return Workshop_level_2::where('workshop_level_1_id', $id_level_1)->get();
    }
    static public function getLevel3WithLevel2($id_level_2)
    {
        return Workshop_level_3::where('workshop_level_2_id', $id_level_2)->get();
    }

    /**
    * Adds a level 1 workshop into the database
    *
    * @param $data, given by ajax
    *
    * @return response, with error message if something went wrong
    */
    public function addLevel1()
    {
    	 if(Request::ajax()) 
        {
            $data = Input::all();
            try
            {
                $level_1 = new Workshop_level_1;      
                $level_1->name = $data["name"];
                $level_1->color_id = $data["color"];

                $level_1->save();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Veuillez vérifier que tous les champs aient bien étés remplis correctement" ,400);
            }
        }
        else
        {
            return response($default_general_error_message,500);
        }
    }
    /**
    * Adds a level 2 workshop into the database
    *
    * @param $data, given by ajax
    *
    * @return response, with error message if something went wrong
    */
    public function addLevel2()
    {
    	 if(Request::ajax()) 
        {
            $data = Input::all();
            try
            {
                $level_2 = new Workshop_level_2;      
                $level_2->name = $data["name"];
                $level_2->workshop_level_1_id = $data["workshop_level_1"];

                $level_2->save();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Veuillez vérifier que tous les champs aient bien étés remplis correctement",400);
            }
        }
        else
        {
            return response($default_general_error_message,500);
        }
    }

    /**
    * Adds a level 3 workshop into the database
    *
    * @param $data, given by ajax
    *
    * @return response, with error message if something went wrong
    */
    public function addLevel3()
    {
         if(Request::ajax()) 
        {
            $data = Input::all();
            try
            {
                $level_3 = new Workshop_level_3;      
                $level_3->name = $data["name"];
                $level_3->workshop_level_2_id = $data["workshop_level_2"];

                $level_3->save();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Veuillez vérifier que tous les champs aient bien étés remplis correctement",400);
            }
        }
        else
        {
            return response($default_general_error_message,500);
        }
    }

    /**
    * Removes a level 1 workshop from the database
    *
    * @param $data, given by ajax
    *
    * @return response, with error message if something went wrong
    */
    public function remLevel1()
    {
        if(Request::ajax()) 
        {
            $data = Input::all();
            $workshop_level_1 = Workshop_level_1::find($data["workshop_id"]);
            try
            {
                $workshop_level_1->delete();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Impossible de supprimer cet atelier" ,400);
            }
        }
        else
            return response($default_general_error_message,500);
    }
     /**
    * Removes a level 2 workshop from the database
    *
    * @param $data, given by ajax
    *
    * @return response, with error message if something went wrong
    */
    public function remLevel2()
    {
        if(Request::ajax()) 
        {
            $data = Input::all();
            $workshop_level_2 = Workshop_level_2::find($data["workshop_id"]);
            try
            {
                $workshop_level_2->delete();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Impossible de supprimer cet atelier" ,400);
            }
        }
        else
            return response($default_general_error_message,500);
    }
     /**
    * Removes a level 3 workshop from the database
    *
    * @param $data, given by ajax
    *
    * @return response, with error message if something went wrong
    */
    public function remLevel3()
    {
        if(Request::ajax()) 
        {
            $data = Input::all();
            $workshop_level_3 = Workshop_level_3::find($data["workshop_id"]);
            try
            {
                $workshop_level_3->delete();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Impossible de supprimer cet atelier" ,400);
            }
        }
        else
            return response($default_general_error_message,500);
    }

    ///getMenu
    //creates the menu and returns it
    public function getMenu()
    {
    	$level_1_list = Workshop_level_1::all();
		$level_2_list = Workshop_level_2::all();
		$level_3_list = Workshop_level_3::all();
		$colors = Color::all();
    	
    	$result = '';
    	foreach ($level_1_list as $level_1_key => $level_1)
    	{
    		$content ='<div class="level_1"><input hidden id="level_1_id_'.$level_1_key.'" value="'.$level_1->id.'"><button onclick="remLevel(1,'. $level_1->id .',this)" value="'. csrf_token().'" class="remove-button">X</button>
	            <h3>Niveau 1 : '. $level_1->name .'</h3>
                ';
	            foreach ($level_2_list as $level_2_key => $level_2)
	            {
	                if($level_2->workshop_level_1_id == $level_1->id)
	                {
	                	$content .= '<div class="level_2"><input hidden id="level_2_id_'.$level_2_key.'" value="'.$level_2->id.'">
	                    <h5 class="left">Niveau 2 : '. $level_2->name .'</h5>
                        <button onclick="remLevel(2,'. $level_2->id .',this)" value="'. csrf_token().'" class="remove-button">X</button>';
	                        foreach ($level_3_list as $level_3)
	                        {
	                            if($level_3->workshop_level_2_id == $level_2->id)
	                            {
	                            	$content .= '<div class="clearfix"></div><div class="level_3 left">
	                                	<p class="left"> '. $level_3->name .'</p>
                                        <button onclick="remLevel(3,'. $level_3->id .',this)" value="'. csrf_token().'" class="remove-button">X</button>
	                                </div>';
	                            }
	                        }
	                        $content .= '<div class="level_3">
	                            <input type="text" class="form-control" id="level_3_name_'.$level_2_key.'" placeholder="Nom de l\'atelier niveau 3">
                                <p id="_token_level_3_'.$level_2_key.'" style="display:none">'. csrf_token().'</p>
                                <button onclick="addLevel3(this)" class="btn btn-secondary middle-button" id="confirm_level_3_'.$level_2_key.'">Ajouter</button>
	                        </div>
	                  </div>';
	                }
	            }
	             $content .= '<div class="level_2">
	             <input type="text" class="form-control" id="level_2_name_'.$level_1_key.'" placeholder="Nom de l\'atelier niveau 2">
	                <p id="_token_level_2_'.$level_1_key.'" style="display:none">'. csrf_token().'</p>
	                <button onclick="addLevel2(this)" class="btn btn-secondary middle-button" id="confirm_level_2_'.$level_1_key.'">Ajouter</button>
	            </div>
	        </div>';

	        $result .= $content;
		}

      	$result .= '<div class="level_1">
        <h4>Ajouter un atelier de niveau 1</h4>
        <input type="text" class="form-control" id="level_1_name" placeholder="Nom de l\'atelier niveau 1">
        <p id="_token_level_1" style="display:none">'. csrf_token().'</p>';
        $select = '<select class="form-control" id="color">';
        $options = "<option disabled selected>Séléctionner couleur</option>";
        foreach ($colors as $color) 
        {
            $options .= "<option value='".$color->id."'>".$color->name."</option>";
        }
        $select .= $options;
		$select .= '</select>';
		$result .= $select;
        $result .= "<button onclick='addLevel1()' class='btn btn-secondary middle-button' id='confirm_level_1'>Ajouter</button>";
      	$result .=  '</div>';
        
        return $result;
    }
}
