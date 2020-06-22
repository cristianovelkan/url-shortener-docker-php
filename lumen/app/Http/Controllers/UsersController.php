<?php namespace App\Http\Controllers;

use App\Url;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|min:3',
        ]);

        try {
            $id = Str::slug($request->id);
            $user = User::where('id', $id)->exists();

            if ($user) {
                return response(null, Response::HTTP_CONFLICT);
            }

            User::create(['id' => $id]);

            return response(null, Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where(['id' => $id])->first();

            if (!$user) {
                return response('', Response::HTTP_NOT_FOUND);
            }

            $user->delete();

            return response('', Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function stats($id)
    {
        try {
            $user = User::where('id', $id)->first();

            if (!$user) {
                return response('', Response::HTTP_NOT_FOUND);
            }

            $urls = Url::where(['user_id' => $user->id])->orderByDesc('hits')->get();
            $hits = Url::where(['user_id' => $user->id])->sum('hits');
            $urlCount = Url::where(['user_id' => $user->id])->count();

            return response([
                "hits" => $hits,
                "urlCount" => $urlCount,
                "topUrls" => $urls,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
