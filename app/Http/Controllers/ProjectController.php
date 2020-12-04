<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


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
            $pathModified = str_replace('public','/storage', $path); // store the correct dir
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

        // add pagination to the items array to only show 17 per page
        $items = $project->Item()->paginate(17);

        return view('projects.show', compact('page','project','items'));
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
                $pathModified = str_replace('public','/storage', $path); // store the correct dir
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
                            
                        } else {

                            // this item's photos already exist and just need passing on
                            $photoPathsArr = $item['photos'];
                        }

                        // update item or create the new photos item in the db
                        Item::updateOrCreate(
                            ['project_id' => $project->id, 'order' => $item['order']],
                            [
                            'photos' => $photoPathsArr,
                            'project_id' => $project->id,
                            'type' => $reqItemsArr[$key]['type'],
                            'order' => $reqItemsArr[$key]['order'],
                            'data' => ''
                        ]);
                        
                        break;
                }
                
            }


            // Delete any excess Items not in the reqItemsArr
            $this->deleteExcessItems($project->id, count($reqItemsArr));

            // clean up excess photo files if any were deleted
            $this->cleanUpPhotos();

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

    private function deleteExcessItems($projectId, $lastOrder)
    {
        Gate::authorize('admin');

        $itemsToDel = Item::where([
            ['project_id', '=', $projectId],
            ['order', '>', $lastOrder]
            ])->delete();
       
    }

    private function cleanUpPhotos() {
        // get an array of all files in the images folder
        $directory = 'public/images';
        $dirFiles = Storage::files($directory);
        //return dd($dirFiles);

        // get an array of all project/experience photos then flatten it into a single arr
        $projectFiles = Item::all()->pluck('photos')->flatten()->toArray();
        $mainPhotoFiles = Project::all()->pluck('mainPhoto')->flatten()->toArray();
        $dbFiles = array_merge($projectFiles, $mainPhotoFiles);
        
        $unassociatedFiles = array_filter($dirFiles, function($dirFile) use ($dbFiles) {
            $dirFile = str_replace('public','/storage', $dirFile); // get it same as dbFiles for comparison
            
            // compare the files to filter the array of files that are part of current projects leaving only the files that are unossociated and should be removed
            foreach ($dbFiles as $dbFile) {
                if ($dbFile == $dirFile) {
                    return false; // false so that it is not included in the list
                    break;
                }
            }
            return true; // there were no matching files in the DB, add file to the delete list
        });

        // delete unassociated photos files left in the array by passing it per Docs
        Storage::delete($unassociatedFiles);

    }
}
