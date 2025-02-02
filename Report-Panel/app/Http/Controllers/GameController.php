<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Game::orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->toJson();
        }
        return view('game.index');
    }

    public function fetch(Request $request, $idOrKeyword)
    {

        if ($request->type == 'attend') {
            $game = Game::select()->where('id', $idOrKeyword)->first();
            $game->incrementAttempt();
            return $this->respondWithSuccess('Successfully fetched game', $game);
        }

        if ($request->type == 'check-keyword') {
            $game = Game::select()->where('keyword', $idOrKeyword)->first();
            if ($game) {
                return $this->respondWithSuccess('Already exists');
            } else {
                return $this->respondWithError('Game\'s keyword does not exist');
            }
        }

        if ($request->type == 'check-keyword-update') {
            $game = Game::select()->where('id', '!=', $idOrKeyword)->where('keyword', $request->keyword)->first();
            if ($game) {
                return $this->respondWithSuccess('Already exists');
            } else {
                return $this->respondWithError('Game\'s keyword does not exist');
            }
        }

        $game = Game::select()->where('id', $idOrKeyword)->first();
        return $this->respondWithSuccess('Successfully fetched game', $game);
    }

    // create
    public function create(Request $request)
    {
        try {

            $hasAlready = Game::select()->where('keyword', $request->keyword)->first();
            if ($hasAlready) {
                Session::flash('error', 'Game\'s keyword already exist');
                return redirect()->back();
            }

            $game = new Game();
            $game->title = $request->title;
            $game->keyword = $request->keyword;
            $game->status = $request->status;
            $game->url = $request->url;

            if ($request->banner) {
                $image = $request->file('banner');
                $image_name = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('/images/game'), $image_name);
                $game->banner = '/images/game/' . $image_name;
            }

            $game->description = $request->description;
            $game->save();

            Session::flash('success', 'Game created successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {
        try {

            $hasAlready = Game::select()->where('id', '!=', $request->id)->where('keyword', $request->keyword)->first();

            if ($hasAlready) {
                Session::flash('error', 'Game\'s keyword already exist');
                return redirect()->back();
            }

            $game = Game::select()->where('id', $request->id)->first();
            $game->title = $request->title;
            $game->keyword = $request->keyword;
            $game->status = $request->status;
            $game->url = $request->url;

            if ($request->banner) {
                // Check if there's an existing banner to delete
                if ($game->banner) {
                    $existingImagePath = public_path($game->banner);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath); // Delete the old banner image
                    }
                }

                $image = $request->file('banner');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('/images/game'), $image_name);

                // Update the banner field in the game record
                $game->banner = '/images/game/' . $image_name;
            }


            $game->description = $request->description;
            $game->save();

            Session::flash('success', 'Game updated successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong');
            Session::flash('error', $th->getMessage());
            return redirect()->back();
        }
    }
}
