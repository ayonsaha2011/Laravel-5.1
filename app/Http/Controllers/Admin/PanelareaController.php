<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request, Auth, Flash, Storage, Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\User;

class PanelareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //dd(Auth::user()->getMenus());
        return view('admin.dashboard');
    }

    public function profile()
    {
        return view('admin.profile');
    }
    public function profileUpdate(Request $request)
    {
        // dd($request->all());
        $this->validate($request, ['name' => 'required', 'email' => 'required']);

        $user = User::findOrFail(Auth::user()->id);
        $postUpdate = $user->update($request->all());

        if ($postUpdate) {
            if ($request->hasFile('avatarImage')) {
                $avatar = $request->avatarImage;
                $meta_extension = $avatar->getClientOriginalExtension();
                Storage::disk('local')->put($avatar->getFilename().'.'.$meta_extension,  File::get($avatar));
                $storname=$avatar->getFilename().'.'.$meta_extension;
                $user->avatar = $storname;
            }
            $changepassword= $request->newpassword;
            if ($changepassword != "")
            {
                $user->password = Hash::make($changepassword);
            }
            $user->save();

            Flash::success('Profile successfully updated!');
        }
        else
        {
            Flash::error('Oop! some thing wrong Profile not updated');
        }
        return redirect()->back();
    }
    
    public function artisan()
    {
        return view('admin.artisan');
    }
    public function artisancommands(Request $request)
    {
        return view('admin.crudgenerate');
    }
    
    public function crud()
    {
        return view('admin.crudgenerate');
    }

    public function crudgenerate(Request $request)
    {

        //dd($request->all());
        $pk="";
        $foreignkey="";
        if ($request->has('fields')) {
            if ($request->command == 'model') {
                $fields="";
                $i=1;
                foreach ($request->fields as $field) {
                    if ($i == 1) {
                        $fields .= $field['name'];
                    }else{
                        $fields .= ", ".$field['name'];
                    }
                    $i++;
                }
            }
            elseif ($request->command == 'controller') {
                $fields="";
            }
            /*elseif ($request->command == 'migration') {
                $fields="";
                $i=1;
                foreach ($request->fields as $field) {
                    if ($i == 1) {
                        $fields .= $field['name'].":".$field['type'];
                    }else{
                        $fields .= ", ".$field['name'].":".$field['type'];
                    }
                    $i++;
                }
            }*/
            else {
                $fields="";
                $i=1;
                $foreignkeyi=1;
                foreach ($request->fields as $field) {
                    if ((array_key_exists("foreignkey", $field)) && ($field['foreignkey'] == 1)) {
                        if ($foreignkeyi == 1) {
                            $foreignkey =':foreignkey#'.$field["name"].'#'.$field["foreignkey_tabel"].'#'.$field["foreignkey_field"].'#'.$field["foreignkey_onupdate"].'#'.$field["foreignkey_ondelete"];
                        }
                        else{
                            $foreignkey .= ',foreignkey#'. $field["name"].'#'.$field["foreignkey_tabel"].'#'.$field["foreignkey_field"].'#'.$field["foreignkey_onupdate"].'#'.$field["foreignkey_ondelete"];
                        };
                        $foreignkeyi++;
                    }

                    $required = (array_key_exists("required", $field)) ? ":required" : ":notrequired";
                    $nullable = (array_key_exists("nullable", $field)) ? ":nullable" : ":notnullable";
                    $unsigned = (array_key_exists("unsigned", $field)) ? ":unsigned" : ":notunsigned";
                    if ($i == 1) {
                        $fields .= $field['name'].":".$field['type'].$required.":".$field['label'].":".$field['fieldType'].":".$field['lenght'].$nullable.$unsigned.":".$field['default'];
                    }else{
                        $fields .= ", ".$field['name'].":".$field['type'].$required.":".$field['label'].":".$field['fieldType'].":".$field['lenght'].$nullable.$unsigned.":".$field['default'];
                    }
                    $i++;
                }
            
            }
        $pk=$request->id["title"].':'.$request->id["type"].$foreignkey;
        $command =$request->command;
        $output = $this->$command($request->name, $request->namespace, $request->viewpath, $fields, $pk);
        if ($request->has('migrate')) {
            $output .= $this->migrate();
        }
        Flash::info($output);
    }
    else{
        Flash::error("please add fields");
    }
    return redirect('/panelarea/crud-generate');

    }
    
    public function crudcommand($name, $namespace, $viewpath, $fields, $pk)
    {
        $crudpk = "";
        if ($pk != "") {
            $crudpk = " --pk=".$pk;
        }
      //dd('php artisan crud:generate '.$name.' --fields="'.$fields.'" --view-path="admin"'.$crudpk.' --namespace=Admin');
        $output = shell_exec('php artisan crud:generate '.$name.' --fields="'.$fields.'" --view-path="'.$viewpath.'"'.$crudpk.' --namespace='.$namespace);
        return $output;
    }
    public function controller($name, $namespace, $viewpath, $fields, $pk)
    {
        $output = shell_exec('php artisan crud:controller '.$name.'Controller --crud-name="'.$name.'" --view-path="'.$viewpath.'"');
        return $output;
    }
    public function model($name, $namespace, $viewpath, $fields, $pk)
    {
        $output = shell_exec('php artisan crud:model '.$name.' --fillable="['.$fields.']"');
        return $output;
    }
    public function migration($name, $namespace, $viewpath, $fields, $pk)
    {
        $output = shell_exec('php artisan crud:migration '.$name.' --schema="'.$fields.'"');
        return $output;
    }
    public function view($name, $namespace, $viewpath, $fields, $pk)
    {
        $output = shell_exec('php artisan crud:view '.$name.' --fields="'.$fields.'" --view-path="'.$viewpath.'"');
        return $output;
    }
    public function migrate()
    {
        $output = shell_exec('php artisan migrate');
        $output .= shell_exec('composer dump-autoload');
        return $output;
    }
}
