<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index', [ 'page' => 'projects']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // NOTE: NEEDS TO BE VALIDATED
        $newProject = new Project;
        $newProject->name = $request->input('name');
        $newProject->projectFlow = [];

        // validate then handle the file
        if ($request->hasFile('main-photo')) {
            $mainPhoto = $request->file('main-photo');
            $path = $mainPhoto->store('public/images');
            $pathModified = str_replace('public','storage', $path); // store the correct dir
            $newProject->mainPhoto = $pathModified;
        }

        $newProject->save();

        // send user to the edit page to construct the project flow array
        return redirect('/projects/' . $newProject->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', $project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // first determine is this is a title/main photo or a change to the project flow content

        if ($request->has('name')) {
            // this is an update to the exiting project's title or main photo
            // project can be used do to route-model binding injecting the project model here


            $project->name = $request->input('name');

            // validate then handle the file
            if ($request->hasFile('main-photo')) {
                $mainPhoto = $request->file('main-photo');
                $path = $mainPhoto->store('public/images');
                $pathModified = str_replace('public','storage', $path); // store the correct dir
                $project->mainPhoto = $pathModified;
            }

            $project->save();

            // return user to the edit view
            return back();

        } else {

            // This is a change to the flow array, handle it


            // get the stringified json flow array
            // decode the stringified json array sent by axios with FormData so that it can be used in PHP
            $reqFlowArr = json_decode($request->input('flowArr'), true);

            // get an array of all the files sent in the request
            $files = $request->file();


            $currentFlowArr = $project->projectFlow;
            forEach($reqFlowArr as $key => $item) {

                if (!isset($currentFlowArr[$key]) || $currentFlowArr[$key] != $reqFlowArr[$key]) {
                    // create/clear then update the value if it is a paragraph or video
                } else {
                    //skip this, it's 
                }
            }
            
            // below doesn't work because it gets the array out of order

            /*

            // handle files by storing them and saving their path to the flow array with eloquent
            if (count($files) > 0) {
                foreach ($files as $key => $file) {
                    //get the index and which value it should be
                    $fileSplitArr = preg_split("/_/", $key);

                    
                    $fileIndex = intval($fileSplitArr[1]);
                    $photoNum = intval($fileSplitArr[2]);

                    
                    // store the image with the temp name and get the path then fix it
                    $path = $file->store('public/images');
                    $pathModified = str_replace('public','storage', $path); // store the correct dir

                    // add the new index to the flow array
                        $castedArr = $project->projectFlow; // neccessary step due to array casting

                        // set new array if it doesn't exist already and  update the project flow array
                        if (!isset($castedArr[0])) {
                            $castedArr[] = [ "value{$photoNum}" => $file];
                        } else {
                            $castedArr[$fileIndex][] = ["value{$photoNum}" => $pathModified];
                        }

                        $project->projectFlow = $castedArr;
                }
            }
            
            // handle the paragraphs and videos


            // here make sure to save the project object

            return dd($project);

            */
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
