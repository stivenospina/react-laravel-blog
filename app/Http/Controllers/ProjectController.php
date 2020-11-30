<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       

        $projectsList = Project::where('projOrExp', '=', 'project')->get();

            return view('projects.index', ['page' => 'projects', 'projects' => $projectsList]);
        
    }

    public function experiencesIndex()
    {
        $experiencesList = Project::where('projOrExp','=','experience')->get();

        return view('projects.index', [ 'page' => 'experiences', 'projects' => $experiencesList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('admin');
        
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
        Gate::authorize('admin');

        // NOTE: NEEDS TO BE VALIDATED
        $newProject = new Project;
        $newProject->name = $request->input('name');
        $newProject->projOrExp = $request->input('proj-or-exp');

        // check if a photo was sent then handle the file
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
        $page = 'projects';

        return view('projects.show', compact('page','project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        Gate::authorize('admin');
        
        return view('projects.edit', [ 'project' => $project ]);
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
        Gate::authorize('admin');

        // first determine is this is a title/main photo or a change to the project flow content

        if ($request->has('name')) {
            // this is an update to the exiting project's title or main photo
            // project can be used do to route-model binding injecting the project model here


            $project->name = $request->input('name');
            $project->projOrExp = $request->input('proj-or-exp');

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

            // This is a change to the project flow, handle it


            // get the stringified json flow array
            // decode the stringified json array sent by axios with FormData so that it can be used in PHP
            $reqItemsArr = json_decode($request->input('items'), true);

            

            // get an array of all the files sent in the request
            $files = $request->file();
            

            // get the most up to date items array for this project from DB
            $currentItemsArr = $project->Item->sortBy('order');
            

            
            // handle each of the flow items sent in the request
            forEach($reqItemsArr as $key => $item) {
                
                // handle the creation/update of each type of item
                switch ($item['type']) {
                    case 'paragraph':
                    case 'video':

                        // updateOrCreate checks to see if item exists, updades it, or creates it if not
                        Item::updateOrCreate(
                            ['project_id' => $project->id, 'order' => $item['order']],
                            [
                                'data' => $reqItemsArr[$key]['data'],
                                'project_id' => $project->id,
                                'type' => $reqItemsArr[$key]['type'],
                                'order' => $reqItemsArr[$key]['order'],
                                'photos' => []
                            ]
                        );
                        break;
                    case 'one':
                    case 'two':   
                    case 'four':
                        // check to see if this is a new item or existing
                        if (empty($item['photos'])) {
                            // handle photo upload
                            
                            // how many photo file should there be?
                            if ($item['type'] == 'one') {
                                $numberOfFiles = 1;
                            } else if ($item['type'] == 'two') {
                                $numberOfFiles = 2;
                            } else if ($item['type'] == 'four') {
                                $numberOfFiles = 4;
                            }

                            $photoPathsArr = [];

                            for ($i = 1; $i <= $numberOfFiles; $i++) {
                                // store the image with the temp name and get the path then fix it
                                $file = $request->file('file_' . strval($item['order'] - 1) . "_{$i}");
                                
                                $path = $file->store('public/images');
                                $pathModified = str_replace('public','/storage', $path); // store the correct dir
                                $photoPathsArr[] = $pathModified;
                            }
                            

                            // create the new item in the db
                            Item::updateOrCreate(
                                ['project_id' => $project->id, 'order' => $item['order']],
                                [
                                'photos' => $photoPathsArr,
                                'project_id' => $project->id,
                                'type' => $reqItemsArr[$key]['type'],
                                'order' => $reqItemsArr[$key]['order'],
                                'data' => ''
                            ]);
                        }
                        break;
                }
                
            }

            return 'success';
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
        Gate::authorize('admin');
        
        $project->delete();

        return redirect('/projects');
    }
}
