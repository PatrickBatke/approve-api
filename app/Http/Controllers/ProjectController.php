<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Session;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Show all Projects.
     *
     * @return Response
     */
    public function showProjects()
    {
        return Project::showProjects();
    }

    /**
     * Show single Projects.
     *
     * @return Response
     */
    public function showSingleProject($id)
    {
        return Project::showSingleProject($id);
    }

    /**
     * Show Project-Picture
     *
     * @return \Illuminate\Http\Response
     */
    public function showProjectPicture(Request $request)
    {
        return Project::showProjectPicture($request);
    }

    /**
     * Show Tags for single Project
     *
     * @return Response
     */
    public function showTagsForProject($id)
    {
        return Project::showTagsForProject($id);
    }

      /**
     * Show Files for single Project
     *
     * @return Response
     */
    public function showFilesForProject($id)
    {
        return Project::showFilesForProject($id);
    }

    /**
     * Create Project
     *
     * @return \Illuminate\Http\Response
     */
    public function createProject(Request $request)
    {
        return Project::createProject($request);
    }

    /**
     * Upload File
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        return Project::uploadFile($request);
    }

       /**
     * Upload Pic
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPic(Request $request)
    {
        return Project::uploadPic($request);
    }

    /**
     * Delete Project
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteProject(Request $request)
    {
        return Project::deleteProject($request);
    }

    /**
     * Delete File
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteFile($id)
    {
        return Project::deleteFile($id);
    }

    /**
     * Create createTags
     *
     * @return \Illuminate\Http\Response
     */
    public function createTags(Request $request)
    {
        return Project::createTags($request);
    }
}
