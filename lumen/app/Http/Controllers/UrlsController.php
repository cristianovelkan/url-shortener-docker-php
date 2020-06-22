<?php

namespace App\Http\Controllers;

use App\Url;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UrlsController extends Controller
{

    public function show($id)
    {
        try {
            $url = Url::find($id);

            if (!$url) {
                return response('', Response::HTTP_NOT_FOUND);
            }

            $url->increment('hits');

            header("Location: {$url->url}", false, 301);
            exit();

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                throw new \Exception("Usuário não encontrado.");
            }

            $url = $this->randomUrl();
            $short = Url::create([
                'user_id' => $user->id,
                'url' => $request->url,
                'short_url' => env("APP_URL") . "/" . $url,
            ]);

            $short = $short->fresh();

            return response($short, Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function randomUrl($size = 8)
    {
        do {
            $url = Str::random($size);
            $exists = Url::where('url', $url)->exists();
        } while ($exists);

        return $url;
    }

    public function destroy($id)
    {
        try {
            $url = Url::find($id);

            if (!$url) {
                return response('', Response::HTTP_NOT_FOUND);
            }

            $url->delete();

            return response('', Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generalStats()
    {
        try {
            $urls = Url::orderByDesc('hits')->get();
            $hits = Url::sum('hits');
            $urlCount = Url::count();

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

    public function stats($id)
    {
        try {
            $url = Url::find($id);

            if (!$url) {
                return response('', Response::HTTP_NOT_FOUND);
            }

            return response($url, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
